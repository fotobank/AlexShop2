<!DOCTYPE html>
{*
	Общий вид страницы
	Этот шаблон отвечает за общий вид страниц без центрального блока.
*}
<html>
<head>
	<base href="{$config->root_url}/"/>
	<title>{$meta_title|escape}</title>
	
	{* Метатеги *}
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="description" content="{$meta_description|escape}" />
	<meta name="keywords"    content="{$meta_keywords|escape}" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	{* Канонический адрес страницы *}
	{if isset($canonical)}<link rel="canonical" href="{$config->root_url}{$canonical}"/>{/if}
	
	{* Стили *}
	<link href="design/{$settings->theme|escape}/images/favicon.ico" rel="icon"          type="image/x-icon"/>
	<link href="design/{$settings->theme|escape}/images/favicon.ico" rel="shortcut icon" type="image/x-icon"/>
    <!-- Google fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,300&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <!-- Bootstrap styles -->
    <link rel="stylesheet" href="design/{$settings->theme|escape}/css/boostrap.css">
    <!-- Font Awesome styles (icons) -->
    <link rel="stylesheet" href="design/{$settings->theme|escape}/css/font_awesome.css">
    <!-- Main Template styles -->
    <link rel="stylesheet" href="design/{$settings->theme|escape}/css/styles.css">
    <!-- IE 8 Fallback -->
    <!--[if lt IE 9]>
	<link rel="stylesheet" type="text/css" href="design/{$settings->theme|escape}/css/ie.css" />
<![endif]-->

    <!-- Your custom styles (blank file) -->
    <link rel="stylesheet" href="design/{$settings->theme|escape}/css/mystyles.css">
	 <link rel="stylesheet" href="design/{$settings->theme|escape}/css/style.css">
</head>
<body class="sticky-header">
      <div class="global-wrap">     
      
        <!-- //////////////////////////////////
	//////////////MAIN HEADER///////////// 
	////////////////////////////////////-->
        <div class="top-main-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-2">
                        <a href="./" class="logo mt5">
                            <img src="design/{$settings->theme|escape}/img/logo-small-dark.png" alt="Image Alternative text" title="Image Title" />
                        </a>
                    </div>
                    <div class="col-md-6 col-md-offset-4">
                        <div class="pull-right">
                            <ul class="header-features">
                                <li><i class="fa fa-phone"></i>
                                    <div class="header-feature-caption">
                                        <h5 class="header-feature-title">+7 (495) 233-88-81</h5>
                                        <p class="header-feature-sub-title">с 9:00 до 21:00 </p>
                                    </div>
                                </li>
                                <li><i class="fa fa-truck"></i>
                                    <div class="header-feature-caption">
                                        <h5 class="header-feature-title">Доставка по всей России</h5>
                                        <p class="header-feature-sub-title">Наш менеджер рассчитает доставку</p>
                                    </div>
                                </li>
                              
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <header class="main">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="flexnav-menu-button" id="flexnav-menu-button">Меню</div>
                        <nav>
			{* Рекурсивная функция вывода дерева категорий *}
			{function name=categories_tree}
			{if $categories}
			
			{foreach $categories as $c}
				{* Показываем только видимые категории *}
				{if $c->visible}
					<li {if in_array($category->id,$c->children)}class="active"{/if}>
						<a href="catalog/{$c->url}" data-category="{$c->id}">{$c->name|escape}</a>
						{if $c->subcategories}
						<ul>{categories_tree categories=$c->subcategories}</ul>
						{/if}
					</li>
				{/if}
			{/foreach}
			
			{/if}
			{/function}
			<ul class="nav nav-pills flexnav" id="flexnav" data-breakpoint="800">
			{categories_tree categories=$categories} 
			</ul>                       
           {* <ul class="nav nav-pills flexnav" id="flexnav" data-breakpoint="800">
 			{foreach $pages as $p}
				{if $p->menu_id == 1}
				<li {if $page && $page->id == $p->id}class="active"{/if}>
					<a data-page="{$p->id}" href="{$p->url}">{$p->name|escape}</a>
				</li>
				{/if}
			{/foreach}                           
                            </ul>*}
                        </nav>
                    </div>
                    <div class="col-md-6">
                        <ul class="login-register">
                            <li class="shopping-cart" id="cart_informer">
                            			{* Обновляемая аяксом корзина должна быть в отдельном файле *}
												{include file='cart_informer.tpl'}
                            </li>
			{if $user}
<li><a href="user"><i class="fa fa-user"></i>{$user->name}{if $group->discount>0} &mdash; {$group->discount}%{/if}</a>
                                </li>
 <li><a href="user/logout"><i class="fa fa-sign-out"></i>Выход</a>
                                </li>                               			
			{else}
                            <li><a class="popup-text" href="#login-dialog" data-effect="mfp-move-from-top"><i class="fa fa-sign-in"></i>Вход</a>
                            </li>
                            <li><a class="popup-text" href="#register-dialog" data-effect="mfp-move-from-top"><i class="fa fa-edit"></i>Регистрация</a>
                            </li>			
			{/if}                            
                        </ul>
                    </div>
                </div>
            </div>
        </header>
  
         {include file='popups.tpl'}
  {if $module == 'MainView'}    
  <div class="top-area">   
							{include file='slider.tpl'}
</div> 
{/if}
        <!-- SEARCH AREA -->
        <form class="search-area form-group"  action="products">
            <div class="container">
                <div class="row">
                    <div class="col-md-9 clearfix">
                        <label><i class="fa fa-search"></i><span>Поиск по товарам</span>
                        </label>
                        <div class="search-area-division search-area-division-input">
                            <input class="form-control input_search" type="text" name="keyword" value="{$keyword|escape}" placeholder="..." />
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-block btn-white search-btn" type="submit">Найти</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- END SEARCH AREA -->   
        
{$smarty.capture.tabs}
       <div class="gap gap-small"></div>



        <!-- //////////////////////////////////
	//////////////END MAIN HEADER////////// 
	////////////////////////////////////-->


        <!-- //////////////////////////////////
	//////////////PAGE CONTENT///////////// 
	////////////////////////////////////-->


{if $module == 'ProductView'}
        <div class="container">
            <div class="row">
                <div class="col-md-9">

						{$content}
                    
                    
                </div>            
                <div class="col-md-3">
                
                    <aside class="sidebar-right">
                    
                    {include file='sidebar.tpl'}
                        
                    </aside>
                </div>

            </div>

        </div>
 {elseif $module == 'CartView' ||  $module == 'MainView'}
        <div class="container">
            <div class="row">
  {if $module == 'MainView'}           
 {include file='banners.tpl'}
{/if}
						{$content}


            </div>

        </div>       
{else}
        <div class="container">
            <div class="row">
          
            
                <div class="col-md-3">
                
                    <aside class="sidebar-left">
                    
                    {include file='sidebar.tpl'}
                        
                    </aside>
                </div>
                <div class="col-md-9">

						{$content}
                    
                    
                </div>
            </div>

        </div>
{/if}

        <!-- //////////////////////////////////
	//////////////END PAGE CONTENT///////// 
	////////////////////////////////////-->



        <!-- //////////////////////////////////
	//////////////MAIN FOOTER////////////// 
	////////////////////////////////////-->

        <footer class="main" id="main-footer">
            <div class="footer-top-area">
                <div class="container">
                    <div class="row row-wrap">
                        <div class="col-md-3">
                            <a href="index.html">
                                <img src="design/{$settings->theme|escape}/img/logo.png" alt="logo" title="logo" class="logo">
                            </a>
                            <ul class="list list-social">
                                <li>
                                    <a class="fa fa-vk box-icon" href="#" data-toggle="tooltip" title="VK"></a>
                                </li>                               
                                <li>
                                    <a class="fa fa-facebook box-icon" href="#" data-toggle="tooltip" title="Facebook"></a>
                                </li>
                                <li>
                                    <a class="fa fa-twitter box-icon" href="#" data-toggle="tooltip" title="Twitter"></a>
                                </li>
                                <li>
                                    <a class="fa fa-linkedin box-icon" href="#" data-toggle="tooltip" title="LinkedIn"></a>
                                </li>
                                <li>
                                    <a class="fa fa-tumblr box-icon" href="#" data-toggle="tooltip" title="Tumblr"></a>
                                </li>                            
                            </ul>
                            <p>Московская область, Ступинский район, с. Большое Алексеевское, ул. Кооперативная, дом 32</p>
                        </div>
                        <div class="col-md-3">
                            <h4>О нас</h4>
<p>
Сoзданная в 2001 гoду активнo развивающаяcя линия прoдукции кoмпании Мирoвoй cпoрт уcпeла за cравнитeльнo нeдoлгий cрoк занять уcтoйчивoe пoлoжeниe в индуcтрии прoизвoдcтва cпoртивнoгo oбoрудoвания.    Кoмпания прeдлагаeт уcлуги пo кoмплeкcнoму ocнащeнию cпoртивных oбъeктoв, пocтавкe прoфeccиoнальнoгo coрeвнoватeльнoгo oбoрудoвания для унивeрcальныхcпoртивных залoв, cпoртивнoй гимнаcтики, грeкo-римcкoй бoрьбы и вocтoчных eдинoбoрcтв, игрoвых видoв cпoрта, хoккeя, футбoла, баcкeтбoла, тeнниcа, лeгкoй атлeтики.
</p>
                        </div>
                        <div class="col-md-3">
                            <h4>Информация</h4>
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
                        <div class="col-md-3">
                            <h4>Последние новости</h4>
			{get_posts var=last_posts limit=2}
			{if $last_posts}                            
                            <ul class="thumb-list">
                            {foreach $last_posts as $post}
                                <li data-post="{$post->id}">
                                    <div class="thumb-list-item-caption">
                                        <p class="thumb-list-item-meta">{$post->date|date} </p>
                                        <h5 class="thumb-list-item-title"><a href="blog/{$post->url}">{$post->name|escape}</a></h5>
                                        <p class="thumb-list-item-desciption">{$post->annotation|strip_tags|truncate:100}</p>
                                    </div>
                                </li>
                                {/foreach}
                            </ul>
                            {/if}
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-copyright">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <p>©Copyright by «Мировой Спорт», 2007. Все права защищены. (495)233-88-81</p>
                        </div>
                        <div class="col-md-6 col-md-offset-2">
                            <div class="pull-right">
                                <ul class="list-inline list-payment">
                                    <li>
                                        <img src="design/{$settings->theme|escape}/img/payment/american-express-curved-32px.png" alt="Image Alternative text" title="Image Title" />
                                    </li>
                                    <li>
                                        <img src="design/{$settings->theme|escape}/img/payment/cirrus-curved-32px.png" alt="Image Alternative text" title="Image Title" />
                                    </li>
                                    <li>
                                        <img src="design/{$settings->theme|escape}/img/payment/discover-curved-32px.png" alt="Image Alternative text" title="Image Title" />
                                    </li>
                                    <li>
                                        <img src="design/{$settings->theme|escape}/img/payment/ebay-curved-32px.png" alt="Image Alternative text" title="Image Title" />
                                    </li>
                                    <li>
                                        <img src="design/{$settings->theme|escape}/img/payment/maestro-curved-32px.png" alt="Image Alternative text" title="Image Title" />
                                    </li>
                                    <li>
                                        <img src="design/{$settings->theme|escape}/img/payment/mastercard-curved-32px.png" alt="Image Alternative text" title="Image Title" />
                                    </li>
                                    <li>
                                        <img src="design/{$settings->theme|escape}/img/payment/visa-curved-32px.png" alt="Image Alternative text" title="Image Title" />
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- //////////////////////////////////
	//////////////END MAIN  FOOTER///////// 
	////////////////////////////////////-->
	<div id="back_to_top"><a href="#" class="fa fa-arrow-up fa-lg"></a></div>
	{* JQuery *}
	<script src="design/{$settings->theme}/js/jquery.js"  type="text/javascript"></script>
	<script src="design/{$settings->theme}/js/jquery-migrate-1.2.1.min.js"  type="text/javascript"></script>
	
	{* Всплывающие подсказки для администратора *}
	{if $smarty.session.admin == 'admin'}
	<script src ="js/admintooltip/admintooltip.js" type="text/javascript"></script>
	<link   href="js/admintooltip/css/admintooltip.css" rel="stylesheet" type="text/css" /> 
	{/if}
	
	{* Ctrl-навигация на соседние товары *}
	<script type="text/javascript" src="js/ctrlnavigate.js"></script>           
	
	{* Аяксовая корзина *}
	<script src="design/{$settings->theme}/js/jquery-ui.min.js"></script>
	<script src="design/{$settings->theme}/js/ajax_cart.js"></script>
	
	{* js-проверка форм *}
	<script src="js/baloon/js/baloon.js" type="text/javascript"></script>
	<link   href="js/baloon/css/baloon.css" rel="stylesheet" type="text/css" /> 
	
	{* Автозаполнитель поиска *}
	{literal}
	<script src="js/autocomplete/jquery.autocomplete-min.js" type="text/javascript"></script>
	<script>
	$(function() {
		//  Автозаполнитель поиска
		$(".input_search").autocomplete({
			serviceUrl:'ajax/search_products.php',
			minChars:1,
			noCache: false, 
			onSelect:
				function(suggestion){
					 $(".input_search").closest('form').submit();
				},
			formatResult:
				function(suggestion, currentValue){
					var reEscape = new RegExp('(\\' + ['/', '.', '*', '+', '?', '|', '(', ')', '[', ']', '{', '}', '\\'].join('|\\') + ')', 'g');
					var pattern = '(' + currentValue.replace(reEscape, '\\$1') + ')';
	  				return (suggestion.data.image?"<img align=absmiddle src='"+suggestion.data.image+"'> ":'') + suggestion.value.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>');
				}	
		});
	});
	$(document).ready(function(){
	// Капча
	$('.captcha img').prop('src', 'captcha/image.php');
});
	</script>
	{/literal}


        <!-- Scripts queries -->
        <script src="design/{$settings->theme|escape}/js/boostrap.min.js"></script>
        <script src="design/{$settings->theme|escape}/js/flexnav.min.js"></script>
        <script src="design/{$settings->theme|escape}/js/magnific.js"></script>
        <script src="design/{$settings->theme|escape}/js/tweet.min.js"></script>
        <script src="design/{$settings->theme|escape}/js/fitvids.min.js"></script>
        <script src="design/{$settings->theme|escape}/js/mail.min.js"></script>
        <script src="design/{$settings->theme|escape}/js/ionrangeslider.js"></script>
        <script src="design/{$settings->theme|escape}/js/icheck.js"></script>
        <script src="design/{$settings->theme|escape}/js/fotorama.js"></script>
        <script src="design/{$settings->theme|escape}/js/card-payment.js"></script>
        <script src="design/{$settings->theme|escape}/js/owl-carousel.js"></script>
        <script src="design/{$settings->theme|escape}/js/masonry.js"></script>
        <script src="design/{$settings->theme|escape}/js/nicescroll.js"></script>

        <!-- Custom scripts -->
        <script src="design/{$settings->theme|escape}/js/custom.js"></script>
    </div>
</body>
</html>
