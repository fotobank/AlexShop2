<?php /* Smarty version 3.1.27, created on 2016-08-14 00:36:09
         compiled from "backend\design\html\templates.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:2028357af92c99fb274_55126495%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c156c951c72699749ece10c99d4e6c7fa277a2bb' => 
    array (
      0 => 'backend\\design\\html\\templates.tpl',
      1 => 1467208466,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2028357af92c99fb274_55126495',
  'variables' => 
  array (
    'manager' => 0,
    'template_file' => 0,
    'theme' => 0,
    'message_error' => 0,
    'templates' => 0,
    't' => 0,
    'template_content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57af92c9a9b514_75386533',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57af92c9a9b514_75386533')) {
function content_57af92c9a9b514_75386533 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '2028357af92c99fb274_55126495';
$_smarty_tpl->_capture_stack[0][] = array('tabs', null, null); ob_start(); ?>
	<li>
        <a href="index.php?module=ThemeAdmin">Тема</a>
    </li>
	<li class="active">
        <a href="index.php?module=TemplatesAdmin">Шаблоны</a>
    </li>
	<li>
        <a href="index.php?module=StylesAdmin">Стили</a>
    </li>
    <li>
        <a href="index.php?module=ScriptsAdmin">Скрипты</a>
    </li>
	<li>
        <a href="index.php?module=ImagesAdmin">Изображения</a>
    </li>
    <?php if (in_array('robots',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=RobotsAdmin">Robots.txt</a>
        </li>
    <?php }?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<?php if ($_smarty_tpl->tpl_vars['template_file']->value) {?>
    <?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_Variable("Шаблон ".((string)$_smarty_tpl->tpl_vars['template_file']->value), null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>
<?php }?>


<link rel="stylesheet" href="design/js/codemirror/lib/codemirror.css">
<link rel="stylesheet" href="design/js/codemirror/theme/monokai.css">

<?php echo '<script'; ?>
 src="design/js/codemirror/lib/codemirror.js"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 src="design/js/codemirror/mode/smarty/smarty.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="design/js/codemirror/mode/smartymixed/smartymixed.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="design/js/codemirror/mode/xml/xml.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="design/js/codemirror/mode/htmlmixed/htmlmixed.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="design/js/codemirror/mode/css/css.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="design/js/codemirror/mode/javascript/javascript.js"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 src="design/js/codemirror/addon/selection/active-line.js"><?php echo '</script'; ?>
>
 

<style type="text/css">

.CodeMirror{
	font-family:'Courier New';
	margin-bottom:10px;
	border:1px solid #c0c0c0;
	background-color: #ffffff;
	height: auto;
	min-height: 300px;
	width:100%;
}
.CodeMirror-scroll
{
	overflow-y: hidden;
	overflow-x: auto;
}
.cm-s-monokai .cm-smarty.cm-tag{color: #ff008a;}
.cm-s-monokai .cm-smarty.cm-string {color: #007000;}
.cm-s-monokai .cm-smarty.cm-variable {color: #ff008a;}
.cm-s-monokai .cm-smarty.cm-variable-2 {color: #ff008a;}
.cm-s-monokai .cm-smarty.cm-variable-3 {color: #ff008a;}
.cm-s-monokai .cm-smarty.cm-property {color: #ff008a;}
.cm-s-monokai .cm-comment {color: #505050;}
.cm-s-monokai .cm-smarty.cm-attribute {color: #ff20Fa;}
</style>

<?php echo '<script'; ?>
>
$(function() {	
	// Сохранение кода аяксом
	function save()
	{
		$('.CodeMirror').css('background-color','#e0ffe0');
		content = editor.getValue();
		
		$.ajax({
			type: 'POST',
			url: 'ajax/save_template.php',
			data: {'content': content, 'theme':'<?php echo $_smarty_tpl->tpl_vars['theme']->value;?>
', 'template': '<?php echo $_smarty_tpl->tpl_vars['template_file']->value;?>
', 'session_id': '<?php echo $_SESSION['id'];?>
'},
			success: function(data){
			
				$('.CodeMirror').animate({'background-color': '#ffffff'});
			},
			dataType: 'json'
		});
	}

	// Нажали кнопку Сохранить
	$('input[name="save"]').click(function() {
		save();
	});
	
	// Обработка ctrl+s
	var isCtrl = false;
	var isCmd = false;
	$(document).keyup(function (e) {
		if(e.which == 17) isCtrl=false;
		if(e.which == 91) isCmd=false;
	}).keydown(function (e) {
		if(e.which == 17) isCtrl=true;
		if(e.which == 91) isCmd=true;
		if(e.which == 83 && (isCtrl || isCmd)) {
			save();
			e.preventDefault();
		}
	});
});
<?php echo '</script'; ?>
>


<h1>Тема <?php echo $_smarty_tpl->tpl_vars['theme']->value;?>
, шаблон <?php echo $_smarty_tpl->tpl_vars['template_file']->value;?>
</h1>

<?php if ($_smarty_tpl->tpl_vars['message_error']->value) {?>
    <!-- Системное сообщение -->
    <div class="message message_error">
        <span class="text">
        <?php if ($_smarty_tpl->tpl_vars['message_error']->value == 'permissions') {?>Установите права на запись для файла <?php echo $_smarty_tpl->tpl_vars['template_file']->value;?>

        <?php } elseif ($_smarty_tpl->tpl_vars['message_error']->value == 'theme_locked') {?>Текущая тема защищена от изменений. Создайте копию темы.
        <?php } else {
echo $_smarty_tpl->tpl_vars['message_error']->value;
}?>
        </span>
    </div>
    <!-- Системное сообщение (The End)-->
<?php }?>

<!-- Список файлов для выбора -->
<div class="block layer">
	<div class="templates_names">
		<?php
$_from = $_smarty_tpl->tpl_vars['templates']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['t'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['t']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['t']->value) {
$_smarty_tpl->tpl_vars['t']->_loop = true;
$foreach_t_Sav = $_smarty_tpl->tpl_vars['t'];
?>
			<a <?php if ($_smarty_tpl->tpl_vars['template_file']->value == $_smarty_tpl->tpl_vars['t']->value) {?>class="selected"<?php }?> href='index.php?module=TemplatesAdmin&file=<?php echo $_smarty_tpl->tpl_vars['t']->value;?>
'><?php echo $_smarty_tpl->tpl_vars['t']->value;?>
</a>
		<?php
$_smarty_tpl->tpl_vars['t'] = $foreach_t_Sav;
}
?>
	</div>
</div>

<?php if ($_smarty_tpl->tpl_vars['template_file']->value) {?>
<div class="block">
<form>
	<textarea id="template_content" name="template_content" style="width:700px;height:500px;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['template_content']->value, ENT_QUOTES, 'UTF-8', true);?>
</textarea>
</form>

<input class="button_green button_save" type="button" name="save" value="Сохранить" />
</div>



<?php echo '<script'; ?>
>
var editor = CodeMirror.fromTextArea(document.getElementById("template_content"), {
		mode: "smartymixed",		
		lineNumbers: true,
		styleActiveLine: true,
		matchBrackets: false,
		enterMode: 'keep',
		indentWithTabs: false,
		indentUnit: 2,
		tabMode: 'classic',
        theme : 'monokai'
	});
<?php echo '</script'; ?>
>


<?php }
}
}
?>