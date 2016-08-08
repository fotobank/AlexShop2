<?php

// Засекаем время
use proxy\Session;
use Tracy\Debugger;

$time_start = microtime(true);

require_once __DIR__ . '/../system/configs/define/config.php';
require_once SYS_DIR . 'core' . DS . 'boot.php';

Session::set('id', session_id());
chdir('..');

// Кеширование в админке нам не нужно
header('Cache-Control: no-cache, must-revalidate');
header('Expires: -1');
header('Pragma: no-cache');

$backend = new IndexAdmin();


// Проверка id сессии для защиты от xss
if(!Session::check_session()) {
    Debugger::log(new Exception('XSS атака на admin адрес сайта: http://' . $_SERVER['SERVER_NAME'] .
        ' пользователь пришел из: ' . Session::get('origURL') . ' Ip адрес пользователя: ' . $_SERVER['REMOTE_ADDR']), Debugger::ERROR);
}


print $backend->fetch();

// Отладочная информация
if(DEBUG_MODE) {
    print "<!--\r\n";
    $i = 0;
    $sql_time = 0;
    $qsl_queries = $backend->db->queries;
    if($qsl_queries){
        foreach ($qsl_queries as $q){
            $i++;
            print "$i.\t$q->exec_time sec\r\n$q->sql\r\n\r\n";
            $sql_time += $q->exec_time;
        }
    }
    $time_end = microtime(true);
    $exec_time = $time_end-$time_start;
    
    if(function_exists('memory_get_peak_usage')) {
        print 'memory peak usage: ' .memory_get_peak_usage()." bytes\r\n";
    }
    print 'page generation time: ' .$exec_time." seconds\r\n";
    print 'sql queries time: ' .$sql_time." seconds\r\n";
    print 'php run time: ' .($exec_time-$sql_time)." seconds\r\n";
    print '-->';
}