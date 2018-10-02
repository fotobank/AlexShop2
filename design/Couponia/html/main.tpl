{* Главная страница магазина *}

{* Для того чтобы обернуть центральный блок в шаблон, отличный от index.tpl *}
{* Укажите нужный шаблон строкой ниже. Это работает и для других модулей *}
{$wrapper = 'index.tpl' scope=parent}

{* Канонический адрес страницы *}
{$canonical="" scope=parent}




{* Рекомендуемые товары *}
{get_featured_products var=featured_products  limit=6}
{if $featured_products}                    
                    <h1 class="mb20"> Рекомендуемые товары  </h1>
                    <div class="row row-wrap">
                    	{foreach $featured_products as $product}
							{include file='product_block.tpl' main=1}
							{if $product@iteration%4 == 0}
							<div class="clear"></div>
							{/if}
								{/foreach}
                    </div>
                    <div class="gap gap-small"></div>
 {/if}                   
{* Новинки *}
{get_new_products var=new_products limit=3}
{if $new_products}               
                    <h1 class="mb20">Новинки  </h1>
                    <div class="row row-wrap">
                    	{foreach $new_products as $product}
							{include file='product_block.tpl' main=1}
							{if $product@iteration%4 == 0}
							<div class="clear"></div>
							{/if}
								{/foreach}
                    </div>
                    <div class="gap gap-small"></div>
 {/if} 
{* Акционные товары *}
{get_discounted_products var=discounted_products limit=6}
{if $discounted_products}                   
                    <h1 class="mb20">Акционные товары  </h1>
                    <div class="row row-wrap">
                    	{foreach $discounted_products as $product}
							{include file='product_block.tpl' main=1}
							{if $product@iteration%4 == 0}
							<div class="clear"></div>
							{/if}
								{/foreach}
                    </div>
                    <div class="gap gap-small"></div>
 {/if} 

{* Заголовок страницы *}
<h1>{$page->header}</h1>

{* Тело страницы *}
{$page->body}

                    <div class="gap gap-small"></div>
            <div class="row row-wrap">
                <div class="col-md-4">
                    <div class="sale-point"><i class="fa fa-truck sale-point-icon"></i>
                        <h5 class="sale-point-title">Быстрая & Бесплатная доставка</h5>
                        <p class="sale-point-description">Заказ на любую доставляется по Москве в пределах МКАД бесплатно.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="sale-point"><i class="fa fa-tags sale-point-icon"></i>
                        <h5 class="sale-point-title">Системы скидок</h5>
                        <p class="sale-point-description">Спецпредложения, Накопительные системы скидок, Скидки выходного дня и многие другие</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="sale-point"><i class="fa fa-money sale-point-icon"></i>
                        <h5 class="sale-point-title">Гарантия от производителя</h5>
                        <p class="sale-point-description">Всё спортивное оборудование сертифицировано. На него предоставляется гарантия производителя.
                   </p>
                    </div>
                </div>
            </div>
            <div class="gap gap-small"></div>