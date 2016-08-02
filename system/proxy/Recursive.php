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

namespace proxy;

use helper\Recursive\Recursive as Instance;


/**
 * Class Recursive
 * @package Proxy
 *
 * $type_array (SCAN_DIR_NAME, SCAN_BASE_NAME, SCAN_MULTI_ARRAY, SCAN_CAROUSEL_ARRAY)
 * @method   static array scanDir($base = '', $arr_mask = [], $type_array = SCAN_BASE_NAME,  &$data = [])
 * @see      proxy\Recursive::scanDir()
 *
 * @method   static array recursiveDir($path, $filter = '')
 * @see      proxy\Recursive::recursiveDir()
 *
 * @method   static array recursiveTree($path, $filter = '')
 * @see      proxy\Recursive::recursiveTree()
 *
 * @method   static array recursiveFile($path, $ext = 'php')
 * @see      proxy\Recursive::recursiveFile()
 *
 * @method   static $this setIncDir($inc_dir)
 * @see      proxy\Recursive::setIncDir()
 *
 * @method   static $this setExcDir($exc_dir)
 * @see      proxy\Recursive::setExcDir()
 */
class Recursive extends AbstractProxy
{
    /**
     * Init instance
     *
     * @return Instance
     */
    protected static function initInstance()
    {
        return new Instance();
    }
}