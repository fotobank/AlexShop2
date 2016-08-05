<?php

// Работаем в корневой директории
chdir ('../../');

$registry = new Registry();

////////////////////////////////////////////////
// Проверка статуса
////////////////////////////////////////////////
if($_POST['notification_type'] !== 'p2p-incoming')
	err('bad status');

////////////////////////////////////////////////
// Выберем заказ из базы
////////////////////////////////////////////////
$order = $registry->orders->get_order(intval($_POST['label']));
if(empty($order))
	err('Оплачиваемый заказ не найден');
 
////////////////////////////////////////////////
// Выбираем из базы соответствующий метод оплаты
////////////////////////////////////////////////
$method = $registry->payment->get_payment_method(intval($order->payment_method_id));
if(empty($method))
	err("Неизвестный метод оплаты");
	
$settings = unserialize($method->settings);
$payment_currency = $registry->money->get_currency(intval($method->currency_id));

// Проверяем контрольную подпись
$hash = sha1($_POST['notification_type'].'&'.$_POST['operation_id'].'&'.$_POST['amount'].'&'.$_POST['currency'].'&'.$_POST['datetime'].'&'.$_POST['sender'].'&'.$_POST['codepro'].'&'.$settings['yandex_secret'].'&'.$_POST['label']);

if($hash !== $_POST['sha1_hash'])
	err('bad sign');

// Нельзя оплатить уже оплаченный заказ  
if($order->paid)
	err('Этот заказ уже оплачен');

// Учет комиссии Яндекса
$amount = round($registry->money->convert($order->total_price, $method->currency_id, false), 2);

if($_POST['amount'] != $amount || $_POST['amount']<=0)
	err("incorrect price");

// Установим статус оплачен
$registry->orders->update_order(intval($order->id), array('paid'=>1));

// Отправим уведомление на email
$registry->notify->email_order_user(intval($order->id));
$registry->notify->email_order_admin(intval($order->id));

// Спишем товары  
$registry->orders->close(intval($order->id));

function err($msg)
{
	header($_SERVER['SERVER_PROTOCOL'].' 400 Bad Request', true, 400);
	// mail("test@test", "yandex: $msg", $msg);
	die($msg);
}
