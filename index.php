<?php

use api\ComingSoon\ComingSoon;

use lib\Security\Security;
use proxy\Cookie;

include(__DIR__ . '/License.php');
include(__DIR__ . '/system/configs/define/config.php');
/** @noinspection PhpIncludeInspection */
include SYS_DIR . 'core' . DS . 'boot.php';

new Security();
$view = new IndexView();


if(isset($_GET['logout'])) {
    $out_manager = $view->request->filter_string($_SESSION['admin'], 'sql');
    $view->managers->delete_cookie($out_manager, 'login');
    Cookie::del('_remember');
    unset($_SESSION['admin']);
    header('location: ' . $view->config->root_url . '/admin');
    exit();
}

$page = $view->request->create($view);
//print Optimize::html($page);

print $page;
