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

namespace core\Db\MysqliDb;

use mysqli;
use mysqli_stmt;
use stdClass;

/**
 * MysqliDb Class
 * @category  Database Access
 * @package   MysqliDb
 * @author    Jeffery Way <jeffrey@jeffrey-way.com>
 * @author    Josh Campbell <jcampbell@ajillion.com>
 * @author    Alexander V. Butenko <a.butenka@gmail.com>
 * @copyright Copyright (c) 2010
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @link      http://github.com/joshcam/PHP-MySQLi-Database-Class
 * @version   2.6b-master
 */
class MysqliDb
{

    /**
     * Table prefix
     * @var string
     */
    public static $prefix = '';
    /**
     * Static instance of self
     * @var MysqliDb
     */
    protected static $_instance;
    /**
     * Переменная, которая удерживает количество возвращаемых строк во время Get / getOne / SELECT запросов
     * @var string
     */
    public $count = 0;
    /**
     * Переменная, которая удерживает количество возвращаемых строк во время Get / getOne / выберите запросы с
     * withTotalCount ()
     * @var string
     */
    public $totalCount = 0;
    /**
     * Тип возвращаемого значения: 'Array' возвращать результаты как массив, 'Object' как объект
     * 'Json' в качестве JSon строки
     * @var string
     */
    public $returnType = 'array';
    public $trace = [];
    /**
     * Per page limit for pagination
     * @var int
     */

    public $pageLimit = 20;
    /**
     * Variable that holds total pages count of last paginate() query
     * @var int
     */
    public $totalPages = 0;
    /**
     * MySQLi instance
     * @var mysqli
     */
    protected $_mysqli;
    /**
     * Запрос SQL должен быть подготовлен и выполнен
     * @var string
     */
    protected $_query;
    /**
     * Ранее выполненного запроса SQL
     * @var string
     */
    protected $_lastQuery;
    /**
     * Параметры SQL-запроса требуется после того SELECT, INSERT, UPDATE or DELETE
     * @var string
     */
    protected $_queryOptions = []; // Create the empty 0 index
    /**
     * An array that holds where joins
     * @var array
     */
    protected $_join = []; // Create the empty 0 index
    /**
     * Массив что имеет место 'fieldname' => 'value'
     * @var array
     */
    protected $_where = [];
    /**
     * An array that holds having conditions
     * @var array
     */
    protected $_having = [];
    /**
     * Динамический тип списка для заказа
     * @var array
     */
    protected $_orderBy = [];
    /**
     * Динамический список типа для группы по значению условием
     */
    protected $_groupBy = [];
    /**
     * Dynamic array that holds a combination of where condition/table data value types and parameter references
     * @var array
     */
    protected $_bindParams = [''];
    /**
     * Variable which holds last statement error
     * @var string
     */
    protected $_stmtError;
    /**
     * Database credentials
     * @var string
     */
    protected $host;
    protected $username;
    protected $password;
    protected $db;
    protected $port;
    protected $charset;
    /**
     * Is Subquery object
     * @var bool
     */
    protected $isSubQuery = false;
    /**
     * Name of the auto increment column
     * @var int
     */
    protected $_lastInsertId;
    /**
     * Имена столбцов для обновления при использовании onDuplicate метода
     * @var array
     */
    protected $_updateColumns;
    /**
     * Следует join() результаты быть вложенные таблицы
     * @var bool
     */
    protected $_nestJoin = false;
    /**
     * FOR UPDATE flag
     * @var bool
     */
    protected $_forUpdate = false;
    /**
     * LOCK IN SHARE MODE flag
     * @var bool
     */
    protected $_lockInShareMode = false;
    /**
     * Key field for Map()'ed result array
     * @var string
     */
    protected $_mapKey;
    /**
     * Variables for query execution tracing
     */
    protected $traceStartQ;
    protected $traceEnabled;
    protected $traceStripPrefix;
    /**
     * Table name (with prefix, if used)
     * @var string
     */
    private $_tableName = '';

    private $_transaction_in_progress;

    /**
     * @param string|array $host
     * @param string $username
     * @param string $password
     * @param string $db
     * @param int    $port
     * @param string $charset
     */
    public function __construct($host = null, $username = null, $password = null, $db = null, $port = null, $charset = 'utf8')
    {
        $isSubQuery = false;
        // если параметры были переданы как массив
        if (is_array($host)){
            foreach ($host as $key => $val){
                $$key = $val; // $isSubQuery и $host для subQuery
            }
        }
        // if host were set as mysqli socket
        if (is_object($host)){
            $this->_mysqli = $host;
        } else {
            $this->host = $host;
        }

        $this->username = $username;
        $this->password = $password;
        $this->db = $db;
        $this->port = (int)$port;
        $this->charset = $charset;

        if ($isSubQuery){
            $this->isSubQuery = true;

            return;
        }

        if (isset($prefix)){
            $this->setPrefix($prefix);
        }

        self::$_instance = $this;
    }

    /**
     * Method to set a prefix
     *
     * @param string $prefix Contains a tableprefix
     *
     * @return MysqliDb
     */
    public function setPrefix($prefix = '')
    {
        self::$prefix = $prefix;

        return $this;
    }

    /**
     * Способ возврата статический экземпляр, чтобы обеспечить доступ к
     * Инстанцирован объект из другого класса.
     * Наследование этот класс потребует перезагрузки информацию о соединении.
     * @uses $db = MySqliDb::getInstance();
     * @return MysqliDb Returns the current instance.
     */
    public static function getInstance()
    {
        return self::$_instance;
    }

    /**
     * Method creates new mysqlidb object for a subquery generation
     *
     * @param string $subQueryAlias
     *
     * @return MysqliDb
     */
    public static function subQuery($subQueryAlias = '')
    {
        return new self(['host' => $subQueryAlias, 'isSubQuery' => true]);
    }

    /**
     * Helper function to create dbObject with JSON return type
     * @return MysqliDb
     */
    public function jsonBuilder()
    {
        $this->returnType = 'json';

        return $this;
    }

    /**
     * Helper function to create dbObject with object return type.
     * @return MysqliDb
     */
    public function objectBuilder()
    {
        $this->returnType = 'object';

        return $this;
    }

    /**
     * Helper function to execute raw SQL query and return only 1 row of results.
     * Note that function do not add 'limit 1' to the query by itself
     * Same idea as getOne()
     *
     * @param string $query      User-provided query to execute.
     * @param array  $bindParams Variables array to bind to the SQL statement.
     *
     * @return array|null Contains the returned row from the query.
     * @throws \RuntimeException;
     */
    public function rawQueryOne($query, $bindParams = null)
    {
        $res = $this->rawQuery($query, $bindParams);
        if (is_array($res) && isset($res[0])){
            return $res[0];
        }

        return null;
    }

    /**
     * Execute raw SQL query.
     *
     * @param string $query      Предоставленный пользователем запроса для выполнения.
     * @param array  $bindParams Переменные массива для привязки к заявлению SQL.
     *
     * @return array Содержит возвращенные строки из запроса.
     * @throws \RuntimeException;
     */
    public function rawQuery($query, $bindParams = null)
    {
        $params = ['']; // Создание пустой индекс 0
        $this->_query = $query;
        $stmt = $this->_prepareQuery();

        if (is_array($bindParams) === true){
            foreach ($bindParams as $prop => $val){
                $params[0] .= $this->_determineType($val);
                $params[] = $bindParams[$prop];
            }

            call_user_func_array([$stmt, 'bind_param'], $this->refValues($params));
        }

        $stmt->execute();
        $this->count = $stmt->affected_rows;
        $this->_stmtError = $stmt->error;
        $this->_lastQuery = $this->replacePlaceHolders($this->_query, $params);
        $res = $this->_dynamicBindResults($stmt);
        $this->reset();

        return $res;
    }

    /**
     * Метод попытки получения запроса SQL
     * и выдает сообщение об ошибке, если возникла проблема.
     * @return mysqli_stmt
     * @throws \RuntimeException()
     */
    protected function _prepareQuery()
    {
        if (!$stmt = $this->mysqli()->prepare($this->_query)){
            $msg = "Problem preparing query ($this->_query) " . $this->mysqli()->error;
            $this->reset();
            throw new \RuntimeException($msg);
        }

        if ($this->traceEnabled){
            $this->traceStartQ = microtime(true);
        }

        return $stmt;
    }

    /**
     * A method to get mysqli object or create it in case needed
     * @return mysqli
     * @throws \RuntimeException()
     */
    public function mysqli()
    {
        if (!$this->_mysqli){
            $this->connect();
        }

        return $this->_mysqli;
    }

    /**
     * A method to connect to the database
     * @throws \RuntimeException
     */
    public function connect()
    {
        if ($this->isSubQuery){
            return;
        }

        if (empty($this->host)){
            throw new \RuntimeException('MySQL host is not set');
        }

        $this->_mysqli = new mysqli($this->host, $this->username, $this->password, $this->db, $this->port);

        if ($this->_mysqli->connect_error){
            throw new \RuntimeException('Connect Error ' . $this->_mysqli->connect_errno . ': ' . $this->_mysqli->connect_error);
        }

        if ($this->charset){
            $this->_mysqli->set_charset($this->charset);
        }
    }

    /**
     * Reset states after an execution
     * @return MysqliDb Returns the current instance.
     */
    protected function reset()
    {
        if ($this->traceEnabled){
            $this->trace[] = [$this->_lastQuery, microtime(true) - $this->traceStartQ, $this->_traceGetCaller()];
        }

        $this->_where = [];
        $this->_having = [];
        $this->_join = [];
        $this->_orderBy = [];
        $this->_groupBy = [];
        $this->_bindParams = ['']; // Create the empty 0 index
        $this->_query = null;
        $this->_queryOptions = [];
        $this->returnType = 'array';
        $this->_nestJoin = false;
        $this->_forUpdate = false;
        $this->_lockInShareMode = false;
        $this->_tableName = '';
        $this->_lastInsertId = null;
        $this->_updateColumns = null;
        $this->_mapKey = null;
    }

    /**
     * Get where and what function was called for query stored in MysqliDB->trace
     * @return string with information
     */
    private function _traceGetCaller()
    {
        $dd = debug_backtrace();
        $caller = next($dd);
        while (null !== $caller && $caller['file'] == __FILE__){
            $caller = next($dd);
        }

        return __CLASS__ . '->' . $caller['function'] . "() >>  file \"" .
        str_replace($this->traceStripPrefix, '', $caller['file']) . "\" line #" . $caller['line'] . ' ';
    }

    /**
     * This method is needed for prepared statements. They require
     * the data type of the field to be bound with "i" s", etc.
     * This function takes the input, determines what type it is,
     * and then updates the param_type.
     *
     * @param mixed $item Ввод для определения типа.
     *
     * @return string Соединенном типы параметров.
     */
    protected function _determineType($item)
    {
        switch (gettype($item)) {
            case 'NULL':
            case 'string':
                return 's';
                break;

            case 'boolean':
            case 'integer':
                return 'i';
                break;

            case 'blob':
                return 'b';
                break;

            case 'double':
                return 'd';
                break;
        }

        return '';
    }

    /**
     * Referenced data array is required by mysqli since PHP 5.3+
     *
     * @param array $arr
     *
     * @return array
     */
    protected function refValues(array &$arr)
    {
        //Ссылка на аргументы функции необходимы для HHVM работы
        //https://github.com/facebook/hhvm/issues/5155
        //Реферировано массив данных требуется MySQLi начиная с PHP 5.3+
        if (strnatcmp(phpversion(), '5.3') >= 0){
            $refs = [];
            foreach ($arr as $key => $value){
                $refs[$key] = &$arr[$key];
            }

            return $refs;
        }

        return $arr;
    }

    /**
     * Функция для замены? с переменными из переменной связывания
     *
     * @param string $str
     * @param array  $vals
     *
     * @return string
     */
    protected function replacePlaceHolders($str, $vals)
    {
        $i = 1;
        $newStr = '';

        if (empty($vals)){
            return $str;
        }

        while ($pos = strpos($str, '?')){
            $val = $vals[$i++];
            if (is_object($val)){
                $val = '[object]';
            }
            if ($val === null){
                $val = 'NULL';
            }
            $newStr .= substr($str, 0, $pos) . "'" . $val . "'";
            $str = substr($str, $pos + 1);
        }
        $newStr .= $str;

        return $newStr;
    }

    /**
     * Этот вспомогательный метод заботится о "методе bind_result подготовленных операторов"
     *  * когда число переменных для передачи неизвестна.
     *
     * @param mysqli_stmt $stmt Equal to the prepared statement object.
     *
     * @return array The results of the SQL fetch.
     * @throws \RuntimeException()
     */
    protected function _dynamicBindResults(mysqli_stmt $stmt)
    {
        $parameters = [];
        $results = [];
        /**
         * @see http://php.net/manual/en/mysqli-result.fetch-fields.php
         */
        $mysqlLongType = 252;
        $shouldStoreResult = false;

        $meta = $stmt->result_metadata();

        // if $meta is false yet sqlstate is true, there's no sql error but the query is
        // most likely an update/insert/delete which doesn't produce any results
        if (!$meta && $stmt->sqlstate)
            {return [];}

        $row = [];
        while ($field = $meta->fetch_field()){
            if ($field->type == $mysqlLongType){
                $shouldStoreResult = true;
            }

            if ($this->_nestJoin && $field->table != $this->_tableName){
                $field->table = substr($field->table, strlen(self::$prefix));
                $row[$field->table][$field->name] = null;
                $parameters[] = &$row[$field->table][$field->name];
            } else {
                $row[$field->name] = null;
                $parameters[] = &$row[$field->name];
            }
        }

        // Во избежание ошибки из памяти в PHP 5.2 и 5.3. Mysqli выделяет много памяти надолго *
        // И типы BLOB *. Таким образом, чтобы избежать из проблем с памятью store_result используется
        // https://github.com/joshcam/PHP-MySQLi-Database-Class/pull/119
        if ($shouldStoreResult){
            $stmt->store_result();
        }

        call_user_func_array([$stmt, 'bind_result'], $parameters);

        $this->totalCount = 0;
        $this->count = 0;

        while ($stmt->fetch()){
            if ($this->returnType == 'object'){
                $result = new stdClass ();

                foreach ($row as $key => $val){
                    if (is_array($val)){
                        $result->$key = new stdClass ();
                        foreach ($val as $k => $v){
                            $result->$key->$k = $v;
                        }
                    } else {
                        $result->$key = $val;
                    }
                }
            } else {
                $result = [];
                foreach ($row as $key => $val){
                    if (is_array($val)){
                        foreach ($val as $k => $v){
                            $result[$key][$k] = $v;
                        }
                    } else {
                        $result[$key] = $val;
                    }
                }
            }
            $this->count++;
            if ($this->_mapKey){
                $results[$row[$this->_mapKey]] = count($row) > 2 ? $result : end($result);
            } else {
                $results[] = $result;
            }
        }

        if ($shouldStoreResult){
            $stmt->free_result();
        }

        $stmt->close();

        // stored procedures sometimes can return more then 1 results
        if ($this->mysqli()->more_results()){
            $this->mysqli()->next_result();
        }

        if (in_array('SQL_CALC_FOUND_ROWS', $this->_queryOptions)){
            $stmt = $this->mysqli()->query('SELECT FOUND_ROWS()');
            $totalCount = $stmt->fetch_row();
            $this->totalCount = $totalCount[0];
        }

        if ($this->returnType == 'json'){
            return json_encode($results);
        }

        return $results;
    }

    /**
     * Helper function to execute raw SQL query and return only 1 column of results.
     * If 'limit 1' will be found, then string will be returned instead of array
     * Same idea as getValue()
     *
     * @param string $query      User-provided query to execute.
     * @param array  $bindParams Variables array to bind to the SQL statement.
     *
     * @return mixed Contains the returned rows from the query.
     */
    public function rawQueryValue($query, $bindParams = null)
    {
        $res = $this->rawQuery($query, $bindParams);
        if (!$res){
            return null;
        }

        $limit = preg_match('/limit\s+1;?$/i', $query);
        $key = key($res[0]);
        if ($limit == true && isset($res[0][$key])){
            return $res[0][$key];
        }

        $newRes = [];
        for ($i = 0; $i < $this->count; $i++){
            $newRes[] = $res[$i][$key];
        }

        return $newRes;
    }

    /**
     * A method to perform select query
     *
     * @param string    $query   Contains a user-provided select query.
     * @param int|array $numRows Array to define SQL limit in format Array ($count, $offset)
     *
     * @return array Contains the returned rows from the query.
     * @throws \RuntimeException()
     */
    public function query($query, $numRows = null)
    {
        $this->_query = $query;
        $stmt = $this->_buildQuery($numRows);
        $stmt->execute();
        $this->_stmtError = $stmt->error;
        $res = $this->_dynamicBindResults($stmt);
        $this->reset();

        return $res;
    }

    /**
     * Метод абстракции, который будет скомпилирован заявление, в котором,
     * любые передаваемые данные обновления, а нужные строки.
     * Затем он строит запрос SQL.
     *
     * @param integer|array $numRows   Массив для определения SQL предел в формате Array ($count, $offset)
     *                                 или только $count
     * @param array         $tableData Должен содержать массив данных для обновления базы данных.
     *
     * @return mysqli_stmt Returns the $stmt object.
     * @throws \RuntimeException()
     */
    protected function _buildQuery($numRows = null, $tableData = null)
    {
        $this->_buildJoin();
        $this->_buildInsertQuery($tableData);
        $this->_buildCondition('WHERE', $this->_where);
        $this->_buildGroupBy();
        $this->_buildCondition('HAVING', $this->_having);
        $this->_buildOrderBy();
        $this->_buildLimit($numRows);
        $this->_buildOnDuplicate($tableData);

        if ($this->_forUpdate){
            $this->_query .= ' FOR UPDATE';
        }
        if ($this->_lockInShareMode){
            $this->_query .= ' LOCK IN SHARE MODE';
        }

        $this->_lastQuery = $this->replacePlaceHolders($this->_query, $this->_bindParams);

        if ($this->isSubQuery){
            return null;
        }

        // Подготовить запрос
        $stmt = $this->_prepareQuery();

        // Свяжите параметры для заявления если таковые имеются
        if (count($this->_bindParams) > 1){
            call_user_func_array([$stmt, 'bind_param'], $this->refValues($this->_bindParams));
        }

        return $stmt;
    }

    /**
     * метод абстракции что будет строить JOIN часть запроса
     */
    protected function _buildJoin()
    {
        if (empty($this->_join)){
            return;
        }

        foreach ($this->_join as $data){
            list ($joinType, $joinTable, $joinCondition) = $data;

            $joinStr = $joinTable;
            if (is_object($joinTable)){
                $joinStr = $this->_buildPair('', $joinTable);
            }
            $this->_query .= ' ' . $joinType . ' JOIN ' . $joinStr .
                (false !== stripos($joinCondition, 'using') ? ' ' : ' on ') . $joinCondition;
        }
    }

    /**
     * Вспомогательная функция для добавления переменных в массив параметров связывания и вернется
     * его SQL часть запроса в соответствии с оператором в '$ оператора? или
     * ' $operator ($subquery) ' форматы
     *
     * @param string $operator
     * @param mixed  $value Variable with values
     *
     * @return string
     */
    protected function _buildPair($operator, $value)
    {
        if (!is_object($value)){
            $this->_bindParam($value);

            return ' ' . $operator . ' ? ';
        }

        $subQuery = $value->getSubQuery();
        $this->_bindParams($subQuery['params']);

        return ' ' . $operator . ' (' . $subQuery['query'] . ') ' . $subQuery['alias'];
    }

    /**
     * Вспомогательная функция для добавления переменных в параметры связывания массива
     *
     * @param string - Variable value
     */
    protected function _bindParam($value)
    {
        $this->_bindParams[0] .= $this->_determineType($value);
        $this->_bindParams[] = $value;
    }

    /**
     * Вспомогательная функция для добавления переменных в массиве параметров связывания навалом
     *
     * @param array $values Variable with values
     */
    protected function _bindParams($values)
    {
        foreach ($values as $value){
            $this->_bindParam($value);
        }
    }

    /**
     * Abstraction method that will build an INSERT or UPDATE part of the query
     *
     * @param array $tableData
     * @throws \RuntimeException()
     */
    protected function _buildInsertQuery($tableData)
    {
        if (!is_array($tableData)){
            return;
        }

        $isInsert = preg_match('/^(INSERT|REPLACE)/i', $this->_query);
        $dataColumns = array_keys($tableData);
        if ($isInsert){
            if (isset ($dataColumns[0]))
                {$this->_query .= ' (`' . implode($dataColumns, '`, `') . '`) ';}
            $this->_query .= ' VALUES (';
        } else {
            $this->_query .= ' SET ';
        }

        $this->_buildDataPairs($tableData, $dataColumns, $isInsert);

        if ($isInsert){
            $this->_query .= ')';
        }
    }

    /**
     * Insert/Update query helper
     *
     * @param array $tableData
     * @param array $tableColumns
     * @param bool  $isInsert INSERT operation flag
     *
     * @throws \RuntimeException
     */
    public function _buildDataPairs($tableData, $tableColumns, $isInsert)
    {
        foreach ($tableColumns as $column){
            $value = $tableData[$column];

            if (!$isInsert){
                $this->_query .= '`' . $column . '` = ';
            }

            // Subquery value
            if ($value instanceof MysqliDb){
                $this->_query .= $this->_buildPair('', $value) . ', ';
                continue;
            }

            // Simple value
            if (!is_array($value)){
                $this->_bindParam($value);
                $this->_query .= '?, ';
                continue;
            }

            // Функция значение
            $key = key($value);
            $val = $value[$key];
            switch ($key) {
                case '[I]':
                    $this->_query .= $column . $val . ', ';
                    break;
                case '[F]':
                    $this->_query .= $val[0] . ', ';
                    if (!empty($val[1])){
                        $this->_bindParams($val[1]);
                    }
                    break;
                case '[N]':
                    if ($val == null){
                        $this->_query .= '!' . $column . ', ';
                    } else {
                        $this->_query .= '!' . $val . ', ';
                    }
                    break;
                default:
                    throw new \RuntimeException('Wrong operation');
            }
        }
        $this->_query = rtrim($this->_query, ', ');
    }

    /**
     * Abstraction method that will build the part of the WHERE conditions
     *
     * @param string $operator
     * @param array  $conditions
     */
    protected function _buildCondition($operator, &$conditions)
    {
        if (empty($conditions)){
            return;
        }

        //Prepare the where portion of the query
        $this->_query .= ' ' . $operator;

        foreach ($conditions as $cond){
            list ($concat, $varName, $operator, $val) = $cond;
            $this->_query .= " " . $concat . " " . $varName;

            switch (strtolower($operator)) {
                case 'not in':
                case 'in':
                    $comparison = ' ' . $operator . ' (';
                    if (is_object($val)){
                        $comparison .= $this->_buildPair("", $val);
                    } else {
                        foreach ($val as $v){
                            $comparison .= ' ?,';
                            $this->_bindParam($v);
                        }
                    }
                    $this->_query .= rtrim($comparison, ',') . ' ) ';
                    break;
                case 'not between':
                case 'between':
                    $this->_query .= " $operator ? AND ? ";
                    $this->_bindParams($val);
                    break;
                case 'not exists':
                case 'exists':
                    $this->_query .= $operator . $this->_buildPair("", $val);
                    break;
                default:
                    if (is_array($val)){
                        $this->_bindParams($val);
                    } elseif ($val === null) {
                        $this->_query .= ' ' . $operator . " NULL";
                    } elseif ($val != 'DBNULL' || $val == '0') {
                        $this->_query .= $this->_buildPair($operator, $val);
                    }
            }
        }
    }

    /**
     * метод абстракции что будет строить GROUP BY часть WHERE заявление
     */
    protected function _buildGroupBy()
    {
        if (empty($this->_groupBy)){
            return;
        }

        $this->_query .= " GROUP BY ";

        foreach ($this->_groupBy as $key => $value){
            $this->_query .= $value . ", ";
        }

        $this->_query = rtrim($this->_query, ', ') . " ";
    }

    /**
     * метод абстракции что будет строить LIMIT часть WHERE заявление
     */
    protected function _buildOrderBy()
    {
        if (empty($this->_orderBy)){
            return;
        }

        $this->_query .= " ORDER BY ";
        foreach ($this->_orderBy as $prop => $value){
            if (strtolower(str_replace(" ", "", $prop)) == 'rand()'){
                $this->_query .= "rand(), ";
            } else {
                $this->_query .= $prop . " " . $value . ", ";
            }
        }

        $this->_query = rtrim($this->_query, ', ') . " ";
    }

    /**
     * метод абстракции что будет строить LIMIT часть WHERE заявление
     *
     * @param int|array $numRows     Array to define SQL limit in format Array ($count, $offset)
     *                               or only $count
     *
     * @return void
     */
    protected function _buildLimit($numRows)
    {
        if (null === $numRows){
            return;
        }

        if (is_array($numRows)){
            /** @var array $numRows */
            $this->_query .= ' LIMIT ' . (isset($numRows[0]) ? (int)$numRows[0] : '') . ', ' .
                (isset($numRows[1]) ? (int)$numRows[1] : '');
        } else {
            $this->_query .= ' LIMIT ' . (int)$numRows;
        }
    }

    /**
     * Вспомогательная функция для добавления переменных в инструкции запроса
     *
     * @param array $tableData Variable with values
     */
    protected function _buildOnDuplicate($tableData)
    {
        if (is_array($this->_updateColumns) && !empty($this->_updateColumns)){
            $this->_query .= ' ON DUPLICATE KEY UPDATE ';
            if ($this->_lastInsertId){
                $this->_query .= $this->_lastInsertId . '=LAST_INSERT_ID (' . $this->_lastInsertId . '), ';
            }

            foreach ($this->_updateColumns as $key => $val){
                // skip all params without a value
                if (is_numeric($key)){
                    $this->_updateColumns[$val] = '';
                    unset($this->_updateColumns[$key]);
                } else {
                    $tableData[$key] = $val;
                }
            }
            $this->_buildDataPairs($tableData, array_keys($this->_updateColumns), false);
        }
    }

    /**
     * A convenient SELECT COLUMN function to get a single column value from one row
     *
     * @param string $tableName The name of the database table to work with.
     * @param string $column    The desired column
     * @param int    $limit     Limit of rows to select. Use null for unlimited..1 by default
     *
     * @return mixed Contains the value of a returned column / array of values
     */
    public function getValue($tableName, $column, $limit = 1)
    {
        $res = $this->arrayBuilder()->get($tableName, $limit, "{$column} AS retval");

        if (!$res){
            return null;
        }

        if ($limit == 1){
            if (isset($res[0]['retval'])){
                return $res[0]['retval'];
            }

            return null;
        }

        $newRes = [];
        for ($i = 0; $i < $this->count; $i++){
            $newRes[] = $res[$i]['retval'];
        }

        return $newRes;
    }

    /**
     * A convenient SELECT * function.
     *
     * @param string    $tableName   The name of the database table to work with.
     * @param int|array $numRows     Array to define SQL limit in format Array ($count, $offset)
     *                               or only $count
     * @param string    $columns     Desired columns
     *
     * @return array Contains the returned rows from the select query.
     */
    public function get($tableName, $numRows = null, $columns = '*')
    {
        if (empty($columns)){
            $columns = '*';
        }

        $column = is_array($columns) ? implode(', ', $columns) : $columns;

        $this->_tableName = $tableName;
        if (strpos($tableName, '.') === false){
            $this->_tableName = self::$prefix . $tableName;
        }

        $this->_query = 'SELECT ' . implode(' ', $this->_queryOptions) . ' ' .
            $column . ' FROM ' . $this->_tableName;
        $stmt = $this->_buildQuery($numRows);

        if ($this->isSubQuery){
            return $this;
        }

        $stmt->execute();
        $this->_stmtError = $stmt->error;
        $res = $this->_dynamicBindResults($stmt);
        $this->reset();

        return $res;
    }

    /**
     * Helper function to create dbObject with array return type
     * Added for consistency as that default output type
     * @return MysqliDb
     */
    public function arrayBuilder()
    {
        $this->returnType = 'array';

        return $this;
    }

    /**
     * Insert method to add new row
     *
     * @param string $tableName  The name of the table.
     * @param array  $insertData Data containing information for inserting into the DB.
     *
     * @return bool Boolean indicating whether the insert query was completed successfully.
     * @throws \RuntimeException()
     */
    public function insert($tableName, $insertData)
    {
        return $this->_buildInsert($tableName, $insertData, 'INSERT');
    }

    /**
     * Internal function to build and execute INSERT/REPLACE calls
     *
     * @param string $tableName  The name of the table.
     * @param array  $insertData Data containing information for inserting into the DB.
     * @param string $operation  Type of operation (INSERT, REPLACE)
     *
     * @return bool Boolean indicating whether the insert query was completed succesfully.
     */
    private function _buildInsert($tableName, $insertData, $operation)
    {
        if ($this->isSubQuery){
            return false;
        }

        $this->_query = $operation . ' ' . implode(' ', $this->_queryOptions) . ' INTO ' . self::$prefix . $tableName;
        $stmt = $this->_buildQuery(null, $insertData);
        $status = $stmt->execute();
        $this->_stmtError = $stmt->error;
        $haveOnDuplicate = !empty ($this->_updateColumns);
        $this->reset();
        $this->count = $stmt->affected_rows;

        if ($stmt->affected_rows < 1){
            // in case of onDuplicate() usage, if no rows were inserted
            if ($status && $haveOnDuplicate){
                return true;
            }

            return false;
        }

        if ($stmt->insert_id > 0){
            return $stmt->insert_id;
        }

        return true;
    }

    /**
     * Заменить метод чтобы добавить новую строку
     *
     * @param <string $tableName The name of the table.
     * @param array $insertData Данные содержащие информацию для вставки в DB.
     *
     * @return bool Boolean indicating whether the insert query was completed successfully.
     */
    public function replace($tableName, $insertData)
    {
        return $this->_buildInsert($tableName, $insertData, 'REPLACE');
    }

    /**
     * Удобная функция, которая возвращает значение TRUE, если существует по крайней мере один элемент, который
     * satisfy где указанное условие называя "where" method перед этим.
     *
     * @param string $tableName The name of the database table to work with.
     *
     * @return array Contains the returned rows from the select query.
     */
    public function has($tableName)
    {
        $this->getOne($tableName, '1');

        return $this->count >= 1;
    }

    /**
     * A convenient SELECT * function to get one record.
     *
     * @param string $tableName The name of the database table to work with.
     * @param string $columns   Desired columns
     *
     * @return array Contains the returned rows from the select query.
     */
    public function getOne($tableName, $columns = '*')
    {
        $res = $this->get($tableName, 1, $columns);

        if ($res instanceof MysqliDb){
            return $res;
        } elseif (is_array($res) && isset($res[0])) {
            return $res[0];
        } elseif ($res) {
            return $res;
        }

        return null;
    }

    /**
     * Update query. Обязательно сначала вызвать "where" method.
     *
     * @param string $tableName The name of the database table to work with.
     * @param array  $tableData Array of data to update the desired row.
     * @param int    $numRows   Limit on the number of rows that can be updated.
     *
     * @return bool
     */
    public function update($tableName, $tableData, $numRows = null)
    {
        if ($this->isSubQuery){
            return;
        }

        $this->_query = "UPDATE " . self::$prefix . $tableName;

        $stmt = $this->_buildQuery($numRows, $tableData);
        $status = $stmt->execute();
        $this->reset();
        $this->_stmtError = $stmt->error;
        $this->count = $stmt->affected_rows;

        return $status;
    }

    /**
     * Delete query. Call the "where" method first.
     *
     * @param string    $tableName   The name of the database table to work with.
     * @param int|array $numRows     Array to define SQL limit in format Array ($count, $offset)
     *                               or only $count
     *
     * @return bool Indicates success. 0 or 1.
     */
    public function delete($tableName, $numRows = null)
    {
        if ($this->isSubQuery){
            return;
        }

        $table = self::$prefix . $tableName;

        if (count($this->_join)){
            $this->_query = "DELETE " . preg_replace('/.* (.*)/', '$1', $table) . " FROM " . $table;
        } else {
            $this->_query = "DELETE FROM " . $table;
        }

        $stmt = $this->_buildQuery($numRows);
        $stmt->execute();
        $this->_stmtError = $stmt->error;
        $this->reset();

        return ($stmt->affected_rows > 0);
    }

    /**
     * имя и имя столбца Эта функция магазин Update столбца из
     * колонка автоинкремент
     *
     * @param array  $updateColumns Variable with values
     * @param string $lastInsertId  Variable value
     *
     * @return MysqliDb
     */
    public function onDuplicate($updateColumns, $lastInsertId = null)
    {
        $this->_lastInsertId = $lastInsertId;
        $this->_updateColumns = $updateColumns;

        return $this;
    }

    /**
     * Этот метод позволяет указать несколько (Метод сцепления опционально) OR WHERE заявления для SQL queries.
     * @uses $MySqliDb->orWhere('id', 7)->orWhere('title', 'MyTitle');
     *
     * @param string $whereProp  The name of the database field.
     * @param mixed  $whereValue The value of the database field.
     * @param string $operator   Comparison operator. Default is =
     *
     * @return MysqliDb
     */
    public function orWhere($whereProp, $whereValue = 'DBNULL', $operator = '=')
    {
        return $this->where($whereProp, $whereValue, $operator, 'OR');
    }

    /**
     * Этот метод позволяет указать несколько (метод цепочки опционально)AND WHERE заявления для SQL queries.
     * @uses $MySqliDb->where('id', 7)->where('title', 'MyTitle');
     *
     * @param string $whereProp  The name of the database field.
     * @param mixed  $whereValue The value of the database field.
     * @param string $operator   Comparison operator. Default is =
     * @param string $cond       Condition of where statement (OR, AND)
     *
     * @return MysqliDb
     */
    public function where($whereProp, $whereValue = 'DBNULL', $operator = '=', $cond = 'AND')
    {
        // foreground for an old operation api
        if (is_array($whereValue) && ($key = key($whereValue)) != '0'){
            $operator = $key;
            $whereValue = $whereValue[$key];
        }

        if (count($this->_where) == 0){
            $cond = '';
        }

        $this->_where[] = [$cond, $whereProp, $operator, $whereValue];

        return $this;
    }

    /**
     * This method allows you to specify multiple (method chaining optional) OR HAVING statements for SQL queries.
     * @uses $MySqliDb->orHaving('SUM(tags) > 10')
     *
     * @param string $havingProp  The name of the database field.
     * @param mixed  $havingValue The value of the database field.
     * @param string $operator    Comparison operator. Default is =
     *
     * @return MysqliDb
     */
    public function orHaving($havingProp, $havingValue = null, $operator = null)
    {
        return $this->having($havingProp, $havingValue, $operator, 'OR');
    }

    /**
     * This method allows you to specify multiple (method chaining optional) AND HAVING statements for SQL queries.
     * @uses $MySqliDb->having('SUM(tags) > 10')
     *
     * @param string $havingProp  The name of the database field.
     * @param mixed  $havingValue The value of the database field.
     * @param string $operator    Comparison operator. Default is =
     *
     * @return MysqliDb
     */

    public function having($havingProp, $havingValue = 'DBNULL', $operator = '=', $cond = 'AND')
    {
        // forkaround for an old operation api
        if (is_array($havingValue) && ($key = key($havingValue)) != "0"){
            $operator = $key;
            $havingValue = $havingValue[$key];
        }

        if (count($this->_having) == 0){
            $cond = '';
        }

        $this->_having[] = [$cond, $havingProp, $operator, $havingValue];

        return $this;
    }

    /**
     * This method allows you to concatenate joins for the final SQL statement.
     * @uses $MySqliDb->join('table1', 'field1 <> field2', 'LEFT')
     *
     * @param string $joinTable     The name of the table.
     * @param string $joinCondition the condition.
     * @param string $joinType      'LEFT', 'INNER' etc.
     *
     * @throws \RuntimeException
     * @return MysqliDb
     */
    public function join($joinTable, $joinCondition, $joinType = '')
    {
        $allowedTypes = ['LEFT', 'RIGHT', 'OUTER', 'INNER', 'LEFT OUTER', 'RIGHT OUTER'];
        $joinType = strtoupper(trim($joinType));

        if ($joinType && !in_array($joinType, $allowedTypes)){
            throw new \RuntimeException('Wrong JOIN type: ' . $joinType);
        }

        if (!is_object($joinTable)){
            $joinTable = self::$prefix . $joinTable;
        }

        $this->_join[] = [$joinType, $joinTable, $joinCondition];

        return $this;
    }

    /**
     * Этот метод позволяет указать несколько (method chaining optional) ORDER BY заявления для запросов SQL.
     * @uses     $MySqliDb->orderBy('id', 'desc')->orderBy('name', 'desc');
     *
     * @param string $orderByField The name of the database field.
     * @param string $orderbyDirection
     * @param array  $customFields Fieldset for ORDER BY FIELD() ordering
     *
     * @return \core\Db\MysqliDb
     * @internal param string $orderByDirection Order direction.
     *
     * @throws \RuntimeException
     */
    public function orderBy($orderByField, $orderbyDirection = 'DESC', $customFields = null)
    {
        $allowedDirection = ['ASC', 'DESC'];
        $orderbyDirection = strtoupper(trim($orderbyDirection));
        $orderByField = preg_replace("/[^-a-z0-9\.\(\),_`\*\'\"]+/i", '', $orderByField);

        // Add table prefix to orderByField if needed.
        //FIXME: We are adding prefix only if table is enclosed into `` to distinguish aliases
        // from table names
        $orderByField = preg_replace('/(\`)([`a-zA-Z0-9_]*\.)/', '\1' . self::$prefix . '\2', $orderByField);


        if (empty($orderbyDirection) || !in_array($orderbyDirection, $allowedDirection)){
            throw new \RuntimeException('Wrong order direction: ' . $orderbyDirection);
        }

        if (is_array($customFields)){
            foreach ($customFields as $key => $value){
                $customFields[$key] = preg_replace("/[^-a-z0-9\.\(\),_`]+/i", '', $value);
            }

            $orderByField = 'FIELD (' . $orderByField . ', "' . implode('","', $customFields) . '")';
        }

        $this->_orderBy[$orderByField] = $orderbyDirection;

        return $this;
    }

    /**
     * Этот метод позволяет указать несколько (метод формирования цепочки дополнительно) GROUP BY для запросов
     * заявлений SQL.
     * @uses $MySqliDb->groupBy('name');
     *
     * @param string $groupByField The name of the database field.
     *
     * @return MysqliDb
     */
    public function groupBy($groupByField)
    {
        $groupByField = preg_replace("/[^-a-z0-9\.\(\),_\*]+/i", '', $groupByField);

        $this->_groupBy[] = $groupByField;

        return $this;
    }

    /**
     * Этот метод возвращает идентификатор последней вставленной элемента
     * @return integer The last inserted item ID.
     */
    public function getInsertId()
    {
        return $this->mysqli()->insert_id;
    }

    /**
     * Escape harmful characters which might affect a query.
     *
     * @param string $str The string to escape.
     *
     * @return string The escaped string.
     */
    public function escape($str)
    {
        return $this->mysqli()->real_escape_string($str);
    }

    /**
     * Метод для вызова mysqli-> Пинг () держать открытыми неиспользуемые соединения на
     * продолжительные скрипты, или восстановить тайм-аут соединения (if php.ini has
     * global mysqli.reconnect set to true). Не можете сделать это непосредственно с помощью объекта
     *  * поскольку _mysqli защищен.
     * @return bool True if connection is up
     */
    public function ping()
    {
        return $this->mysqli()->ping();
    }

    /**
     * Закрыть соединение
     */
    public function __destruct()
    {
        if ($this->isSubQuery){
            return;
        }

        if ($this->_mysqli){
            $this->_mysqli->close();
            $this->_mysqli = null;
        }
    }

    /**
     * Method returns last executed query
     * @return string
     */
    public function getLastQuery()
    {
        return $this->_lastQuery;
    }

    /**
     * Метод возвращает ошибку MySQL
     * @return string
     */
    public function getLastError()
    {
        if (!$this->_mysqli){
            return 'mysqli is null';
        }

        return trim($this->_stmtError . ' ' . $this->mysqli()->error);
    }

    /**
     * Mostly internal method to get query and its params out of subquery object
     * after get() and getAll()
     * @return array
     */
    public function getSubQuery()
    {
        if (!$this->isSubQuery){
            return null;
        }

        array_shift($this->_bindParams);
        $val = ['query' => $this->_query,
            'params' => $this->_bindParams,
            'alias' => $this->host
        ];
        $this->reset();

        return $val;
    }

    /* Helper functions */

    /**
     * Method returns generated interval function as an insert/update function
     *
     * @param string $diff interval in the formats:
     *                     "1", "-1d" or "- 1 day" -- For interval - 1 day
     *                     Supported intervals [s]econd, [m]inute, [h]hour, [d]day, [M]onth, [Y]ear
     *                     Default null;
     * @param string $func Initial date
     *
     * @return array
     */
    public function now($diff = null, $func = 'NOW()')
    {
        return ['[F]' => [$this->interval($diff, $func)]];
    }

    /**
     * Method returns generated interval function as a string
     *
     * @param string $diff interval in the formats:
     *                     "1", "-1d" or "- 1 day" -- For interval - 1 day
     *                     Supported intervals [s]econd, [m]inute, [h]hour, [d]day, [M]onth, [Y]ear
     *                     Default null;
     * @param string $func Initial date
     *
     * @return string
     */
    public function interval($diff, $func = 'NOW()')
    {
        $types = ['s' => 'second', 'm' => 'minute', 'h' => 'hour', 'd' => 'day', 'M' => 'month', 'Y' => 'year'];
        $incr = '+';
        $items = '';
        $type = 'd';

        if ($diff && preg_match('/([+-]?) ?(\d+) ?([a-zA-Z]?)/', $diff, $matches)){
            if (!empty($matches[1])){
                $incr = $matches[1];
            }

            if (!empty($matches[2])){
                $items = $matches[2];
            }

            if (!empty($matches[3])){
                $type = $matches[3];
            }

            if (!in_array($type, array_keys($types))){
                throw new \RuntimeException("invalid interval type in '{$diff}'");
            }

            $func .= " " . $incr . " interval " . $items . " " . $types[$type] . " ";
        }

        return $func;
    }

    /**
     * Метод генерирует вызов функции инкрементного
     *
     * @param int $num increment by int or float. 1 by default
     *
     * @throws \RuntimeException
     * @return array
     */
    public function inc($num = 1)
    {
        if (!is_numeric($num)){
            throw new \RuntimeException('Argument supplied to inc must be a number');
        }

        return ['[I]' => '+' . $num];
    }

    /**
     * Метод создает вызов убывающих функции
     *
     * @param int $num increment by int or float. 1 by default
     *
     * @return array
     */
    public function dec($num = 1)
    {
        if (!is_numeric($num)){
            throw new \RuntimeException('Argument supplied to dec must be a number');
        }

        return ['[I]' => '-' . $num];
    }

    /**
     * Метод генерирует вызов функции изменения булево
     *
     * @param string $col column name. null by default
     *
     * @return array
     */
    public function not($col = null)
    {
        return ['[N]' => (string)$col];
    }

    /**
     * Метод генерирует определенный пользователем вызов функции
     *
     * @param string $expr user function body
     * @param array  $bindParams
     *
     * @return array
     */
    public function func($expr, $bindParams = null)
    {
        return ['[F]' => [$expr, $bindParams]];
    }

    /**
     * Method returns a copy of a mysqlidb subquery object
     * @return MysqliDb new mysqlidb object
     */
    public function copy()
    {
        $copy = unserialize(serialize($this));
        $copy->_mysqli = null;

        return $copy;
    }

    /**
     * Начать транзакцию
     * @uses mysqli->autocommit(false)
     * @uses register_shutdown_function(array($this, "_transaction_shutdown_check"))
     * @throws \RuntimeException()
     */
    public function startTransaction()
    {
        $this->mysqli()->autocommit(false);
        $this->_transaction_in_progress = true;
        register_shutdown_function([$this, '_transaction_status_check']);
    }

    /**
     * Transaction commit
     * @uses mysqli->commit();
     * @uses mysqli->autocommit(true);
     */
    public function commit()
    {
        $result = $this->mysqli()->commit();
        $this->_transaction_in_progress = false;
        $this->mysqli()->autocommit(true);

        return $result;
    }

    /**
     * обработчик Shutdown откатить неподтвержденными операций, с тем чтобы сохранить
     * атомарные операции sane.
     * @uses mysqli->rollback();
     */
    public function _transaction_status_check()
    {
        if (!$this->_transaction_in_progress){
            return;
        }
        $this->rollback();
    }

    /**
     * Функция отката транзакции
     * @uses mysqli->rollback();
     * @uses mysqli->autocommit(true);
     */
    public function rollback()
    {
        $result = $this->mysqli()->rollback();
        $this->_transaction_in_progress = false;
        $this->mysqli()->autocommit(true);

        return $result;
    }

    /**
     * Query exection Реле времени слежения
     *
     * @param bool   $enabled     Enable execution time tracking
     * @param string $stripPrefix Prefix to strip from the path in exec log
     *
     * @return MysqliDb
     */
    public function setTrace($enabled, $stripPrefix = null)
    {
        $this->traceEnabled = $enabled;
        $this->traceStripPrefix = $stripPrefix;

        return $this;
    }

    /**
     * Method to check if needed table is created
     *
     * @param array $tables Table name or an Array of table names to check
     *
     * @return bool True if table exists
     */
    public function tableExists($tables)
    {
        $tables = !is_array($tables) ? [$tables] : $tables;
        $count = count($tables);
        if ($count == 0){
            return false;
        }

        array_walk($tables, function (&$value, $key) {
            $value = self::$prefix . $value;
        });
        $this->where('table_schema', $this->db);
        $this->where('table_name', $tables, 'IN');
        $this->get('information_schema.tables', $count);

        return $this->count == $count;
    }

    /**
     * Return result as an associative array with $idField field value used as a record key
     * Array Returns an array($k => $v) if get(.."param1, param2"), array ($k => array ($v, $v)) otherwise
     *
     * @param string $idField field name to use for a mapped element key
     *
     * @return MysqliDb
     */
    public function map($idField)
    {
        $this->_mapKey = $idField;

        return $this;
    }

    /**
     * Pagination wrapper to get()
     * @access public
     *
     * @param string       $table  The name of the database table to work with
     * @param int          $page   Page number
     * @param array|string $fields Array or coma separated list of fields to fetch
     *
     * @return array
     * @throws \RuntimeException()
     */
    public function paginate($table, $page, $fields = null)
    {
        $offset = $this->pageLimit * ($page - 1);
        $res = $this->withTotalCount()->get($table, [$offset, $this->pageLimit], $fields);
        $this->totalPages = ceil($this->totalCount / $this->pageLimit);

        return $res;
    }

    /**
     * Function to enable SQL_CALC_FOUND_ROWS in the get queries
     * @return MysqliDb
     * @throws \RuntimeException()
     */
    public function withTotalCount()
    {
        $this->setQueryOption('SQL_CALC_FOUND_ROWS');

        return $this;
    }

    /**
     * This method allows you to specify multiple (method chaining optional) options for SQL queries.
     * @uses $MySqliDb->setQueryOption('name');
     *
     * @param string|array $options The options name of the query.
     *
     * @throws \RuntimeException
     * @return MysqliDb
     */
    public function setQueryOption($options)
    {
        $allowedOptions = ['ALL', 'DISTINCT', 'DISTINCTROW', 'HIGH_PRIORITY', 'STRAIGHT_JOIN', 'SQL_SMALL_RESULT',
            'SQL_BIG_RESULT', 'SQL_BUFFER_RESULT', 'SQL_CACHE', 'SQL_NO_CACHE', 'SQL_CALC_FOUND_ROWS',
            'LOW_PRIORITY', 'IGNORE', 'QUICK', 'MYSQLI_NESTJOIN', 'FOR UPDATE', 'LOCK IN SHARE MODE'];

        if (!is_array($options)){
            $options = [$options];
        }

        foreach ($options as $option){
            $option = strtoupper($option);
            if (!in_array($option, $allowedOptions)){
                throw new \RuntimeException('Wrong query option: ' . $option);
            }

            if ($option == 'MYSQLI_NESTJOIN'){
                $this->_nestJoin = true;
            } elseif ($option == 'FOR UPDATE') {
                $this->_forUpdate = true;
            } elseif ($option == 'LOCK IN SHARE MODE') {
                $this->_lockInShareMode = true;
            } else {
                $this->_queryOptions[] = $option;
            }
        }

        return $this;
    }
}