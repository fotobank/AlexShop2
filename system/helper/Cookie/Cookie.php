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

namespace helper\Cookie;

use helper\ArrayHelper\ArrayHelper;


/**
 * Class Server
 */
class Cookie extends ArrayHelper
{
    /**
     * конструктор
     */
    public function __construct()
    {
        if(null !==$_COOKIE)
        {
            $this->properties = &$_COOKIE;
        }

    }

    /**
     * @param $name
     * @param $value
     * @param $expire
     * @param $path
     * @param $domain
     * @param $secure
     *
     * @return $this|void
     */
    public function set($name, $value, $expire  = 0, $path  = '/', $domain  = '', $secure  = 0)
    {
        setcookie ($name, $value, $expire, $path, $domain, $secure);
    }

    /**
     * Delete a value from session by its key.
     *
     * @param $name
     *
     * @return bool
     * @internal param $key
     */
    public function del($name)
    {
        setcookie ($name, $value = '', 1);
    }
}
