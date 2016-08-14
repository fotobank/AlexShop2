<?php /* Smarty version 3.1.27, created on 2016-08-13 07:06:04
         compiled from "backend\design\html\features.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:3166357ae9cacb5bfc0_50893261%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '049ee83b227b9b941972dcecd4aa7307931cc828' => 
    array (
      0 => 'backend\\design\\html\\features.tpl',
      1 => 1466581588,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3166357ae9cacb5bfc0_50893261',
  'variables' => 
  array (
    'manager' => 0,
    'features' => 0,
    'feature' => 0,
    'categories' => 0,
    'level' => 0,
    'category' => 0,
    'c' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57ae9cacc23374_77824305',
  'tpl_function' => 
  array (
    'categories_tree' => 
    array (
      'called_functions' => 
      array (
      ),
      'compiled_filepath' => 'backend/design/compiled\\049ee83b227b9b941972dcecd4aa7307931cc828_0.file.features.tpl.php',
      'uid' => '049ee83b227b9b941972dcecd4aa7307931cc828',
      'call_name' => 'smarty_template_function_categories_tree_3166357ae9cacb5bfc0_50893261',
    ),
  ),
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57ae9cacc23374_77824305')) {
function content_57ae9cacc23374_77824305 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '3166357ae9cacb5bfc0_50893261';
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
    <?php if (in_array('brands',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=BrandsAdmin">Бренды</a>
        </li>
    <?php }?>
    <li class="active">
        <a href="index.php?module=FeaturesAdmin">Свойства</a>
    </li>
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


<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_Variable('Свойства', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>

<div id="header" style="overflow: visible;">
	<h1>Свойства</h1> 
	<a class="add" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'FeatureAdmin','return'=>$_SERVER['REQUEST_URI']),$_smarty_tpl);?>
">Добавить свойство</a>
	<div class="helper_wrap">
		<a class="top_help" id="show_help_search" href="https://www.youtube.com/watch?v=eATslZw5RxI" target="_blank"></a>
		<div class="right helper_block topvisor_help">
			<p>Видеоинструкция по разделу</p>
		</div>
	</div>
</div>

<?php if ($_smarty_tpl->tpl_vars['features']->value) {?>
    <div id="main_list" class="features">
        <form id="list_form" method="post">
            <input type="hidden" name="session_id" value="<?php echo $_SESSION['id'];?>
">
            <div id="list">
                <?php
$_from = $_smarty_tpl->tpl_vars['features']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['feature'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['feature']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['feature']->value) {
$_smarty_tpl->tpl_vars['feature']->_loop = true;
$foreach_feature_Sav = $_smarty_tpl->tpl_vars['feature'];
?>
                    <div class="<?php if ($_smarty_tpl->tpl_vars['feature']->value->in_filter) {?>in_filter<?php }?> row">
                        <input type="hidden" name="positions[<?php echo $_smarty_tpl->tpl_vars['feature']->value->id;?>
]" value="<?php echo $_smarty_tpl->tpl_vars['feature']->value->position;?>
">
                        <div class="move cell">
                            <div class="move_zone"></div>
                        </div>
                        <div class="checkbox cell">
                            <input type="checkbox" id="<?php echo $_smarty_tpl->tpl_vars['feature']->value->id;?>
" name="check[]" value="<?php echo $_smarty_tpl->tpl_vars['feature']->value->id;?>
"/>
                            <label for="<?php echo $_smarty_tpl->tpl_vars['feature']->value->id;?>
"></label>
                        </div>
                        <div class="cell">
                            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'FeatureAdmin','id'=>$_smarty_tpl->tpl_vars['feature']->value->id,'return'=>$_SERVER['REQUEST_URI']),$_smarty_tpl);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['feature']->value->name, ENT_QUOTES, 'UTF-8', true);?>
</a>
                        </div>
                        <div class="icons cell">
                            <label title="Передавать в выгрузку Я.Маркет" data-vid="<?php echo $_smarty_tpl->tpl_vars['feature']->value->id;?>
" class="yandex_icon <?php if ($_smarty_tpl->tpl_vars['feature']->value->yandex) {?>active<?php }?>"></label>
                            <a title="Использовать в фильтре" class="in_filter" href='#'></a>
                            <a title="Удалить" class="delete" href='#'></a>
                        </div>
                        <div class="clear"></div>
                    </div>
                <?php
$_smarty_tpl->tpl_vars['feature'] = $foreach_feature_Sav;
}
?>
            </div>

            <div id="action">
                <label id="check_all" class="dash_link">Выбрать все</label>
	
                <span id="select">
                    <select name="action">
                        <option value="set_in_filter">Использовать в фильтре</option>
                        <option value="unset_in_filter">Не использовать в фильтре</option>
                        <option value="to_yandex">В яндекс</option>
                        <option value="from_yandex">Из яндекса</option>
                        <option value="delete">Удалить</option>
                    </select>
                </span>
                <input id="apply_action" class="button_green" type="submit" value="Применить">
            </div>

        </form>

    </div>
<?php } else { ?>
    Нет свойств
<?php }?>


<div id="right_menu">
    
    <?php $_smarty_tpl->callTemplateFunction ('categories_tree', $_smarty_tpl, array('categories'=>$_smarty_tpl->tpl_vars['categories']->value,'level'=>1), true);?>

</div>

<?php echo '<script'; ?>
>
$(function() {
    
    $("label.yandex_icon").click(function() {
		var icon        = $(this);
		var id          = icon.data('vid');
		var state       = icon.hasClass('active')?0:1;
        icon.addClass('loading_icon');
		$.ajax({
			type: 'POST',
			url: 'ajax/update_object.php',
			data: {'object': 'feature', 'id': id, 'values': {'yandex': state}, 'session_id': '<?php echo $_SESSION['id'];?>
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
	});

	// Раскраска строк
	function colorize()
	{
		$("#list div.row:even").addClass('even');
		$("#list div.row:odd").removeClass('even');
	}
	// Раскрасить строки сразу
	colorize();
	
	// Сортировка списка
	$("#list").sortable({
		items:             ".row",
		tolerance:         "pointer",
		handle:            ".move_zone",
		axis: 'y',
		scrollSensitivity: 40,
		opacity:           0.7, 
		forcePlaceholderSize: true,
		
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
	
	// Выделить все
	$("#check_all").click(function() {
		$('#list input[type="checkbox"][name*="check"]').attr('checked', $('#list input[type="checkbox"][name*="check"]:not(:checked)').length>0);
	});	
	
	// Указать "в фильтре"/"не в фильтре"
	$("a.in_filter").click(function() {
		var icon        = $(this);
		var line        = icon.closest(".row");
		var id          = line.find('input[type="checkbox"][name*="check"]').val();
		var state       = line.hasClass('in_filter')?0:1;
		icon.addClass('loading_icon');
		$.ajax({
			type: 'POST',
			url: 'ajax/update_object.php',
			data: {'object': 'feature', 'id': id, 'values': {'in_filter': state}, 'session_id': '<?php echo $_SESSION['id'];?>
'},
			success: function(data){
				icon.removeClass('loading_icon');
				if(!state)
					line.removeClass('in_filter');
				else
					line.addClass('in_filter');				
			},
			dataType: 'json'
		});	
		return false;	
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
}
?><?php
/* smarty_template_function_categories_tree_3166357ae9cacb5bfc0_50893261 */
if (!function_exists('smarty_template_function_categories_tree_3166357ae9cacb5bfc0_50893261')) {
function smarty_template_function_categories_tree_3166357ae9cacb5bfc0_50893261($_smarty_tpl,$params) {
$saved_tpl_vars = $_smarty_tpl->tpl_vars;
foreach ($params as $key => $value) {
$_smarty_tpl->tpl_vars[$key] = new Smarty_Variable($value);
}?>
        <?php if ($_smarty_tpl->tpl_vars['categories']->value) {?>
            <ul class="cats_right<?php if ($_smarty_tpl->tpl_vars['level']->value > 1) {?> sub_menu<?php }?>" >
                <?php if ($_smarty_tpl->tpl_vars['categories']->value[0]->parent_id == 0) {?>
                    <li <?php if (!$_smarty_tpl->tpl_vars['category']->value->id) {?>class="selected"<?php }?>>
                        <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('category_id'=>null),$_smarty_tpl);?>
">Все категории</a>
                    </li>
                <?php }?>
                <?php
$_from = $_smarty_tpl->tpl_vars['categories']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['c'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['c']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['c']->value) {
$_smarty_tpl->tpl_vars['c']->_loop = true;
$foreach_c_Sav = $_smarty_tpl->tpl_vars['c'];
?>
                    <li <?php if ($_smarty_tpl->tpl_vars['category']->value->id == $_smarty_tpl->tpl_vars['c']->value->id) {?>class="selected"<?php }?>>
                        <a href="index.php?module=FeaturesAdmin&category_id=<?php echo $_smarty_tpl->tpl_vars['c']->value->id;?>
"><?php echo $_smarty_tpl->tpl_vars['c']->value->name;?>
</a>
                        <?php if ($_smarty_tpl->tpl_vars['c']->value->subcategories) {?><span class="slide_menu"></span><?php }?>
                    </li>
                    <?php $_smarty_tpl->callTemplateFunction ('categories_tree', $_smarty_tpl, array('categories'=>$_smarty_tpl->tpl_vars['c']->value->subcategories,'level'=>$_smarty_tpl->tpl_vars['level']->value+1), false);?>

                <?php
$_smarty_tpl->tpl_vars['c'] = $foreach_c_Sav;
}
?>
            </ul>
        <?php }?>
    <?php foreach (Smarty::$global_tpl_vars as $key => $value){
if ($_smarty_tpl->tpl_vars[$key] === $value) $saved_tpl_vars[$key] = $value;
}
$_smarty_tpl->tpl_vars = $saved_tpl_vars;
}
}
/*/ smarty_template_function_categories_tree_3166357ae9cacb5bfc0_50893261 */

?>
