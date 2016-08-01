<?php /* Smarty version Smarty-3.1.18, created on 2016-08-01 17:38:25
         compiled from "O:\domains\okay\design\test\html\email_feedback_answer_to_user.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2711579f5ee1e5b9f3-75911901%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ad7fa553e1a772ca53bb434f918cda5f532c0760' => 
    array (
      0 => 'O:\\domains\\okay\\design\\test\\html\\email_feedback_answer_to_user.tpl',
      1 => 1470059634,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2711579f5ee1e5b9f3-75911901',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'feedback' => 0,
    'text' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_579f5ee1ea1f00_82544618',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_579f5ee1ea1f00_82544618')) {function content_579f5ee1ea1f00_82544618($_smarty_tpl) {?>
<?php $_smarty_tpl->tpl_vars['subject'] = new Smarty_variable('Ответ на заявку', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['subject'] = clone $_smarty_tpl->tpl_vars['subject'];?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
</head>
<body>
<h1 style="text-align: center;font: 18px;background: #41ade2;color: #fff;padding: 5px; width: 800px;">
    Вы оставили заявку (<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['feedback']->value->date);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['feedback']->value->date);?>
):
</h1>
<div style="border: 1px dashed #41ade2;padding: 5px;margin-left: 10px;width: 800px;">
    <?php echo nl2br(htmlspecialchars($_smarty_tpl->tpl_vars['feedback']->value->message, ENT_QUOTES, 'UTF-8', true));?>

</div>
<h2>Ответ:</h2>
<div style="border: 1px dashed #41ade2;padding: 5px;margin-left: 10px;width: 800px;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['text']->value, ENT_QUOTES, 'UTF-8', true);?>
</div>
</body>
</html><?php }} ?>
