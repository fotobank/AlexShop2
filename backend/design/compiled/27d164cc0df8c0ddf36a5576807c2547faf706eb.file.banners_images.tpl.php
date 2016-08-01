<?php /* Smarty version Smarty-3.1.18, created on 2016-08-01 16:53:21
         compiled from "backend\design\html\banners_images.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3668579f5451688ee4-18460698%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '27d164cc0df8c0ddf36a5576807c2547faf706eb' => 
    array (
      0 => 'backend\\design\\html\\banners_images.tpl',
      1 => 1466581588,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3668579f5451688ee4-18460698',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'banner' => 0,
    'keyword' => 0,
    'banners_images_count' => 0,
    'banners_images' => 0,
    'banners_image' => 0,
    'config' => 0,
    'banners' => 0,
    'b' => 0,
    'filter' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_579f54517e8832_06949360',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_579f54517e8832_06949360')) {function content_579f54517e8832_06949360($_smarty_tpl) {?>
<?php $_smarty_tpl->_capture_stack[0][] = array('tabs', null, null); ob_start(); ?>
    <li class="active">
        <a href="index.php?module=BannersImagesAdmin">Баннеры</a>
    </li>
    <li>
        <a href="index.php?module=BannersAdmin">Группы баннеров</a>
    </li>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>


<?php if ($_smarty_tpl->tpl_vars['banner']->value) {?>
	<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable($_smarty_tpl->tpl_vars['banner']->value->name, null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>
<?php } else { ?>
	<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Баннеры', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>
<?php }?>


<form method="get">
<div id="search">
	<input type="hidden" name="module" value="BannersImagesAdmin">
	<input class="search" type="text" name="keyword" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['keyword']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
	<input class="search_button" type="submit" value=""/>
</div>
</form>
	

<div id="header">	
	<?php if ($_smarty_tpl->tpl_vars['banners_images_count']->value) {?>
		<?php if ($_smarty_tpl->tpl_vars['banner']->value->name) {?>
			<h1><?php echo $_smarty_tpl->tpl_vars['banner']->value->name;?>
 (<?php echo $_smarty_tpl->tpl_vars['banners_images_count']->value;?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->tpl_vars['banners_images_count']->value,'товар','товаров','товара');?>
)</h1>
		<?php } elseif ($_smarty_tpl->tpl_vars['keyword']->value) {?>
			<h1><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->tpl_vars['banners_images_count']->value,'Найден','Найдено','Найдено');?>
 <?php echo $_smarty_tpl->tpl_vars['banners_images_count']->value;?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->tpl_vars['banners_images_count']->value,'баннер','баннеров','баннера');?>
</h1>
		<?php } else { ?>
			<h1><?php echo $_smarty_tpl->tpl_vars['banners_images_count']->value;?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->tpl_vars['banners_images_count']->value,'баннер','баннеров','баннера');?>
</h1>
		<?php }?>		
	<?php } else { ?>
		<h1>Нет баннеров</h1>
	<?php }?>
	<a class="add" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'BannersImageAdmin','return'=>$_SERVER['REQUEST_URI']),$_smarty_tpl);?>
">Добавить баннер</a>
</div>

<div id="main_list">
    <?php echo $_smarty_tpl->getSubTemplate ('pagination.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <?php if ($_smarty_tpl->tpl_vars['banners_images']->value) {?>
        
        <form id="list_form" method="post">
            <input type="hidden" name="session_id" value="<?php echo $_SESSION['id'];?>
">
            <div id="list">
                <?php  $_smarty_tpl->tpl_vars['banners_image'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['banners_image']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['banners_images']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['banners_image']->key => $_smarty_tpl->tpl_vars['banners_image']->value) {
$_smarty_tpl->tpl_vars['banners_image']->_loop = true;
?>
                    <div class="<?php if (!$_smarty_tpl->tpl_vars['banners_image']->value->visible) {?>invisible<?php }?> <?php if ($_smarty_tpl->tpl_vars['banners_image']->value->featured) {?>featured<?php }?> row">
                        <input type="hidden" name="positions[<?php echo $_smarty_tpl->tpl_vars['banners_image']->value->id;?>
]" value="<?php echo $_smarty_tpl->tpl_vars['banners_image']->value->position;?>
">
                        <div class="move cell">
                            <div class="move_zone"></div>
                        </div>
                        <div class="checkbox cell">
                            <input type="checkbox" id="<?php echo $_smarty_tpl->tpl_vars['banners_image']->value->id;?>
" name="check[]" value="<?php echo $_smarty_tpl->tpl_vars['banners_image']->value->id;?>
"/>
                            <label for="<?php echo $_smarty_tpl->tpl_vars['banners_image']->value->id;?>
"></label>
                        </div>
                        <div class="image cell">
                            <?php if ($_smarty_tpl->tpl_vars['banners_image']->value->image) {?>
                                <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'BannersImageAdmin','id'=>$_smarty_tpl->tpl_vars['banners_image']->value->id,'return'=>$_SERVER['REQUEST_URI']),$_smarty_tpl);?>
">
                                    <img src="../<?php echo $_smarty_tpl->tpl_vars['config']->value->banners_images_dir;?>
<?php echo $_smarty_tpl->tpl_vars['banners_image']->value->image;?>
" width="30px"/>
                                </a>
                            <?php }?>
                        </div>
                        <div class="name cell">
                            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'BannersImageAdmin','id'=>$_smarty_tpl->tpl_vars['banners_image']->value->id,'return'=>$_SERVER['REQUEST_URI']),$_smarty_tpl);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['banners_image']->value->name, ENT_QUOTES, 'UTF-8', true);?>
</a>
                        </div>
                        <div class="icons cell banner">
                            <a class="enable" title="Активен" href="#"></a>
                            <a class="delete" title="Удалить" href="#"></a>
                        </div>
                        <div class="icons cell">
                            <?php if ($_smarty_tpl->tpl_vars['banners']->value) {?>
                                <select name=image_banners[<?php echo $_smarty_tpl->tpl_vars['banners_image']->value->id;?>
] style="width:150px;">
                                    <?php  $_smarty_tpl->tpl_vars['b'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['b']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['banners']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['b']->key => $_smarty_tpl->tpl_vars['b']->value) {
$_smarty_tpl->tpl_vars['b']->_loop = true;
?>
                                        <option value="<?php echo $_smarty_tpl->tpl_vars['b']->value->id;?>
"<?php if ($_smarty_tpl->tpl_vars['b']->value->id==$_smarty_tpl->tpl_vars['banners_image']->value->banner_id) {?> selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['b']->value->name;?>
</option>
                                    <?php } ?>
                                </select>
                            <?php }?>
                        </div>
                        <div class="clear"></div>
                    </div>
                <?php } ?>
            </div>

            <div id="action">
                <label id="check_all" class="dash_link">Выбрать все</label>
                <span id="select">
                    <select name="action">
                        <option value="enable">Сделать видимыми</option>
                        <option value="disable">Сделать невидимыми</option>
                        <option value="duplicate">Создать дубликат</option>
                        <?php if (count($_smarty_tpl->tpl_vars['banners']->value)>1) {?>
                            <option value="move_to_banner">Переместить в группу</option>
                        <?php }?>
                        <option value="delete">Удалить</option>
                    </select>
                </span>
                <span id="move_to_banner">
                    <select name="target_banner">
                        <?php  $_smarty_tpl->tpl_vars['b'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['b']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['banners']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['b']->key => $_smarty_tpl->tpl_vars['b']->value) {
$_smarty_tpl->tpl_vars['b']->_loop = true;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['b']->value->id;?>
"<?php if ($_smarty_tpl->tpl_vars['b']->value->id==$_smarty_tpl->tpl_vars['banners_image']->value->banner_id) {?> selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['b']->value->name;?>
</option>
                        <?php } ?>
                    </select>
                </span>
                <input id="apply_action" class="button_green" type="submit" value="Применить">
            </div>
        </form>
    <?php }?>

    <?php echo $_smarty_tpl->getSubTemplate ('pagination.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</div>

<div id="right_menu">

    <ul>
        <li <?php if (!$_smarty_tpl->tpl_vars['filter']->value) {?>class="selected"<?php }?>>
            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('brand_id'=>null,'banner_id'=>null,'keyword'=>null,'page'=>null,'filter'=>null),$_smarty_tpl);?>
">Все баннеры</a>
        </li>
        <li <?php if ($_smarty_tpl->tpl_vars['filter']->value=='visible') {?>class="selected"<?php }?>>
            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('keyword'=>null,'brand_id'=>null,'banner_id'=>null,'page'=>null,'filter'=>'visible'),$_smarty_tpl);?>
">Активные</a>
        </li>
        <li <?php if ($_smarty_tpl->tpl_vars['filter']->value=='hidden') {?>class="selected"<?php }?>>
            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('keyword'=>null,'brand_id'=>null,'banner_id'=>null,'page'=>null,'filter'=>'hidden'),$_smarty_tpl);?>
">Неактивные</a>
        </li>
    </ul>

	<?php if ($_smarty_tpl->tpl_vars['banners']->value) {?>
	<ul>
		<li <?php if (!$_smarty_tpl->tpl_vars['banner']->value->id) {?>class="selected"<?php }?>>
            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('banner_id'=>null,'brand_id'=>null),$_smarty_tpl);?>
">Все группы</a>
        </li>
		<?php  $_smarty_tpl->tpl_vars['b'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['b']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['banners']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['b']->key => $_smarty_tpl->tpl_vars['b']->value) {
$_smarty_tpl->tpl_vars['b']->_loop = true;
?>
		<li banner_id="<?php echo $_smarty_tpl->tpl_vars['b']->value->id;?>
" <?php if ($_smarty_tpl->tpl_vars['banner']->value->id==$_smarty_tpl->tpl_vars['b']->value->id) {?>class="selected"<?php } else { ?>class="droppable"<?php }?>>
            <a href='<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['b']->value->id;?>
<?php $_tmp1=ob_get_clean();?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('keyword'=>null,'page'=>null,'banner_id'=>$_tmp1),$_smarty_tpl);?>
'><?php echo $_smarty_tpl->tpl_vars['b']->value->name;?>
</a>
        </li>
		<?php } ?>
	</ul>
	<?php }?>
</div>


<script>

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
	

	// Перенос товара в другую категорию
	$("#action select[name=action]").change(function() {
		if($(this).val() == 'move_to_banner')
			$("span#move_to_banner").show();
		else
			$("span#move_to_banner").hide();
	});
	$("#right_menu .droppable.banner").droppable({
		activeClass: "drop_active",
		hoverClass: "drop_hover",
		tolerance: "pointer",
		drop: function(event, ui){
			$(ui.helper).find('input[type="checkbox"][name*="check"]').attr('checked', true);
			$(ui.draggable).closest("form").find('select[name="action"] option[value=move_to_banner]').attr("selected", "selected");	
			$(ui.draggable).closest("form").find('select[name=target_banner] option[value='+$(this).attr('banner_id')+']').attr("selected", "selected");
			$(ui.draggable).closest("form").submit();
			return false;			
		}
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
			data: {'object': 'banners_image', 'id': id, 'values': {'visible': state}, 'session_id': '<?php echo $_SESSION['id'];?>
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


	// Подтверждение удаления
	$("form").submit(function() {
		if($('select[name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
			return false;	
	});
	
});

</script>

<?php }} ?>
