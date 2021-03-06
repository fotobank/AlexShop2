<?php

use api\Registry;

include __DIR__ . '/../system/configs/define/config.php';
/** @noinspection PhpIncludeInspection */
include SYS_DIR . 'core' . DS . 'boot.php';

define('IS_CLIENT', true);
$registry = new Registry();
$result = [];

$limit = 500;

$id = $registry->request->get('id', 'integer');

if (!empty($_COOKIE['wished_products'])){
    $products_ids = explode(',', $_COOKIE['wished_products']);
    $products_ids = array_reverse($products_ids);
} else {
    $products_ids = [];
}

if ($registry->request->get('action', 'string') == 'delete'){
    $key = array_search($id, $products_ids);
    unset($products_ids[$key]);
} else {
    array_push($products_ids, $id);
    $products_ids = array_unique($products_ids);
}

$products_ids = array_slice($products_ids, 0, $limit);
$products_ids = array_reverse($products_ids);

if (!count($products_ids)){
    unset($_COOKIE['wished_products']);
    setcookie('wished_products', '', time() - 3600, '/');
} else {
    setcookie('wished_products', implode(',', $products_ids), time() + 30 * 24 * 3600, '/');
}

$registry->design->assign('wished_products', $products_ids);

$language = $registry->languages->languages(['id' => $registry->languages->lang_id()]);
$registry->design->assign('language', $language);

$lang_link = '';
$first_lang = $registry->languages->languages();
if (!empty($first_lang)){
    $first_lang = reset($first_lang);
    if ($first_lang->id !== $language->id){
        $lang_link = $language->label . '/';
    }
}
$registry->design->assign('lang_link', $lang_link);
$registry->design->assign('lang', $registry->translations);

header("Content-type: text/html; charset=UTF-8");
header("Cache-Control: must-revalidate");
header("Pragma: no-cache");
header("Expires: -1");
/*mt1sk*/
$result['info'] = $registry->design->fetch('wishlist_informer.tpl');
$result['cnt'] = count($products_ids);
print json_encode($result);
//print $registry->design->fetch('wishlist_informer.tpl');
/*/mt1sk*/
