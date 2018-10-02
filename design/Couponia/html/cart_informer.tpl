{* Информера корзины (отдаётся аяксом) *}
                           <a href="./cart/"><i class="fa fa-shopping-cart"></i>Корзина ({$cart->total_products})</a>

                                <div class="shopping-cart-box">
{if $cart->total_products>0}
                                    <ul class="shopping-cart-items">
                        {foreach from=$cart->purchases item=purchase}                                    
                                        <li>
                                            <a href="products/{$purchase->product->url}l">
 		{$image = $purchase->product->images|first}
		{if $image}
		<img src="{$image->filename|resize:70:70}" alt="{$purchase->product->name|escape}">
		{/if}                                           
                                                <h5>{$purchase->product->name|escape} {$purchase->variant->name|escape}</h5>
                                                <span class="shopping-cart-item-price">{$purchase->amount} &times; {$purchase->variant->price|convert}&nbsp;{$currency->sign}</span>
                                            </a>
                                        </li>
                        {/foreach}                                        

                                    </ul>
                                     <ul class="list-inline text-right">
                                        <li><h4>		Итого :		{$cart->total_price|convert}&nbsp;{$currency->sign}</h4>
                                        </li>
                                    </ul>                                     
                                    
                                    <ul class="list-inline text-center">
                                        <li><a href="cart"><i class="fa fa-check-square"></i> Оформить заказ</a>
                                        </li>
                                    </ul>                           
                               
{else}
Корзина пуста
{/if}
 </div>