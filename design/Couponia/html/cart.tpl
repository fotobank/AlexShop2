{* Шаблон корзины *}

{$meta_title = "Корзина" scope=parent}

<h1>
{if $cart->purchases}В корзине {$cart->total_products} {$cart->total_products|plural:'товар':'товаров':'товара'}
{else}Корзина пуста{/if}
</h1>

{if $cart->purchases}
<form method="post" name="cart">
<div class="row">
                <div class="col-md-12">
                    <table class="table cart-table">
                        <thead>
                            <tr>
                                <th>Фото</th>
                                <th>Название</th>
                                <th>К-во</th>
                                <th>Цена</th>
                                <th>Удалить</th>
                            </tr>
                        </thead>
                        <tbody>
                        {foreach from=$cart->purchases item=purchase}
                            <tr>
                                <td class="cart-item-image">
		{$image = $purchase->product->images|first}
		{if $image}
		<a href="products/{$purchase->product->url}"><img src="{$image->filename|resize:70:70}" alt="{$product->name|escape}"></a>
		{/if}
                                </td>
                                <td>		<a href="products/{$purchase->product->url}">{$purchase->product->name|escape}</a>
											{$purchase->variant->name|escape}
                                </td>
                                <td class="cart-item-quantity"><i class="fa fa-minus cart-item-minus"></i>
                                    <input type="text"  name="amounts[{$purchase->variant->id}]" onchange="document.cart.submit();" class="cart-quantity" value="{$purchase->amount}"><i class="fa fa-plus cart-item-plus"></i>
                                </td>
                                <td>{($purchase->variant->price*$purchase->amount)|convert}&nbsp;{$currency->sign}</td>
                                <td class="cart-item-remove">
                                    <a class="fa fa-times" href="cart/remove/{$purchase->variant->id}"></a>
                                </td>
                            </tr>
                            {/foreach}
                        </tbody>
                    </table>

                </div>
                                    	                <div class="col-md-8">
                    	<a  onclick="document.cart.submit();" class="btn btn-primary">Обновить корзину</a>
                    	</div>
                    	                <div class="col-md-4">
                    <ul class="cart-total-list">
                    {if $user->discount}
                        <li><span>Cкидкаl</span><span>{$user->discount}&nbsp;%</span>
                        </li>
                        {/if}
                        <li><span>Итого</span><span>{$cart->total_price|convert}&nbsp;{$currency->sign}</span>
                        </li>
                    </ul>

                </div>
            </div>
            <div class="gap gap-small"></div>
<div class="row row-wrap">
{* Доставка *}
{if $deliveries}
                <div class="col-md-6">
                <h3>Выберите способ доставки:</h3>
<ul id="deliveries" class=" cart-table">
	{foreach $deliveries as $delivery}
	<li>
		<div class="checkbox">
			<input type="radio" name="delivery_id" value="{$delivery->id}" {if $delivery_id==$delivery->id}checked{elseif $delivery@first}checked{/if} id="deliveries_{$delivery->id}">
		</div>
		
			<h4>
			<label for="deliveries_{$delivery->id}">
			{$delivery->name}
			{if $cart->total_price < $delivery->free_from && $delivery->price>0}
				({$delivery->price|convert}&nbsp;{$currency->sign})
			{elseif $cart->total_price >= $delivery->free_from}
				(бесплатно)
			{/if}
			</label>
			</h4>
			<div class="description">
			{$delivery->description}
			</div>
	</li>
	{/foreach}
</ul>
                </div>
                {/if}
                <div class="col-md-6">
                    <h3>Адрес получателя</h3>
<div class="form cart_form cart-table">         
	{if $error}
	<div class="message_error">
		{if $error == 'empty_name'}Введите имя{/if}
		{if $error == 'empty_email'}Введите email{/if}
		{if $error == 'captcha'}Капча введена неверно{/if}
	</div>
	{/if}
	<label>Имя, фамилия</label>
	<input class="form-control" name="name" type="text" value="{$name|escape}" data-format=".+" data-notice="Введите имя"/>
	
	<label>Email</label>
	<input class="form-control" name="email" type="text" value="{$email|escape}" data-format="email" data-notice="Введите email" />

	<label>Телефон</label>
	<input class="form-control" name="phone" type="text" value="{$phone|escape}" />
	
	<label>Адрес доставки</label>
	<input class="form-control" name="address" type="text" value="{$address|escape}"/>

	<label>Комментарий к&nbsp;заказу</label>
	<textarea class="form-control" name="comment" id="order_comment">{$comment|escape}</textarea>
	
	<div class="captcha"><img src="captcha/image.php?{math equation='rand(10,10000)'}" alt='captcha'/></div> 
	<input class="input_captcha form-control" id="comment_captcha" type="text" name="captcha_code" value="" data-format="\d\d\d\d" data-notice="Введите капчу"/>
	
	<input type="submit" name="checkout" class="btn btn-primary" value="Оформить заказ">
	</div>
                </div>
            </div>
<div class="gap gap-small"></div>

   
</form>
{else}
<div class="gap gap-small"></div>
  В корзине нет товаров
  <div class="gap gap-small"></div>
{/if}