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

use core\Db\Strategy\DataBase;


/**
 * Proxy to Db
 *
 * Example of usage
 *     use proxy\Db;
 *
 *     Db::init()
 *
 * @package  Alex\Proxy
 *
 * @method   static Db|bool init()
 * @see      proxy\Db::init()
 *
 * @method   static Db setPrefix($prefix = '')
 * @see      proxy\Db::setPrefix()
 *
 * @method   static array rawQuery ($query, $bindParams = null, $sanitize = true)
 * @see      proxy\Db::rawQuery ()
 *
 * @method   static array query($query, $numRows = null)
 * @see      proxy\Db::getQuery()
 *
 * @method   static Db setQueryOption ($options)
 * @see      proxy\Db::setQueryOption()
 *
 * @method   static Db withTotalCount()
 * @see      proxy\Db::withTotalCount()
 *
 * @method   static array getOne($tableName, $columns = '*')
 * @see      proxy\Db::getOne()
 *
 * @method   static array getValue($tableName, $column)
 * @see      proxy\Db::getValue()
 *
 * @method   static boolean insert_($tableName, $insertData)
 * @see      proxy\Db::insert_()
 *
 * @method   static boolean insert($tableName, $insertData, $insertPrefix = NULL)
 * @see      proxy\Db::insert()
 *
 * @method   static array has($tableName)
 * @see      proxy\Db::has()
 *
 * @method   static boolean update($tableName, $tableData)
 * @see      proxy\Db::update()
 *
 * @method   static boolean delete($tableName, $numRows = null)
 * @see      proxy\Db::delete()
 *
 * @method   static Db where($whereProp, $whereValue = null, $operator = null)
 * @see      proxy\Db::where()
 *
 * @method   static Db orWhere($whereProp, $whereValue = null, $operator = null)
 * @see      proxy\Db::orWhere()
 *
 * @method   static Db orderBy($orderByField, $orderbyDirection = 'DESC', $customFields = null)
 * @see      proxy\Db::orderBy()
 *
 * @method   static Db groupBy($groupByField)
 * @see      proxy\Db::groupBy()
 *
 * @method   static integer getInsertId()
 * @see      proxy\Db::getInsertId()
 *
 * @method   static bool escape($str)
 * @see      proxy\Db::escape()
 *
 * @method   static bool ping()
 * @see      proxy\Db::ping()
 *
 * @method   static __destruct()
 * @see      proxy\Db::__destruct()
 *
 * @method   static string getLastQuery()
 * @see      proxy\Db::getLastQuery()
 *
 * @method   static string getLastError()
 * @see      proxy\Db::getLastError()
 *
 * @method   static array getSubQuery()
 * @see      proxy\Db::getSubQuery()
 *
 * @method   static string interval($diff, $func = 'NOW()')
 * @see      proxy\Db::interval ()
 *
 * @method   static array now($diff = null, $func = 'NOW()')
 * @see      proxy\Db::now ()
 *
 * @method   static array inc($num = 1)
 * @see      proxy\Db::inc()
 *
 * @method   static array dec($num = 1)
 * @see      proxy\dec()
 *
 * @method   static array not($col = null)
 * @see      proxy\Db::not()
 *
 * @method   static array func($expr, $bindParams = null)
 * @see      proxy\Db::func()
 *
 * @method   static Db subQuery($subQueryAlias = '')
 * @see      proxy\Db::subQuery()
 *
 * @method   static mixed copy()
 * @see      proxy\Db::copy()
 *
 * @method   static startTransaction()
 * @see      proxy\Db::startTransaction()
 *
 * @method   static commit()
 * @see      proxy\Db::commit()
 *
 * @method   static rollback()
 * @see      proxy\Db::rollback()
 *
 * @method   static _transaction_status_check()
 * @see      proxy\Db::_transaction_status_check()
 *
 * @method   static Db setTrace ($enabled, $stripPrefix = null)
 * @see      proxy\Db::setTrace()
 *
 * @method   static string _traceGetCaller()
 * @see      proxy\Db::_traceGetCaller()
 *
 * @method   static array|bool getParam($file = '')
 * @see      proxy\Db::getParam()
 *
 * @method   static connect()
 * @see      proxy\Db::connect()
 *
 * @method   static $this|array get($tableName, $numRows = null, $columns = '*')
 * @see      proxy\Db::get()
 *
 * @method   static string getCount()
 * @see      proxy\Db::getCount()
 *
 * @method   static bool|\mysqli_result getQuery($str)
 * @see      proxy\Db::getQuery()
 *
 * @method   static bool|\mysqli_result queryDb($sql, $print = false)
 * @see      proxy\Db::queryDb()
 *
 * @method   static array|string safesql($data)
 * @see      proxy\Db::safesql()
 *
 * @method   static bool|void freeResult($resource)
 * @see      proxy\Db::freeResult()
 *
 * @method   static array getRow($resource)
 * @see      proxy\Db::getRow()
 *
 * @method   static array|bool fetchRow($resource)
 * @see      proxy\Db::fetchRow()
 *
 * @method   static bool|int numRows($resource)
 * @see      proxy\Db::numRows()
 * 
 * @method   static  getSql()
 * @see      proxy\Db::getSql()
 *
 * @author   Alex Jurii
 * @package  Proxy
 */
class Db extends AbstractProxy
{
    /**
     * @return \core\Db\Db
     * @throws \Exception
     * @throws \exception\Db_Exception
     */
    protected static function initInstance()
    {
        try
        {
            $db = new DataBase(Config::getInstance());
            return $db->getDb();

        }
        catch(\Exception $e)
        {
            throw $e;
        }
    }
}