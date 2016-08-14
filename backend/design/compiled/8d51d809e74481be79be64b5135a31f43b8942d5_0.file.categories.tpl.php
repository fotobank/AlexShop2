<?php /* Smarty version 3.1.27, created on 2016-08-13 07:05:11
         compiled from "backend\design\html\categories.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:2389157ae9c77af64b4_38247340%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8d51d809e74481be79be64b5135a31f43b8942d5' => 
    array (
      0 => 'backend\\design\\html\\categories.tpl',
      1 => 1466581588,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2389157ae9c77af64b4_38247340',
  'variables' => 
  array (
    'manager' => 0,
    'categories' => 0,
    'category' => 0,
    'level' => 0,
    'config' => 0,
    'settings' => 0,
    'lang_link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57ae9c77bdcc71_52023059',
  'tpl_function' => 
  array (
    'categories_tree' => 
    array (
      'called_functions' => 
      array (
      ),
      'compiled_filepath' => 'backend/design/compiled\\8d51d809e74481be79be64b5135a31f43b8942d5_0.file.categories.tpl.php',
      'uid' => '8d51d809e74481be79be64b5135a31f43b8942d5',
      'call_name' => 'smarty_template_function_categories_tree_2389157ae9c77af64b4_38247340',
    ),
  ),
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57ae9c77bdcc71_52023059')) {
function content_57ae9c77bdcc71_52023059 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '2389157ae9c77af64b4_38247340';
?>

<?php $_smarty_tpl->_capture_stack[0][] = array('tabs', null, null); ob_start(); ?>
    <?php if (in_array('products',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=ProductsAdmin">Товары</a>
        </li>
    <?php }?>
    <li class="active">
        <a href="index.php?module=CategoriesAdmin">Категории</a>
    </li>
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
    <?php }?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>


<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_Variable('Категории', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>


<div id="header" style="overflow: visible;">
	<h1>Категории товаров</h1>
	<a class="add" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'CategoryAdmin','return'=>$_SERVER['REQUEST_URI']),$_smarty_tpl);?>
">Добавить категорию</a>
    <div class="helper_wrap">
        <a class="top_help" id="show_help_search" href="https://www.youtube.com/watch?v=-EIM2YxnV4Q" target="_blank"></a>
        <div class="right helper_block topvisor_help">
            <p>Видеоинструкция по разделу</p>
        </div>
    </div>
</div>


<?php if ($_smarty_tpl->tpl_vars['categories']->value) {?>
    <div id="main_list" class="categories">

        <form id="list_form" method="post">
            <input type="hidden" name="session_id" value="<?php echo $_SESSION['id'];?>
">

            <div id="list">
                
                <?php $_smarty_tpl->callTemplateFunction ('categories_tree', $_smarty_tpl, array('categories'=>$_smarty_tpl->tpl_vars['categories']->value), true);?>

            </div>
            <div id="action">
                <label id="check_all" class="dash_link">Выбрать все</label>
                <span id="select">
                    <select name="action">
                        <option value="enable">Сделать видимыми</option>
                        <option value="disable">Сделать невидимыми</option>
                        <option value="delete">Удалить</option>
                    </select>
                </span>
                <input id="apply_action" class="button_green" type="submit" value="Применить">
            </div>

        </form>
    </div>
<?php } else { ?>
    Нет категорий
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
			data: {'object': 'category_yandex', 'id': id, 'values': {'to_yandex': state}, 'session_id': '<?php echo $_SESSION['id'];?>
'},
			success: function(data){
                line.find('.tree_row a.yandex.success_yandex').removeClass('success_yandex');
                line.find('.tree_row a.yandex.fail_yandex').removeClass('fail_yandex');
                if (data == -1) {
                    line.find('.tree_row a.yandex[data-to_yandex="' + state + '"]').addClass('fail_yandex');
                } else if (data) {
                    line.find('.tree_row a.yandex[data-to_yandex="' + state + '"]').addClass('success_yandex');
				} else {
                    line.find('.tree_row a.yandex[data-to_yandex="' + state + '"]').removeClass('success_yandex');
				}
			},
			dataType: 'json'
		});	
		return false;	
	});

	// Сортировка списка
	$(".sortable").sortable({
		items:".row",
		handle: ".move_zone",
		tolerance:"pointer",
		scrollSensitivity:40,
		opacity:0.7, 
		axis: "y",
		update:function()
		{
			$("#list_form input[name*='check']").attr('checked', false);
			$("#list_form").ajaxSubmit();
		}
	});
 
	// Выделить все
	$("#check_all").click(function() {
		$('#list input[type="checkbox"][name*="check"]:not(:disabled)').attr('checked', $('#list input[type="checkbox"][name*="check"]:not(:disabled):not(:checked)').length>0);
	});	

	// Показать категорию
	$("a.enable").click(function() {
		var icon        = $(this);
		var line        = icon.closest(".row");
		var id          = line.find('input[type="checkbox"][name*="check"]').val();
		var state       = line.hasClass('invisible')?1:0;
		icon.addClass('loading_icon');
		$.ajax({
			type: 'POST',
			url: 'ajax/update_object.php',
			data: {'object': 'category', 'id': id, 'values': {'visible': state}, 'session_id': '<?php echo $_SESSION['id'];?>
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

	// Удалить 
	$("a.delete").click(function() {
		$('#list input[type="checkbox"][name*="check"]').attr('checked', false);
		$(this).closest("div.row").find('input[type="checkbox"][name*="check"]:first').attr('checked', true);
		$(this).closest("form").find('select[name="action"] option[value=delete]').attr('selected', true);
		$(this).closest("form").submit();
	});

	
	// Подтвердить удаление
	$("form").submit(function() {
		if($('select[name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
			return false;	
	});

});
<?php echo '</script'; ?>
>
<?php }
}
?><?php
/* smarty_template_function_categories_tree_2389157ae9c77af64b4_38247340 */
if (!function_exists('smarty_template_function_categories_tree_2389157ae9c77af64b4_38247340')) {
function smarty_template_function_categories_tree_2389157ae9c77af64b4_38247340($_smarty_tpl,$params) {
$saved_tpl_vars = $_smarty_tpl->tpl_vars;
$params = array_merge(array('level'=>0), $params);
foreach ($params as $key => $value) {
$_smarty_tpl->tpl_vars[$key] = new Smarty_Variable($value);
}?>
                    <?php if ($_smarty_tpl->tpl_vars['categories']->value) {?>
                        <div class="sortable">
                            <?php
$_from = $_smarty_tpl->tpl_vars['categories']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['category'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['category']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['category']->value) {
$_smarty_tpl->tpl_vars['category']->_loop = true;
$foreach_category_Sav = $_smarty_tpl->tpl_vars['category'];
?>
                                <div class="<?php if (!$_smarty_tpl->tpl_vars['category']->value->visible) {?>invisible<?php }?> row">
                                    <div class="tree_row">
                                        <input type="hidden" name="positions[<?php echo $_smarty_tpl->tpl_vars['category']->value->id;?>
]" value="<?php echo $_smarty_tpl->tpl_vars['category']->value->position;?>
">

                                        <div class="move cell" style="margin-left:<?php echo $_smarty_tpl->tpl_vars['level']->value*20;?>
px">
                                            <div class="move_zone"></div>
                                        </div>
                                        <div class="checkbox cell">
                                            <input type="checkbox" name="check[]" id="<?php echo $_smarty_tpl->tpl_vars['category']->value->id;?>
" value="<?php echo $_smarty_tpl->tpl_vars['category']->value->id;?>
"/>
                                            <label for="<?php echo $_smarty_tpl->tpl_vars['category']->value->id;?>
"></label>
                                        </div>
                                        <div class="image cell">
                                            <?php if ($_smarty_tpl->tpl_vars['category']->value->image) {?>
                                                <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'CategoryAdmin','id'=>$_smarty_tpl->tpl_vars['category']->value->id,'return'=>$_SERVER['REQUEST_URI']),$_smarty_tpl);?>
">
                                                    <img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['resize'][0][0]->resize_modifier($_smarty_tpl->tpl_vars['category']->value->image,35,35,false,$_smarty_tpl->tpl_vars['config']->value->resized_categories_dir);?>
" alt="" /></a>
                                                <?php } else { ?>
                                                    <img height="35" width="35" src="../design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/images/no_image.png"/>
                                            <?php }?>
                                        </div>
                                        <div class="cell categ_name">
                                            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'CategoryAdmin','id'=>$_smarty_tpl->tpl_vars['category']->value->id,'return'=>$_SERVER['REQUEST_URI']),$_smarty_tpl);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['category']->value->name, ENT_QUOTES, 'UTF-8', true);?>
</a>
                                        </div>
                                        <div class="icons cell cat">
                                            <a class="preview" title="Предпросмотр в новом окне" href="../<?php echo $_smarty_tpl->tpl_vars['lang_link']->value;?>
catalog/<?php echo $_smarty_tpl->tpl_vars['category']->value->url;?>
" target="_blank"></a>
                                            <a class="enable" title="Активна" href="#"></a>
                                            <a class="delete" title="Удалить" href="#"></a>
                                        </div>
                                        <div class="icons cell">
                                            <div class="helper_wrap">
                                                <a href="javascript:;" id="show_help_search" class="helper_link"></a>
                                                <div class="helper_block">
                                                    Отметить/снять отметку выгрузки всех товаров из этой категории и её подкатегорий в файл экспорта для ЯндексМаркета
                                                </div>
                                            </div>
                                            <a class="yandex" data-to_yandex="1" href="javascript:;">В Я.Маркет</a>
                                            <a class="yandex" data-to_yandex="0" href="javascript:;">Из Я.Маркета</a>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <?php $_smarty_tpl->callTemplateFunction ('categories_tree', $_smarty_tpl, array('categories'=>$_smarty_tpl->tpl_vars['category']->value->subcategories,'level'=>$_smarty_tpl->tpl_vars['level']->value+1), false);?>

                                </div>
                            <?php
$_smarty_tpl->tpl_vars['category'] = $foreach_category_Sav;
}
?>

                        </div>
                    <?php }?>
                <?php foreach (Smarty::$global_tpl_vars as $key => $value){
if ($_smarty_tpl->tpl_vars[$key] === $value) $saved_tpl_vars[$key] = $value;
}
$_smarty_tpl->tpl_vars = $saved_tpl_vars;
}
}
/*/ smarty_template_function_categories_tree_2389157ae9c77af64b4_38247340 */

?>
