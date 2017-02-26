{*<!-- BEGIN SIDEBAR -->*}
<div class="page-sidebar-wrapper">
<div class="page-sidebar navbar-collapse collapse">
{*<!-- BEGIN SIDEBAR MENU -->*}
<ul class="page-sidebar-menu page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">

	{if in_array('products', $manager->permissions)}
        <li class = "start {if $menu_selected == 'catalog'}active{/if}">
			<a href = "index.php?module=ProductsAdmin">
				<i class = "icon-catalog"></i>
				<span class="title">Каталог</span>
			</a>
		</li>

                {elseif in_array('categories', $manager->permissions)}

        <li class = "{if $menu_selected == 'catalog'}active{/if}">
			<a href = "index.php?module=CategoriesAdmin">
				<i class = "icon-catalog"></i>
				<span class="title">Каталог</span>
			</a>
		</li>

                {elseif in_array('brands', $manager->permissions)}

        <li class = "{if $menu_selected == 'catalog'}active{/if}">
			<a href = "index.php?module=BrandsAdmin">
				<i class = "icon-catalog"></i>
				<span class="title">Каталог</span>
			</a>
		</li>

                {elseif in_array('features', $manager->permissions)}

        <li class = "{if $menu_selected == 'catalog'}active{/if}">
			<a href = "index.php?module=FeaturesAdmin">
				<i class = "icon-catalog"></i>
				<span class="title">Каталог</span>
			</a>
		</li>

                {elseif in_array('special', $manager->permissions)}

        <li class = "{if $menu_selected == 'catalog'}active{/if}">
			<a href = "index.php?module=SpecialAdmin">
				<i class = "icon-catalog"></i>
				<span class="title">Каталог</span>
			</a>
		</li>
    {/if}

    {if in_array('orders', $manager->permissions)}
        <li class = "{if $menu_selected == 'orders'}active{/if}">
			<a href = "index.php?module=OrdersAdmin">
			   <i class = "icon-orders"></i>
				<span class="title">Заказы</span>
                <span class="arrow "></span>
                {if $new_orders_counter}
                    <span class = "orders_num">{$new_orders_counter}</span>
                {/if}
			</a>
			
		</li>

                {elseif in_array('labels', $manager->permissions)}

        <li class = "{if $menu_selected == 'orders'}active{/if}">
			<a href = "index.php?module=OrdersLabelsAdmin">
				<i class = "icon-orders"></i>
				<span class="title">Заказы</span>
                <span class="arrow "></span>
                {if $new_orders_counter}
                    <span class = "orders_num">{$new_orders_counter}</span>
                {/if}
			</a>
		</li>
    {/if}

    {if in_array('users', $manager->permissions)}
        <li class = "{if $menu_selected == 'users'}active{/if}">
			<a href = "index.php?module=UsersAdmin">
			   <i class = "icon-users"></i>
				<span class="title">Пользователи</span>
			</a>
		</li>

                {elseif in_array('groups', $manager->permissions)}

        <li class = "{if $menu_selected == 'users'}active{/if}">
			<a href = "index.php?module=GroupsAdmin">
				<i class = "icon-users"></i>
				<span class="title">Пользователи</span>
			</a>
		</li>

                {elseif in_array('coupons', $manager->permissions)}

        <li class = "{if $menu_selected == 'users'}active{/if}">
			<a href = "index.php?module=CouponsAdmin">
				<i class = "icon-users"></i>
				<span class="title">Пользователи</span>
			</a>
		</li>
    {/if}

    {if in_array('pages', $manager->permissions)}
        <li class = "{if $menu_selected == 'pages'}active{/if}">
			<a href = "index.php?module=PagesAdmin">
				<i class = "icon-pages"></i>
				<span class="title">Страницы</span>
			</a></li>
    {/if}

    {if in_array('blog', $manager->permissions)}
        <li class = "{if $menu_selected == 'blog'}active{/if}">
			<a href = "index.php?module=BlogAdmin">
				<i class = "icon-blog"></i>
				<span class="title">Блог</span>
			</a></li>
    {/if}

    {if in_array('comments', $manager->permissions)}
        <li class = "{if $menu_selected == 'comments'}active{/if}">
		<a href = "index.php?module=CommentsAdmin">
			<i class = "icon-comments"></i>
			<span class="title">Комментарии</span>
            {if $new_comments_counter || $new_callbacks_counter || $new_feedbacks_counter}
                <span class = "comments_num">{$new_comments_counter + $new_callbacks_counter + $new_feedbacks_counter}</span>
            {/if}
		</a>
		
	</li>

                {elseif in_array('feedbacks', $manager->permissions)}

        <li class = "{if $menu_selected == 'comments'}active{/if}">
		<a href = "index.php?module=FeedbacksAdmin">
			<i class = "icon-comments"></i>
			<span class="title">Комментарии</span>
            {if $new_comments_counter || $new_callbacks_counter || $new_feedbacks_counter}
                <span class = "comments_num">{$new_comments_counter + $new_callbacks_counter + $new_feedbacks_counter}</span>
            {/if}
		</a>
    </li>

                {elseif in_array('callbacks', $manager->permissions)}

        <li class = "{if $menu_selected == 'comments'}active{/if}">
		<a href = "index.php?module=CallbacksAdmin">
			<i class = "icon-comments"></i>
			<span class="title">Комментарии</span>
            {if $new_comments_counter || $new_callbacks_counter || $new_feedbacks_counter}
                <span class = "comments_num">{$new_comments_counter + $new_callbacks_counter + $new_feedbacks_counter}</span>
            {/if}
		</a>
    </li>
    {/if}

    {if in_array('import', $manager->permissions)}
        <li class = "{if $menu_selected == 'auto'}active{/if}">
		<a href = "index.php?module=ImportAdmin">
			<i class = "icon-automatic"></i>
			<span class="title">Импорт/экспорт</span>
		</a>
	</li>

                {elseif in_array('export', $manager->permissions)}

        <li class = "{if $menu_selected == 'auto'}active{/if}">
		<a href = "index.php?module=ExportAdmin">
			<i class = "icon-automatic"></i>
			<span class="title">Импорт/экспорт</span>
		</a>
	</li>
    {/if}

    {if in_array('stats', $manager->permissions)}
        <li class = "{if $menu_selected == 'stats'}active{/if}">
			<a href = "index.php?module=StatsAdmin">
				<i class = "icon-statistic"></i>
				<span class="title">Статистика</span>
			</a>
		</li>
    {/if}

    {if in_array('topvisor', $manager->permissions)}
        <li class = "{if $menu_selected == 'topvisor'}active{/if}">
			<a href = "index.php?module=TopvisorProjectsAdmin">
				<i class = "icon-topvisor"></i>
				<span class="title">Topvisor</span>
			</a>
		</li>
    {/if}

    {if in_array('design', $manager->permissions)}
        <li class = "{if $menu_selected == 'design'}active{/if}">
			<a href = "index.php?module=ThemeAdmin">
				<i class = "icon-design"></i>
				<span class="title">Шаблоны</span>
			</a>
		</li>
    {/if}

    {if in_array('banners', $manager->permissions)}
        <li class = "{if $menu_selected == 'banners'}active{/if}">
			<a href = "index.php?module=BannersImagesAdmin">
				<i class = "icon-banner"></i>
				<span class="title">Баннеры</span>
			</a>
		</li>
    {/if}
	{if in_array('service', $manager->permissions)}
        <li class = "{if $menu_selected == 'service'}active{/if}">
			<a href = "index.php?module=ServiceAdmin">
				<i class = "icon-service"></i>
				<span class="title">Обслуживание</span>
			</a>
		</li>
    {/if}

    {if in_array('settings', $manager->permissions)}
        <li class = "dropdown {if $menu_selected == ('settings')}active
                              {elseif $menu_selected == ('settings2')}active{/if}" rel="1">
			<a href = "index.php?module=SettingsAdmin">
				<i class = "icon-settings"></i>
				<span class="title">Настройки</span>
                <span class="arrow "></span>
            </a>
                 <ul class="sub-menu">
                   <li class = "{if $menu_selected == ('settings')}active{/if}" rel="11">
                       <a href = "index.php?module=SettingsAdmin">
                           <i class="icon-first_settings"></i><span class="title">Основные</span></a></li>
                   <li class = "{if $menu_selected == ('settings2')}active{/if}" rel="12">
                       <a href = "index.php?module=ComingSoon">
                           <i class="icon-second_settings"></i><span class="title">Дополнительные</span></a></li>
                 </ul>

		</li>

         {elseif in_array('currency', $manager->permissions)}

        <li class = "{if $menu_selected == 'settings'}active{/if}">
			<a href = "index.php?module=CurrencyAdmin">
				<i class = "icon-settings"></i>
				<span>Настройки</span>
				<span class="arrow "></span>
			</a>
		</li>

          {elseif in_array('delivery', $manager->permissions)}

        <li class = "{if $menu_selected == 'settings'}active{/if}">
			<a href = "index.php?module=DeliveriesAdmin">
				<i class = "icon-settings"></i>
				<span class="title">Настройки</span>
				<span class="arrow "></span>
			</a>
		</li>

          {elseif in_array('payment', $manager->permissions)}

        <li class = "{if $menu_selected == 'settings'}active{/if}">
			<a href = "index.php?module=PaymentMethodsAdmin">
				<i class = "icon-settings"></i>
				<span class="title">Настройки</span>
				<span class="arrow "></span>
			</a>
		</li>

          {elseif in_array('managers', $manager->permissions)}

        <li class = "{if $menu_selected == 'settings'}active{/if}">
			<a href = "index.php?module=ManagersAdmin">
				<i class = "icon-settings"></i>
				<span class="title">Настройки</span>
				<span class="arrow "></span>
			</a>
		</li>

         {elseif in_array('languages', $manager->permissions)}

        <li class = "{if $menu_selected == 'settings'}active{/if}">
			<a href = "index.php?module=LanguagesAdmin">
				<i class = "icon-settings"></i>
				<span class="title">Настройки</span>
				<span class="arrow "></span>
			</a>
		</li>
    {/if}
    <li>
    <a href = '{$config->root_url}?logout'>
        <i class = "icon-log_out"></i>
        <span class="title">Выход</span>
    </a>
    </li>
</ul>
{*<!-- END SIDEBAR MENU -->*}
			</div>
		</div>
{*<!-- END SIDEBAR -->*}
<div class = "language">
{foreach $languages as $l}
    <a href = "{url lang_id=$l->id}" {if $l->id == $lang_id}class = "selected"{/if}>{$l->label}</a>
{/foreach}
</div>
<div class = "license_info">
{if in_array('license', $manager->permissions)}
    {if $license->valid}
<span>
    <a href = 'index.php?module=LicenseAdmin'>Лицензия</a> действительна {if $license->expiration != '*'}до {$license->expiration}{/if} для домен{$license->domains|count|plural:'а':'ов'}
    {foreach $license->domains as $d}{$d}{if !$d@last}, {/if}{/foreach} .</span>

    {else}
        <span><a href = 'index.php?module=LicenseAdmin'>Лицензия</a> недействительна.</span>
    {/if}
{/if}
</div>
