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


use lib\Config\Config;
use core\Db\Cache\InterfaceDataBaseCache;
use core\Db\Cache\DataBaseCache;

/**
 * Class DataBase
 * @package core\Db\Strategy
 */
class DataBase implements InterfaceDataBase
{

    /**
     *
     * @var InterfaceDataBaseCache | InterfaceDataBaseSelectTypeStrategy $Db подключаемая с кэшем или без база данных
     */
    protected $Db;


    /**
     * DataBaseSelect constructor.
     *
     * @param \lib\Config\Config $configs
     *
     * @throws \Exception
     */
    public function __construct(Config $configs)
    {
        try {
            /**
             * @var string $dbCache включение кэша ('0' или '1')
             */
            $dbCache = $configs->getData('config', 'dbCache');
            if ($dbCache){
                $this->Db = new DataBaseCache($configs);
            } else {
                $this->Db = new DataBaseSelectType($configs);
            }
        } catch (\Exception $e) {
            throw $e;
        }
       
    }

    /**
     * @return InterfaceDataBaseCache | InterfaceDataBaseSelectTypeStrategy $this->Db
     */
    public function getDb()
    {
        return $this->Db;
    }
    
}