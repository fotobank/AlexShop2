<?php /* Smarty version Smarty-3.1.18, created on 2016-08-01 16:55:53
         compiled from "backend\design\html\callbacks.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10822579f54e99b8300-76430131%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9dbf1c8d9ee6b84474a0d8543efabe2aed4765af' => 
    array (
      0 => 'backend\\design\\html\\callbacks.tpl',
      1 => 1467208466,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10822579f54e99b8300-76430131',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'manager' => 0,
    'callbacks' => 0,
    'callback' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_579f54e9a67fa3_44334764',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_579f54e9a67fa3_44334764')) {function content_579f54e9a67fa3_44334764($_smarty_tpl) {?>
<?php $_smarty_tpl->_capture_stack[0][] = array('tabs', null, null); ob_start(); ?>
    <?php if (in_array('comments',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=CommentsAdmin">Комментарии</a>
        </li>
    <?php }?>
    <?php if (in_array('feedbacks',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=FeedbacksAdmin">Обратная связь</a>
        </li>
    <?php }?>
    <li class="active">
        <a href="index.php?module=CallbacksAdmin">Заказ обратного звонка</a>
    </li>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>


<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Заказ обратного звонка', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>

<div id="header">
	<?php if (count($_smarty_tpl->tpl_vars['callbacks']->value)>0) {?>
	    <h1><?php echo count($_smarty_tpl->tpl_vars['callbacks']->value);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier(count($_smarty_tpl->tpl_vars['callbacks']->value),'заказ','заказов','заказа');?>
</h1>
	<?php } else { ?>
	    <h1>Нет заказов</h1>
	<?php }?>
</div>

<div id="main_list">
    <?php echo $_smarty_tpl->getSubTemplate ('pagination.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <?php if ($_smarty_tpl->tpl_vars['callbacks']->value) {?>
        <form id="list_form" method="post">
            <input type="hidden" name="session_id" value="<?php echo $_SESSION['id'];?>
"/>
            <div id="list" class="sortable">
                <?php  $_smarty_tpl->tpl_vars['callback'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['callback']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['callbacks']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['callback']->key => $_smarty_tpl->tpl_vars['callback']->value) {
$_smarty_tpl->tpl_vars['callback']->_loop = true;
?>
                    <div class="<?php if (!$_smarty_tpl->tpl_vars['callback']->value->processed) {?>unapproved<?php }?> row">
                        <div class="checkbox cell">
                            <input type="checkbox" id="<?php echo $_smarty_tpl->tpl_vars['callback']->value->id;?>
" name="check[]" value="<?php echo $_smarty_tpl->tpl_vars['callback']->value->id;?>
"/>
                            <label for="<?php echo $_smarty_tpl->tpl_vars['callback']->value->id;?>
"></label>
                        </div>
                        <div class="name cell">
                            <div class='comment_name'>
                                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['callback']->value->name, ENT_QUOTES, 'UTF-8', true);?>

                                <a class="approve" href="#">Обработать</a>
                            </div>
                            <div class='comment_text'>
                                Телефон: <?php echo nl2br(htmlspecialchars($_smarty_tpl->tpl_vars['callback']->value->phone, ENT_QUOTES, 'UTF-8', true));?>

                            </div>
                            <?php if ($_smarty_tpl->tpl_vars['callback']->value->message) {?>
                                <div class='comment_text'>
                                    Сообщение: <?php echo nl2br(htmlspecialchars($_smarty_tpl->tpl_vars['callback']->value->message, ENT_QUOTES, 'UTF-8', true));?>

                                </div>
                            <?php }?>
                            <div class='comment_text'>
                                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['callback']->value->url, ENT_QUOTES, 'UTF-8', true);?>
" target="_blank">Страница с которой было отправлено</a>
                            </div>
                            <div class='comment_info'>
                                Заявка отправлена <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['callback']->value->date);?>
 в <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['callback']->value->date);?>

                            </div>
                        </div>
                        <div class="icons cell">
                            <a href='#' title='Удалить' class="delete"></a>
                        </div>
                        <div class="clear"></div>
                    </div>
                <?php } ?>
            </div>

            <div id="action">
                <label id='check_all' class='dash_link'>Выбрать все</label>
                <span id=select>
                    <select name="action">
                        <option value="processed">Отметить как обработанные</option>
                        <option value="delete">Удалить</option>
                    </select>
                </span>
                <input id='apply_action' class="button_green" type=submit value="Применить">
            </div>
        </form>
    <?php } else { ?>
        Нет сообщений
    <?php }?>
    <?php echo $_smarty_tpl->getSubTemplate ('pagination.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

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
	
	// Обработать
	$("a.approve").click(function() {
		var line        = $(this).closest(".row");
		var id          = line.find('input[type="checkbox"][name*="check"]').val();
		line.addClass('loading_icon');
		$.ajax({
			type: 'POST',
			url: 'ajax/update_object.php',
			data: {'object': 'callback', 'id': id, 'values': {'processed': 1}, 'session_id': '<?php echo $_SESSION['id'];?>
'},
			success: function(data){
				line.removeClass('loading_icon');
                line.removeClass('unapproved');
			},
			dataType: 'json'
		});	
		return false;	
	});
	
	// Подтверждение удаления
	$("form#list_form").submit(function() {
		if($('select[name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
			return false;	
	});

});

</script>

<?php }} ?>
