<?php /* Smarty version 3.1.27, created on 2016-08-13 00:39:47
         compiled from "backend\design\html\comments\comment_admin.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:106157ae4223579a33_76012434%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e20bdf98afb0e4b1c622b84f39b4d53da891b30a' => 
    array (
      0 => 'backend\\design\\html\\comments\\comment_admin.tpl',
      1 => 1431890433,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '106157ae4223579a33_76012434',
  'variables' => 
  array (
    'manager' => 0,
    'delivery' => 0,
    'comment' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57ae4223606451_31138316',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57ae4223606451_31138316')) {
function content_57ae4223606451_31138316 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '106157ae4223579a33_76012434';
?>

<?php $_smarty_tpl->_capture_stack[0][] = array('tabs', null, null); ob_start(); ?>
	<li class="active"><a href="index.php?module=CommentsAdmin">Комментарии</a></li>
	<?php if (in_array('feedbacks',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?><li><a href="index.php?module=FeedbacksAdmin">Обратная связь</a></li><?php }?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<?php if ($_smarty_tpl->tpl_vars['delivery']->value->id) {?>
<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_Variable('Комментарий от $comment->name', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>
<?php } else { ?>
<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_Variable('...', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>
<?php }?>

<!-- Основная форма -->
<form method=post id=product enctype="multipart/form-data">

	<input type=hidden name="session_id" value="<?php echo $_SESSION['id'];?>
">
	<input name=id type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['comment']->value->id;?>
"/> 

	<div id="name">
		<h2>Комментарий</h2>
		<div class="comment_name"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['comment']->value->name, ENT_QUOTES, 'UTF-8', true);?>
</div>
		<div class="comment_text"><?php echo nl2br(htmlspecialchars($_smarty_tpl->tpl_vars['comment']->value->text, ENT_QUOTES, 'UTF-8', true));?>
</div>
	</div> 

	<!-- Описагние товара -->
	<div class="block layer">
		<h2>Ответ</h2>	
		<textarea name="text" rows="10" style="width: 100%;"></textarea>
	</div>
	<!-- Описание товара (The End)-->
	<input class="button_green button_save" type="submit" name="" value="Сохранить" />
	
</form>
<!-- Основная форма (The End) -->
<?php }
}
?>