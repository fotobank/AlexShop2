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

/**
 * ------------------------------------
 * фабричный метод регистрации:
 * ------------------------------------
 * Создание singleton объекта
 * $b = Registry::factory("B", null, "__instance");
 * Или короткий способ
 * $b = Registry::factory("B");
 * Создание обычного объекта c параметрами
 * $c = Registry::factory("C",array($b));
 *
 * ------------------------------------
 * регистрация и удаления объекта:
 * ------------------------------------
 * Создаем и регистрируем singleton объект
 * $b = Registry::register("B");
 * Создаем и регистрируем обычный объект с параметрами
 * Registry::register("C","C",array($b));
 * Экстрагируем объект
 * $c = Registry::extract("C");
 * Регистрируем уже готовый объект
 * Registry::register($c,"D");
 * Разрушаем обычный объект
 * Registry::unregister("D");
 * Разрушаем singleton объект
 * Registry::unregister("B",true);
 * Разрушаем ссылку на B в С
 * Registry::extract("C")->setB(null);
 * разрушаем ссылки на объекты в глобальной области видимости
 * $b = $c = null;
 * теперь остался один зарегистрированный экземпляр С
 * echo Registry::has("C");
 *
 * ------------------------------------
 * или без использования двойных двоеточий:
 * ------------------------------------
 * Создаем и регистрируем обычный объект
 * Registry::register("C");
 * присваиваем инстанс класса переменной
 * $registry = Registry::__instance();
 * читаем и пишем в свойства объекта
 * var_dump($registry->C);
 * $Registry->B = "B";
 * var_dump($registry->B);
 * $registry->D = new C(new B());
 */

namespace helper\Pattern;

use exception\BaseException;

/**
 * Class RegistryException2
 * @package helper\Pattern
 */
class RegistryException2 extends BaseException
{
}

/**
 * Class Registry2
 * @package helper\Pattern
 */
class Registry2
{

    private $tools = []; // array
    private static $instance; // object

    /**
     * Private constructor does nothing
     */
    final private function __construct()
    {
        /* ... */
    }

    /**
     * Return the single instance of object
     * @return object
     */
    public static function & __instance()
    {
        if (!isset(self:: $instance)){
            self:: $instance = new self;
        }

        return self:: $instance;
    }

    /**
     * Register tools
     *
     * @param object|string $tool
     * @param string        $name
     * @param array         $p
     * @param string        $f
     *
     * @return object
     */
    public static function & register($tool, $name = '', $p = null, $f = '__instance')
    {
        if (is_string($tool) && !$name){
            $name = $tool;
        }
        $instance = self:: __instance();
        $instance->tools[$name] = $instance->factory($tool, $p, $f);

        return $instance->tools[$name];
    }

    /**
     * Unregistered tools
     *
     * @param string|object $name
     * @param bool          $force
     */
    public static function unregister($name, $force = false)
    {
        $instance = self:: __instance();
        unset($instance->tools[$name]);
        if ($force && is_callable([$name, '__kill'])){
            $name->__kill();
        }
    }

    /**
     * Search for tool
     *
     * @param $name
     *
     * @return bool
     */
    public static function has($name)
    {
        $instance = self:: __instance();
        if (isset($instance->tools[$name])){
            return true;
        }

        return false;
    }

    /**
     * Factory method
     *
     * @param string|object $name
     * @param null          $params
     * @param string        $func
     *
     * @return object
     * @throws \helper\Pattern\RegistryException2
     */
    public static function & factory($name, $params = null, $func = '__instance')
    {

        if (is_object($name)){
            return $name;
        }

        if (!class_exists($name) && is_callable('__autoload')){
            __autoload($name);
        }

        if (class_exists($name)){
            if (is_callable([$name, $func])){
                return call_user_func_array([$name, $func], $params); // метод $name::$func вызван статично
            } else if (!$params){ // пытаемся сэкономить время
                return new $name();
            } else {
                $reflection = new \ReflectionClass($name);

                return $reflection->newInstanceArgs($params);
            }
        }
        throw new RegistryException2("Class '$name' doesn't declared and can't be loaded!");

    }

    /**
     * Access method for tools
     *
     * @param string $name
     *
     * @return object
     */
    public static function & extract($name)
    {
        if (!self:: has($name)){
            self:: factory($name);
        }
        $instance = self:: __instance();

        return $instance->tools[$name];
    }

    /**
     * Overload
     *
     * @param string $name
     *
     * @return object
     */
    public function __get($name)
    {
        return self:: extract($name);
    }

    /**
     * Overload
     *
     * @param string        $name
     * @param object|string $tool
     *
     * @return object
     */
    public function __set($name, $tool)
    {
        return self:: register($tool, $name);
    }

    /**
     * Cloning is deprecated
     * @throws \helper\Pattern\RegistryException2
     */
    public function __clone()
    {
        throw new RegistryException2('Clone is not allowed!');
    }

    /**
     * Destroy all tools
     */
    public function __destruct()
    {
        $instance = self:: __instance();
        $tools = array_reverse(array_keys($instance->tools), true);
        foreach ((array)$tools as $name){
            self:: unregister($name, true);
        }
    }
}