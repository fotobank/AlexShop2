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

use helper\Post\Post as Instance;


/**
 * Proxy Session

 * Class Session
 * @package Proxy

 * @method   static bool|null get($key)
 * @see      proxy\Post::get()
 *
 * @method   static bool|null filter($post_key, $filter)
 * @see      proxy\Post::filter($post_key, $filter)

 * @method   static array set($key, $value)
 * @see      proxy\Post::set()

 * @method   static bool inc($key, $value=1)
 * @see      proxy\Post::inc()

 * @method   static bool dec($key, $value=1)
 * @see      proxy\Post::dec()

 * @method   static bool has($key=null)
 * @see      proxy\Post::has()

 * @method   static void del($key)
 * @see      proxy\Post::del()

 * @method   static bool _has($path)
 * @see      proxy\Post::_has()

 * @method   static array getKeys()
 * @see      proxy\Post::getKeys()

 * @method   static array|mixed _get($path = null)
 * @see      proxy\Post::_get()

 * @method   static Session add($name, $value)
 * @see      proxy\Post::add()

 * @method   static bool|mixed find($value)
 * @see      proxy\Post::find()

 * @method   static array flatten($array, $preserve_keys = false)
 * @see      proxy\Post::flatten()

 * @method   static array arrMultiToOne($arr, &$arr_one)
 * @see      proxy\Post::arrMultiToOne()

 * @method   static array array_merge_recursive_distinct(array &$array1, array &$array2)
 * @see      proxy\Post::array_merge_recursive_distinct()

 * @method   static bool isIn($name, $value)
 * @see      proxy\Post::isIn()

 * @method   static string setDelimiter($delimiter = '/')
 * @see      proxy\Post::setDelimiter()

 * @method   static string getDelimiter()
 * @see      proxy\Post::getDelimiter()

 * @method   static array getAll()
 * @see      proxy\Post::getAll()

 * @method   static array fetchAll()
 * @see      proxy\Post::fetchAll()

 * @method   static Session clear()
 * @see      proxy\Post::clear()
 */
class Post extends AbstractProxy
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
