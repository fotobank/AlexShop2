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
error_reporting(E_ALL);

use core\Db\MysqliDb;
use proxy\Config;
use core\Autoloader;



require_once(__DIR__ . '/../../../system/core/Db/tests/MysqliDbTest/MysqliDbTest.php');
require_once(SYS_DIR . 'core/Autoloader.php');
new Autoloader();

require_once(__DIR__ . '/../../core/Db/MysqliDb.php');


/**
 * Class MysqliDbTest
 * @package core\Db
 */
class MysqliDbTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var MysqliDb
     */
    private $mysqliDb;
    private $tables = [];
    private $data = [];
    private $id;


    protected function setUp()
    {

        $configDb = Config::getData('db');
        $this->mysqliDb = new MysqliDb(
            $configDb['dbhost'],
            $configDb['dbuser'],
            $configDb['dbpass'],
            $configDb['dbname'],
            $configDb['dbport'],
            $configDb['dbencoding']
        );

        $this->mysqliDb->connect();

        $this->data = [
            '_users' => [
                [
                    'login' => 'user1',
                    'customerId' => 10,
                    'firstName' => 'John',
                    'lastName' => 'Doe',
                    'password' => $this->mysqliDb->func('SHA1(?)', ['secretpassword+salt']),
                    'createdAt' => $this->mysqliDb->now(),
                    'expires' => $this->mysqliDb->now('+1Y'),
                    'loginCount' => $this->mysqliDb->inc()
                ],
                [
                    'login' => 'user2',
                    'customerId' => 10,
                    'firstName' => 'Mike',
                    'lastName' => null,
                    'password' => $this->mysqliDb->func('SHA1(?)', ['secretpassword2+salt']),
                    'createdAt' => $this->mysqliDb->now(),
                    'expires' => $this->mysqliDb->now('+1Y'),
                    'loginCount' => $this->mysqliDb->inc(2)
                ],
                [
                    'login' => 'user3',
                    'active' => true,
                    'customerId' => 11,
                    'firstName' => 'Pete',
                    'lastName' => 'D',
                    'password' => $this->mysqliDb->func('SHA1(?)', ['secretpassword2+salt']),
                    'createdAt' => $this->mysqliDb->now(),
                    'expires' => $this->mysqliDb->now('+1Y'),
                    'loginCount' => $this->mysqliDb->inc(3)
                ]
            ],
            '_products' => [
                [
                    'customerId' => 1,
                    'userId' => 1,
                    'productName' => 'product1',
                ],
                [
                    'customerId' => 1,
                    'userId' => 1,
                    'productName' => 'product2',
                ],
                [
                    'customerId' => 1,
                    'userId' => 1,
                    'productName' => 'product3',
                ],
                [
                    'customerId' => 1,
                    'userId' => 2,
                    'productName' => 'product4',
                ],
                [
                    'customerId' => 1,
                    'userId' => 2,
                    'productName' => 'product5',
                ],

            ]
        ];
        $this->tables = [
            '_users' => [
                'login' => 'char(10) not null',
                'active' => 'bool default 0',
                'customerId' => 'int(10) not null',
                'firstName' => 'char(10) not null',
                'lastName' => 'char(10)',
                'password' => 'text not null',
                'createdAt' => 'datetime',
                'expires' => 'datetime',
                'loginCount' => 'int(10) default 0'
            ],
            '_products' => [
                'customerId' => 'int(10) not null',
                'userId' => 'int(10) not null',
                'productName' => 'char(50)'
            ]
        ];

        $this->mysqliDb->setTrace(true);
    }

    public function testSetPrefix() {
        $prefix = 'TEST';
        $this->mysqliDb->setPrefix($prefix);
        static::assertEquals($prefix, MysqliDb::$prefix, 'error in setPrefix()');
    }

    protected function tearDown()
    {
        $this->mysqliDb = null;
    }

    public function testConnectionIsDbValid()
    {
        // проверка валидности соединения с базой
        static::assertInstanceOf('core\Db\MysqliDb', $this->mysqliDb, 'Cannot declare class core\Db\MysqliDb');
        static::assertEquals(true, $this->mysqliDb !== false, 'нет подключения к базе данных');
    }

    /**
     * @param       $name
     * @param array $fields
     */
    private function createTable ($name, array $fields) {

        //$q = "CREATE TABLE $name (id INT(9) UNSIGNED PRIMARY KEY NOT NULL";
        $q = 'CREATE TABLE ' . $name . ' (id INT(9) UNSIGNED PRIMARY KEY AUTO_INCREMENT';
        foreach ($fields as $k => $v) {
            $q .= ", $k $v";
        }
        $q .= ')';
        $this->mysqliDb->rawQuery($q);
    }

    public function testRawQuery() {
        foreach ($this->tables as $name => $fields) {
            $this->mysqliDb->rawQuery('DROP TABLE ' . MysqliDb::$prefix . $name);
            $this->createTable (MysqliDb::$prefix . $name, $fields);
        }
    }

    public function testInsert() {
        // insert test with autoincrement
        foreach ($this->data as $name => $datas) {
            foreach ($datas as $d) {
                $this->id = $this->mysqliDb->insert($name, $d);
                static::assertEquals(true, $this->id, 'bad insert test failed');
            }
        }
    }

    public function testBadInsertTest() {

        $badUser = ['login' => null,
            'customerId' => 10,
            'firstName' => 'John',
            'lastName' => 'Doe',
            'password' => 'test',
            'createdAt' => $this->mysqliDb->now(),
            'expires' => $this->mysqliDb->now('+1Y'),
            'loginCount' => $this->mysqliDb->inc()
        ];

        $id = $this->mysqliDb->insert ('_users', $badUser);
        static::assertEquals(false, $id, 'bad insert test failed');
    }



}