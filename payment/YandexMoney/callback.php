<?php

use api\Registry;

// Работаем в корневой директории
chdir ('../../');


$registry = new Registry();

$order_id = $registry->request->post('customerNumber', 'integer');
$invoice_id = $registry->request->post('invoiceId', 'string');

////////////////////////////////////////////////
// Выберем заказ из базы
////////////////////////////////////////////////
$order = $registry->orders->get_order((int)$order_id);
if(empty($order))
	print_error('Оплачиваемый заказ не найден');
 
////////////////////////////////////////////////
// Выбираем из базы соответствующий метод оплаты
////////////////////////////////////////////////
$method = $registry->payment->get_payment_method((int)$order->payment_method_id);
if(empty($method))
	print_error("Неизвестный метод оплаты");
 
$settings = unserialize($method->settings);
$shop_id = $settings['yandex_shopid'];
       
// Нельзя оплатить уже оплаченный заказ  
if($order->paid)
	print_error('Этот заказ уже оплачен');
       
////////////////////////////////////
// Проверка контрольной подписи
////////////////////////////////////
$str =	$_POST['action'].';'.$_POST['orderSumAmount'].';'.
		$_POST['orderSumCurrencyPaycash'].';'.$_POST['orderSumBankPaycash'].';'.
		$settings['yandex_shopid'].';'.$invoice_id.';'.
		$_POST['customerNumber'].';'.$settings['yandex_password'];

$md5 = strtoupper(md5($str));
if($md5 !== $_POST['md5'])
		print_error("Контрольная подпись не верна");

////////////////////////////////////
// Проверка суммы платежа
////////////////////////////////////
       
// Сумма заказа у нас в магазине
$order_amount = $registry->money->convert($order->total_price, $method->currency_id, false);
       
// Должна быть равна переданной сумме
if(floatval($order_amount) !== floatval($_POST['orderSumAmount']))
	print_error("Неверная сумма оплаты");

////////////////////////////////////
// Проверка наличия товара
////////////////////////////////////
$purchases = $registry->orders->get_purchases(array('order_id'=>(int)$order->id));
foreach($purchases as $purchase)
{
	$variant = $registry->variants->get_variant((int)$purchase->variant_id);
	if(empty($variant) || (!$variant->infinity && $variant->stock < $purchase->amount))
	{
		print_error("Нехватка товара $purchase->product_name $purchase->variant_name");
	}
}
       
// Запишем
if($_POST['action'] == 'paymentAviso')
{
	// Установим статус оплачен
	$registry->orders->update_order((int)$order->id, array('paid'=>1));

	// Спишем товары  
	$registry->orders->close((int)$order->id);
	$registry->notify->email_order_user((int)$order->id);
	$registry->notify->email_order_admin((int)$order->id);
	
	$datetime = new DateTime();
	$performedDatetime = $datetime->format('c');
	print '<?xml version="1.0" encoding="UTF-8"?> 
	<paymentAvisoResponse performedDatetime="'.$performedDatetime.'" 
	code="0" invoiceId="'.$invoice_id.'" 
	shopId="'.$shop_id.'"/>';
	
}
elseif($_POST['action'] == 'checkOrder')
{
	$datetime = new DateTime();
	$performedDatetime = $datetime->format('c');
	print '<?xml version="1.0" encoding="UTF-8"?> 
	<checkOrderResponse performedDatetime="'.$performedDatetime.'" 
	code="0" invoiceId="'.$invoice_id.'" 
	shopId="'.$shop_id.'"/>';
}

function print_error($text)
{
	$datetime = new DateTime();
	$performedDatetime = $datetime->format('c');
	$shop_id = (int)$_POST['shopId'];
	$invoice_id = (int)$_POST['invoiceId'];
	
	$responce = '';
	$action = $_POST['action'];
	if($action === 'paymentAviso')
		$responce = 'paymentAvisoResponse';
	elseif($action === 'checkOrder')
		$responce = 'checkOrderResponse';
	

	print '<?xml version="1.0" encoding="UTF-8"?> 
	<'.$responce.' performedDatetime="'.$performedDatetime.'" 
	code="200" invoiceId="'.$invoice_id.'" 
	message="'.$text.'" shopId="'.$shop_id.'"/>';

	exit();
}