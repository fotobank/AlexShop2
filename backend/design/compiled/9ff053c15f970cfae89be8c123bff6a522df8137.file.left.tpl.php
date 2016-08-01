<?php /* Smarty version Smarty-3.1.18, created on 2016-08-01 16:50:33
         compiled from "backend\design\html\left.tpl" */ ?>
<?php /*%%SmartyHeaderCode:24312579f53a9486ce8-03893488%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9ff053c15f970cfae89be8c123bff6a522df8137' => 
    array (
      0 => 'backend\\design\\html\\left.tpl',
      1 => 1467208466,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '24312579f53a9486ce8-03893488',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'manager' => 0,
    'menu_selected' => 0,
    'new_orders_counter' => 0,
    'new_comments_counter' => 0,
    'new_callbacks_counter' => 0,
    'new_feedbacks_counter' => 0,
    'languages' => 0,
    'l' => 0,
    'lang_id' => 0,
    'license' => 0,
    'd' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_579f53a96b1862_45554814',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_579f53a96b1862_45554814')) {function content_579f53a96b1862_45554814($_smarty_tpl) {?>
<div id="okay_logo">
     <a href='index.php?module=LicenseAdmin'><img src="design/images/logo.png" alt="OkayCMS"/></a>
</div>

<ul id="main_menu">

	<?php if (in_array('products',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
		<li class="<?php if ($_smarty_tpl->tpl_vars['menu_selected']->value=='catalog') {?>active<?php }?>">
			<a href="index.php?module=ProductsAdmin">
				<i class="icon_catalog"></i>
				<span>Каталог</span>
			</a>
		</li>
	<?php } elseif (in_array('categories',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
		<li class="<?php if ($_smarty_tpl->tpl_vars['menu_selected']->value=='catalog') {?>active<?php }?>">
			<a href="index.php?module=CategoriesAdmin">
				<i class="icon_catalog"></i>
				<span>Каталог</span>
			</a>
		</li>
	<?php } elseif (in_array('brands',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
		<li class="<?php if ($_smarty_tpl->tpl_vars['menu_selected']->value=='catalog') {?>active<?php }?>">
			<a href="index.php?module=BrandsAdmin">
				<i class="icon_catalog"></i>
				<span>Каталог</span>
			</a>
		</li>
	<?php } elseif (in_array('features',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
		<li class="<?php if ($_smarty_tpl->tpl_vars['menu_selected']->value=='catalog') {?>active<?php }?>">
			<a href="index.php?module=FeaturesAdmin">
				<i class="icon_catalog"></i>
				<span>Каталог</span>
			</a>
		</li>
	<?php } elseif (in_array('special',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
		<li class="<?php if ($_smarty_tpl->tpl_vars['menu_selected']->value=='catalog') {?>active<?php }?>">
			<a href="index.php?module=SpecialAdmin">
				<i class="icon_catalog"></i>
				<span>Каталог</span>
			</a>
		</li>
	<?php }?>

	<?php if (in_array('orders',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
		<li class="<?php if ($_smarty_tpl->tpl_vars['menu_selected']->value=='orders') {?>active<?php }?>">
			<a href="index.php?module=OrdersAdmin">
			   <i class="icon_orders"></i>
				<span>Заказы</span> 
				<?php if ($_smarty_tpl->tpl_vars['new_orders_counter']->value) {?>
					<span class="orders_num"><?php echo $_smarty_tpl->tpl_vars['new_orders_counter']->value;?>
</span>
				<?php }?>
			</a>
			
		</li>
	<?php } elseif (in_array('labels',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
		<li class="<?php if ($_smarty_tpl->tpl_vars['menu_selected']->value=='orders') {?>active<?php }?>">
			<a href="index.php?module=OrdersLabelsAdmin">
				<i class="icon_orders"></i>
				<span>Заказы</span>
                <?php if ($_smarty_tpl->tpl_vars['new_orders_counter']->value) {?>
    				<span class="orders_num"><?php echo $_smarty_tpl->tpl_vars['new_orders_counter']->value;?>
</span>
    			<?php }?>
			</a>
		</li>
	<?php }?>

	<?php if (in_array('users',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
		<li class="<?php if ($_smarty_tpl->tpl_vars['menu_selected']->value=='users') {?>active<?php }?>">
			<a href="index.php?module=UsersAdmin">
			   <i class="icon_users"></i>
				<span>Пользователи</span>
			</a>
		</li>
	<?php } elseif (in_array('groups',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
		<li class="<?php if ($_smarty_tpl->tpl_vars['menu_selected']->value=='users') {?>active<?php }?>">
			<a href="index.php?module=GroupsAdmin">
				<i class="icon_users"></i>
				<span>Пользователи</span>
			</a>
		</li>
	<?php } elseif (in_array('coupons',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
		<li class="<?php if ($_smarty_tpl->tpl_vars['menu_selected']->value=='users') {?>active<?php }?>">
			<a href="index.php?module=CouponsAdmin">
				<i class="icon_users"></i>
				<span>Пользователи</span>
			</a>
		</li>
	<?php }?>

	<?php if (in_array('pages',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
		<li class="<?php if ($_smarty_tpl->tpl_vars['menu_selected']->value=='pages') {?>active<?php }?>">
			<a href="index.php?module=PagesAdmin">
				<i class="icon_pages"></i>
				<span>Страницы</span>
			</a></li>
	<?php }?>

	<?php if (in_array('blog',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
		<li class="<?php if ($_smarty_tpl->tpl_vars['menu_selected']->value=='blog') {?>active<?php }?>">
			<a href="index.php?module=BlogAdmin">
				<i class="icon_blog"></i>
				<span>Блог</span>
			</a></li>
	<?php }?>

	<?php if (in_array('comments',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
	<li class="<?php if ($_smarty_tpl->tpl_vars['menu_selected']->value=='comments') {?>active<?php }?>">
		<a href="index.php?module=CommentsAdmin">
			<i class="icon_comments"></i>
			<span>Комментарии</span>
			<?php if ($_smarty_tpl->tpl_vars['new_comments_counter']->value||$_smarty_tpl->tpl_vars['new_callbacks_counter']->value||$_smarty_tpl->tpl_vars['new_feedbacks_counter']->value) {?>
				<span class="comments_num"><?php echo $_smarty_tpl->tpl_vars['new_comments_counter']->value+$_smarty_tpl->tpl_vars['new_callbacks_counter']->value+$_smarty_tpl->tpl_vars['new_feedbacks_counter']->value;?>
</span>
			<?php }?>
		</a>
		
	</li>
	<?php } elseif (in_array('feedbacks',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
	<li class="<?php if ($_smarty_tpl->tpl_vars['menu_selected']->value=='comments') {?>active<?php }?>">
		<a href="index.php?module=FeedbacksAdmin">
			<i class="icon_comments"></i>
			<span>Комментарии</span>
            <?php if ($_smarty_tpl->tpl_vars['new_comments_counter']->value||$_smarty_tpl->tpl_vars['new_callbacks_counter']->value||$_smarty_tpl->tpl_vars['new_feedbacks_counter']->value) {?>
    			<span class="comments_num"><?php echo $_smarty_tpl->tpl_vars['new_comments_counter']->value+$_smarty_tpl->tpl_vars['new_callbacks_counter']->value+$_smarty_tpl->tpl_vars['new_feedbacks_counter']->value;?>
</span>
    		<?php }?>
		</a>
    </li>
    <?php } elseif (in_array('callbacks',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
	<li class="<?php if ($_smarty_tpl->tpl_vars['menu_selected']->value=='comments') {?>active<?php }?>">
		<a href="index.php?module=CallbacksAdmin">
			<i class="icon_comments"></i>
			<span>Комментарии</span>
            <?php if ($_smarty_tpl->tpl_vars['new_comments_counter']->value||$_smarty_tpl->tpl_vars['new_callbacks_counter']->value||$_smarty_tpl->tpl_vars['new_feedbacks_counter']->value) {?>
    			<span class="comments_num"><?php echo $_smarty_tpl->tpl_vars['new_comments_counter']->value+$_smarty_tpl->tpl_vars['new_callbacks_counter']->value+$_smarty_tpl->tpl_vars['new_feedbacks_counter']->value;?>
</span>
    		<?php }?>
		</a>
    </li>
	<?php }?>

	<?php if (in_array('import',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
	<li class="<?php if ($_smarty_tpl->tpl_vars['menu_selected']->value=='auto') {?>active<?php }?>">
		<a href="index.php?module=ImportAdmin">
			<i class="icon_automatic"></i>
			<span>Импорт/экспорт</span>
		</a>
	</li>
	<?php } elseif (in_array('export',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
	<li class="<?php if ($_smarty_tpl->tpl_vars['menu_selected']->value=='auto') {?>active<?php }?>">
		<a href="index.php?module=ExportAdmin">
			<i class="icon_automatic"></i>
			<span>Импорт/экспорт</span>
		</a>
	</li>
	<?php }?>

	<?php if (in_array('stats',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
		<li class="<?php if ($_smarty_tpl->tpl_vars['menu_selected']->value=='stats') {?>active<?php }?>">
			<a href="index.php?module=StatsAdmin">
				<i class="icon_statistic"></i>
				<span>Статистика</span>
			</a>
		</li>
    <?php }?>
        
    <?php if (in_array('topvisor',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li class="<?php if ($_smarty_tpl->tpl_vars['menu_selected']->value=='topvisor') {?>active<?php }?>">
			<a href="index.php?module=TopvisorProjectsAdmin">
				<i class="icon_topvisor"></i>
				<span>Topvisor</span>
			</a>
		</li>
	<?php }?>

	<?php if (in_array('design',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
		<li class="<?php if ($_smarty_tpl->tpl_vars['menu_selected']->value=='design') {?>active<?php }?>">
			<a href="index.php?module=ThemeAdmin">
				<i class="icon_design"></i>
				<span>Шаблоны</span>
			</a>
		</li>
	<?php }?>
    
    <?php if (in_array('banners',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
		<li class="<?php if ($_smarty_tpl->tpl_vars['menu_selected']->value=='banners') {?>active<?php }?>">
			<a href="index.php?module=BannersImagesAdmin">
				<i class="icon_banner"></i>
				<span>Баннеры</span>
			</a>
		</li>
	<?php }?>

	<?php if (in_array('settings',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
		<li class="<?php if ($_smarty_tpl->tpl_vars['menu_selected']->value=='settings') {?>active<?php }?>">
			<a href="index.php?module=SettingsAdmin">
				<i class="icon_settings"></i>
				<span>Настройки</span>
			</a>
		</li>
    <?php } elseif (in_array('currency',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
		<li class="<?php if ($_smarty_tpl->tpl_vars['menu_selected']->value=='settings') {?>active<?php }?>">
			<a href="index.php?module=CurrencyAdmin">
				<i class="icon_settings"></i>
				<span>Настройки</span>
			</a>
		</li>
	<?php } elseif (in_array('delivery',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
		<li class="<?php if ($_smarty_tpl->tpl_vars['menu_selected']->value=='settings') {?>active<?php }?>">
			<a href="index.php?module=DeliveriesAdmin">
				<i class="icon_settings"></i>
				<span>Настройки</span>
			</a>
		</li>
	<?php } elseif (in_array('payment',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
		<li class="<?php if ($_smarty_tpl->tpl_vars['menu_selected']->value=='settings') {?>active<?php }?>">
			<a href="index.php?module=PaymentMethodsAdmin">
				<i class="icon_settings"></i>
				<span>Настройки</span>
			</a>
		</li>
	<?php } elseif (in_array('managers',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
		<li class="<?php if ($_smarty_tpl->tpl_vars['menu_selected']->value=='settings') {?>active<?php }?>">
			<a href="index.php?module=ManagersAdmin">
				<i class="icon_settings"></i>
				<span>Настройки</span>
			</a>
		</li>
    <?php } elseif (in_array('languages',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
		<li class="<?php if ($_smarty_tpl->tpl_vars['menu_selected']->value=='settings') {?>active<?php }?>">
			<a href="index.php?module=LanguagesAdmin">
				<i class="icon_settings"></i>
				<span>Настройки</span>
			</a>
		</li>
	<?php }?>

</ul>
<div class="language">
<?php  $_smarty_tpl->tpl_vars['l'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['l']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['l']->key => $_smarty_tpl->tpl_vars['l']->value) {
$_smarty_tpl->tpl_vars['l']->_loop = true;
?>
		<a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('lang_id'=>$_smarty_tpl->tpl_vars['l']->value->id),$_smarty_tpl);?>
" <?php if ($_smarty_tpl->tpl_vars['l']->value->id==$_smarty_tpl->tpl_vars['lang_id']->value) {?>class="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['l']->value->label;?>
</a>
<?php } ?>
</div>
<div class="license_info">
<?php if (in_array('license',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
	<?php if ($_smarty_tpl->tpl_vars['license']->value->valid) {?>
		<span><a href='index.php?module=LicenseAdmin'>Лицензия</a> действительна <?php if ($_smarty_tpl->tpl_vars['license']->value->expiration!='*') {?>до <?php echo $_smarty_tpl->tpl_vars['license']->value->expiration;?>
<?php }?> для домен<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier(count($_smarty_tpl->tpl_vars['license']->value->domains),'а','ов');?>
 <?php  $_smarty_tpl->tpl_vars['d'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['d']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['license']->value->domains; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['d']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['d']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['d']->key => $_smarty_tpl->tpl_vars['d']->value) {
$_smarty_tpl->tpl_vars['d']->_loop = true;
 $_smarty_tpl->tpl_vars['d']->iteration++;
 $_smarty_tpl->tpl_vars['d']->last = $_smarty_tpl->tpl_vars['d']->iteration === $_smarty_tpl->tpl_vars['d']->total;
?><?php echo $_smarty_tpl->tpl_vars['d']->value;?>
<?php if (!$_smarty_tpl->tpl_vars['d']->last) {?>, <?php }?><?php } ?>.</span>
		
	<?php } else { ?>
		<span><a href='index.php?module=LicenseAdmin'>Лицензия</a> недействительна.</span>
	<?php }?>
<?php }?>
</div>



<?php }} ?>
