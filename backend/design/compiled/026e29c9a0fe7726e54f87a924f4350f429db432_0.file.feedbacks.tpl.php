<?php /* Smarty version 3.1.27, created on 2016-08-13 07:06:48
         compiled from "backend\design\html\feedbacks.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1947957ae9cd89a0aa8_95397845%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '026e29c9a0fe7726e54f87a924f4350f429db432' => 
    array (
      0 => 'backend\\design\\html\\feedbacks.tpl',
      1 => 1467208466,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1947957ae9cd89a0aa8_95397845',
  'variables' => 
  array (
    'manager' => 0,
    'feedbacks' => 0,
    'keyword' => 0,
    'feedbacks_count' => 0,
    'feedback' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57ae9cd8a63fd3_43776067',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57ae9cd8a63fd3_43776067')) {
function content_57ae9cd8a63fd3_43776067 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '1947957ae9cd89a0aa8_95397845';
?>

<?php $_smarty_tpl->_capture_stack[0][] = array('tabs', null, null); ob_start(); ?>
    <?php if (in_array('comments',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=CommentsAdmin">Комментарии</a>
        </li>
    <?php }?>
    <li class="active">
        <a href="index.php?module=FeedbacksAdmin">Обратная связь</a>
    </li>
    <?php if (in_array('callbacks',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=CallbacksAdmin">Заказ обратного звонка</a>
        </li>
    <?php }?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>


<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_Variable('Обратная связь', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>


<?php if ($_smarty_tpl->tpl_vars['feedbacks']->value || $_smarty_tpl->tpl_vars['keyword']->value) {?>
    <form method="get">
    <div id="search">
        <input type="hidden" name="module" value='FeedbacksAdmin'>
        <input class="search" type="text" name="keyword" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['keyword']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
        <input class="search_button" type="submit" value=""/>
    </div>
    </form>
<?php }?>

<div id="header">
	<?php if ($_smarty_tpl->tpl_vars['feedbacks_count']->value) {?>
	    <h1><?php echo $_smarty_tpl->tpl_vars['feedbacks_count']->value;?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->tpl_vars['feedbacks_count']->value,'сообщение','сообщений','сообщения');?>
</h1>
	<?php } else { ?>
	    <h1>Нет сообщений</h1>
	<?php }?>
</div>

<div id="main_list">
    <?php echo $_smarty_tpl->getSubTemplate ('pagination.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

    <?php if ($_smarty_tpl->tpl_vars['feedbacks']->value) {?>
        <form id="list_form" method="post">
            <input type="hidden" name="session_id" value="<?php echo $_SESSION['id'];?>
">
            <div id="list" style="width:100%;">

                <?php
$_from = $_smarty_tpl->tpl_vars['feedbacks']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['feedback'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['feedback']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['feedback']->value) {
$_smarty_tpl->tpl_vars['feedback']->_loop = true;
$foreach_feedback_Sav = $_smarty_tpl->tpl_vars['feedback'];
?>
                    <div class="<?php if (!$_smarty_tpl->tpl_vars['feedback']->value->processed) {?>unapproved<?php }?> row">
                        <div class="checkbox cell">
                            <input type="checkbox" id="<?php echo $_smarty_tpl->tpl_vars['feedback']->value->id;?>
" name="check[]" value="<?php echo $_smarty_tpl->tpl_vars['feedback']->value->id;?>
"/>
                            <label for="<?php echo $_smarty_tpl->tpl_vars['feedback']->value->id;?>
"></label>
                        </div>
                        <div class="name cell" data-email_name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['feedback']->value->name, ENT_QUOTES, 'UTF-8', true);?>
">
                            <div class='comment_name'>
                                <a href="mailto:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['feedback']->value->name, ENT_QUOTES, 'UTF-8', true);?>
<<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['feedback']->value->email, ENT_QUOTES, 'UTF-8', true);?>
>?subject=Вопрос от пользователя <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['feedback']->value->name, ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['feedback']->value->name, ENT_QUOTES, 'UTF-8', true);?>
 <?php if ($_smarty_tpl->tpl_vars['feedback']->value->email) {?>&nbsp;(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['feedback']->value->email, ENT_QUOTES, 'UTF-8', true);?>
)<?php }?></a>
                                <?php if (!$_smarty_tpl->tpl_vars['feedback']->value->processed) {?>
                                    <a class="approve" href="#">Обработать</a>
                                <?php }?>
                            </div>
                            <div class='comment_text'>
                                <?php echo nl2br(htmlspecialchars($_smarty_tpl->tpl_vars['feedback']->value->message, ENT_QUOTES, 'UTF-8', true));?>

                            </div>
                            <?php if ($_smarty_tpl->tpl_vars['feedback']->value->email) {?>
                                <a href="#feedback_answer" class="answer" data-feedback_id="<?php echo $_smarty_tpl->tpl_vars['feedback']->value->id;?>
">Ответить</a>
                            <?php }?>
                            <div class='comment_info'>
                                Сообщение отправлено <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['feedback']->value->date);?>
 в <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['feedback']->value->date);?>

                            </div>
                        </div>
                        <div class="icons cell">
                            <a href='#' title='Удалить' class="delete"></a>
                        </div>
                        <div class="clear"></div>
                    </div>
                <?php
$_smarty_tpl->tpl_vars['feedback'] = $foreach_feedback_Sav;
}
?>
            </div>

            <div id="action">
                <label id='check_all' class='dash_link'>Выбрать все</label>
                <span id=select>
                    <select name="action">
                        <option value="delete">Удалить</option>
                    </select>
                </span>
                <input id='apply_action' class="button_green" type=submit value="Применить">
            </div>
        </form>
    <?php } else { ?>
        Нет сообщений
    <?php }?>
    <?php echo $_smarty_tpl->getSubTemplate ('pagination.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

</div>
<form id="feedback_answer" style="display: none;" method="post">
    <input type="hidden" name="session_id" value="<?php echo $_SESSION['id'];?>
">
    <h2>Написать ответ</h2>
        <input type="hidden" name="feedback_id" value="" />
        <textarea name="text" rows="10" cols="50"></textarea>
    <br>
    <input class="button" type="submit" name="feedback_answer" value="Отправить" />
</form>

<?php echo '<script'; ?>
 type="text/javascript" src="design/js/fancybox/jquery.fancybox.js"><?php echo '</script'; ?>
>
<link type="text/css" href="design/js/fancybox/jquery.fancybox.css" rel="stylesheet" />
<?php echo '<script'; ?>
>
$(function() {

    $('.answer').click(function() {
        $('input[name="feedback_id"]').val($(this).data('feedback_id'));
        $('#feedback_answer textarea').html($(this).parent().data('email_name')+',');
    });
    $('.answer').fancybox();


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
            data: {'object': 'feedback', 'id': id, 'values': {'processed': 1}, 'session_id': '<?php echo $_SESSION['id'];?>
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

<?php echo '</script'; ?>
>

<?php }
}
?>