<?php

include(__DIR__ . '/system/configs/define/config.php');
include(SYS_DIR . DS . 'core' . DS . 'boot.php');


$view = new IndexView();

if(isset($_GET['logout'])) {
    unset($_SESSION['admin']);
    header('location: '.$view->config->root_url);
    exit();
}

$page = $view->request->print($view);
print $page;