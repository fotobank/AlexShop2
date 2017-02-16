<?php
/*************************************************
  Framework Component
  name      AlexShop_CMS
  created   by Alex production
  version   1.0
  author    Alex Jurii <alexjurii@gmail.com>
  Copyright (c) 2016
 ************************************************/

namespace api;

class Request extends Registry {
    
    public function __construct() {
        parent::__construct();

        $_POST = $this->stripslashes_recursive($_POST);
        $_GET = $this->stripslashes_recursive($_GET);
    }
    
    /**
    * Определение request-метода обращения к странице (GET, POST)
    * Если задан аргумент функции (название метода, в любом регистре), возвращает true или false
    * Если аргумент не задан, возвращает имя метода
    * Пример:
    *
    *	if($registry->request->method('post'))
    *		print 'Request method is POST';
    *
    */
    public function method($method = null) {
        if(!empty($method)) {
            return strtolower($_SERVER['REQUEST_METHOD']) == strtolower($method);
        }
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Возвращает переменную _GET, отфильтрованную по заданному типу, если во втором параметре указан тип фильтра
     * Второй параметр $type может иметь такие значения: integer, string, boolean
     * Если $type не задан, возвращает переменную в чистом виде
     *
     * @param      $name
     * @param null $type
     *
     * @return array|bool|float|int|mixed|null
     */
    public function get($name, $type = null) {
        $val = null;
        if(isset($_GET[$name])) {
            $val = $_GET[$name];
        }
        if(!empty($type) && is_array($val)) {
            $val = reset($val);
        }
        if($type === 'string') {
            return (string)preg_replace('/[^\p{L}\p{Nd}\d\s_\-\.\%\s]/ui', '', $val);
        }
        if($type === 'integer') {
            return (int)$val;
        }
        if($type === 'float') {
            return (float)$val;
        }
        if($type === 'boolean') {
            return !empty($val);
        }
        return $val;
    }

    /**
     * Возвращает переменную _POST, отфильтрованную по заданному типу, если во втором параметре указан тип фильтра
     * Второй параметр $type может иметь такие значения: integer, string, boolean
     * Если $type не задан, возвращает переменную в чистом виде
     *
     * @param null $name
     * @param null $type
     *
     * @return bool|float|int|null|string
     */
    public function post($name = null, $type = null) {
        $val = null;
        if(!empty($name) && isset($_POST[$name])) {
            $val = $_POST[$name];
        } elseif(empty($name)) {
            $val = file_get_contents('php://input');
        }
        if($val){
            if ($type === 'string'){
                return (string)preg_replace('/[^\p{L}\p{Nd}\d\s_\-\.\%\s]/iu', '', $val);
            }
            if ($type === 'integer'){
                return (int)$val;
            }
            if ($type === 'float'){
                return (float)$val;
            }
            if ($type === 'boolean'){
                return !empty($val);
            }
        }
        return $val;
    }

    /**
     * доделать
     * очистка переменных
     * @param      $string
     * @param null $type
     *
     * @return mixed|string
     */
    public function filter($string, $type = null) {

        if ($type === 'js'){
            $string = preg_replace("/\r*\n/", "\\n", $string);
            $string = preg_replace("/\//", "\\\/", $string);
            $string = preg_replace("/\"/", "\\\"", $string);
            return preg_replace("/'/", " ", $string);
        }
        if ($type === 'sql_valid'){
            return str_replace(["\\", "'", '"', "\x00", "\x1a", "\r", "\n"],
                ["\\\\", "\'", '\"', "\\x00", "\\x1a", "\\r", "\\n"], $string);
        }
        if ($type === 'sql'){
            $string = htmlentities($string, ENT_QUOTES);
            if(get_magic_quotes_gpc())
            {
                $string = stripslashes($string);
            }
            $string = mysqli_real_escape_string($this->db->getMysqli(), $string);
            $string = strip_tags($string);
            $string = str_replace('  ', "\n", $string);

            return $string;
        }
        if ($type === 'clean'){
            $search = [
                '@<script[^>]*?>.*?</script>@si', // javascript
                '@<[\/\!]*?[^<>]*?>@si', // HTML теги
                '@<style[^>]*?>.*?</style>@siU', // теги style
                '@<![\s\S]*?--[ \t\n\r]*>@' // многоуровневые комментарии
            ];

            return preg_replace($search, '', $string);
        }
        return $string;
    }
    
    /**
    * Возвращает переменную _FILES
    * Обычно переменные _FILES являются двухмерными массивами, поэтому можно указать второй параметр,
    * например, чтобы получить имя загруженного файла: $filename = $registry->request->files('myfile', 'name');
    */
    public function files($name, $name2 = null) {
        if(!empty($name2) && !empty($_FILES[$name][$name2])) {
            return $_FILES[$name][$name2];
        } elseif(empty($name2) && !empty($_FILES[$name])) {
            return $_FILES[$name];
        } else {
            return null;
        }
    }


    /**
     * Функция экранирования переменных
     * $info = $Database->prepare("SELECT money FROM users WHERE text = '".quoteSmart($_POST["text"])."'");
     *
     * @param $value
     *
     * @return string
     */
    public function quoteSmart($value)
    {
        // если magic_quotes_gpc включена - используем stripslashes
        if (get_magic_quotes_gpc()) {
            $value = stripslashes($value);
        }
        // Если переменная - число, то экранировать её не нужно
        // если нет - то окружем её кавычками, и экранируем
        if (!is_numeric($value)) {
            $value = $this->db->getMysqli()->real_escape_string($value);
        }
        return $value;
    }


    /**
     * Рекурсивная чистка магических слешей
     */
    private function stripslashes_recursive($var) {
        if(get_magic_quotes_gpc()) {
            $res = null;
            if(is_array($var)) {
                foreach($var as $k=>$v) {
                    $res[stripcslashes($k)] = $this->stripslashes_recursive($v);
                }
            } else {
                $res = stripcslashes($var);
            }
        } else {
            $res = $var;
        }
        return $res;
    }
    
    /**
    * Проверка сессии
    */
    public function checkSession() {
        if(isset($_POST, $_POST['session_id'])) {
            if(empty($_POST['session_id']) || $_POST['session_id'] != session_id()) {
                unset($_POST);
                return false;
            }
        }
        return true;
    }

    /**
     * URL
     *
     * @param array $params
     *
     * @return string
     */
    public function url($params = array()) {
        $url = @parse_url($_SERVER['REQUEST_URI']);
        parse_str($url['query'], $query);
        
        if(get_magic_quotes_gpc()) {
            foreach($query as &$v) {
                if(!is_array($v)) {
                    $v = stripslashes(urldecode($v));
                }
            }
        }
        
        foreach($params as $name=>$value) {
            $query[$name] = $value;
        }
        
        $query_is_empty = true;
        foreach($query as $name=>$value) {
            if($value!=='' && $value!==null) {
                $query_is_empty = false;
            }
        }
        
        if(!$query_is_empty) {
            $url['query'] = http_build_query($query);
        } else {
            $url['query'] = null;
        }

        return http_build_url(null, $url);
    }

    /**
     * @param \IndexView $view
     * вывод результата
     *
     * @return bool|string
     */
    public function create($view){

        $res = $view->fetch();
        if($res !== false) {
            header('Content-type: text/html; charset=UTF-8');

            // Сохраняем последнюю просмотренную страницу в переменной $_SESSION['last_visited_page']
            if ((isset($_SESSION['last_visited_page']) && empty($_SESSION['last_visited_page'])) ||
                (isset($_SESSION['current_page']) && empty($_SESSION['current_page'])) ||
                $_SERVER['REQUEST_URI'] !== $_SESSION['current_page']) {
                if(!empty($_SESSION['current_page']) && $_SESSION['last_visited_page'] !== $_SESSION['current_page']) {
                    $_SESSION['last_visited_page'] = $_SESSION['current_page'];
                }
                $_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
            }

            return $res;
        } else {
            // Иначе страница об ошибке
            header('http/1.0 404 not found');
            // Подменим переменную GET, чтобы вывести страницу 404
            $_GET['page_url'] = '404';
            $_GET['module'] = 'PageView';
            return $view->fetch();
        }
    }



}
