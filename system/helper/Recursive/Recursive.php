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

namespace helper\Recursive;

use exception\HelperException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;
use FilesystemIterator;


/**
 * Class Recursive
 *
 * @package helper
 */
class Recursive
{
    // включить дирректории
    protected $inc_dir = [];
    // не включать директории
    protected $exc_dir = [];


    /**
     * быстрый метод сканирования директорий
     *
     * @param string $base - закрывающий слеш обязателен  => dir/foto/
     * @param array $arr_mask = ['jpg', 'png'] - расширение файла без точки
     * @param int $type_array
     *
     * @return array
     * @throws \exception\HelperException
     * param array $data (SCAN_DIR_NAME, SCAN_BASE_NAME, SCAN_MULTI_ARRAY)
     *
     */
    public function scanDir($base = '', $arr_mask, $type_array)
    {
        static $data;
        static $dir;
        $base = str_replace(['\\', '/'], '/', $base);
        if(is_dir($base))
        {
            $array     = array_diff(scandir($base), ['.', '..']);
            $base_name = basename($base);
            foreach($array as $value)
            {
                if(is_dir($base . $value))
                {
                    if(count($this->exc_dir) > 0 && in_array($value, $this->exc_dir, true))
                    {
                        continue;
                    }
                    $dir = $base_name;
                    $data = $this->scanDir($base . $value . DS, $arr_mask, $type_array);
                }
                else
                {
                    if(count($this->inc_dir) > 0 && !in_array($base_name, $this->inc_dir, true))
                    {
                        continue;
                    }
                    $path_parts = pathinfo($value);
                    $extension  = $path_parts['extension'] ?? false;
                    if(count($arr_mask) > 0 && !in_array($extension, $arr_mask, true))
                    {
                        continue;
                    }
                    switch($type_array)
                    {
                        case SCAN_DIR_NAME:
                            $data[$base_name][] = $base . $value;
                            break;
                        case SCAN_BASE_NAME:
                            $path_class = preg_replace('#[\\\/]$#', '', $base);
                            $data[$path_parts['filename']][] = $path_class;
                            break;
                        case SCAN_MULTI_ARRAY:
                            $data[] = [$base_name, $base . $value];
                            break;
                        case SCAN_CAROUSEL_ARRAY:
                            $data[] = [$dir, $base . $value];
                            break;
                        default:
                            $path_class = preg_replace('#[\\\/]$#', '', $base);
                            $data[$path_parts['filename']][] = $path_class;
                    }
                }
            }
        }
        else
        {
            throw new HelperException('не найдена директория сканирования файлов "' . $base . '"', 404);
        }
        return $data;
    }


    /**
     * @param        $path
     *
     * @param string $filter = '/^.+\.php$/i'
     *
     * @return array рекурсивный перебор
     * рекурсивный перебор
     * с фильтрацией
     * return:
     * [
     * ajaxSite => [
     * 0 => O:\domains\anna.od.ua\classes\ajaxSite\ajaxLoad.php
     * 1 => O:\domains\anna.od.ua\classes\ajaxSite\bodyEdit.php
     * 2 => O:\domains\anna.od.ua\classes\ajaxSite\EditBody.php
     * ]
     * ]
     */
    public function recursiveDir($path, $filter = '')
    {
        $directory = new RecursiveDirectoryIterator($path);
        $iterator  = new RecursiveIteratorIterator($directory);
        $flags = RecursiveRegexIterator::GET_MATCH;
        $regex     = ('' !== $filter) ? new RegexIterator($iterator, $filter, $flags) : $iterator;
        $filelist  = [];
        foreach($regex as $key => $entry)
        {
            $name_s              = explode(DIRECTORY_SEPARATOR, dirname($key));
            $name_s              = array_pop($name_s);
            $filelist[$name_s][] = $key;
        }

        return $filelist;
    }

    /**
     * выводит массив дерева файлов и каталогов
     * с фильтрацией
     *
     * @param        $path
     * @param string $filter  = '/^.+\.php$/i';
     *
     * @return array
     */
    public function recursiveTree($path, $filter = '')
    {
        $flags =  RecursiveIteratorIterator::CHILD_FIRST;
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), $flags);
        $flags = RecursiveRegexIterator::GET_MATCH;
        $regex    = ('' !== $filter) ? new RegexIterator($iterator, $filter, $flags) : $iterator;
        $tree     = [];
        foreach($regex as $splFileInfo)
        {
            for($depth = $iterator->getDepth() - 1; $depth >= 0; $depth--)
            {
                $splFileInfo = [$iterator->getSubIterator($depth)->current()->getFilename() => $splFileInfo];
            }
            $tree = array_merge_recursive($tree, $splFileInfo);
        }
        return $tree;
    }

    /**
     * @param        $path
     * @param string $ext - расширение файла для фильтра
     *
     * file: O:\domains\anna.od.ua\classes\Backup.php
     * return:
     * [
     * Backup => [ 0 => O:\domains\anna.od.ua\classes]
     * ]
     *
     * @return array
     */
    public function recursiveFile($path, $ext = 'php')
    {
        $files = [];
        $flags = FilesystemIterator::SKIP_DOTS | FilesystemIterator::FOLLOW_SYMLINKS;
        $iterator = new RecursiveDirectoryIterator($path, $flags);
        $iterator = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::SELF_FIRST);
        foreach ($iterator as $file_info)
        {
            $file_info->getExtension() !== $ext or $files[$file_info->getBaseName('.'.$ext)][] = $file_info->getPath();
        }
        return $files;
    }

    /**
     * @param array $inc_dir
     *
     * @return $this
     */
    public function setIncDir($inc_dir)
    {
        if(is_array($inc_dir))
        {
            $this->inc_dir = array_merge($this->inc_dir, $inc_dir);
        }
        else
        {
            $this->inc_dir[] = $inc_dir;
        }
        return $this;
    }

    /**
     * @param array $exc_dir
     *
     * @return $this
     */
    public function setExcDir($exc_dir)
    {
        if(is_array($exc_dir))
        {
            $this->exc_dir = array_merge($this->exc_dir, $exc_dir);
        }
        else
        {
            $this->exc_dir[] = $exc_dir;
        }
        return $this;
    }
}