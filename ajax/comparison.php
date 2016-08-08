<?php

use api\Registry;

include __DIR__ . '/../system/configs/define/config.php';
/** @noinspection PhpIncludeInspection */
include SYS_DIR . 'core' . DS . 'boot.php';

define('IS_CLIENT', true);
$registry = new Registry();
$product_id = $registry->request->get('product', 'integer');
$action = $registry->request->get('action');
if ($action == 'add'){
    $registry->comparison->add_item((int)$product_id);
} elseif ($action == 'delete') {
    $registry->comparison->delete_item((int)$product_id);
}

$comparison = $registry->comparison->get_comparison();
$registry->design->assign('comparison', $comparison);

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

$result = $registry->design->fetch('comparison_informer.tpl');
header("Content-type: application/json; charset=UTF-8");
header("Cache-Control: must-revalidate");
header("Pragma: no-cache");
header("Expires: -1");
print json_encode($result);