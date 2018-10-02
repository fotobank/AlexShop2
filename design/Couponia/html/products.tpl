{* Список товаров *}

{* Канонический адрес страницы *}
{if $category && $brand}
{$canonical="/catalog/{$category->url}/{$brand->url}" scope=parent}
{elseif $category}
{$canonical="/catalog/{$category->url}" scope=parent}
{elseif $brand}
{$canonical="/brands/{$brand->url}" scope=parent}
{elseif $keyword}
{$canonical="/products?keyword={$keyword|escape}" scope=parent}
{else}
{$canonical="/products" scope=parent}
{/if}
{capture name=tabs}
<div class="bg-white">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="/">Главная</a>
                    </li>
					{if $category}
					{foreach from=$category->path item=cat}
					<li><a href="catalog/{$cat->url}">{$cat->name|escape}</a></li>
					{/foreach}  
					{if $brand}
					<li><a href="catalog/{$cat->url}/{$brand->url}">{$brand->name|escape}</a></li>
					{/if}
					{elseif $brand}
					<li><a href="brands/{$brand->url}">{$brand->name|escape}</a></li>
					{elseif $keyword}
					<li>Поиск</li>
					{/if}
                </ul>
            </div>
        </div>
{/capture}  
{* Заголовок страницы *}
{if $keyword}
<h1>Поиск {$keyword|escape}</h1>
{elseif $page}
<h1>{$page->name|escape}</h1>
{else}
<h1>{$category->name|escape} {$brand->name|escape} {$keyword|escape}</h1>
{/if}
<!--Каталог товаров-->
{if $products}

{* Сортировка *}
{if $products|count>0}
                    <div class="row">                                                         
                        <div class="col-md-5">
                            <div class="product-sort">
                                <span class="product-sort-selected">{if $sort=='position'}Сортировать по <b>умолчанию</b>{elseif $sort=='price'}Сортировать по <b>цене</b>{elseif $sort=='name'}Сортировать по <b>названию</b>{/if}</span>
                                <ul>
									<li><a {if $sort=='position'} class="selected"{/if} href="{url sort=position page=null}">Сортировать по умолчанию</a></li>
									<li><a {if $sort=='price'}    class="selected"{/if} href="{url sort=price page=null}">Сортировать по цене</a></li>
									<li><a {if $sort=='name'}     class="selected"{/if} href="{url sort=name page=null}">Сортировать по названию</a></li>                               
                                </ul>
                            </div>
                        </div>
						<div class="col-md-2 col-md-offset-5">
                            <div class="product-view pull-right">
                                <a class="fa fa-th-large{if $smarty.cookies.view == 'table' || !$smarty.cookies.view} active{/if}" onclick="document.cookie='view=table;path=/';document.location.reload();" href="javascript:;"></a>
                                <a class="fa fa-list{if $smarty.cookies.view == 'list'} active{/if}" onclick="document.cookie='view=list;path=/';document.location.reload();" href="javascript:;"></a>
                            </div>
                        </div>
                    </div>
{/if}
                    <div class="row row-wrap">
                    	{foreach $products as $product}
                    	{if $smarty.cookies.view == 'list'}
							{include file='product_list.tpl'}                    	
                    	{else}
							{include file='product_block.tpl'}
							{if $product@iteration%3 == 0}
							<div class="clear"></div>
							{/if}
							{/if}
								{/foreach}
                    </div>
{include file='pagination.tpl'}

{else}
Товары не найдены
{/if}
<!--Каталог товаров (The End)-->
         <div class="gap gap-small"></div>
{* Описание страницы (если задана) *}
{$page->body}

{if $current_page_num==1}
{* Описание категории *}
{$category->description}
{/if}

{if $current_page_num==1}
{* Описание бренда *}
{$brand->description}
{/if}

<div class="gap gap-small"></div>




