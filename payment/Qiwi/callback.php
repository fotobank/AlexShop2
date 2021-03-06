<?php

use api\Registry;

// Подключаем SOAP
require_once('nusoap/nusoap.php');
$server = new nusoap_server;
$server->register('updateBill');
$server->service(file_get_contents("php://input"));

// Эта функция вызывается при уведомлениях от QIWI Кошелька
function updateBill($login, $password, $txn, $status)
{
	// Если уведомление не о успешной оплате, нам это не интересно
	if($status!=60)
		return new soapval('updateBillResult', 'xsd:integer', 0); 

	// Работаем в корневой директории
	chdir ('../../');
	
	// Подключаем основной класс

	$registry = new Registry();

	// Выбираем оплачиваемый заказ
	$order = $registry->orders->get_order((int)$txn);
	
	// 210 = Счет не найден
	if(empty($order))
		return new soapval('updateBillResult', 'xsd:integer', 210); 
		
	// Выбираем из базы соответствующий метод оплаты
	$method = $registry->payment->get_payment_method((int)$order->payment_method_id);
	if(empty($method))
		return new soapval('updateBillResult', 'xsd:integer', 210);
	// Настройки способа оплаты	
	$settings = unserialize($method->settings);

	// Проверяем логин
	// 150 = Ошибка авторизации (неверный логин/пароль)
	if(empty($login) || ($settings['qiwi_login'] !== $login))
		return new soapval('updateBillResult', 'xsd:integer', 150); 

	// Проверяем пароль
	// 150 = Ошибка авторизации (неверный логин/пароль)
	if(empty($password) || (strtoupper(md5($txn.strtoupper(md5($settings['qiwi_password'])))) !== strtoupper($password)))
		return new soapval('updateBillResult', 'xsd:integer', 150); 

	// Нельзя оплатить уже оплаченный заказ 
	// 215 = Счет с таким txn-id уже существует
	if($order->paid)
		return new soapval('updateBillResult', 'xsd:integer', 215);
		
	// Проверка наличия товара
	$purchases = $registry->orders->get_purchases(array('order_id'=>(int)$order->id));
	foreach($purchases as $purchase)
	{
		$variant = $registry->variants->get_variant((int)$purchase->variant_id);
		if(empty($variant) || (!$variant->infinity && $variant->stock < $purchase->amount))
		{
			// 300 = Неизвестная ошибка
			return new soapval('updateBillResult', 'xsd:integer', 300); 
		}
	}
	
	// Установим статус оплачен
	$registry->orders->update_order((int)$order->id, array('paid'=>1));
	
	// Спишем товары  
	$registry->orders->close((int)$order->id);
	$registry->notify->email_order_user((int)$order->id);
	$registry->notify->email_order_admin((int)$order->id);

	// Успешное завершение
	return new soapval('updateBillResult', 'xsd:integer', 0); 
}

