<?php /* Smarty version 3.1.27, created on 2016-08-13 07:06:00
         compiled from "backend\design\html\brands.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:330657ae9ca8b284f3_28937610%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '619324e57c727864e24235147092e7c7850eccca' => 
    array (
      0 => 'backend\\design\\html\\brands.tpl',
      1 => 1466581588,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '330657ae9ca8b284f3_28937610',
  'variables' => 
  array (
    'manager' => 0,
    'brands' => 0,
    'brand' => 0,
    'config' => 0,
    'settings' => 0,
    'lang_link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57ae9ca8bcc610_65827986',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57ae9ca8bcc610_65827986')) {
function content_57ae9ca8bcc610_65827986 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '330657ae9ca8b284f3_28937610';
?>

<?php $_smarty_tpl->_capture_stack[0][] = array('tabs', null, null); ob_start(); ?>
    <?php if (in_array('products',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=ProductsAdmin">Товары</a>
        </li>
    <?php }?>
    <?php if (in_array('categories',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=CategoriesAdmin">Категории</a>
        </li>
    <?php }?>
    <li class="active">
        <a href="index.php?module=BrandsAdmin">Бренды</a>
    </li>
    <?php if (in_array('features',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=FeaturesAdmin">Свойства</a>
        </li>
    <?php }?>
    <?php if (in_array('special',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=SpecialAdmin">Промо-изображения</a>
        </li>
    <?php }?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>


<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_Variable('Бренды', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>


<div id="header" style="overflow: visible;">
	<h1>Бренды</h1> 
	<a class="add" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'BrandAdmin','return'=>$_SERVER['REQUEST_URI']),$_smarty_tpl);?>
">Добавить бренд</a>
    <div class="helper_wrap">
        <a class="top_help" id="show_help_search" href="https://www.youtube.com/watch?v=GXMSLwsgJLk" target="_blank"></a>
        <div class="right helper_block topvisor_help">
            <p>Видеоинструкция по разделу</p>
        </div>
    </div>
</div>

<?php if ($_smarty_tpl->tpl_vars['brands']->value) {?>
    <div id="main_list" class="brands">
        <form id="list_form" method="post">
            <input type="hidden" name="session_id" value="<?php echo $_SESSION['id'];?>
">
            <div id="list" class="brands">
                <?php
$_from = $_smarty_tpl->tpl_vars['brands']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['brand'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['brand']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['brand']->value) {
$_smarty_tpl->tpl_vars['brand']->_loop = true;
$foreach_brand_Sav = $_smarty_tpl->tpl_vars['brand'];
?>
                    <div class="row">
                        <div class="checkbox cell">
                            <input type="checkbox" id="<?php echo $_smarty_tpl->tpl_vars['brand']->value->id;?>
" name="check[]" value="<?php echo $_smarty_tpl->tpl_vars['brand']->value->id;?>
"/>
                            <label for="<?php echo $_smarty_tpl->tpl_vars['brand']->value->id;?>
"></label>
                        </div>
                        <div class="image cell">
                            <?php if ($_smarty_tpl->tpl_vars['brand']->value->image) {?>
                                <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'BrandAdmin','id'=>$_smarty_tpl->tpl_vars['brand']->value->id,'return'=>$_SERVER['REQUEST_URI']),$_smarty_tpl);?>
">
                                    <img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['resize'][0][0]->resize_modifier($_smarty_tpl->tpl_vars['brand']->value->image,35,35,false,$_smarty_tpl->tpl_vars['config']->value->resized_brands_dir);?>
" alt="" /></a>
                            <?php } else { ?>
                                <img height="35" width="35" src="../design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/images/no_image.png"/>
                            <?php }?>
                        </div>
                        <div class="cell">
                            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'BrandAdmin','id'=>$_smarty_tpl->tpl_vars['brand']->value->id,'return'=>$_SERVER['REQUEST_URI']),$_smarty_tpl);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['brand']->value->name, ENT_QUOTES, 'UTF-8', true);?>
</a>
                        </div>
                        <div class="icons cell brand">
                            <a class="preview" title="Предпросмотр в новом окне" href="../<?php echo $_smarty_tpl->tpl_vars['lang_link']->value;?>
brands/<?php echo $_smarty_tpl->tpl_vars['brand']->value->url;?>
" target="_blank"></a>
                            <a class="delete" title="Удалить" href="#"></a>
                        </div>
                        <div class="icons cell">
                            <a class="yandex" data-to_yandex="1" href="javascript:;">В Я.Маркет</a>
                            <a class="yandex" data-to_yandex="0" href="javascript:;">Из Я.Маркета</a>
                        </div>
                        <div class="clear"></div>
                    </div>
                <?php
$_smarty_tpl->tpl_vars['brand'] = $foreach_brand_Sav;
}
?>
            </div>
            <div id="action">
                <label id="check_all" class="dash_link">Выбрать все</label>
                <span id="select">
                    <select name="action">
                        <option value="delete">Удалить</option>
                    </select>
                </span>
                <input id="apply_action" class="button_green" type="submit" value="Применить">
            </div>

        </form>
    </div>
<?php } else { ?>
    Нет брендов
<?php }?>


<?php echo '<script'; ?>
>
$(function() {
    
    $("a.yandex").click(function() {
		var icon        = $(this);
		var line        = icon.closest(".row");
		var id          = line.find('input[type="checkbox"][name*="check"]').val();
        var state = $(this).data('to_yandex');
		$.ajax({
			type: 'POST',
			url: 'ajax/update_object.php',
			data: {'object': 'brand_yandex', 'id': id, 'values': {'to_yandex': state}, 'session_id': '<?php echo $_SESSION['id'];?>
'},
			success: function(data){
                line.find('a.yandex.success_yandex').removeClass('success_yandex');
                line.find('a.yandex.fail_yandex').removeClass('fail_yandex');
				if (data == -1) {
                    line.find('a.yandex[data-to_yandex="' + state + '"]').addClass('fail_yandex');
                } else if (data) {
                    line.find('a.yandex[data-to_yandex="' + state + '"]').addClass('success_yandex');
				} else {
                    line.find('a.yandex[data-to_yandex="' + state + '"]').removeClass('success_yandex');
				}
			},
			dataType: 'json'
		});	
		return false;	
	});

	// Раскраска строк
	function colorize()
	{
		$("#list div.row:even").addClass('even');
		$("#list div.row:odd").removeClass('even');
	}
	// Раскрасить строки сразу
	colorize();	
	
	// Выделить все
	$("#check_all").click(function() {
		$('#list input[type="checkbox"][name*="check"]').attr('checked', $('#list input[type="checkbox"][name*="check"]:not(:checked)').length>0);
	});	

	// Удалить
	$("a.delete").click(function() {
		$('#list input[type="checkbox"][name*="check"]').attr('checked', false);
		$(this).closest("div.row").find('input[type="checkbox"][name*="check"]').attr('checked', true);
		$(this).closest("form").find('select[name="action"] option[value=delete]').attr('selected', true);
		$(this).closest("form").submit();
	});
	
	// Подтверждение удаления
	$("form").submit(function() {
		if($('#list input[type="checkbox"][name*="check"]:checked').length>0)
			if($('select[name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
				return false;	
	});
 	
});
<?php echo '</script'; ?>
>

<?php }
}
?>