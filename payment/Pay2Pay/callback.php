<?php

function get_tag_val($xml, $name)
{
  preg_match("/<$name>(.*)<\/$name>/i", $xml, $matches);
  return trim($matches[1]); 
}

// Работаем в корневой директории
chdir ('../../');

$registry = new Registry();


$xml_post = base64_decode(str_replace(' ', '+', $_REQUEST['xml']));
$sign_post = base64_decode(str_replace(' ', '+', $_REQUEST['sign']));

// Выбираем из xml нужные данные
$order_id      = (int)get_tag_val($xml_post, 'order_id');
$merchant_id   = get_tag_val($xml_post, 'merchant_id'); 
$amount        = get_tag_val($xml_post, 'amount'); 
$currency_code = get_tag_val($xml_post, 'currency'); 
$status        = get_tag_val($xml_post, 'status'); 

$err = '';

////////////////////////////////////////////////
// Выберем заказ из базы
////////////////////////////////////////////////
$order = $registry->orders->get_order((int)$order_id);
if(!empty($order))
{ 
  ////////////////////////////////////////////////
  // Выбираем из базы соответствующий метод оплаты
  ////////////////////////////////////////////////
  $method = $registry->payment->get_payment_method((int)$order->payment_method_id);
  if(!empty($method))
  {
  	
    $settings = unserialize($method->settings);
    $payment_currency = $registry->money->get_currency((int)$method->currency_id);
    
    // Проверяем контрольную подпись
    $mysignature = md5($settings['pay2pay_hidden'].$xml_post.$settings['pay2pay_hidden']);
    if($mysignature == $sign_post)
    {
    
      // Нельзя оплатить уже оплаченный заказ  
      if (!$order->paid)
      {
        if($amount >= round($registry->money->convert($order->total_price, $method->currency_id, false), 2))
        {
          $currency = $payment_currency->code;
          if ($currency == 'RUR')
            $currency = 'RUB';
          if($currency_code == $currency)
          {
            if($status == 'success')
            {
              // Установим статус оплачен
              $registry->orders->update_order((int)$order->id, array('paid'=>1));
              
              // Отправим уведомление на email
              $registry->notify->email_order_user((int)$order->id);
              $registry->notify->email_order_admin((int)$order->id);
              
              // Спишем товары  
              $registry->orders->close((int)$order->id);
            }
          }
          else
            $err = 'Currency check failed';
        }
        else
          $err = 'Amount check failed';
      }
      //else
      //  $err = 'Order is paid';
    }
    else
      $err = 'Security check failed';
  }
  else
    $err = 'Unknown payment method';
}
else
  $err = 'Unknown OrderId';

if ($err != '')
  die("<?xml version=\"1.0\" encoding=\"UTF-8\"?><response><status>no</status><err_msg>$err</err_msg></response>");
else
  die("<?xml version=\"1.0\" encoding=\"UTF-8\"?><response><status>yes</status><err_msg></err_msg></response>");