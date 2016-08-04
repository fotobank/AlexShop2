<?php
/**
 * Framework Component
 * @name      ALEX_CMS
 * @created   by PhpStorm
 * @package   Alex.php
 * @version   1.0
 * @author    Alex Jurii <jurii@mail.ru>
 * @link      http://alex.od.ua
 * @copyright Авторские права (C) 2000-2016, Alex Jurii
 * @date      :     02.08.2016
 * @time      :     23:28
 * @license   MIT License: http://opensource.org/licenses/MIT
 */

namespace core;
use exception\CommonException;


/**
 * Exception
 *
 * @package  Session
 *
 * @author   Alex Jurii
 */
class AlexException extends CommonException
{
}

/**
 * Class Alex
 * @package core
 *
 * сборник статичесских функций
 */
class Alex
{

    /**
     * @param     $dir
     * @param int $mode
     *
     * @throws \core\AlexException
     */
    public static function checkDir($dir, $mode = 0777){
        if (!is_dir($dir)) {
          self::mkDir($dir, $mode);
        }
        $read_mode = substr(sprintf('%o', fileperms($dir)), -4);
        if($read_mode !== $mode)
        {
            self::recursive_chmod($dir, $mode);
        }
    }

    /**
     * @param $dir
     * @param $mode
     *
     * @throws AlexException
     */
    public static function mkDir($dir, $mode = 0777)
    {
        if (!mkdir($dir, $mode, true) && !is_dir($dir)) {
            throw new AlexException('Не возможно создать дирректорию:' . $dir);
        }
    }

    /**
     * @param $path
     * @param $perm
     */
    public static function recursive_chmod($path, $perm) {
        $handle = opendir($path);
        while ( false !== ($file = readdir($handle)) ) {
            if ($file !== '..')  {
                chmod($path . '/' . $file, $perm);
                if ( ($file !== '.') && !is_file($path.'/'.$file) )
                {
                    self::recursive_chmod($path . '/' . $file, $perm);
                }
            }
        }
        closedir($handle);
    }
}