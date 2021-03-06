<?php

use api\Registry;

include __DIR__ . '/../system/configs/define/config.php';
/** @noinspection PhpIncludeInspection */
include SYS_DIR . 'core' . DS . 'boot.php';

$filename = $_GET['file'];
$token = $_GET['token'];

$registry = new Registry();

/*if(!$registry->config->check_token($filename, $token)) {
    exit('bad token');
}*/

/*resizing_image*/
$original_img_dir = null;
$resized_img_dir = null;
if (isset($_GET['object']) && !empty($_GET['object'])) {
    //$_GET['object'] - по сути папка с нарезанными картинками
    if ($_GET['object'] == 'blog_resized') {
        $original_img_dir = $registry->config->original_blog_dir;
        $resized_img_dir = $registry->config->resized_blog_dir;
    }
    if ($_GET['object'] == 'brands_resized') {
        $original_img_dir = $registry->config->original_brands_dir;
        $resized_img_dir = $registry->config->resized_brands_dir;
    }
    if ($_GET['object'] == 'categories_resized') {
        $original_img_dir = $registry->config->original_categories_dir;
        $resized_img_dir = $registry->config->resized_categories_dir;
    }
    if ($_GET['object'] == 'deliveries_resized') {
        $original_img_dir = $registry->config->original_deliveries_dir;
        $resized_img_dir = $registry->config->resized_deliveries_dir;
    }
    if ($_GET['object'] == 'payments_resized') {
        $original_img_dir = $registry->config->original_payments_dir;
        $resized_img_dir = $registry->config->resized_payments_dir;
    }

}
/*/resizing_image*/

$resized_filename =  $registry->image->resize($filename/*resizing_image*/, $original_img_dir, $resized_img_dir/*/resizing_image*/);

if(is_readable($resized_filename)) {
    header('Content-type: image');
    print file_get_contents($resized_filename);
}

