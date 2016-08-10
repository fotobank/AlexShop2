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

use helper\Session\Session as Instance;


/**
 * Proxy Session
 *
 * Class Session
 * @package Proxy
 *
 * @method   static bool|null get($key)
 * @see      proxy\Session::get()
 *
 * @method   static array set($key, $value)
 * @see      proxy\Session::set()
 *
 * @method   static bool inc($key, $value=1)
 * @see      proxy\Session::inc()
 *
 * @method   static bool dec($key, $value=1)
 * @see      proxy\Session::dec()
 *
 * @method   static bool has($key)
 * @see      proxy\Session::has()
 *
 * @method   static void del($key)
 * @see      proxy\Session::del()
 *
 * @method   static bool _has($path)
 * @see      proxy\Session::_has()
 *
 * @method   static array getKeys()
 * @see      proxy\Session::getKeys()
 *
 * @method   static array|mixed _get($path = null)
 * @see      proxy\Session::_get()
 *
 * @method   static Session add($name, $value)
 * @see      proxy\Session::add()
 *
 * @method   static bool|mixed find($value)
 * @see      proxy\Session::find()
 *
 * @method   static array flatten($array, $preserve_keys = false)
 * @see      proxy\Session::flatten()
 *
 * @method   static array arrMultiToOne($arr, &$arr_one)
 * @see      proxy\Session::arrMultiToOne()
 *
 * @method   static array array_merge_recursive_distinct(array &$array1, array &$array2)
 * @see      proxy\Session::array_merge_recursive_distinct()
 *
 * @method   static bool isIn($name, $value)
 * @see      proxy\Session::isIn()
 *
 * @method   static string setDelimiter($delimiter = '/')
 * @see      proxy\Session::setDelimiter()
 *
 * @method   static string getDelimiter()
 * @see      proxy\Session::getDelimiter()
 *
 * @method   static array getAll()
 * @see      proxy\Session::getAll()
 *
 * @method   static array fetchAll()
 * @see      proxy\Session::fetchAll()
 *
 * @method   static Session clear()
 * @see      proxy\Session::clear()
 *
 * @method   static bool sessionExists()
 * @see      proxy\Session::sessionExists()
 *
 * @method   static void start()
 * @see      proxy\Session::start()
 *
 * @method   static string getId()
 * @see      proxy\Session::getId()
 *
 * @method   static bool Session sessionExists()
 * @see      proxy\Session::sessionExists()
 *
 * @method   static destroy()
 * @see      proxy\Session::destroy()
 *
 * @method   static bool cookieExists()
 * @see      proxy\Session::cookieExists()
 *
 * @method   static void expireSessionCookie()
 * @see      proxy\Session::expireSessionCookie()
 *
 * @method   static string getName()
 * @see      proxy\Session::getName()
 *
 * @method   static Session setName($name)
 * @see      proxy\Session::setName()
 *
 * @method   static void setSessionCookieLifetime($ttl)
 * @see      proxy\Session::setSessionCookieLifetime()
 *
 * @method   static bool regenerateId($deleteOldSession = true)
 * @see      proxy\Session::regenerateId()
 *
 * @method   static Session setId($id)
 * @see      proxy\Session::setId()
 *
 * @method   static Session check_session()
 * @see      proxy\Session::check_session()
 *
 */
class Session extends AbstractProxy
{
    /**
     * Init instance
     * @return Instance
     * @throws \exception\ComponentException
     */
    protected static function initInstance()
    {
        return new Instance(Config::getInstance());
    }
}