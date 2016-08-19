<?php

if(!$registry->managers->access('design')) {
    exit();
}

// Проверка сессии для защиты от xss
if(!$registry->request->checkSession()) {
    trigger_error('Session expired', E_USER_WARNING);
    exit();
}
$content = $registry->request->post('content');
$script = $registry->request->post('script');
$theme = $registry->request->post('theme', 'string');

if(pathinfo($script, PATHINFO_EXTENSION) != 'js') {
    exit();
}

$file = $registry->config->root_dir.'design/'.$theme.'/js/'.$script;
if(is_file($file) && is_writable($file) && !is_file($registry->config->root_dir.'design/'.$theme.'/locked')) {
    file_put_contents($file, $content);
}

$result = true;
header("Content-type: application/json; charset=UTF-8");
header("Cache-Control: must-revalidate");
header("Pragma: no-cache");
header("Expires: -1");
$json = json_encode($result);
print $json;
