<?php

// Работаем в корневой директории
chdir ('../../');

$registry = new Registry();

// Выбираем из xml нужные данные
$public_key		 	= $registry->request->post('public_key');
$amount				= $registry->request->post('amount');
$currency			= $registry->request->post('currency');
$description		= $registry->request->post('description');
$liqpay_order_id	= $registry->request->post('order_id');
$order_id			= intval(substr($liqpay_order_id, 0, strpos($liqpay_order_id, '-')));
$type				= $registry->request->post('type');
$signature			= $registry->request->post('signature');
$status				= $registry->request->post('status');
$transaction_id		= $registry->request->post('transaction_id');
$sender_phone		= $registry->request->post('sender_phone');

if($status !== 'success')
	die("bad status");

if($type !== 'buy')
	die("bad type");

////////////////////////////////////////////////
// Выберем заказ из базы
////////////////////////////////////////////////
$order = $registry->orders->get_order(intval($order_id));
if(empty($order))
	die('Оплачиваемый заказ не найден');
 
////////////////////////////////////////////////
// Выбираем из базы соответствующий метод оплаты
////////////////////////////////////////////////
$method = $registry->payment->get_payment_method(intval($order->payment_method_id));
if(empty($method))
	die("Неизвестный метод оплаты");
	
$settings = unserialize($method->settings);
$payment_currency = $registry->money->get_currency(intval($method->currency_id));

// Валюта должна совпадать
if($currency !== $payment_currency->code)
	die("bad currency");

// Проверяем контрольную подпись
$mysignature = base64_encode(sha1($settings['liqpay_private_key'].$amount.$currency.$public_key.$liqpay_order_id.$type.$description.$status.$transaction_id.$sender_phone, 1));
if($mysignature !== $signature)
	die("bad sign".$signature);

// Нельзя оплатить уже оплаченный заказ  
if($order->paid)
	die('order already paid');

if($amount != round($registry->money->convert($order->total_price, $method->currency_id, false), 2) || $amount<=0)
	die("incorrect price");
	       
// Установим статус оплачен
$registry->orders->update_order(intval($order->id), array('paid'=>1));

// Отправим уведомление на email
$registry->notify->email_order_user(intval($order->id));
$registry->notify->email_order_admin(intval($order->id));

// Спишем товары  
$registry->orders->close(intval($order->id));

// Перенаправим пользователя на страницу заказа
// header('Location: '.$registry->config->root_url.'/order/'.$order->url);

exit();