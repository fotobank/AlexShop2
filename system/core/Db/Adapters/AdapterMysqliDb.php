<?php
/**
 * Framework Component
 * @name      ALEX_CMS
 * @author    Alex Jurii <jurii@mail.ru>
 * The MIT License (MIT)
 * Copyright (c) 2016
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace core\Db\Adapters;

use core\Db\MysqliDb\MysqliDb;
use exception\DbException;
use lib\Config\Config;

/** @noinspection RealpathOnRelativePathsInspection */
defined('ROOT') or define('ROOT', realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' .
        DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR);


/**
 * Class Mysqli_Db
 * @package core\Db
 */
class AdapterMysqliDb  implements InterfaceDbAdapters
{

    public $timeQuery = 0;
    public $timeQueries = 0;
    public $numQueries = 0;
    public $listQueries = [];
    protected $mysqliDb;


    /**
     * AdapterMysqliDb constructor.
     *
     * @param Config $configs
     *
     * @throws \exception\Db_Exception
     * @throws \RuntimeException
     * @throws \lib\Config\ConfigException
     */
    public function __construct(Config $configs)
    {
        if(DEBUG_MODE) {mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);}
        $connectSettings = $configs->getData('db');
        
        if (!is_array($connectSettings)){
            throw new DbException('ошибка в файле конфигурации базы данных', 500);
        }
        // if params were passed as array
        if (is_array($connectSettings['dbhost'])){
            $this->mysqliDb = new MysqliDb($connectSettings['dbhost']);
        } else {
            $this->mysqliDb = new MysqliDb(
                $connectSettings['dbhost'],
                $connectSettings['dbuser'],
                $connectSettings['dbpass'],
                $connectSettings['dbname'],
                ($connectSettings['dbport'] == 'default') ? ini_get('mysqli.default_port') : $connectSettings['dbport'],
                $connectSettings['dbencoding']
            );
        }
        $this->mysqliDb->setPrefix($connectSettings['prefix']);
    }

    /**
     * @param $sql
     *
     * @return bool|\mysqli_result
     * @throws \RuntimeException
     */
    public function getQuery($sql)
    {
        $timer = microtime(1);

        $result = mysqli_query($this->mysqliDb->mysqli(), $sql);
        if ($result === false){
            if(DEBUG_MODE) {
                $this->printErrorBacktrace();
            } else {
                writeInLog('[Ошибка в базе данных] - запрос: ' . $sql, 'db_query');
            }

        }
        $this->timeQuery += microtime(1) - $timer;
        $this->timeQueries += $this->timeQuery;
        $this->numQueries++;

        if (DEBUG_MODE){
            $this->listQueries[$this->numQueries] = [$sql, $this->timeQuery];
        }

        return $result;
    }


    /**
     * @param $data
     *
     * @return array|string
     * @internal param $str
     * @throws \RuntimeException
     */
    public function safesql($data)
    {
        if (is_array($data)){
            $data = array_map('self::escape', $data);
        } else {
            $data = mysqli_real_escape_string($this->mysqliDb->mysqli(), $data);
        }

        return $data;
    }

    /**
     * @param $resource
     *
     * @return bool|void
     */
    public function freeResult($resource)
    {
        mysqli_free_result($resource);
    }

    /**
     * @param $resource
     *
     * @return array
     */
    public function getRow($resource)
    {
        return mysqli_fetch_assoc($resource);

    }

    /**
     * @param $resource
     *
     * @return array|bool
     */
    public function fetchRow($resource)
    {
        return mysqli_fetch_array($resource);
    }

    /**
     * @param $resource
     *
     * @return bool|int
     */
    public function numRows($resource)
    {
        return mysqli_num_rows($resource);
    }

    /**
     * @return \mysqli
     * @throws \RuntimeException
     */
    public function getSql() {
        return $this->mysqliDb->mysqli();
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->mysqliDb->$name(...$arguments);
    }

    /**
     * @param $name
     */
    public function __get($name)
    {
        return $this->mysqliDb->$name;
    }

    public function __isset($name)
    {
       return isset($this->mysqliDb->$name) ?? null;
    }

    /**
     * @param $name
     * @param $value
     *
     * @return mixed
     */
    public function __set($name, $value)
    {
        return $this->mysqliDb->$name = $value;
    }

    protected function printErrorBacktrace()
    {
        $error = mysqli_error($this->mysqliDb->mysqli());
        $trace = debug_backtrace();
        $head = $error ? '<b style="color:red">MySQL ERROR_NO: ' . $this->mysqliDb->mysqli()->errno . ' </b><br>
            <b style="color:green">' . $error . '</b><br>' : null;

        $error_log = '[' . date('Y-m-d h:i:s') . ']<br> ' . $head . '
            <b>Query:</b>
            <pre><span style="color:#990099"><b style="color:red">' . $trace[0]['args'][0] . '</b></span></pre>
            <b>File: </b><b style="color:#660099">' . $trace[0]['file'] . '</b><br>
            <b>Line: </b><b style="color:#660099">' . $trace[0]['line'] . '</b>';

        dump($trace);
        die($error_log);
    }
}