<?php /* Smarty version 3.1.27, created on 2016-08-13 07:06:07
         compiled from "backend\design\html\special.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1119657ae9caf10fc99_83862239%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8945e9aac61b0f60d041a134182702db681304e8' => 
    array (
      0 => 'backend\\design\\html\\special.tpl',
      1 => 1466581588,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1119657ae9caf10fc99_83862239',
  'variables' => 
  array (
    'manager' => 0,
    'product' => 0,
    'special_images' => 0,
    'special' => 0,
    'config' => 0,
    'settings' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57ae9caf1cb4c6_69786675',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57ae9caf1cb4c6_69786675')) {
function content_57ae9caf1cb4c6_69786675 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '1119657ae9caf10fc99_83862239';
$_smarty_tpl->_capture_stack[0][] = array('tabs', null, null); ob_start(); ?>
    <?php if (in_array('products',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
        <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'ProductsAdmin','category_id'=>$_smarty_tpl->tpl_vars['product']->value->category_id,'return'=>null,'brand_id'=>null,'id'=>null),$_smarty_tpl);?>
">Товары</a>
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
    <?php if (in_array('features',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=FeaturesAdmin">Свойства</a>
        </li>
    <?php }?>
    <?php if (in_array('special',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li class="active">
            <a href="index.php?module=SpecialAdmin">Промо-изображения</a>
        </li>
    <?php }?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_Variable('Промо-изображения', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>


<div id="main_list" class="brands">

	<form id="list_form" method="post">
        <input type="hidden" name="session_id" value="<?php echo $_SESSION['id'];?>
"/>
		<div id="list" class="brands">	
			<?php
$_from = $_smarty_tpl->tpl_vars['special_images']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['special'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['special']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['special']->value) {
$_smarty_tpl->tpl_vars['special']->_loop = true;
$foreach_special_Sav = $_smarty_tpl->tpl_vars['special'];
?>
			<div class="row">
                <input type="hidden" name="positions[<?php echo $_smarty_tpl->tpl_vars['special']->value->id;?>
]" value="<?php echo $_smarty_tpl->tpl_vars['special']->value->position;?>
"/>
                <div class="move cell"><div class="move_zone"></div></div>
                
		 		<div class="checkbox cell">
					<input id="special_<?php echo $_smarty_tpl->tpl_vars['special']->value->id;?>
" type="checkbox" name="check[]" value="<?php echo $_smarty_tpl->tpl_vars['special']->value->id;?>
" />
                    <label for="special_<?php echo $_smarty_tpl->tpl_vars['special']->value->id;?>
"></label>
				</div>
                <div class="image cell">
                    <?php if ($_smarty_tpl->tpl_vars['special']->value->filename) {?>
                        <img height="35" width="35" src="../<?php echo $_smarty_tpl->tpl_vars['config']->value->special_images_dir;
echo $_smarty_tpl->tpl_vars['special']->value->filename;?>
" alt="<?php echo $_smarty_tpl->tpl_vars['special']->value->name;?>
" />
                    <?php } else { ?>
                        <img height="35" width="35" src="../design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/images/no_image.png"/>
                    <?php }?>
                </div>
				<div class="cell">
                    <input type="text" name="special[name][<?php echo $_smarty_tpl->tpl_vars['special']->value->id;?>
]" value="<?php echo $_smarty_tpl->tpl_vars['special']->value->name;?>
" /> 	 			
				</div>
				<div class="icons cell">
					<a class="delete"  title="Удалить" href="#"></a>
				</div>
				<div class="clear"></div>
			</div>
			<?php
$_smarty_tpl->tpl_vars['special'] = $foreach_special_Sav;
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
			<input id="apply_action" class="button_green" type="submit" value="Применить"/>
		</div>
	</form>
    
    <form id="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="session_id" value="<?php echo $_SESSION['id'];?>
"/>
		<div id="list2" class="brands">
            <div class="row" style="display: none;" id="new_special">
				<div class="cell">
                    <input type="text" name="new_special[name][]" />
				</div>
                <div class="cell">
                    <input class="upload" name="special_files[]" type="file" />
				</div>
				<div class="clear"></div>
			</div>
            <a href="javascript:;" class="add_special">Добавить промо-изображение</a>
        </div>
        <input id="apply_action" class="button_green" type="submit" value="Добавить"/>
    </form>
</div>


<?php echo '<script'; ?>
>
$(function() {
    
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
    
    var new_special = $('#new_special').clone(true);
	$('#new_special').remove();
    new_special.removeAttr('id');
    $('.add_special').on('click', function() {
        new_item = new_special.clone().appendTo('#list2');
        new_item.show();
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