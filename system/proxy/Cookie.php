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

use helper\Cookie\Cookie as Instance;


/**
 * Proxy Session
 *
 * Class Session
 * @package Proxy
 *
 * @method   static bool|null get($name)
 * @see      proxy\Cookie::get()
 *
 * @method   static bool inc($name, $value=1)
 * @see      proxy\Cookie::inc()
 *
 * @method   static bool dec($name, $value=1)
 * @see      proxy\Cookie::dec()
 *
 * @method   static bool has($name)
 * @see      proxy\Cookie::has()
 *
 * @method   static void del($name)
 * @see      proxy\Cookie::del()
 *
 * @method   static array CookieKeys()
 * @see      proxy\Cookie::CookieKeys()
 *
 * @method   static bool isIn($name, $value)
 * @see      proxy\Cookie::isIn()
 *
 * @method   static string setDelimiter($delimiter = '/')
 * @see      proxy\Cookie::setDelimiter()
 *
 * @method   static string getDelimiter()
 * @see      proxy\Cookie::getDelimiter()
 *
 * @method   static array CookieAll()
 * @see      proxy\Cookie::CookieAll()
 *
 * @method   static array fetchAll()
 * @see      proxy\Cookie::fetchAll()
 *
 * @method   static object|void set($name, $value, $expire  = 0, $path  = '', $domain  = '', $secure  = 0)
 * @see      proxy\Cookie::set()
 *
 */
class Cookie extends AbstractProxy
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