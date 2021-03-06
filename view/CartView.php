<?php

class CartView extends View
{

    public function __construct()
    {
        parent::__construct();

        // Если передан id варианта, добавим его в корзину
        if ($variant_id = $this->request->get('variant', 'integer')){
            $this->cart->add_item($variant_id, $this->request->get('amount', 'integer'));
            header('location: ' . $this->config->root_url . '/' . $this->lang_link . 'cart/');
        }

        // Удаление товара из корзины
        if ($delete_variant_id = (int)$this->request->get('delete_variant')){
            $this->cart->delete_item($delete_variant_id);
            if (!isset($_POST['submit_order']) || $_POST['submit_order'] != 1){
                //header('location: '.$this->config->root_url.'/cart/');
                //header('location: '.$this->config->root_url.'/'.$this->language->label.'/cart/');
                header('location: ' . $this->config->root_url . '/' . $this->lang_link . 'cart/');
            }
        }

        // Если нажали оформить заказ
        if (isset($_POST['checkout'])){
            $order = new \stdClass;
            $order->payment_method_id = $this->request->post('payment_method_id', 'integer');
            $order->delivery_id = $this->request->post('delivery_id', 'integer');
            $order->name = $this->request->post('name');
            $order->surname = $this->request->post('surname');
            $order->phone = $this->request->post('phone');
            $order->email = $this->request->post('email');
            $order->address = $this->request->post('address', 'string');
            $order->comment = $this->request->post('comment', 'string');
            $order->ip = $_SERVER['REMOTE_ADDR'];

            $this->design->assign('delivery_id', $order->delivery_id);
            $this->design->assign('name', $order->name);
            $this->design->assign('surname', $order->surname);
            $this->design->assign('email', $order->email);
            $this->design->assign('phone', $order->phone);
            $this->design->assign('address', $order->address);
            $this->design->assign('comment', $order->comment);

            $captcha_code = $this->request->post('captcha_code', 'string');

            // Скидка
            $cart = $this->cart->get_cart();
            $order->discount = $cart->discount;

            if ($cart->coupon){
                $order->coupon_discount = $cart->coupon_discount;
                $order->coupon_code = $cart->coupon->code;
            }

            //валидатор входящих данных
            if (!empty($this->user->id)){
                $order->user_id = $this->user->id;
            } elseif(!preg_match('/^[а-я\w\s_\-\/\'\"\.\,\(\)]{2,40}$/i', $order->name)){
                $this->design->assign('error', 'empty_name');
            } elseif(!preg_match('/^[а-я\w\s_\-\/\'\"\.\,\(\)]{2,40}$/i', $order->surname)){
                $this->design->assign('error', 'empty_surname');
            } elseif(!preg_match('/^\(?\d{3}\)?-?\s?\d{3}(-\d{2}){2}$/', $order->phone)){
                $this->design->assign('error', 'empty_phone');
            } elseif(!preg_match('/^[-0-9a-z_\.]+@[-0-9a-z_\.]+\.[a-z]{2,6}$/i',$order->email)) {
                $this->design->assign('error', 'empty_email');
            } elseif($this->settings->captcha_cart && (($_SESSION['captcha_code'] != $captcha_code ||
                        empty($captcha_code)) || empty($_SESSION['captcha_code']))) {
                $this->design->assign('error', 'captcha');
            } else {
                // Добавляем заказ в базу
                $order->lang_id = $this->languages->lang_id();
                $order_id = $this->orders->add_order($order);
                $_SESSION['order_id'] = $order_id;

                // Если использовали купон, увеличим количество его использований
                if ($cart->coupon){
                    $this->coupons->update_coupon($cart->coupon->id, ['usages' => $cart->coupon->usages + 1]);
                }

                // Добавляем товары к заказу
                foreach ($this->request->post('amounts') as $variant_id => $amount){
                    $this->orders->add_purchase([
                        'order_id' => $order_id,
                        'variant_id' => (int)$variant_id,
                        'amount' => (int)$amount
                    ]);
                }
                $order = $this->orders->get_order($order_id);

                // Стоимость доставки
                $delivery = $this->delivery->get_delivery($order->delivery_id);
                if (!empty($delivery) && $delivery->free_from > $order->total_price){
                    $this->orders->update_order($order->id, ['delivery_price' => $delivery->price, 'separate_delivery' => $delivery->separate_payment]);
                }

                // Отправляем письмо пользователю
                $this->notify->email_order_user($order->id);

                // Отправляем письмо администратору
                $this->notify->email_order_admin($order->id);

                // Очищаем корзину (сессию)
                $this->cart->empty_cart();
                unset($_SESSION['captcha_code']);

                // Перенаправляем на страницу заказа
                header('location: ' . $this->config->root_url . '/' . $this->lang_link . 'order/' . $order->url);
            }
        } else {
            // Если нам запостили amounts, обновляем их
            if ($amounts = $this->request->post('amounts')){
                foreach ($amounts as $variant_id => $amount){
                    $this->cart->update_item($variant_id, $amount);
                }

                $coupon_code = trim($this->request->post('coupon_code', 'string'));
                if (empty($coupon_code)){
                    $this->cart->apply_coupon('');
                    header('location: ' . $this->config->root_url . '/' . $this->lang_link . 'cart/');
                } else {
                    $coupon = $this->coupons->get_coupon((string)$coupon_code);
                    if (empty($coupon) || !$coupon->valid){
                        $this->cart->apply_coupon($coupon_code);
                        $this->design->assign('coupon_error', 'invalid');
                    } else {
                        $this->cart->apply_coupon($coupon_code);
                        header('location: ' . $this->config->root_url . '/' . $this->lang_link . 'cart/');
                    }
                }
            }
        }
    }

    public function fetch()
    {
        // Способы доставки
        $deliveries = $this->delivery->get_deliveries(['enabled' => 1]);
        foreach ($deliveries as $delivery){
            $delivery->payment_methods = $this->payment->get_payment_methods(['delivery_id' => $delivery->id, 'enabled' => 1]);
        }
        $this->design->assign('all_currencies', $this->money->get_currencies());
        $this->design->assign('deliveries', $deliveries);

        // Данные пользователя
        if ($this->user){
            $last_order = $this->orders->get_orders(['user_id' => $this->user->id, 'limit' => 1]);
            $last_order = reset($last_order);
            if ($last_order){
                $this->design->assign('name', $last_order->name);
                $this->design->assign('email', $last_order->email);
                $this->design->assign('phone', $last_order->phone);
                $this->design->assign('address', $last_order->address);
            } else {
                $this->design->assign('name', $this->user->name);
                $this->design->assign('email', $this->user->email);
                $this->design->assign('phone', $this->user->phone);
                $this->design->assign('address', $this->user->address);
            }
        }

        // Если существуют валидные купоны, нужно вывести инпут для купона
        if ($this->coupons->count_coupons(['valid' => 1]) > 0){
            $this->design->assign('coupon_request', true);
        }

        // Выводим корзину
        return $this->design->fetch('cart.tpl');
    }

}