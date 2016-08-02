<?php

/** @noinspection TernaryOperatorSimplifyInspection */
defined('DEBUG_MODE') or define('DEBUG_MODE', true);

include(__DIR__ . '/system/configs/define/config.php');
include(SYS_DIR . DS . 'core' . DS . 'boot.php');



$view = new IndexView();

if(isset($_GET['logout'])) {
    unset($_SESSION['admin']);
    header('location: '.$view->config->root_url);
    exit();
}

if(($res = $view->fetch()) !== false) {
    header('Content-type: text/html; charset=UTF-8');
    print $res;
    
    // Сохраняем последнюю просмотренную страницу в переменной $_SESSION['last_visited_page']
    if ((isset($_SESSION['last_visited_page']) && empty($_SESSION['last_visited_page'])) ||
        (isset($_SESSION['current_page']) && empty($_SESSION['current_page'])) ||
        $_SERVER['REQUEST_URI'] !== $_SESSION['current_page']) {
        if(!empty($_SESSION['current_page']) && $_SESSION['last_visited_page'] !== $_SESSION['current_page']) {
            $_SESSION['last_visited_page'] = $_SESSION['current_page'];
        }
        $_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
    }
} else {
    // Иначе страница об ошибке
    header('http/1.0 404 not found');
    
    // Подменим переменную GET, чтобы вывести страницу 404
    $_GET['page_url'] = '404';
    $_GET['module'] = 'PageView';
    print $view->fetch();   
}