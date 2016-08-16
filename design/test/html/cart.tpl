{* Шаблон корзины *}
{* Тайтл страницы *}
{$meta_title = $lang->cart_title scope=parent}

<div class="container">
	{* Хлебные крошки *}
	{include file='breadcrumb.tpl'}

	{* Заголовок страницы *}
	<h1 class="m-b-1"><span data-language="{$translate_id['cart_header']}">{$lang->cart_header}</span></h1>

	{if $cart->purchases}
		<form method="post" name="cart">
            <input name="checkout" value="1" type="hidden">
			{* Список покупок *}
			<div id="fn-purchases" class="h6 m-b-2">
				{include file='cart_purchases.tpl'}
			</div>

			<div class="row">
				{* Доставка *}
				<div id="fn-ajax_deliveries" class="col-lg-7 m-b-2">
					{include file='cart_deliveries.tpl'}
				</div>

				{* Форма *}
				<div class="col-lg-5 m-b-2">
					<div class="bg-info p-a-1">
						{* Заголовок формы *}
						<div class="h1 m-b-1 text-xs-center" data-language="{$translate_id['cart_form_header']}">{$lang->cart_form_header}</div>

						{* Вывод ошибок формы *}
						{if $error}
							<div class="p-x-1 p-y-05 text-red m-b-1">
								{if $error == 'empty_name'}
									<span data-language="{$translate_id['form_enter_name']}">{$lang->form_enter_name}</span>
								{/if}
								{if $error == 'empty_email'}
									<span data-language="{$translate_id['form_enter_email']}">{$lang->form_enter_email}</span>
								{/if}
								{if $error == 'captcha'}
									<span data-language="{$translate_id['form_error_captcha']}">{$lang->form_error_captcha}</span>
								{/if}
							</div>
						{/if}

						{* Имя клиента *}
						<div class="form-group">
							<input class="form-control" name="name" type="text" value="{$name|escape}" required
                                   data-format=".+" data-notice="{$lang->form_enter_name}" maxlength="50"
                                   data-language="{$translate_id['form_name']}" placeholder="{$lang->form_name}*"/>
						</div>

						{* Телефон клиента *}
						<div class="form-group user_phone">

							<input class="form-control" name="phone" type="tel" value="{$phone|escape}" required
                                   data-language="{$translate_id['form_phone']}" pattern="[0-9_-]{10}"
                                   placeholder="{$lang->form_phone}"
                                   id="user_phone" title="Формат: (067) 999 99 99"/>


						</div>
						{* Почта клиента *}
						<div class="form-group">
							<input class="form-control" name="email" type="email"
                                   value="{$email|escape}" data-format="email"
                                   data-notice="{$lang->form_enter_email}"
                                   data-language="{$translate_id['form_email']}"
                                   placeholder="{$lang->form_email}*"
                                   pattern="^\S+@\S+\.\S+$"
                                   title="Допустимы любые латинские буквы, цифры и подчеркивание."/>
						</div>

						{* Адрес доставки *}
						<div class="form-group">
							<input id="address" class="form-control" name="address" type="text" required
                                   value="{$address|escape}" data-language="{$translate_id['form_address']}" placeholder="{$lang->form_address}"/>
						</div>

						<div class="form-group">
							<textarea class="form-control" name="comment" data-language="{$translate_id['cart_order_comment']}" placeholder="{$lang->cart_order_comment}">{$comment|escape}</textarea>
						</div>
						<div class="row">
							<div class="col-xs-12 form-inline m-b-1-md_down text-xs-center">
								{if $settings->captcha_cart}
									<div class="col-md-6 col-xs-12 m-b-1-md_down">
										{* Изображение капчи *}
										<div class="form-group">
											<img class="brad-3" src="captcha/image.php?{math equation='rand(10,10000)'}" alt="captcha"/>
										</div>

										{* Поле ввода капчи *}
										<div class="form-group">
											<input class="form-control" type="text" name="captcha_code" value="" data-format="\d\d\d\d\d" data-notice="{$lang->form_enter_captcha}" data-language="{$translate_id['form_enter_captcha']}" placeholder="{$lang->form_enter_captcha}*"/>
										</div>
									</div>
								{/if}
								{* Кнопка отправки формы *}
                                <input class="btn btn-warning btn_submit disabled" type="submit" name="checkout_fake" data-language="{$translate_id['cart_checkout']}" value="{$lang->cart_checkout}"/>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	{else}
		<div class="m-b-2"><span data-language="{$translate_id['cart_empty']}">{$lang->cart_empty}</span></div>
	{/if}
</div>