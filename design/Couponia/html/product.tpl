{* Страница товара *}

{* Канонический адрес страницы *}
{$canonical="/products/{$product->url}" scope=parent}
{capture name=tabs}
<div class="bg-white">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="/">Главная</a>
                    </li>
	{foreach from=$category->path item=cat}
	<li><a href="catalog/{$cat->url}">{$cat->name|escape}</a></li>
	{/foreach}  
	{if $brand}
	<li><a href="catalog/{$cat->url}/{$brand->url}">{$brand->name|escape}</a></li>
	{/if}
	<li>{$product->name|escape}  </li>
                </ul>
            </div>
        </div>
{/capture}  
<div id="review-dialog" class="mfp-with-anim mfp-hide mfp-dialog clearfix">
                        <h3>Добавить комментарий</h3>
                        <form method="post">
                            <div class="form-group">
                                <label>Имя</label>
                                 <input  type="text" id="comment_name"  placeholder="Введите ваше имя" name="name" value="{$comment_name|escape}" data-format=".+" data-notice="Введите имя" class="form-control">
                            </div>
                            <div class="form-group">
                                    <label>Комментарий</label>
                                    <textarea class="form-control" id="comment_text"  placeholder="Ваш комментарий" name="text" data-format=".+" data-notice="Введите комментарий">{$comment_text}</textarea>
                            </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label> </label>
                                   <div class="captcha"><img src="captcha/image.php?{math equation='rand(10,10000)'}"/></div>
                                </div>
                            </div>
                             <div class="col-md-4">
                                <div class="form-group">
                                    <label> </label>
                                    <input class="form-control" id="comment_captcha" type="text" name="captcha_code" placeholder="Число" value="" data-format="\d\d\d\d" data-notice="Введите капчу"/>
                                </div>
                            </div>                           
                        </div>
                             <input type="submit" name="comment" value="Отправить" class="btn btn-primary">
                        </form>
                    </div>


                    <div class="row product">
                        <div class="col-md-6">
                                 {if $product->variant->compare_price>0}
                                <span class="product-label label label-danger">-{round(abs(100-{$product->variant->price}/($product->variant->compare_price)*100))}%</span>                               
                                {elseif $product->featured}
                                <span class="product-label label label-info">Хит</span>
                                {/if}                        
                            <div class="fotorama product-thumb image" data-nav="thumbs" data-allowfullscreen="1" data-thumbheight="150" data-thumbwidth="150">
 		{foreach $product->images as $i=>$image}
			<img src="{$image->filename|resize:800:800:w}" alt="{$product->name|escape}" title="{$product->name|escape}" /></a>
		{/foreach}                           
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="product-info box">
                                <h3 data-product="{$product->id}">{$product->name|escape}</h3>
                                   <form class="variants" action="/cart">
                                 {if $product->variants|count > 0}
 <button class="btn btn-primary fright"  type="submit"><i class="fa fa-shopping-cart"></i> В корзину</button>                                
                                <p class="product-info-price"><span class="pr">{$product->variant->price|convert}</span> {$currency->sign|escape}</p>
                                            {if $product->variant->compare_price>0}
                                            <b class="product-old-price" style="font-size:16px;text-decoration: line-through;"><span class="old">{$product->variant->compare_price|convert}</span> {$currency->sign|escape}</b>
                                            {/if} 
                                            
    			{* Не показывать выбор варианта, если он один и без названия *}
			<select name="variant" class="fright" {if $product->variants|count==1  && !$product->variant->name}style='display:none;'{/if}>
				{foreach $product->variants as $v}
				<option value="{$v->id}" {if $v->compare_price > 0}compare_price="{$v->compare_price|convert}"{/if} price="{$v->price|convert}">
				{$v->name}
				</option>
				{/foreach}
			</select>
			<!-- Выбор варианта товара (The End) -->                                             
                                                                           
                                            {else}
                                            <b class="product-price">Нет в наличии</b>                                                                                    
                                            {/if}
                                </form>
                                <p class="text-smaller text-muted">{$product->annotation}</p>                                
                                
                            </div>
                        </div>
                    </div>
                    <div class="gap"></div>
<div class="tabbable">
                        <ul class="nav nav-tabs" id="myTab">
                            <li class="active"><a href="#tab-1" data-toggle="tab"><i class="fa fa-pencil"></i>Описание</a>
                            </li>
                            	{if $product->features}
                            <li><a href="#tab-2" data-toggle="tab"><i class="fa fa-info"></i>Характеристики</a>
                            </li>
                            {/if}
                            <li><a href="#tab-3" data-toggle="tab"><i class="fa fa-truck"></i>Доставка &amp; Оплата</a>
                            </li>
                            <li><a href="#tab-4" data-toggle="tab"><i class="fa fa-comments"></i>Комментарии ({$comments|count})</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab-1">
                                {$product->body}
                            </div>
                            	{if $product->features}
                            <div class="tab-pane fade" id="tab-2">
                                <table class="table table-striped mb0">
                                    <tbody>
 	{foreach $product->features as $f}
                                        <tr>
		<td><b>{$f->name}</b></td>
		<td>{$f->value}</td>
                                        </tr>
	{/foreach}                                   
                                    </tbody>
                                </table>
                            </div>
                            {/if}
                            <div class="tab-pane fade" id="tab-3">
                                <p>Курьерская доставка по Москве.</p>
                                <p>Курьерская доставка осуществляется на следующий день после оформления заказа, если товар есть в наличии. Курьерская доставка осуществляется в пределах Томска и Северска ежедневно с 10.00 до 21.00. Заказ на сумму свыше 10000 рублей доставляется бесплатно.</p>
                                <p>Самовывоз.</p>
                                <p>Удобный, бесплатный и быстрый способ получения заказа. Адрес офиса: Москва, ул. Арбат, 1/3, офис 419.</p>
                             	<p>Доставка с помощью предприятия «Автотрейдинг».</p>
                                <p>Удобный и быстрый способ доставки в крупные города России. Посылка доставляется в офис «Автотрейдинг» в Вашем городе. Для получения необходимо предъявить паспорт и номер грузовой декларации (сообщит наш менеджер после отправки).</p>
                            </div>
                            <div class="tab-pane fade" id="tab-4">
 		{if $error}
		<div class="message_error">
			{if $error=='captcha'}
			Неверно введена капча
			{elseif $error=='empty_name'}
			Введите имя
			{elseif $error=='empty_comment'}
			Введите комментарий
			{/if}
		</div>
		{/if}                           
                            	{if $comments}
                                <ul class="comments-list">
		{foreach $comments as $comment}
		<a name="comment_{$comment->id}"></a>                                
                                    <li>
                                        <!-- REVIEW -->
                                        <article class="comment">
                                            <div class="comment-inner">
                                               <b>{$comment->name|escape} </b> <span class="comment-author-name"> {$comment->date|date}, {$comment->date|time}
				{if !$comment->approved}<b>ожидает модерации</b>{/if}</span>
                                                <p class="comment-content">
                                               {$comment->text|escape|nl2br}
                                                </p>
                                            </div>
                                        </article>
                                    </li>
		{/foreach}                                

                                </ul>
	{else}
	<p>
		Пока нет комментариев
	</p>
	{/if}
                                
                                <a class="popup-text btn btn-primary" href="#review-dialog" data-effect="mfp-zoom-out"><i class="fa fa-pencil"></i> Оставить комментарий</a>
                            </div>
                        </div>
                    </div>
<div class="gap"></div>                    
{* Связанные товары *}
{if $related_products}
<h3>Так же советуем посмотреть</h3>
<div class="gap gap-mini"></div>
                    <div class="row row-wrap">
                    	{foreach $related_products  as $product}
							{include file='product_block.tpl'}
							{if $product@iteration%3 == 0}
							<div class="clear"></div>
							{/if}
								{/foreach}
                    </div>
{/if}
<div class="gap gap-small"></div>


