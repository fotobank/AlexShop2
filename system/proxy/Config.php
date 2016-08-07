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

/**
 * Framework Component
 */

/**
 * @namespace
 */
namespace proxy;

use lib\Config\Config as Instance;
use lib\Config\ConfigException;
use exception\ComponentException;

/**
 * Proxy to Config
 * Example of usage
 *     use proxy\Config;
 *     if (!Config::getData('db')) {
 *          throw new Exception('Configuration for `db` is missed');
 *     }
 * @property  string $root_url
 * @package  Proxy
 * @method   Config static Instance getInstance()
 * @method   static array getData($key = null, $section = null)
 * @see      proxy\Config\Config::getData()
 */
class Config extends AbstractProxy
{
    /**
     * Init instance
     * @return \lib\Config\Config
     *
     * @throws \Exception
     * @throws ConfigException
     */
    protected static function initInstance()
    {
        try
        {
            return new Instance();

        } catch(\Exception $e)
        {
            throw $e;
        }
    }

    /**
     * @throws ComponentException
     * @throws \Exception
     */
    public static function reLoad()
    {
        $class = static::class;
        static::$instances[$class] = static::initInstance();
        if (!static::$instances[$class])
        {
            throw new ComponentException("Прокси класс `$class` не инициализируется");
        }
    }
}
