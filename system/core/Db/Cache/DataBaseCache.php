<?php
/**
 * Framework Component 
 * @name      ALEX_CMS
 * @author    Alex Jurii <jurii@mail.ru>
 *
 * The MIT License (MIT)
 *
 * Copyright (c) 2016
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace core\Db\Cache;


use core\Db\Strategy\DataBaseSelectType;
use exception\DbException;
use lib\Config\Config;

if (!defined('ACCESS')){
    header('Location: /');
    exit;
}
define('NOW_TIME', time());

/**
 * Class DataBase
 */
class DataBaseCache extends DataBaseSelectType implements InterfaceDataBaseCache
{
    protected $iQuery_id;
    protected $prefix;
    protected $user_prefix;
    private $dir = 'tmp/mysql/';
    private $index_file = 'index';
    private $index = ['drop' => []];
    private $cached = [];
    private $pointer = [];
    private $hashDrop = [];
    private static $flush_by = ['INSERT', 'UPDATE', 'DELETE', 'REPLACE', 'ALTER'];
    private static $real_time_tables = ['online', 'comments', 'plugins', 'logs', 'reffers'];
    private $real_time_func = ['NOW', 'UNIX_TIMESTAMP'];
    private $no_cache_timeout = 300;


    /**
     * DataBase constructor.
     *
     * @param \lib\Config\Config $configs
     *
     * @throws \Exception
     */
    public function __construct(Config $configs)
    {
        try {
            $this->prefix = $configs->getData('db', 'prefix');
            $this->user_prefix = $configs->getData('db', 'user_prefix');
            if (!is_dir($this->dir)){
                $this->makeTempDir();
            }
            parent::__construct($configs);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * создаем папку Temp и файлы защиты директории кэша
     * @throws \exception\Db_Exception
     */
    protected function makeTempDir()
    {
        if (!@mkdir($this->dir, 0777) && !is_dir($this->dir)) {
            throw new DbException('insufficient privilege to create sub-directories ' . $this->dir);
        }
        file_put_contents($this->dir . '.htaccess', 'deny from all', LOCK_EX);
        file_put_contents($this->dir . 'index.html', '', LOCK_EX);
    }

    public function __destruct()
    {
        if (count($this->index['drop']) > 0){
            $this->index['drop'] = array_unique($this->index['drop']);
            foreach ($this->index['drop'] AS $hash){
                unset($this->index['lifetime'][$hash]);
                unlink($this->dir . $hash);
            }
            $this->index['drop'] = [];
        }

        $index = '<?php $this->index=' . $this->arr2str($this->index) . '; ?>';
        $this->write_file($this->index_file, $index);
    }

    /**
     * @param array $arr
     * @param int   $depth
     *
     * @return string
     */
    protected function arr2str(&$arr, $depth = 0)
    {
        $ret = [];
        if (is_array($arr) && count($arr) > 0){
            foreach ($arr AS $key => $value){
                $key = str_replace("'", "\\'", $key);
                if (is_array($value)){
                    $ret[] = "'{$key}'=>" . $this->arr2str($value, $depth + 1);
                } elseif (is_int($value)) {
                    $ret[] = "'{$key}'=>$value";
                } else {
                    if (is_string($value)){
                        $value = str_replace("'", '"', $value);
                    }
                    $ret[] = "'{$key}'=>'" . (string)$value . "'";
                }
            }
        }

        return 'array(' . implode(',', $ret) . ')';
    }

    /**
     * @param $filename
     * @param $content
     *
     * @return bool
     */
    private function write_file($filename, &$content)
    {
        ignore_user_abort(1);
        $lockfile = $this->dir . $filename . '.lock';
        if (file_exists($lockfile) && (time() - filemtime($lockfile)) > 5){
            unlink($lockfile);
        }
        /** @var resource $lock_ex */
        $lock_ex = fopen($lockfile, 'x');
        for ($i = 0; ($lock_ex === false) && ($i < 20); $i++){
            clearstatcache();
            usleep(random_int(5, 15));
            $lock_ex = fopen($lockfile, 'x');
        }

        $success = false;
        if ($lock_ex !== false){
            $fp = fopen($this->dir . $filename, 'wb');
            if (fwrite($fp, $content)){
                $success = true;
            }
            fclose($fp);
            fclose($lock_ex);
            unlink($lockfile);
        }
        ignore_user_abort(0);

        return $success;
    }

    /**
     * @param string $query
     *
     * @return bool|\mysqli_result|string
     */
    public function getQuery($query)
    {
        $hash = md5(preg_replace('~(\d{10})~', '', $query));
        $is_realtime = preg_match('~(\d{10})~', $query);
        $is_cached = false;
        $do = trim(strtoupper(mb_substr($query, 0, strpos($query, ' '))));
        /** @noinspection UnSafeIsSetOverArrayInspection */
        if (!isset($this->cached[$hash])){
            if ($do == 'SELECT' or $do == 'DO'){
                preg_match_all('~' . $this->prefix . '_([^\s`]+)~i', $query, $match);
                $tables =& $match[1];
                unset ($match);

                if (count($tables) > 0 && count(array_intersect($tables, static::$real_time_tables)) == 0){
                    if (!file_exists($this->dir . $hash) || in_array($hash, $this->index['drop'])){
                        foreach ($tables as $tabl){
                            $this->index['links'][$tabl][$hash] = array_diff($tables, [$tabl]);
                        }
                        $this->index['times'][$hash] = NOW_TIME;
                    } else {
                        $modified =& $this->index['times'][$hash];
                        if ($is_realtime || preg_match('~(' . implode('|', $this->real_time_func) . ')~i', $query)){
                            if ($this->no_cache_timeout && (NOW_TIME - $modified) < $this->no_cache_timeout){
                                $is_cached = true;
                            } else {
                                $this->index['times'][$hash] = NOW_TIME;
                            }
                        } else {
                            $is_cached = true;
                        }
                    }
                    if ($is_cached){
                        $this->readcache($hash);
                    } else {
                        $mysql = $this->currentDb->getQuery($query);
                        if ($mysql){
                            while ($row = $this->currentDb->getRow($mysql)) $this->cached[$hash]['data'][] = $row;
                            $this->cached[$hash]['sizeof'] = $this->currentDb->numRows($mysql);
                            if (!$this->cached[$hash]['sizeof']){
                                $this->cached[$hash]['sizeof'] = 0;
                            }
                            $this->pointer[$hash] = 0;
                            $this->iQuery_id = $hash;
                            $this->write_cache($hash);
                        }
                    }

                    return $hash;
                }
            }
            if (in_array($do, static::$flush_by) && preg_match('~' . $this->prefix . '_([^\s`]+)~i', $query, $match)){
                $table =& $match[1];
                unset ($match);
                if (isset($this->index['links'][$table])){
                    foreach ($this->index['links'][$table] AS $h => $link){
                        /** @noinspection UnSafeIsSetOverArrayInspection */
                        if (!isset($this->hashDrop[$h])){
                            foreach ($link AS $tbl){
                                unset($this->index['links'][$tbl][$h]);
                            }
                            $this->index['drop'][] = $h;
                            $this->hashDrop[$h] = true;
                        }
                    }
                }
            }

            return $this->currentDb->getQuery($query);
        }

        return $hash;
    }

    /**
     * @param $hash
     */
    private function readcache($hash)
    {
        /** @noinspection PhpIncludeInspection */
        include_once($this->dir . $hash);
        $this->pointer[$hash] = 0;
        $this->iQuery_id = $hash;
    }

    /**
     * @param $hash
     */
    private function write_cache($hash)
    {
        $data = "<?php \$this->cached['$hash']=" . $this->arr2str($this->cached[$hash]) . '; ?>';
        $this->write_file($hash, $data);
    }

    /**
     * @param $resource
     *
     * @return bool|void
     */
    public function freeResult($resource)
    {
        return $this->currentDb->freeResult($resource);
    }

    /**
     * @param $query_id
     *
     * @return array
     * @internal param $resource
     */
    public function &getRow($query_id)
    {
        $ret = false;
        if (!is_object($query_id)){
            if ($this->pointer[$query_id] < $this->cached[$query_id]['sizeof']){
                $ret = $this->cached[$query_id]['data'][$this->pointer[$query_id]];
                $this->pointer[$query_id]++;
            }
        } else {
            $ret = $this->currentDb->getRow($query_id);
        }

        return $ret;
    }

    /**
     * @param $query_id
     *
     * @return array|bool
     */
    public function fetchRow($query_id)
    {
        $ret =& $this->fetch_assoc($query_id);

        return $ret ? array_values($ret) : $ret;
    }

    /**
     * @param int $query_id
     *
     * @return array|bool
     */
    public function &fetch_assoc($query_id = -1)
    {
        $ret = false;
        if (!is_object($query_id)){
            if ($this->pointer[$query_id] < $this->cached[$query_id]['sizeof']){
                $ret = $this->cached[$query_id]['data'][$this->pointer[$query_id]];
                $this->pointer[$query_id]++;
            }
        } else {
            $ret = $this->currentDb->getRow($query_id);
        }

        return $ret;
    }

    /**
     * @param $query_id
     *
     * @return bool|int
     */
    public function numRows($query_id)
    {
        if (!is_object($query_id)){
            return $this->cached[$query_id]['sizeof'];
        } else {
            return $this->currentDb->numRows($query_id);
        }
    }
}