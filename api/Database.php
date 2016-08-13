<?php
/*************************************************
 * Framework Component
 * name      AlexShop_CMS
 * created   by Alex production
 * version   1.0
 * author    Alex Jurii <alexjurii@gmail.com>
 * Copyright (c) 2016
 ************************************************/

namespace api;

use exception\DbException;
use Tracy\Debugger;

/**
 * Class Database
 * @package api
 */
class Database extends Registry
{

    /**
     * @var \Mysqli $mysqli
     */
    private $mysqli;
    /**
     * @var \mysqli_result|boolean $res
     */
    private $res;

    public $timeQuery = 0;
    public $timeQueries = 0;
    public $numQueries = 0;
    public $listQueries = [];

    /**
     * В конструкторе подключаем базу
     */
    public function __construct()
    {
        parent::__construct();
        $this->connect();
    }

    /**
     * В деструкторе отсоединяемся от базы
     */
    public function __destruct()
    {
        if (!DEBUG_MODE){
            $this->disconnect();
        }
    }

    /**
     * Подключение к базе данных
     */
    public function connect()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        // При повторном вызове возвращаем существующий линк
        if (null !== ($this->mysqli)){
            return $this->mysqli;
        } // Иначе устанавливаем соединение
        else {
            $this->mysqli = new \mysqli($this->config->db_server, $this->config->db_user,
                $this->config->db_password, $this->config->db_name);
        }

        // Выводим сообщение, в случае ошибки
        if ($this->mysqli->connect_error){
            throw new DbException('Could not connect to the database: ' . $this->mysqli->connect_error);

        } // Или настраиваем соединение
        else {
            if ($this->config->db_charset){
                $this->mysqli->query('SET NAMES ' . $this->config->db_charset);
            }
            if ($this->config->db_sql_mode){
                $this->mysqli->query('SET SESSION SQL_MODE = "' . $this->config->db_sql_mode . '"');
            }
            if ($this->config->db_timezone){
                $this->mysqli->query('SET time_zone = "' . $this->config->db_timezone . '"');
            }
        }

        return $this->mysqli;
    }

    /**
     * Закрываем подключение к базе данных
     */
    public function disconnect()
    {
        if (!@$this->mysqli->close()){
            return true;
        } else {
            return false;
        }
    }

    /**
     * Запрос к базе. Обязателен первый аргумент - текст запроса.
     * При указании других аргументов автоматически выполняется placehold() для запроса с подстановкой этих аргументов
     *
     * @param array $args
     *
     * @return bool|\mysqli_result
     * @throws \exception\DbException
     */
    public function query(...$args)
    {
        try {
            $timer = microtime(1);
            if (is_object($this->res)){
                $this->res->free();
            }
            $query = $this->placehold(...$args);
            $this->res = $this->mysqli->query($query);

            $this->timeQuery += microtime(1) - $timer;
            $this->timeQueries += $this->timeQuery;
            $this->numQueries++;
            if (DEBUG_MODE){
                $this->listQueries[$this->numQueries] = [$query, $this->timeQuery];
            }
        } catch (\mysqli_sql_exception $e) {
            $sql = $query ?? null;
            Debugger::log(new \Exception('[Ошибка в базе данных] - запрос: ' . $sql), 'err_db_query');
            if (DEBUG_MODE){
                throw new DbException('Ошибка: ' . $this->mysqli->error . ' в запросе: ' . $sql);
            }
        }

        return $this->res;
    }


    /**
     *  Экранирование
     */
    public function escape($str)
    {
        return $this->mysqli->real_escape_string($str);
    }

    /**
     * Плейсхолдер для запросов.
     * Пример работы: $query = $db->placehold('SELECT name FROM products WHERE id=?', $id);
     *
     * @param array $args
     *
     * @return bool|mixed|string
     * @throws \exception\DbException
     */
    public function placehold(... $args)
    {
        $tmpl = array_shift($args);
        // Заменяем все __ на префикс, но только необрамленные кавычками
        $tmpl = preg_replace('/([^"\'0-9a-z_])__([a-z_]+[^"\'])/i', "\$1" . $this->config->db_prefix . "\$2", $tmpl);
        if (0 !== count($args)){
            // формирование запроса
            $result = $this->sql_placeholder_ex($tmpl, $args, $error);
            if ($result === false){
                if (DEBUG_MODE){
                    throw new DbException("Placeholder substitution error. Diagnostics: \"$error\"");
                }

                return false;
            }

            return $result;
        } else {
            return $tmpl;
        }
    }

    /**
     * Возвращает результаты запроса.
     * Необязательный второй аргумент указывает какую колонку возвращать вместо всего массива колонок
     *
     * @param null $field
     *
     * @return array
     * @throws \Exception
     */
    public function results($field = null)
    {
        $results = [];
        if (!$this->res){
            throw new DbException($this->mysqli->error . ' ' . $this->mysqli->connect_error);
        }

        if ($this->res->num_rows == 0){
            return [];
        }

        while ($row = $this->res->fetch_object()){
            if (!empty($field) && isset($row->$field)){
                array_push($results, $row->$field);
            } else {
                array_push($results, $row);
            }
        }

        return $results;
    }

    /**
     * Возвращает первый результат запроса.
     * Необязательный второй аргумент указывает какую колонку возвращать вместо всего массива колонок
     */
    public function result($field = null)
    {
        $result = [];
        if (!$this->res){
            $this->error_msg = "Could not execute query to database";

            return 0;
        }
        $row = $this->res->fetch_object();
        if (!empty($field) && isset($row->$field)){
            return $row->$field;
        } elseif (!empty($field) && !isset($row->$field)) {
            return false;
        } else {
            return $row;
        }
    }

    /**
     * Возвращает последний вставленный id
     */
    public function insert_id()
    {
        return $this->mysqli->insert_id;
    }

    /**
     * Возвращает количество выбранных строк
     */
    public function num_rows()
    {
        return $this->res->num_rows;
    }

    /**
     * Возвращает количество затронутых строк
     */
    public function affected_rows()
    {
        return $this->mysqli->affected_rows;
    }

    /**
     * Компиляция плейсхолдера
     */
    private function sql_compile_placeholder($tmpl)
    {
        $compiled = [];
        $p = 0;     // текущая позиция в строке
        $i = 0;     // счетчик placeholder-ов
        $has_named = false;
        while (false !== ($start = $p = strpos($tmpl, '?', $p))){
            // Определяем тип placeholder-а.
            switch ($c = substr($tmpl, ++$p, 1)) {
                case '%':
                case '@':
                case '#':
                    $type = $c;
                    ++$p;
                    break;
                default:
                    $type = '';
                    break;
            }
            // Проверяем, именованный ли это placeholder: "?keyname"
            if (preg_match('/^((?:[^\s[:punct:]]|_)+)/', substr($tmpl, $p), $pock)){
                $key = $pock[1];
                if ($type != '#'){
                    $has_named = true;
                }
                $p += strlen($key);
            } else {
                $key = $i;
                if ($type != '#'){
                    $i++;
                }
            }
            // Сохранить запись о placeholder-е.
            $compiled[] = [$key, $type, $start, $p - $start];
        }

        return [$compiled, $tmpl, $has_named];
    }

    /**
     * Выполнение плейсхолдера
     *
     * @param $tmpl
     * @param $args
     * @param $error_msg
     *
     * @return bool|string
     */
    private function sql_placeholder_ex($tmpl, $args, &$error_msg)
    {
        // Запрос уже разобран?.. Если нет, разбираем.
        if (is_array($tmpl)){
            $compiled = $tmpl;
        } else {
            $compiled = $this->sql_compile_placeholder($tmpl);
        }

        list ($compiled, $tmpl, $has_named) = $compiled;

        // Если есть хотя бы один именованный placeholder, используем
        // первый аргумент в качестве ассоциативного массива.
        if ($has_named){
            $args = @$args[0];
        }

        // Выполняем все замены в цикле.
        $p = 0;                // текущее положение в строке
        $out = '';            // результирующая строка
        $error = false; // были ошибки?

        foreach ($compiled as $num => $e){
            list ($key, $type, $start, $length) = $e;

            // Pre-string.
            $out .= substr($tmpl, $p, $start - $p);
            $p = $start + $length;

            $repl = '';        // текст для замены текущего placeholder-а
            $errmsg = ''; // сообщение об ошибке для этого placeholder-а
            do {
                // Это placeholder-константа?
                if ($type === '#'){
                    $repl = @constant($key);
                    if (null === $repl){
                        $error = $errmsg = "UNKNOWN_CONSTANT_$key";
                    }
                    break;
                }
                // Обрабатываем ошибку.
                if (!isset($args[$key])){
                    $error = $errmsg = "UNKNOWN_PLACEHOLDER_$key";
                    break;
                }
                // Вставляем значение в соответствии с типом placeholder-а.
                $a = $args[$key];
                if ($type === ''){
                    // Скалярный placeholder.
                    if (is_array($a)){
                        $error = $errmsg = "NOT_A_SCALAR_PLACEHOLDER_$key";
                        break;
                    }
                    $repl = is_int($a) || is_float($a) ? str_replace(',', '.', $a) : "'" . addslashes($a) . "'";
                    break;
                }
                // Иначе это массив или список.
                if (is_object($a)){
                    $a = get_object_vars($a);
                }
                // удаляем пустые строковые значения
                // для sql-mode="STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION"
                /*$a = array_filter($a, function($element) {
                    return ('' !== $element);
                });*/

                if (!is_array($a)){
                    $error = $errmsg = "NOT_AN_ARRAY_PLACEHOLDER_$key";
                    break;
                }
                if ($type === '@'){
                    // Это список.
                    foreach ($a as $v){
                        if (is_null($v)){
                            $r = 'NULL';
                        } else {
                            $r = "'" . @addslashes($v) . "'";
                        }

                        $repl .= ($repl === '' ? "" : ",") . $r;
                    }
                } elseif ($type === '%') {
                    // Это набор пар ключ=>значение.
                    $lerror = [];
                    foreach ($a as $k => $v){
                        if (!is_string($k)){
                            $lerror[$k] = "NOT_A_STRING_KEY_{$k}_FOR_PLACEHOLDER_$key";
                        } else {
                            $k = preg_replace('/[^a-zA-Z0-9_]/', '_', $k);
                        }

                        if (is_null($v)){
                            $r = '=NULL';
                        /*} elseif (true === $v) {
                            $r = '=' . 1;
                        } elseif (false === $v) {
                            $r = '=' . 0;*/
                        } else {
                            $r = "='" . @addslashes($v) . "'";
                        }

                        $repl .= ($repl === '' ? '' : ', ') . $k . $r;
                    }
                    // Если была ошибка, составляем сообщение.
                    if (count($lerror)){
                        $repl = '';
                        foreach ($a as $k => $v){
                            if (isset($lerror[$k])){
                                $repl .= ($repl === '' ? '' : ', ') . $lerror[$k];
                            } else {
                                $k = preg_replace('/[^a-zA-Z0-9_-]/', '_', $k);
                                $repl .= ($repl === '' ? '' : ', ') . $k . '=?';
                            }
                        }
                        $error = $errmsg = $repl;
                    }
                }
            } while (false);
            if ($errmsg){
                $compiled[$num]['error'] = $errmsg;
            }
            if (!$error){
                $out .= $repl;
            }
        }
        $out .= substr($tmpl, $p);

        // Если возникла ошибка, переделываем результирующую строку
        // в сообщение об ошибке (расставляем диагностические строки
        // вместо ошибочных placeholder-ов).
        if ($error){
            $out = '';
            $p = 0; // текущая позиция
            foreach ($compiled as $num => $e){
                list ($key, $type, $start, $length) = $e;
                $out .= substr($tmpl, $p, $start - $p);
                $p = $start + $length;
                if (isset($e['error'])){
                    $out .= $e['error'];
                } else {
                    $out .= substr($tmpl, $start, $length);
                }
            }
            // Последняя часть строки.
            $out .= substr($tmpl, $p);
            $error_msg = $out;

            return false;
        } else {
            $error_msg = false;

            return $out;
        }
    }

    /**
     * @param $filename
     *
     * @throws \exception\DbException
     */
    public function dump($filename)
    {
        $h = fopen($filename, 'w');
        $q = $this->placehold("SHOW FULL TABLES LIKE '__%';");
        $result = $this->mysqli->query($q);
        while ($row = $result->fetch_row()){
            if ($row[1] == 'BASE TABLE'){
                $this->dump_table($row[0], $h);
            }
        }
        fclose($h);
    }

    /**
     * @param $filename
     */
    public function restore($filename)
    {
        $temp_line = '';
        $h = fopen($filename, 'r');

        // Loop through each line
        if ($h){
            while (!feof($h)){
                $line = fgets($h);
                // Only continue if it's not a comment
                if (substr($line, 0, 2) != '--' && $line != ''){
                    // Add this line to the current segment
                    $temp_line .= $line;
                    // If it has a semicolon at the end, it's the end of the query
                    if (substr(trim($line), -1, 1) == ';'){
                        // Perform the query
                        $this->mysqli->query($temp_line) or print('Error performing query \'<b>' . $temp_line . '</b>\': ' . $this->mysqli->error . '<br/><br/>');
                        // Reset temp variable to empty
                        $temp_line = '';
                    }
                }
            }
        }
        fclose($h);
    }

    /**
     * @param $table
     * @param $h
     */
    public function dump_table($table, $h)
    {
        $sql = "SELECT * FROM `$table`;";
        $result = $this->mysqli->query($sql);
        if ($result){
            fwrite($h, "/* Data for table $table */\n");
            fwrite($h, "TRUNCATE TABLE `$table`;\n");

            $num_rows = $result->num_rows;
            $num_fields = $this->mysqli->field_count;

            if ($num_rows > 0){
                $field_type = [];
                $field_name = [];
                $meta = $result->fetch_fields();
                foreach ($meta as $m){
                    array_push($field_type, $m->type);
                    array_push($field_name, $m->name);
                }
                $fields = implode('`, `', $field_name);
                fwrite($h, "INSERT INTO `$table` (`$fields`) VALUES\n");
                $index = 0;
                while ($row = $result->fetch_row()){
                    fwrite($h, '(');
                    for ($i = 0; $i < $num_fields; $i++){
                        if (is_null($row[$i])){
                            fwrite($h, 'null');
                        } else {
                            switch ($field_type[$i]) {
                                case 'int':
                                    fwrite($h, $row[$i]);
                                    break;
                                case 'string':
                                case 'blob' :
                                default:
                                    fwrite($h, "'" . $this->mysqli->real_escape_string($row[$i]) . "'");
                            }
                        }
                        if ($i < $num_fields - 1){
                            fwrite($h, ',');
                        }
                    }
                    fwrite($h, ')');

                    if ($index < $num_rows - 1){
                        fwrite($h, ',');
                    } else {
                        fwrite($h, ';');
                    }
                    fwrite($h, "\n");

                    $index++;
                }
            }
            $result->free();
        }
        fwrite($h, "\n");
    }
}