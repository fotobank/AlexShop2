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

namespace core\Db\Strategy;


use core\Db\Adapters\InterfaceDbAdapters;
use lib\Config\Config;

/**
 * Class DataBaseSelect
 * @package core\Db\Strategy
 */
class DataBaseSelectType implements InterfaceDataBaseSelectTypeStrategy
{
    /**
     * @var InterfaceDbAdapters $currentDb инициализированная база данных
     */
    protected $currentDb;

    /**
     * DataBaseSelect constructor.
     *
     * @param \lib\Config\Config $configs
     *
     * @throws \lib\Config\ConfigException
     */
    public function __construct(Config $configs)
    {
        /**
         * @var string $dbType имя подключаемой базы данных (для подключения баз разных типов)
         */
        $dbType = 'core\Db\Adapters\Adapter'.$configs->getData('config', 'dbType');
        /**
         * запуск InterfaceDbAdapters
         */
        $this->currentDb = new $dbType($configs);
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments) {

       return $this->currentDb->$name(...$arguments);

    }

    /**
     * @param $name
     */
    public function __get($name)
    {
        return $this->currentDb->$name;
    }

    /**
     * @param $name
     * @param $value
     *
     * @return mixed
     */
    public function __set($name, $value)
    {
        return $this->currentDb->$name = $value;
    }

    /**
     * @return mixed
     */
    public function getCurrentDb()
    {
        return $this->currentDb;
    }
}