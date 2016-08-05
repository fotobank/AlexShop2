<?php

include __DIR__ . '/../system/configs/define/config.php';
/** @noinspection PhpIncludeInspection */
include SYS_DIR . 'core' . DS . 'boot.php';

define('IS_CLIENT', true);
$registry = new Registry();
$registry->cart->add_item($registry->request->get('variant', 'integer'), $registry->request->get('amount', 'integer'));
$cart = $registry->cart->get_cart();
$registry->design->assign('cart', $cart);

$currencies = $registry->money->get_currencies(['enabled' => 1]);
if (isset($_SESSION['currency_id'])){
    $currency = $registry->money->get_currency($_SESSION['currency_id']);
} else {
    $currency = reset($currencies);
}

$registry->design->assign('currency', $currency);

$language = $registry->languages->languages(['id' => $_SESSION['lang_id']]);
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

$result = $registry->design->fetch('cart_informer.tpl');
header('Content-type: application/json; charset=UTF-8');
header('Cache-Control: must-revalidate');
header('Pragma: no-cache');
header('Expires: -1');
print json_encode($result);