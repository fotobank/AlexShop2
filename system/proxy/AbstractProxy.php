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
 * Alex Framework Component
 */

/**
 * @namespace
 */
namespace proxy;

use exception\CommonException;
use exception\ComponentException;


/**
 * Abstract Proxy
 */
abstract class AbstractProxy
{

    /**
     * @var array Instances of classes
     */
    protected static $instances = [];

    /**
     * Init class instance
     *
     * @abstract
     * @internal
     * @throws ComponentException
     * @return mixed
     */
    protected static function initInstance()
    {
        throw new ComponentException(
            'Realization of method `initInstance()` is required for class `'. static::class .'`'
        );
    }

    /**
     * Get class instance
     *
     * @throws ComponentException
     * @return mixed
     */
    public static function getInstance()
    {
        $class = static::class;
        if (!isset(static::$instances[$class]))
        {
            static::$instances[$class] = static::initInstance();
            if (!static::$instances[$class])
            {
                throw new ComponentException("Прокси класс `$class` не инициализируется");
            }
        }
        return static::$instances[$class];
    }

    /**
     * Set or replace instance
     *
     * @param  mixed $instance
     * @return void
     */
    public static function setInstance($instance)
    {
        static::$instances[static::class] = $instance;
    }

    /**
     * Handle dynamic, static calls to the object.
     *
     * @internal
     *
     * @param  string $method
     * @param  array  $args
     *
     * @return mixed
     * @throws \Exception
     * @throws \exception\CommonException
     */
    public static function __callStatic($method, $args)
    {
        try
        {
            $instance = static::getInstance();

            // $reflectionMethod = new \ReflectionMethod($instance, $method);
            // return $reflectionMethod->invokeArgs($instance, $args);

            // если вызван метод с неопределенным количеством аргументов
            /*if(isset($args[0]) && is_array($args[0]))
            {
                $args = array_shift($args);
            }*/
            // не нужно проверять метод на существование т.к. мы можем использовать магические методы класса
            // или магические или пустой класс
            // return call_user_func_array([$instance, $method], $args);

              return $instance->$method(...$args);
        }
        catch(CommonException $e)
        {
            throw $e;
        }
    }
}
