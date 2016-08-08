<?php

use api\Registry;

include __DIR__ . '/../system/configs/define/config.php';
/** @noinspection PhpIncludeInspection */
include SYS_DIR . 'core' . DS . 'boot.php';

include __DIR__ . '/../core/inc/functions.php';
$registry = new Registry();

$variant_id = $registry->request->post('variant', 'integer');
$amount = $registry->request->post('amount', 'integer');

$order = new \stdClass;
$order->name = sanitize($registry->request->post('name', 'string'));
$order->phone = sanitize($registry->request->post('phone', 'string'));
$order->ip = ip();

// добавляем заказ
$order_id = $registry->orders->add_order($order);

// добавляем товар в заказ
$registry->orders->add_purchase([
    'order_id' => $order_id,
    'variant_id' => (int)$variant_id,
    'amount' => (int)$amount
]);

// отправляем письмо администратору
$registry->notify->email_order_admin($order_id);