{if $category->brands || $features}
	<h3 class="mb20">Фильтр</h3>
{* Фильтр по брендам *}
{if $category->brands}
<div class="sidebar-box">
    <h4>Бренды</h4>
    <ul class="icon-list blog-category-list">
	<li{if !$brand->id} class="selected"{/if}><a href="catalog/{$category->url}"><i class="fa fa-angle-right"></i>Все бренды</a></li>
	{foreach name=brands item=b from=$category->brands}
		<li{if $b->id == $brand->id} class="selected"{/if}><a data-brand="{$b->id}" href="catalog/{$category->url}/{$b->url}"><i class="fa fa-angle-right"></i>{$b->name|escape}</a></li>
	{/foreach}
    </ul>
</div>
{/if}
	<div class="sidebar-box">
	<h4>
		{* Фильтр, список категорий и брендов *}
	</h4>
	<ul class="icon-list blog-category-list">
		{include "features.tpl"}
	</ul>
	</div>
{/if} 
<div class="sidebar-box">
                            <h3>Информация</h3>
                            <ul class="icon-list blog-category-list">
 			{foreach $pages as $p}
				{* Выводим только страницы из первого меню *}
				{if $p->menu_id == 1}
				<li {if $page && $page->id == $p->id}class="selected"{/if}>
					<a data-page="{$p->id}" href="{$p->url}"><i class="fa fa-angle-right"></i>{$p->name|escape}</a>
				</li>
				{/if}
			{/foreach}                           
                            </ul>
                        </div>
                       
                      
  			<!-- Просмотренные товары -->
			{get_browsed_products var=browsed_products limit=5}
			{if $browsed_products}                      
                        <div class="sidebar-box">
                            <h3>Вы смотрели</h3>
                            <ul class="thumb-list">
                            {foreach $browsed_products as $browsed_product}
                                <li>
                                  <a href="products/{$browsed_product->url}"><img src="{$browsed_product->image->filename|resize:70:70}" alt="{$browsed_product->name}" title="{$browsed_product->name}"/></a>
                                    <div class="thumb-list-item-caption">
                                        <h5 class="thumb-list-item-title"><a href="products/{$browsed_product->url}">{$browsed_product->name}</a></h5>
                                    </div>
                                </li>
                                {/foreach}
                            </ul>
                        </div>
 			{/if}
			<!-- Просмотренные товары (The End)-->
{* Рекомендуемые товары *}
{get_featured_products var=featured_products  limit=3}
{if $featured_products} 			                       
                        <div class="sidebar-box">
                            <h3>Хиты продаж</h3>
                            <ul class="thumb-list">
                            {foreach $featured_products as $product}
                                <li>
                                <a href="products/{$product->url}">
                                    <img  src="{$product->image->filename|resize:70:70}" alt="{$product->name|escape}" title="{$product->name|escape}" />
                                    </a>
                                    <div class="thumb-list-item-caption">
                                        <h5 class="thumb-list-item-title"><a href="products/{$product->url}">{$product->name|escape}</a></h5>
                                        <p class="thumb-list-item-price">{$product->variant->price|convert} {$currency->sign|escape}</p>
                                    </div>
                                </li>
                                {/foreach}
                            </ul>
                        </div>
                        {/if}
{* Новинки *}
{get_new_products var=new_products limit=3}
{if $new_products}  		                       
                        <div class="sidebar-box">
                            <h3>Новинки</h3>
                            <ul class="thumb-list">
                            {foreach $new_products as $product}
                                <li>
                                <a href="products/{$product->url}">
                                    <img  src="{$product->image->filename|resize:70:70}" alt="{$product->name|escape}" title="{$product->name|escape}" />
                                    </a>
                                    <div class="thumb-list-item-caption">
                                        <h5 class="thumb-list-item-title"><a href="products/{$product->url}">{$product->name|escape}</a></h5>
                                        <p class="thumb-list-item-price">{$product->variant->price|convert} {$currency->sign|escape}</p>
                                    </div>
                                </li>
                                {/foreach}
                            </ul>
                        </div>
                        {/if}