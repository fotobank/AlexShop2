<?php
/* Smarty version 3.1.29, created on 2016-08-07 03:56:25
  from "O:\domains\okay\backend\design\html\products.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57a68739453762_89712651',
  'file_dependency' => 
  array (
    '2853786c27cb5c829550210cb436f5a95397a0ce' => 
    array (
      0 => 'O:\\domains\\okay\\backend\\design\\html\\products.tpl',
      1 => 1467208466,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:pagination.tpl' => 2,
  ),
  'tpl_function' => 
  array (
    'category_select' => 
    array (
      'called_functions' => 
      array (
      ),
      'compiled_filepath' => 'O:\\domains\\okay\\backend\\design\\compiled\\2853786c27cb5c829550210cb436f5a95397a0ce_0.file.products.tpl.php',
      'uid' => '2853786c27cb5c829550210cb436f5a95397a0ce',
      'call_name' => 'smarty_template_function_category_select_1401557a687379b2180_88011393',
    ),
    'categories_tree' => 
    array (
      'called_functions' => 
      array (
      ),
      'compiled_filepath' => 'O:\\domains\\okay\\backend\\design\\compiled\\2853786c27cb5c829550210cb436f5a95397a0ce_0.file.products.tpl.php',
      'uid' => '2853786c27cb5c829550210cb436f5a95397a0ce',
      'call_name' => 'smarty_template_function_categories_tree_1401557a687379b2180_88011393',
    ),
  ),
),false)) {
function content_57a68739453762_89712651 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once 'O:\\domains\\okay\\vendor\\smarty\\smarty\\libs\\plugins\\modifier.truncate.php';
?>

<?php $_smarty_tpl->_cache['capture_stack'][] = array('tabs', null, null); ob_start(); ?>
	<li class="active">
        <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'ProductsAdmin','keyword'=>null,'category_id'=>null,'brand_id'=>null,'filter'=>null,'page'=>null,'limit'=>null),$_smarty_tpl);?>
">Товары</a>
    </li>
    <?php if (in_array('categories',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=CategoriesAdmin">Категории</a>
        </li>
    <?php }?>
    <?php if (in_array('brands',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=BrandsAdmin">Бренды</a>
        </li>
    <?php }?>
    <?php if (in_array('features',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=FeaturesAdmin">Свойства</a>
        </li>
    <?php }?>
    <?php if (in_array('special',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=SpecialAdmin">Промо-изображения</a>
        </li>
    <?php }
list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_cache['capture_stack']);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
$_smarty_tpl->_cache['__smarty_capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>


<?php if ($_smarty_tpl->tpl_vars['category']->value) {?>
	<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_Variable($_smarty_tpl->tpl_vars['category']->value->name, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'meta_title', 66);
} else { ?>
	<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_Variable('Товары', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'meta_title', 66);
}?>


<form method="get">
    <div id="search">
        <input type="hidden" name="module" value="ProductsAdmin">
        <input class="search" type="text" name="keyword" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['keyword']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
        <input class="search_button" type="submit" value=""/>
    </div>
</form>
	

<div id="header" style="overflow: visible;">
	<?php if ($_smarty_tpl->tpl_vars['products_count']->value) {?>
		<?php if ($_smarty_tpl->tpl_vars['category']->value->name || $_smarty_tpl->tpl_vars['brand']->value->name) {?>
			<h1><?php echo $_smarty_tpl->tpl_vars['category']->value->name;?>
 <?php echo $_smarty_tpl->tpl_vars['brand']->value->name;?>
 (<?php echo $_smarty_tpl->tpl_vars['products_count']->value;?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->tpl_vars['products_count']->value,'товар','товаров','товара');?>
)</h1>
		<?php } elseif ($_smarty_tpl->tpl_vars['keyword']->value) {?>
			<h1><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->tpl_vars['products_count']->value,'Найден','Найдено','Найдено');?>
 <?php echo $_smarty_tpl->tpl_vars['products_count']->value;?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->tpl_vars['products_count']->value,'товар','товаров','товара');?>
</h1>
		<?php } else { ?>
			<h1><?php echo $_smarty_tpl->tpl_vars['products_count']->value;?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->tpl_vars['products_count']->value,'товар','товаров','товара');?>
</h1>
		<?php }?>		
	<?php } else { ?>
		<h1>Нет товаров</h1>
	<?php }?>
	<a class="add" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'ProductAdmin','return'=>$_SERVER['REQUEST_URI']),$_smarty_tpl);?>
">Добавить товар</a>
    <div class="helper_wrap">
        <a class="top_help" id="show_help_search" href="https://www.youtube.com/watch?v=5vO7uMwM9VA" target="_blank"></a>
        <div class="right helper_block topvisor_help">
            <p>Видеоинструкция по разделу</p>
        </div>
    </div>
</div>	

<div id="main_list">
    
    <?php if ($_smarty_tpl->tpl_vars['products']->value) {?>
    <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:pagination.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    <div class="limit_show">
        <span>Показывать по: </span>
        <select onchange="location = this.value;">
            <option value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('limit'=>5),$_smarty_tpl);?>
" <?php if ($_smarty_tpl->tpl_vars['current_limit']->value == 5) {?>selected<?php }?>>5</option>
            <option value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('limit'=>10),$_smarty_tpl);?>
" <?php if ($_smarty_tpl->tpl_vars['current_limit']->value == 10) {?>selected<?php }?>>10</option>
            <option value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('limit'=>25),$_smarty_tpl);?>
" <?php if ($_smarty_tpl->tpl_vars['current_limit']->value == 25) {?>selected<?php }?>>25</option>
            <option value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('limit'=>50),$_smarty_tpl);?>
" <?php if ($_smarty_tpl->tpl_vars['current_limit']->value == 50) {?>selected<?php }?>>50</option>
            <option value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('limit'=>100),$_smarty_tpl);?>
" <?php if ($_smarty_tpl->tpl_vars['current_limit']->value == 100) {?>selected=""<?php }?>>100</option>
        </select>

        <div class="helper_wrap">
            <a href="javascript:;" id="show_help_search" class="helper_link"></a>
            <div class="helper_block right">
                <span>Количество товаров на одной странице в админ. панели</span>
            </div>
        </div>
    </div>

	<div id="expand">
	<a href="#" class="dash_link" id="expand_all">Развернуть все варианты ↓</a>
	<a href="#" class="dash_link" id="roll_up_all" style="display:none;">Свернуть все варианты ↑</a>
	</div>

	
	<form id="list_form" method="post">
	<input type="hidden" name="session_id" value="<?php echo $_SESSION['id'];?>
">
	
		<div id="list" class="catalog">
		<?php
$_from = $_smarty_tpl->tpl_vars['products']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_product_0_saved_item = isset($_smarty_tpl->tpl_vars['product']) ? $_smarty_tpl->tpl_vars['product'] : false;
$_smarty_tpl->tpl_vars['product'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['product']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->_loop = true;
$__foreach_product_0_saved_local_item = $_smarty_tpl->tpl_vars['product'];
?>
            <div class="<?php if (!$_smarty_tpl->tpl_vars['product']->value->visible) {?>invisible<?php }?> <?php if ($_smarty_tpl->tpl_vars['product']->value->featured) {?>featured<?php }?> row">
                <input type="hidden" name="positions[<?php echo $_smarty_tpl->tpl_vars['product']->value->id;?>
]" value="<?php echo $_smarty_tpl->tpl_vars['product']->value->position;?>
">
                <div class="move cell">
                    <div class="move_zone"></div>
                </div>
                <div class="checkbox cell">
                    <input type="checkbox" id="<?php echo $_smarty_tpl->tpl_vars['product']->value->id;?>
" name="check[]" value="<?php echo $_smarty_tpl->tpl_vars['product']->value->id;?>
"/>
                    <label for="<?php echo $_smarty_tpl->tpl_vars['product']->value->id;?>
"></label>
                </div>
                <div class="image cell">
                    <?php $_smarty_tpl->tpl_vars['image'] = new Smarty_Variable($_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['first'][0][0]->first_modifier($_smarty_tpl->tpl_vars['product']->value->images), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'image', 0);?>
                    <?php if ($_smarty_tpl->tpl_vars['image']->value) {?>
                        <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'ProductAdmin','id'=>$_smarty_tpl->tpl_vars['product']->value->id,'return'=>$_SERVER['REQUEST_URI']),$_smarty_tpl);?>
">
                            <img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['resize'][0][0]->resize_modifier(htmlspecialchars($_smarty_tpl->tpl_vars['image']->value->filename, ENT_QUOTES, 'UTF-8', true),35,35);?>
"/></a>
                    <?php } else { ?>
                        <img height="35" width="35" src="../design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/images/no_image.png"/>

                    <?php }?>
                </div>
			<div class="name product_name cell">
			 	
            <div class="variants">
                <ul>
                    <?php
$_from = $_smarty_tpl->tpl_vars['product']->value->variants;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_variant_1_saved_item = isset($_smarty_tpl->tpl_vars['variant']) ? $_smarty_tpl->tpl_vars['variant'] : false;
$_smarty_tpl->tpl_vars['variant'] = new Smarty_Variable();
$__foreach_variant_1_first = true;
$_smarty_tpl->tpl_vars['variant']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['variant']->value) {
$_smarty_tpl->tpl_vars['variant']->_loop = true;
$_smarty_tpl->tpl_vars['variant']->first = $__foreach_variant_1_first;
$__foreach_variant_1_first = false;
$__foreach_variant_1_saved_local_item = $_smarty_tpl->tpl_vars['variant'];
?>
                        <li <?php if (!$_smarty_tpl->tpl_vars['variant']->first) {?>class="variant" style="display:none;"<?php }?>>
                            <i title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['variant']->value->name, ENT_QUOTES, 'UTF-8', true);?>
"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['variant']->value->name,30,'..',true,true);?>
</i>
                            <label data-vid="<?php echo $_smarty_tpl->tpl_vars['variant']->value->id;?>
" class="yandex_icon <?php if ($_smarty_tpl->tpl_vars['variant']->value->yandex) {?>active<?php }?>"></label>
                            <input class="price <?php if ($_smarty_tpl->tpl_vars['variant']->value->compare_price > 0) {?>compare_price<?php }?>" type="text" name="price[<?php echo $_smarty_tpl->tpl_vars['variant']->value->id;?>
]" value="<?php echo $_smarty_tpl->tpl_vars['variant']->value->price;?>
"
                            <?php if ($_smarty_tpl->tpl_vars['variant']->value->compare_price > 0) {?>title="Старая цена &mdash; <?php echo $_smarty_tpl->tpl_vars['variant']->value->compare_price;?>
 <?php if ($_smarty_tpl->tpl_vars['variant']->value->currency_id) {
echo $_smarty_tpl->tpl_vars['currencies']->value[$_smarty_tpl->tpl_vars['variant']->value->currency_id]->sign;
} else {
echo $_smarty_tpl->tpl_vars['currency']->value->sign;
}?>"<?php }?> />
                            <?php if (isset($_smarty_tpl->tpl_vars['currencies']->value[$_smarty_tpl->tpl_vars['variant']->value->currency_id])) {?><span><?php echo $_smarty_tpl->tpl_vars['currencies']->value[$_smarty_tpl->tpl_vars['variant']->value->currency_id]->code;?>
</span><?php }?>
                            <input class="stock" type="text" name="stock[<?php echo $_smarty_tpl->tpl_vars['variant']->value->id;?>
]" value="<?php if ($_smarty_tpl->tpl_vars['variant']->value->infinity) {?>∞<?php } else {
echo $_smarty_tpl->tpl_vars['variant']->value->stock;
}?>"/><?php echo $_smarty_tpl->tpl_vars['settings']->value->units;?>

                        </li>
                    <?php
$_smarty_tpl->tpl_vars['variant'] = $__foreach_variant_1_saved_local_item;
}
if ($__foreach_variant_1_saved_item) {
$_smarty_tpl->tpl_vars['variant'] = $__foreach_variant_1_saved_item;
}
?>
                </ul>
	
				<?php $_smarty_tpl->tpl_vars['variants_num'] = new Smarty_Variable(count($_smarty_tpl->tpl_vars['product']->value->variants), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'variants_num', 0);?>
                <?php if ($_smarty_tpl->tpl_vars['variants_num']->value > 1) {?>
                    <div class="expand_variant">
                        <a class="dash_link expand_variant"
                           href="#"><?php echo $_smarty_tpl->tpl_vars['variants_num']->value;?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->tpl_vars['variants_num']->value,'вариант','вариантов','варианта');?>
 ↓</a>
                        <a class="dash_link roll_up_variant" style="display:none;"
                           href="#"><?php echo $_smarty_tpl->tpl_vars['variants_num']->value;?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->tpl_vars['variants_num']->value,'вариант','вариантов','варианта');?>
 ↑</a>
                    </div>
                <?php }?>
            </div>
				<a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'ProductAdmin','id'=>$_smarty_tpl->tpl_vars['product']->value->id,'return'=>$_SERVER['REQUEST_URI']),$_smarty_tpl);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value->name, ENT_QUOTES, 'UTF-8', true);?>
</a>
	 			<span><?php echo $_smarty_tpl->tpl_vars['brands_name']->value[$_smarty_tpl->tpl_vars['product']->value->brand_id]->name;?>
</span>
			</div>
			<div class="icons cell products">
				<a class="preview"   title="Предпросмотр в новом окне" href="../<?php echo $_smarty_tpl->tpl_vars['lang_link']->value;?>
products/<?php echo $_smarty_tpl->tpl_vars['product']->value->url;?>
" target="_blank"></a>
				<a class="enable"    title="Активен"                 href="#"></a>
				<a class="featured"  title="Хит продаж"           href="#"></a>
				<a class="duplicate" title="Дублировать"             href="#"></a>
				<a class="delete"    title="Удалить"                 href="#"></a>
			</div>
			
			<div class="clear"></div>
		</div>
		<?php
$_smarty_tpl->tpl_vars['product'] = $__foreach_product_0_saved_local_item;
}
if ($__foreach_product_0_saved_item) {
$_smarty_tpl->tpl_vars['product'] = $__foreach_product_0_saved_item;
}
?>
		</div>

        <div id="action">
            <label id="check_all" class="dash_link">Выбрать все</label>
			<span id="select">
			<select name="action">
                <option value="enable">Сделать видимыми</option>
                <option value="disable">Сделать невидимыми</option>
                <option value="set_featured">Сделать хитом продаж</option>
                <option value="unset_featured">Отменить хит продаж</option>
                <option value="set_yandex">В Я.Маркет</option>
                <option value="unset_yandex">Из Я.Маркета</option>
                <option value="duplicate">Создать дубликат</option>
                <?php if ($_smarty_tpl->tpl_vars['pages_count']->value > 1) {?>
                    <option value="move_to_page">Переместить на страницу</option>
                <?php }?>
                <?php if (count($_smarty_tpl->tpl_vars['categories']->value) > 1) {?>
                    <option value="move_to_category">Переместить в категорию</option>
                <?php }?>
                <?php if (count($_smarty_tpl->tpl_vars['all_brands']->value) > 0) {?>
                    <option value="move_to_brand">Указать бренд</option>
                <?php }?>
                <option value="delete">Удалить</option>
            </select>
			</span>
		
			<span id="move_to_page">
			<select name="target_page">
                <?php
$__section_target_page_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_target_page']) ? $_smarty_tpl->tpl_vars['__smarty_section_target_page'] : false;
$__section_target_page_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['pages_count']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_target_page_0_total = $__section_target_page_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_target_page'] = new Smarty_Variable(array());
if ($__section_target_page_0_total != 0) {
for ($__section_target_page_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_target_page']->value['index'] = 0; $__section_target_page_0_iteration <= $__section_target_page_0_total; $__section_target_page_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_target_page']->value['index']++){
?>
                    <option value="<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_target_page']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_target_page']->value['index'] : null)+1;?>
"><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_target_page']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_target_page']->value['index'] : null)+1;?>
</option>
                <?php
}
}
if ($__section_target_page_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_target_page'] = $__section_target_page_0_saved;
}
?>
            </select>
			</span>
		
			<span id="move_to_category">
			<select name="target_category">
                
                <?php $_smarty_tpl->smarty->ext->_tplFunction->callTemplateFunction($_smarty_tpl, 'category_select', array('categories'=>$_smarty_tpl->tpl_vars['categories']->value), true);?>

            </select>
			</span>
			
			<span id="move_to_brand">
			<select name="target_brand">
                <option value="0">Не указан</option>
                <?php
$_from = $_smarty_tpl->tpl_vars['all_brands']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_b_3_saved_item = isset($_smarty_tpl->tpl_vars['b']) ? $_smarty_tpl->tpl_vars['b'] : false;
$_smarty_tpl->tpl_vars['b'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['b']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['b']->value) {
$_smarty_tpl->tpl_vars['b']->_loop = true;
$__foreach_b_3_saved_local_item = $_smarty_tpl->tpl_vars['b'];
?>
                    <option value="<?php echo $_smarty_tpl->tpl_vars['b']->value->id;?>
"><?php echo $_smarty_tpl->tpl_vars['b']->value->name;?>
</option>
                <?php
$_smarty_tpl->tpl_vars['b'] = $__foreach_b_3_saved_local_item;
}
if ($__foreach_b_3_saved_item) {
$_smarty_tpl->tpl_vars['b'] = $__foreach_b_3_saved_item;
}
?>
            </select>
			</span>

            <input id="apply_action" class="button_green" type="submit" value="Применить">
        </div>

	</form>

    
	<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:pagination.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

    
    <div class="limit_show">
        <span>Показывать по: </span>
        <select onchange="location = this.value;">
            <option value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('limit'=>5),$_smarty_tpl);?>
" <?php if ($_smarty_tpl->tpl_vars['current_limit']->value == 5) {?>selected<?php }?>>5</option>
            <option value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('limit'=>10),$_smarty_tpl);?>
" <?php if ($_smarty_tpl->tpl_vars['current_limit']->value == 10) {?>selected<?php }?>>10</option>
            <option value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('limit'=>25),$_smarty_tpl);?>
" <?php if ($_smarty_tpl->tpl_vars['current_limit']->value == 25) {?>selected<?php }?>>25</option>
            <option value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('limit'=>50),$_smarty_tpl);?>
" <?php if ($_smarty_tpl->tpl_vars['current_limit']->value == 50) {?>selected<?php }?>>50</option>
            <option value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('limit'=>100),$_smarty_tpl);?>
" <?php if ($_smarty_tpl->tpl_vars['current_limit']->value == 100) {?>selected=""<?php }?>>100</option>
        </select>

        <div class="helper_wrap">
            <a href="javascript:;" id="show_help_search" class="helper_link"></a>
            <div class="right helper_block">
                <span>Количество товаров на одной странице в админ. панели</span>
            </div>
        </div>
    </div>
    <?php }?>
</div>


<div id="right_menu">
	
    <ul class="filter_right">
        <li <?php if (!$_smarty_tpl->tpl_vars['filter']->value) {?>class="selected"<?php }?>>
            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('brand_id'=>null,'category_id'=>null,'keyword'=>null,'page'=>null,'limit'=>null,'filter'=>null),$_smarty_tpl);?>
">Все товары</a></li>
        <li <?php if ($_smarty_tpl->tpl_vars['filter']->value == 'featured') {?>class="selected"<?php }?>>
            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('keyword'=>null,'brand_id'=>null,'category_id'=>null,'page'=>null,'limit'=>null,'filter'=>'featured'),$_smarty_tpl);?>
">Хиты продаж</a>
        </li>
        <li <?php if ($_smarty_tpl->tpl_vars['filter']->value == 'discounted') {?>class="selected"<?php }?>>
            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('keyword'=>null,'brand_id'=>null,'category_id'=>null,'page'=>null,'limit'=>null,'filter'=>'discounted'),$_smarty_tpl);?>
">Со скидкой</a>
        </li>
        <li <?php if ($_smarty_tpl->tpl_vars['filter']->value == 'visible') {?>class="selected"<?php }?>>
            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('keyword'=>null,'brand_id'=>null,'category_id'=>null,'page'=>null,'limit'=>null,'filter'=>'visible'),$_smarty_tpl);?>
">Активные</a>
        </li>
        <li <?php if ($_smarty_tpl->tpl_vars['filter']->value == 'hidden') {?>class="selected"<?php }?>>
            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('keyword'=>null,'brand_id'=>null,'category_id'=>null,'page'=>null,'limit'=>null,'filter'=>'hidden'),$_smarty_tpl);?>
">Неактивные</a>
        </li>
        <li <?php if ($_smarty_tpl->tpl_vars['filter']->value == 'outofstock') {?>class="selected"<?php }?>>
            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('keyword'=>null,'brand_id'=>null,'category_id'=>null,'page'=>null,'limit'=>null,'filter'=>'outofstock'),$_smarty_tpl);?>
">Отсутствующие</a>
        </li>
        <li <?php if ($_smarty_tpl->tpl_vars['filter']->value == 'in_yandex') {?>class="selected"<?php }?>>
            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('keyword'=>null,'brand_id'=>null,'category_id'=>null,'page'=>null,'limit'=>null,'filter'=>'in_yandex'),$_smarty_tpl);?>
">В яндексе</a>
        </li>
        <li <?php if ($_smarty_tpl->tpl_vars['filter']->value == 'out_yandex') {?>class="selected"<?php }?>>
            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('keyword'=>null,'brand_id'=>null,'category_id'=>null,'page'=>null,'limit'=>null,'filter'=>'out_yandex'),$_smarty_tpl);?>
">Не в яндексе</a>
        </li>
        <li <?php if ($_smarty_tpl->tpl_vars['filter']->value == 'without_images') {?>class="selected"<?php }?>>
            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('keyword'=>null,'brand_id'=>null,'category_id'=>null,'page'=>null,'limit'=>null,'filter'=>'without_images'),$_smarty_tpl);?>
">Без изображений</a>
        </li>
    </ul>
    
	
    
    <?php $_smarty_tpl->smarty->ext->_tplFunction->callTemplateFunction($_smarty_tpl, 'categories_tree', array('categories'=>$_smarty_tpl->tpl_vars['categories']->value,'level'=>1), true);?>

    

    
    <?php if ($_smarty_tpl->tpl_vars['brands']->value) {?>
        <ul>
            <li <?php if (!$_smarty_tpl->tpl_vars['brand']->value->id) {?>class="selected"<?php }?>>
                <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('brand_id'=>null),$_smarty_tpl);?>
">Все бренды</a>
            </li>
            <?php
$_from = $_smarty_tpl->tpl_vars['brands']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_b_5_saved_item = isset($_smarty_tpl->tpl_vars['b']) ? $_smarty_tpl->tpl_vars['b'] : false;
$_smarty_tpl->tpl_vars['b'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['b']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['b']->value) {
$_smarty_tpl->tpl_vars['b']->_loop = true;
$__foreach_b_5_saved_local_item = $_smarty_tpl->tpl_vars['b'];
?>
                <li brand_id="<?php echo $_smarty_tpl->tpl_vars['b']->value->id;?>
" <?php if ($_smarty_tpl->tpl_vars['brand']->value->id == $_smarty_tpl->tpl_vars['b']->value->id) {?>class="selected" <?php } else { ?>class="droppable brand"<?php }?>>
                    <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('keyword'=>null,'page'=>null,'limit'=>null,'brand_id'=>$_smarty_tpl->tpl_vars['b']->value->id),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['b']->value->name;?>
</a>
                </li>
            <?php
$_smarty_tpl->tpl_vars['b'] = $__foreach_b_5_saved_local_item;
}
if ($__foreach_b_5_saved_item) {
$_smarty_tpl->tpl_vars['b'] = $__foreach_b_5_saved_item;
}
?>
        </ul>
        
    <?php }?>
</div>



<?php echo '<script'; ?>
>

$(function() {
    
	// Сортировка списка
	$("#list").sortable({
		items:             ".row",
		tolerance:         "pointer",
		handle:            ".move_zone",
		scrollSensitivity: 40,
		opacity:           0.7, 
		
		helper: function(event, ui){		
			if($('input[type="checkbox"][name*="check"]:checked').size()<1) return ui;
			var helper = $('<div/>');
			$('input[type="checkbox"][name*="check"]:checked').each(function(){
				var item = $(this).closest('.row');
				helper.height(helper.height()+item.innerHeight());
				if(item[0]!=ui[0]) {
					helper.append(item.clone());
					$(this).closest('.row').remove();
				}
				else {
					helper.append(ui.clone());
					item.find('input[type="checkbox"][name*="check"]').attr('checked', false);
				}
			});
			return helper;			
		},	
 		start: function(event, ui) {
  			if(ui.helper.children('.row').size()>0)
				$('.ui-sortable-placeholder').height(ui.helper.height());
		},
		beforeStop:function(event, ui){
			if(ui.helper.children('.row').size()>0){
				ui.helper.children('.row').each(function(){
					$(this).insertBefore(ui.item);
				});
				ui.item.remove();
			}
		},
		update:function(event, ui)
		{
			$("#list_form input[name*='check']").attr('checked', false);
			$("#list_form").ajaxSubmit(function() {
				colorize();
			});
		}
	});
	

	// Перенос товара на другую страницу
	$("#action select[name=action]").change(function() {
		if($(this).val() == 'move_to_page')
			$("span#move_to_page").show();
		else
			$("span#move_to_page").hide();
	});
	$("#pagination a.droppable").droppable({
		activeClass: "drop_active",
		hoverClass: "drop_hover",
		tolerance: "pointer",
		drop: function(event, ui){
			$(ui.helper).find('input[type="checkbox"][name*="check"]').attr('checked', true);
			$(ui.draggable).closest("form").find('select[name="action"] option[value=move_to_page]').attr("selected", "selected");		
			$(ui.draggable).closest("form").find('select[name=target_page] option[value='+$(this).html()+']').attr("selected", "selected");
			$(ui.draggable).closest("form").submit();
			return false;	
		}		
	});


	// Перенос товара в другую категорию
	$("#action select[name=action]").change(function() {
		if($(this).val() == 'move_to_category')
			$("span#move_to_category").show();
		else
			$("span#move_to_category").hide();
	});
	$("#right_menu .droppable.category").droppable({
		activeClass: "drop_active",
		hoverClass: "drop_hover",
		tolerance: "pointer",
		drop: function(event, ui){
			$(ui.helper).find('input[type="checkbox"][name*="check"]').attr('checked', true);
			$(ui.draggable).closest("form").find('select[name="action"] option[value=move_to_category]').attr("selected", "selected");	
			$(ui.draggable).closest("form").find('select[name=target_category] option[value='+$(this).attr('category_id')+']').attr("selected", "selected");
			$(ui.draggable).closest("form").submit();
			return false;			
		}
	});


	// Перенос товара в другой бренд
	$("#action select[name=action]").change(function() {
		if($(this).val() == 'move_to_brand')
			$("span#move_to_brand").show();
		else
			$("span#move_to_brand").hide();
	});
	$("#right_menu .droppable.brand").droppable({
		activeClass: "drop_active",
		hoverClass: "drop_hover",
		tolerance: "pointer",
		drop: function(event, ui){
			$(ui.helper).find('input[type="checkbox"][name*="check"]').attr('checked', true);
			$(ui.draggable).closest("form").find('select[name="action"] option[value=move_to_brand]').attr("selected", "selected");			
			$(ui.draggable).closest("form").find('select[name=target_brand] option[value='+$(this).attr('brand_id')+']').attr("selected", "selected");
			$(ui.draggable).closest("form").submit();
			return false;			
		}
	});


	// Если есть варианты, отображать ссылку на их разворачивание
	if($("li.variant").size()>0)
		$("#expand").show();


	// Раскраска строк
	function colorize()
	{
		$("#list div.row:even").addClass('even');
		$("#list div.row:odd").removeClass('even');
	}
	// Раскрасить строки сразу
	colorize();


	// Показать все варианты
	$("#expand_all").click(function() {
		$("a#expand_all").hide();
		$("a#roll_up_all").show();
		$("a.expand_variant").hide();
		$("a.roll_up_variant").show();
		$(".variants ul li.variant").fadeIn('fast');
		return false;
	});


	// Свернуть все варианты
	$("#roll_up_all").click(function() {
		$("a#roll_up_all").hide();
		$("a#expand_all").show();
		$("a.roll_up_variant").hide();
		$("a.expand_variant").show();
		$(".variants ul li.variant").fadeOut('fast');
		return false;
	});

 
	// Показать вариант
	$("a.expand_variant").click(function() {
		$(this).closest("div.cell").find("li.variant").fadeIn('fast');
		$(this).closest("div.cell").find("a.expand_variant").hide();
		$(this).closest("div.cell").find("a.roll_up_variant").show();
		return false;
	});

	// Свернуть вариант
	$("a.roll_up_variant").click(function() {
		$(this).closest("div.cell").find("li.variant").fadeOut('fast');
		$(this).closest("div.cell").find("a.roll_up_variant").hide();
		$(this).closest("div.cell").find("a.expand_variant").show();
		return false;
	});

	// Выделить все
	$("#check_all").click(function() {
		$('#list input[type="checkbox"][name*="check"]').attr('checked', $('#list input[type="checkbox"][name*="check"]:not(:checked)').length>0);
	});	

	// Удалить товар
	$("a.delete").click(function() {
		$('#list input[type="checkbox"][name*="check"]').attr('checked', false);
		$(this).closest("div.row").find('input[type="checkbox"][name*="check"]').attr('checked', true);
		$(this).closest("form").find('select[name="action"] option[value=delete]').attr('selected', true);
		$(this).closest("form").submit();
	});
	
	// Дублировать товар
	$("a.duplicate").click(function() {
		$('#list input[type="checkbox"][name*="check"]').attr('checked', false);
		$(this).closest("div.row").find('input[type="checkbox"][name*="check"]').attr('checked', true);
		$(this).closest("form").find('select[name="action"] option[value=duplicate]').attr('selected', true);
		$(this).closest("form").submit();
	});
	
	// Показать товар
	$("a.enable").click(function() {
		var icon        = $(this);
		var line        = icon.closest("div.row");
		var id          = line.find('input[type="checkbox"][name*="check"]').val();
		var state       = line.hasClass('invisible')?1:0;
		icon.addClass('loading_icon');
		$.ajax({
			type: 'POST',
			url: 'ajax/update_object.php',
			data: {'object': 'product', 'id': id, 'values': {'visible': state}, 'session_id': '<?php echo $_SESSION['id'];?>
'},
			success: function(data){
				icon.removeClass('loading_icon');
				if(state)
					line.removeClass('invisible');
				else
					line.addClass('invisible');				
			},
			dataType: 'json'
		});	
		return false;	
	});
    
    $("label.yandex_icon").click(function() {
		var icon        = $(this);
		var id          = icon.data('vid');
		var state       = icon.hasClass('active')?0:1;
        icon.addClass('loading_icon');
		$.ajax({
			type: 'POST',
			url: 'ajax/update_object.php',
			data: {'object': 'variant', 'id': id, 'values': {'yandex': state}, 'session_id': '<?php echo $_SESSION['id'];?>
'},
			success: function(data){
				icon.removeClass('loading_icon');
				if(!state) {
				    icon.removeClass('active');
				} else {
				    icon.addClass('active');
				}
			},
			dataType: 'json'
		});	
		return false;	
	});

	// Сделать хитом
	$("a.featured").click(function() {
		var icon        = $(this);
		var line        = icon.closest("div.row");
		var id          = line.find('input[type="checkbox"][name*="check"]').val();
		var state       = line.hasClass('featured')?0:1;
		icon.addClass('loading_icon');
		$.ajax({
			type: 'POST',
			url: 'ajax/update_object.php',
			data: {'object': 'product', 'id': id, 'values': {'featured': state}, 'session_id': '<?php echo $_SESSION['id'];?>
'},
			success: function(data){
				icon.removeClass('loading_icon');
				if(state)
					line.addClass('featured');				
				else
					line.removeClass('featured');
			},
			dataType: 'json'
		});	
		return false;	
	});


	// Подтверждение удаления
	$("form").submit(function() {
		if($('select[name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
			return false;	
	});
	
	
	// Бесконечность на складе
	$("input[name*=stock]").focus(function() {
		if($(this).val() == '∞')
			$(this).val('');
		return false;
	});
	$("input[name*=stock]").blur(function() {
		if($(this).val() == '')
			$(this).val('∞');
	});

    $('.slide_menu').on('click',function(){
        if($(this).hasClass('open')){
            $(this).removeClass('open');
        }
        else{
            $(this).addClass('open');
        }
        $(this).parent().next().slideToggle(500);
    });

    $('.cats_right li.selected').parents('.cats_right.sub_menu').removeClass('sub_menu');
    $('.cats_right li.selected').parents('.cats_right').prev('li').find('span').addClass('open');

});

<?php echo '</script'; ?>
>
<?php }
/* smarty_template_function_category_select_1401557a687379b2180_88011393 */
if (!function_exists('smarty_template_function_category_select_1401557a687379b2180_88011393')) {
function smarty_template_function_category_select_1401557a687379b2180_88011393($_smarty_tpl,$params) {
$saved_tpl_vars = $_smarty_tpl->tpl_vars;
$params = array_merge(array('level'=>0), $params);
foreach ($params as $key => $value) {
$_smarty_tpl->tpl_vars[$key] = new Smarty_Variable($value);
}?>
                    <?php
$_from = $_smarty_tpl->tpl_vars['categories']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_category_2_saved_item = isset($_smarty_tpl->tpl_vars['category']) ? $_smarty_tpl->tpl_vars['category'] : false;
$_smarty_tpl->tpl_vars['category'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['category']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['category']->value) {
$_smarty_tpl->tpl_vars['category']->_loop = true;
$__foreach_category_2_saved_local_item = $_smarty_tpl->tpl_vars['category'];
?>
                        <option value='<?php echo $_smarty_tpl->tpl_vars['category']->value->id;?>
'><?php
$__section_sp_1_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_sp']) ? $_smarty_tpl->tpl_vars['__smarty_section_sp'] : false;
$__section_sp_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['level']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_sp_1_total = $__section_sp_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_sp'] = new Smarty_Variable(array());
if ($__section_sp_1_total != 0) {
for ($__section_sp_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_sp']->value['index'] = 0; $__section_sp_1_iteration <= $__section_sp_1_total; $__section_sp_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_sp']->value['index']++){
?>&nbsp;&nbsp;&nbsp;&nbsp;<?php
}
}
if ($__section_sp_1_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_sp'] = $__section_sp_1_saved;
}
echo htmlspecialchars($_smarty_tpl->tpl_vars['category']->value->name, ENT_QUOTES, 'UTF-8', true);?>
</option>
                        <?php $_smarty_tpl->smarty->ext->_tplFunction->callTemplateFunction($_smarty_tpl, 'category_select', array('categories'=>$_smarty_tpl->tpl_vars['category']->value->subcategories,'selected_id'=>$_smarty_tpl->tpl_vars['selected_id']->value,'level'=>$_smarty_tpl->tpl_vars['level']->value+1), true);?>

                    <?php
$_smarty_tpl->tpl_vars['category'] = $__foreach_category_2_saved_local_item;
}
if ($__foreach_category_2_saved_item) {
$_smarty_tpl->tpl_vars['category'] = $__foreach_category_2_saved_item;
}
?>
                <?php foreach (Smarty::$global_tpl_vars as $key => $value){
if (!isset($_smarty_tpl->tpl_vars[$key]) || $_smarty_tpl->tpl_vars[$key] === $value) $saved_tpl_vars[$key] = $value;
}
$_smarty_tpl->tpl_vars = $saved_tpl_vars;
}
}
/*/ smarty_template_function_category_select_1401557a687379b2180_88011393 */
/* smarty_template_function_categories_tree_1401557a687379b2180_88011393 */
if (!function_exists('smarty_template_function_categories_tree_1401557a687379b2180_88011393')) {
function smarty_template_function_categories_tree_1401557a687379b2180_88011393($_smarty_tpl,$params) {
$saved_tpl_vars = $_smarty_tpl->tpl_vars;
foreach ($params as $key => $value) {
$_smarty_tpl->tpl_vars[$key] = new Smarty_Variable($value);
}?>
        <?php if ($_smarty_tpl->tpl_vars['categories']->value) {?>
            <ul class="cats_right<?php if ($_smarty_tpl->tpl_vars['level']->value > 1) {?> sub_menu<?php }?>">
                <?php if ($_smarty_tpl->tpl_vars['categories']->value[0]->parent_id == 0) {?>
                    <li class="clearfix <?php if (!$_smarty_tpl->tpl_vars['category']->value->id) {?>selected<?php }?>">
                        <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('category_id'=>null,'brand_id'=>null),$_smarty_tpl);?>
">Все категории</a>
                    </li>
                <?php }?>
                <?php
$_from = $_smarty_tpl->tpl_vars['categories']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_c_4_saved_item = isset($_smarty_tpl->tpl_vars['c']) ? $_smarty_tpl->tpl_vars['c'] : false;
$_smarty_tpl->tpl_vars['c'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['c']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['c']->value) {
$_smarty_tpl->tpl_vars['c']->_loop = true;
$__foreach_c_4_saved_local_item = $_smarty_tpl->tpl_vars['c'];
?>
                    <li category_id="<?php echo $_smarty_tpl->tpl_vars['c']->value->id;?>
" <?php if ($_smarty_tpl->tpl_vars['category']->value->id == $_smarty_tpl->tpl_vars['c']->value->id) {?>class="selected clearfix"<?php } else { ?>class="droppable category clearfix"<?php }?>>
                        <a href='<?php ob_start();
echo $_smarty_tpl->tpl_vars['c']->value->id;
$_tmp1=ob_get_clean();
echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('keyword'=>null,'brand_id'=>null,'page'=>null,'limit'=>null,'category_id'=>$_tmp1),$_smarty_tpl);?>
'><?php echo $_smarty_tpl->tpl_vars['c']->value->name;?>
</a>
                        <?php if ($_smarty_tpl->tpl_vars['c']->value->subcategories) {?><span class="slide_menu"></span><?php }?>
                    </li>
                    <?php $_smarty_tpl->smarty->ext->_tplFunction->callTemplateFunction($_smarty_tpl, 'categories_tree', array('categories'=>$_smarty_tpl->tpl_vars['c']->value->subcategories,'level'=>$_smarty_tpl->tpl_vars['level']->value+1), true);?>

                <?php
$_smarty_tpl->tpl_vars['c'] = $__foreach_c_4_saved_local_item;
}
if ($__foreach_c_4_saved_item) {
$_smarty_tpl->tpl_vars['c'] = $__foreach_c_4_saved_item;
}
?>
            </ul>
        <?php }?>
    <?php foreach (Smarty::$global_tpl_vars as $key => $value){
if (!isset($_smarty_tpl->tpl_vars[$key]) || $_smarty_tpl->tpl_vars[$key] === $value) $saved_tpl_vars[$key] = $value;
}
$_smarty_tpl->tpl_vars = $saved_tpl_vars;
}
}
/*/ smarty_template_function_categories_tree_1401557a687379b2180_88011393 */
}
