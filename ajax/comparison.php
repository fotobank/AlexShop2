<?php
include __DIR__ . '/../system/configs/define/config.php';
/** @noinspection PhpIncludeInspection */
include SYS_DIR . 'core' . DS . 'boot.php';

define('IS_CLIENT', true);
$okay = new Okay();
$product_id = $okay->request->get('product', 'integer');
$action = $okay->request->get('action');
if ($action == 'add'){
    $okay->comparison->add_item((int)$product_id);
} elseif ($action == 'delete') {
    $okay->comparison->delete_item((int)$product_id);
}

$comparison = $okay->comparison->get_comparison();
$okay->design->assign('comparison', $comparison);

$language = $okay->languages->languages(['id' => $okay->languages->lang_id()]);
$okay->design->assign('language', $language);

$lang_link = '';
$first_lang = $okay->languages->languages();
if (!empty($first_lang)){
    $first_lang = reset($first_lang);
    if ($first_lang->id !== $language->id){
        $lang_link = $language->label . '/';
    }
}

$okay->design->assign('lang_link', $lang_link);
$okay->design->assign('lang', $okay->translations);

$result = $okay->design->fetch('comparison_informer.tpl');
header("Content-type: application/json; charset=UTF-8");
header("Cache-Control: must-revalidate");
header("Pragma: no-cache");
header("Expires: -1");
print json_encode($result);