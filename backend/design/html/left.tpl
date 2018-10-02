<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
<div class="page-sidebar navbar-collapse collapse">
<!-- BEGIN SIDEBAR MENU -->
<ul class="page-sidebar-menu page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">

	{if in_array('products', $manager->permissions) ||
    in_array('categories', $manager->permissions) ||
    in_array('brands', $manager->permissions) ||
    in_array('features', $manager->permissions) ||
    in_array('special', $manager->permissions)}
        <li class = "start {if $menu_selected == 'catalog'}active{/if}">
			<a href = "index.php?module={if in_array('products', $manager->permissions)}ProductsAdmin
			{elseif in_array('categories', $manager->permissions)}CategoriesAdmin
			{elseif in_array('brands', $manager->permissions)}BrandsAdmin
			{elseif in_array('features', $manager->permissions)}FeaturesAdmin
			{elseif in_array('special', $manager->permissions)}SpecialAdmin{/if}">
				<i class = "fa fa-list-alt"></i>
				<span class="title">Каталог</span>
                <span class="selected"></span>
			</a>
		</li>
    {/if}
    {if in_array('orders', $manager->permissions) || in_array('labels', $manager->permissions)}
        <li{if $menu_selected == 'orders'} class = "active"{/if}>
			<a href = "index.php?module={$module}">
			   <i class = "fa fa-shopping-cart"></i>
				<span class="title">Заказы</span>
                <span class="arrow "></span>
                {if $new_orders_counter}
                    <span class = "orders_num">{$new_orders_counter}</span>
                {/if}
			</a>

		</li>
	{/if}

    {if in_array('users', $manager->permissions) ||
	    in_array('groups', $manager->permissions) ||
	    in_array('coupons', $manager->permissions)}
        <li{if $menu_selected == 'users'} class = "active"{/if}>
			<a href = "index.php?module={$module}">
			   <i class = "icon-users"></i>
				<span class="title">Пользователи</span>
			</a>
		</li>
	{/if}

    {if in_array('pages', $manager->permissions)}
        <li{if $menu_selected == 'pages'} class = "active"{/if}>
			<a href = "index.php?module={$module}">
				<i class = "fa  fa-file-text-o"></i>
				<span class="title">Страницы</span>
			</a></li>
    {/if}

    {if in_array('blog', $manager->permissions)}
        <li{if $menu_selected == 'blog'} class = "active"{/if}>
			<a href = "index.php?module={$module}">
				<i class = "fa fa-edit"></i>
				<span class="title">Блог</span>
			</a></li>
    {/if}

    {if in_array('comments', $manager->permissions) ||
	    in_array('feedbacks', $manager->permissions) ||
	    in_array('callbacks', $manager->permissions)}
        <li{if $menu_selected == 'comments'} class = "active"{/if}>
		<a href = "index.php?module={$module}">
			<i class = "fa fa-comments-o"></i>
			<span class="title">Комментарии</span>
            {if $new_comments_counter || $new_callbacks_counter || $new_feedbacks_counter}
                <span class = "comments_num">{$new_comments_counter + $new_callbacks_counter + $new_feedbacks_counter}</span>
            {/if}
		</a>

	</li>
    {/if}

    {if in_array('import', $manager->permissions) || in_array('export', $manager->permissions)}
        <li{if $menu_selected == 'auto'} class = "active"{/if}>
		<a href = "index.php?module={$module}">
			<i class = "fa fa-chain"></i>
			<span class="title">Импорт/экспорт</span>
		</a>
	</li>
    {/if}

    {if in_array('stats', $manager->permissions)}
        <li{if $menu_selected == 'stats'} class = "active"{/if}>
			<a href = "index.php?module={$module}">
				<i class = "fa fa-bar-chart-o"></i>
				<span class="title">Статистика</span>
			</a>
		</li>
    {/if}

    {if in_array('topvisor', $manager->permissions)}
        <li{if $menu_selected == 'topvisor'} class = "active"{/if}>
			<a href = "index.php?module={$module}">
				<i class = "fa fa-bullseye"></i>
				<span class="title">Topvisor</span>
			</a>
		</li>
    {/if}

    {if in_array('design', $manager->permissions)}
        <li{if $menu_selected == 'design'} class = "active"{/if}>
			<a href = "index.php?module={$module}">
				<i class = "fa fa-desktop"></i>
				<span class="title">Шаблоны</span>
			</a>
		</li>
    {/if}

    {if in_array('banners', $manager->permissions)}
        <li{if $menu_selected == 'banners'} class = "active"{/if}>
			<a href = "index.php?module={$module}">
				<i class = "fa fa-picture-o"></i>
				<span class="title">Баннеры</span>
			</a>
		</li>
    {/if}
	{if in_array('service', $manager->permissions)}
        <li{if $menu_selected == 'service'} class = "active"{/if}>
			<a href = "index.php?module={$module}">
				<i class = "fa fa-tachometer"></i>
				<span class="title">Обслуживание</span>
			</a>
		</li>
    {/if}

{if in_array('settings', $manager->permissions)}
        <li class = "dropdown {if $menu_selected == ('settings')}active
                              {elseif $menu_selected == ('settings2')}active{/if}" rel="1">
			<a href = "index.php?module={$module}">
				<i class = "fa fa-gears"></i>
				<span class="title">Настройки</span>
                <span class="arrow "></span>
            </a>
                 <ul class="sub-menu">
                   <li{if $menu_selected == ('settings')} class = "active"{/if} rel="11">
                       <a href = "index.php?module={$module}">
                           <i class="icon-first_settings"></i><span class="title">Основные</span></a></li>
                   <li{if $menu_selected == ('settings2')} class = "active"{/if} rel="12">
                       <a href = "index.php?module={$module}">
                           <i class="fa fa-wrench"></i><span class="title">Дополнительные</span></a></li>
                 </ul>

		</li>

        {elseif in_array('currency', $manager->permissions) ||
                 in_array('delivery', $manager->permissions) ||
                 in_array('payment', $manager->permissions) ||
                 in_array('managers', $manager->permissions) ||
                 in_array('languages', $manager->permissions)}

        <li{if $menu_selected == 'settings'} class = "active"{/if}>
			<a href = "index.php?module={$module}">
				<i class = "icon-settings"></i>
				<span class="title">Настройки</span>
				<span class="arrow "></span>
			</a>
		</li>
        {/if}
    <li>
    <a href = '{$config->root_url}?logout'>
        <i class = "fa fa-power-off"></i>
        <span class="title">Выход</span>
    </a>
    </li>
</ul>
<!-- END SIDEBAR MENU -->
			</div>
		</div>
<!-- END SIDEBAR -->


{*<!-- BEGIN SIDEBAR -->
<div class="page-sidebar navbar-collapse collapse">
  <!-- BEGIN SIDEBAR MENU -->
  <ul class="page-sidebar-menu page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
    <li>
      <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
      <div class="sidebar-toggler hidden-phone"></div>
	  <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
    </li>
    <li class="start active ">
      <a href="index.html">
      <i class="icon-home"></i>
      <span class="title">Dashboard</span>
      <span class="selected"></span>
      </a>
    </li>
    <li class="">
      <a href="javascript:;">
      <i class="icon-file-text"></i>
      <span class="title">Portlets</span>
      <span class="arrow "></span>
      </a>
      <ul class="sub-menu">
        <li >
          <a href="portlet_general.html">
          General Portlets              </a>
        </li>
        <li >
          <a href="portlet_draggable.html">
          Draggable Portlets              </a>
        </li>
      </ul>
    </li>
    <li class="last ">
      <a href="charts.html">
      <i class="icon-bar-chart"></i>
      <span class="title">Visual Charts</span>
      </a>
    </li>
  </ul>
  <!-- END SIDEBAR MENU -->
</div>
<!-- END SIDEBAR -->*}
