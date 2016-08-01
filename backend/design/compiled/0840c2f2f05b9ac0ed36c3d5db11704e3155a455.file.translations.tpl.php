<?php /* Smarty version Smarty-3.1.18, created on 2016-08-01 17:27:08
         compiled from "backend\design\html\translations.tpl" */ ?>
<?php /*%%SmartyHeaderCode:30086579f5c3c3f0966-04720368%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0840c2f2f05b9ac0ed36c3d5db11704e3155a455' => 
    array (
      0 => 'backend\\design\\html\\translations.tpl',
      1 => 1467208466,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '30086579f5c3c3f0966-04720368',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'manager' => 0,
    'sort' => 0,
    'translations' => 0,
    'translation' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_579f5c3c4e2ca8_56427084',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_579f5c3c4e2ca8_56427084')) {function content_579f5c3c4e2ca8_56427084($_smarty_tpl) {?><?php $_smarty_tpl->_capture_stack[0][] = array('tabs', null, null); ob_start(); ?>
	<?php if (in_array('settings',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=SettingsAdmin">Настройки</a>
        </li>
    <?php }?>
	<?php if (in_array('currency',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=CurrencyAdmin">Валюты</a>
        </li>
    <?php }?>
	<?php if (in_array('delivery',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=DeliveriesAdmin">Доставка</a>
        </li>
    <?php }?>
	<?php if (in_array('payment',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=PaymentMethodsAdmin">Оплата</a>
        </li>
    <?php }?>
	<?php if (in_array('managers',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=ManagersAdmin">Менеджеры</a>
        </li>
    <?php }?>
    <?php if (in_array('languages',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=LanguagesAdmin">Языки</a>
        </li>
    <?php }?>
	<li class="active">
        <a href="index.php?module=TranslationsAdmin">Переводы</a>
    </li>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>


<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Переводы', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>


<div id="header">
	<h1>Переводы</h1>
	<a class="add" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'TranslationAdmin'),$_smarty_tpl);?>
">Добавить перевод</a>
</div>

<div id="main_list">
    <div>Сортировка переводов:</div>
    <ul class="sort_translation">
        <li>
            <a <?php if ($_smarty_tpl->tpl_vars['sort']->value=='translation'||$_smarty_tpl->tpl_vars['sort']->value=='translation_desc') {?> class="selected" <?php }?> href="<?php if ($_smarty_tpl->tpl_vars['sort']->value=='translation') {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('sort'=>'translation_desc'),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('sort'=>'translation'),$_smarty_tpl);?>
<?php }?>">По переводу &nbsp;<?php if ($_smarty_tpl->tpl_vars['sort']->value=='translation_desc') {?>&#8659;<?php } else { ?>&#8657;<?php }?></a>
        </li>
        <li>
            <a <?php if ($_smarty_tpl->tpl_vars['sort']->value=='date'||$_smarty_tpl->tpl_vars['sort']->value=='date_desc') {?> class="selected" <?php }?>href="<?php if ($_smarty_tpl->tpl_vars['sort']->value=='date') {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('sort'=>'date_desc'),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('sort'=>'date'),$_smarty_tpl);?>
<?php }?>">По новизне &nbsp;<?php if ($_smarty_tpl->tpl_vars['sort']->value=='date_desc') {?>&#8659;<?php } else { ?>&#8657;<?php }?></a>
        </li>
        <li>
            <a <?php if ($_smarty_tpl->tpl_vars['sort']->value=='label'||$_smarty_tpl->tpl_vars['sort']->value=='label_desc'||!$_smarty_tpl->tpl_vars['sort']->value) {?> class="selected" <?php }?>href="<?php if ($_smarty_tpl->tpl_vars['sort']->value=='label'||!$_smarty_tpl->tpl_vars['sort']->value) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('sort'=>'label_desc'),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('sort'=>null),$_smarty_tpl);?>
<?php }?>">По переменной &nbsp;<?php if ($_smarty_tpl->tpl_vars['sort']->value=='label_desc') {?>&#8659;<?php } else { ?>&#8657;<?php }?></a>
        </li>
    </ul>
	<form id="list_form" method="post">
        <input type="hidden" name="session_id" value="<?php echo $_SESSION['id'];?>
">

        <div id="list">

            <?php  $_smarty_tpl->tpl_vars['translation'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['translation']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['translations']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['translation']->key => $_smarty_tpl->tpl_vars['translation']->value) {
$_smarty_tpl->tpl_vars['translation']->_loop = true;
?>
                <div class="<?php if (!$_smarty_tpl->tpl_vars['translation']->value->enabled) {?>invisible<?php }?> row">
                    <div class="checkbox cell">
                        <input type="checkbox" id="<?php echo $_smarty_tpl->tpl_vars['translation']->value->id;?>
" name="check[]" value="<?php echo $_smarty_tpl->tpl_vars['translation']->value->id;?>
" />
                        <label for="<?php echo $_smarty_tpl->tpl_vars['translation']->value->id;?>
"></label>
                    </div>
                    <div class="name cell">
                        <span style='width:350px;display:inline-block;overflow:hidden'>
                            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'TranslationAdmin','id'=>$_smarty_tpl->tpl_vars['translation']->value->id,'return'=>$_SERVER['REQUEST_URI']),$_smarty_tpl);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['translation']->value->value, ENT_QUOTES, 'UTF-8', true);?>
</a>
                        </span>
                         <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'TranslationAdmin','id'=>$_smarty_tpl->tpl_vars['translation']->value->id,'return'=>$_SERVER['REQUEST_URI']),$_smarty_tpl);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['translation']->value->label, ENT_QUOTES, 'UTF-8', true);?>
</a>
                    </div>
                    <div class="icons cell">
                        <a class="delete" title="Удалить" href="#"></a>
                    </div>
                    <div class="clear"></div>
                </div>
            <?php } ?>
        </div>

        <div id="action">
        <label id="check_all" class='dash_link'>Выбрать все</label>
        <span id="select">
            <select name="action">
                <option value="delete">Удалить</option>
            </select>
        </span>
        <input id="apply_action" class="button_green" type="submit" value="Применить">
        </div>
	</form>

</div>


<script>
$(function() {

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
		$(this).closest(".row").find('input[type="checkbox"][name*="check"]').attr('checked', true);
		$(this).closest("form").find('select[name="action"] option[value=delete]').attr('selected', true);
		$(this).closest("form").submit();
	});
	
	$("form").submit(function() {
		if($('select[name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
			return false;	
	});


});

</script>

<?php }} ?>
