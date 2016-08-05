<?php

include __DIR__ . '/../system/configs/define/config.php';
/** @noinspection PhpIncludeInspection */
include SYS_DIR . 'core' . DS . 'boot.php';

define('IS_CLIENT', true);
$registry = new Registry();
if (isset($_SESSION['user_id']) && $user = $registry->users->get_user((int)$_SESSION['user_id'])){
    $registry->design->assign('user', $user);
}

$action = $registry->request->get('action');
$variant_id = $registry->request->get('variant_id', 'integer');
$amount = $registry->request->get('amount', 'integer');

switch ($action) {
    case 'update_citem':
        $registry->cart->update_item($variant_id, $amount);
        break;
    case 'remove_citem':
        $registry->cart->delete_item($variant_id);
        break;
    case 'add_citem':
        $registry->cart->add_item($variant_id, $amount);
        break;
    default:
        break;
}

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

$cart = $registry->cart->get_cart();
if (count($cart->purchases) > 0){
    $coupon_code = trim($registry->request->get('coupon_code', 'string'));
    if (empty($coupon_code)){
        $registry->cart->apply_coupon('');
    } else {
        $coupon = $registry->coupons->get_coupon((string)$coupon_code);
        if (empty($coupon) || !$coupon->valid){
            $registry->cart->apply_coupon($coupon_code);
            $registry->design->assign('coupon_error', 'invalid');
        } else {
            $registry->cart->apply_coupon($coupon_code);
        }
    }

    $cart = $registry->cart->get_cart();
    $registry->design->assign('cart', $cart);
    $currencies = $registry->money->get_currencies(['enabled' => 1]);
    if (isset($_SESSION['currency_id'])){
        $currency = $registry->money->get_currency($_SESSION['currency_id']);
    } else {
        $currency = reset($currencies);
    }
    $registry->design->assign('currency', $currency);

    $deliveries = $registry->delivery->get_deliveries(['enabled' => 1]);
    $registry->design->assign('deliveries', $deliveries);
    foreach ($deliveries as $delivery){
        $delivery->payment_methods = $registry->payment->get_payment_methods(['delivery_id' => $delivery->id, 'enabled' => 1]);
    }
    $registry->design->assign('all_currencies', $registry->money->get_currencies());
    if ($registry->coupons->count_coupons(['valid' => 1]) > 0){
        $registry->design->assign('coupon_request', true);
    }
    /** @var array $result */
    $result['result'] = 1;
    $result['cart_informer'] = $registry->design->fetch('cart_informer.tpl');
    $result['cart_purchases'] = $registry->design->fetch('cart_purchases.tpl');
    $result['cart_deliveries'] = $registry->design->fetch('cart_deliveries.tpl');
    $result['currency_sign'] = $currency->sign;
    $result['total_price'] = $registry->money->convert($cart->total_price, $currency->id);
    $result['total_products'] = $cart->total_products;
} else {
    /** @var array $result */
    $result['result'] = 0;
    $result['cart_informer'] = $registry->design->fetch('cart_informer.tpl');
    $result['content'] = $registry->design->fetch('cart.tpl');
}
header('Content-type: application/json; charset=UTF-8');
header('Cache-Control: must-revalidate');
header('Pragma: no-cache');
header('Expires: -1');
print json_encode($result);