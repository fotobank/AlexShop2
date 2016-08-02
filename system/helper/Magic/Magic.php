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
 * Class Magic
 * PHP magic wrapper
 *
 * пример:
 * protected $data;
 * public function exists($key) { return array_key_exists($key, $this->data); }
 * public function set($key, $val) { $this->data[$key] = $val; }
 * public function &get($key) { return $this->data[$key]; }
 * public function clear($key) { unset($this->data[$key]); }
 *
 * class Foo() extend Magic { ... }
 * $t =new Foo()
 * $t->test = 1; // set('test', 1)
 * exho $t->test; // 1
 *
 */

namespace helper\Magic;



/**
 * Class Magic
 *
 * @package helper\Magic
 */
abstract class Magic implements \ArrayAccess
{
    /**
     *    Вернуться true, если ключ не пуст
     * @return bool
     * @param $key string
     **/
    public abstract function exists($key);

    /**
     * Привязать значение ключа
     * @return mixed
     * @param $key string
     * @param $val mixed
     **/
    public abstract function set($key, $val);

    /**
     * Получить содержимое ключа
     * @return mixed
     * @param $key string
     **/
    public abstract function &get($key);

    /**
     * Удалить ключ
     * @return NULL
     * @param $key string
     **/
    public abstract function clear($key);

    /**
     * метод для проверки значения key
     * @return mixed
     * @param $key string
     **/
    public function __isset($key)
    {
        return $this->visible($this, $key) ? isset($this->$key) : $this->exists($key);
    }

    /**
     * метод для проверки значения value
     * @return mixed
     * @param $key string
     * @param $val
     **/
    public function __set($key, $val)
    {
        return $this->visible($this, $key) ? ($this->$key = $val) : $this->set($key, $val);
    }

    /**
     * метод для получения значения свойства
     *    Alias for offsetget()
     * @return mixed
     * @param $key string
     **/
    public function &__get($key)
    {
        if ($this->visible($this, $key)) {
            $val = &$this->$key;
        } else {
            $val = &$this->get($key);
        }
        return $val;
    }

    /**
     *  метод для удаления значения свойства
     *    Alias for offsetunset()
     * @return NULL
     * @param $key string
     **/
    public function __unset($key)
    {
        if ($this->visible($this, $key)) {
            unset($this->$key);
        } else {
            $this->clear($key);
        }
    }

    /**
     *    Return TRUE if property has public visibility
     * @return bool
     * @param $obj object
     * @param $key string
     **/
    public function visible($obj, $key)
    {
        if (property_exists($obj, $key)) {
            $ref = new \ReflectionProperty(get_class($obj), $key);
            $out = $ref->isPublic();
            unset($ref);
            return $out;
        }
        return FALSE;
    }
}
