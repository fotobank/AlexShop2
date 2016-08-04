<?php
include __DIR__ . '/../system/configs/define/config.php';
/** @noinspection PhpIncludeInspection */
include SYS_DIR . 'core' . DS . 'boot.php';

include __DIR__ . '/../core/inc/functions.php';
$okay = new Okay();

$variant_id = $okay->request->post('variant', 'integer');
$amount = $okay->request->post('amount', 'integer');

$order = new stdClass;
$order->name = sanitize($okay->request->post('name', 'string'));
$order->phone = sanitize($okay->request->post('phone', 'string'));
$order->ip = ip();

// добавляем заказ
$order_id = $okay->orders->add_order($order);

// добавляем товар в заказ
$okay->orders->add_purchase([
    'order_id' => $order_id,
    'variant_id' => (int)$variant_id,
    'amount' => (int)$amount
]);

// отправляем письмо администратору
$okay->notify->email_order_admin($order_id);