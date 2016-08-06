<?php
/* Smarty version 3.1.29, created on 2016-08-05 15:33:58
  from "O:\domains\okay\backend\design\html\license.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57a487b6b563a7_47241318',
  'file_dependency' => 
  array (
    '1a20c46f984426499608b4fcfb6ca2d619517537' => 
    array (
      0 => 'O:\\domains\\okay\\backend\\design\\html\\license.tpl',
      1 => 1470387428,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57a487b6b563a7_47241318 ($_smarty_tpl) {
$_smarty_tpl->_cache['capture_stack'][] = array('tabs', null, null); ob_start(); ?>
		<li class="active">
            <a href="index.php?module=LicenseAdmin">Лицензия</a>
        </li>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_cache['capture_stack']);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
$_smarty_tpl->_cache['__smarty_capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<!-- Основная форма -->
<form method=post id=product enctype="multipart/form-data">
<input type=hidden name="session_id" value="<?php echo $_SESSION['id'];?>
">
	<!-- Левая колонка свойств товара -->
	<div id="column_left">
 	
	<div class=block>
		<?php if ($_smarty_tpl->tpl_vars['license']->value->valid) {?>	
		    <h2 style='color:green;'>Лицензия действительна <?php if ($_smarty_tpl->tpl_vars['license']->value->expiration != '*') {?>до <?php echo $_smarty_tpl->tpl_vars['license']->value->expiration;
}?> для домен<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier(count($_smarty_tpl->tpl_vars['license']->value->domains),'а','ов');?>
 <?php
$_from = $_smarty_tpl->tpl_vars['license']->value->domains;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_d_0_saved_item = isset($_smarty_tpl->tpl_vars['d']) ? $_smarty_tpl->tpl_vars['d'] : false;
$__foreach_d_0_total = $_smarty_tpl->smarty->ext->_foreach->count($_from);
$_smarty_tpl->tpl_vars['d'] = new Smarty_Variable();
$__foreach_d_0_iteration=0;
$_smarty_tpl->tpl_vars['d']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['d']->value) {
$_smarty_tpl->tpl_vars['d']->_loop = true;
$__foreach_d_0_iteration++;
$_smarty_tpl->tpl_vars['d']->last = $__foreach_d_0_iteration == $__foreach_d_0_total;
$__foreach_d_0_saved_local_item = $_smarty_tpl->tpl_vars['d'];
echo $_smarty_tpl->tpl_vars['d']->value;
if (!$_smarty_tpl->tpl_vars['d']->last) {?>, <?php }
$_smarty_tpl->tpl_vars['d'] = $__foreach_d_0_saved_local_item;
}
if ($__foreach_d_0_saved_item) {
$_smarty_tpl->tpl_vars['d'] = $__foreach_d_0_saved_item;
}
?></h2>
		<?php } else { ?>
		    <h2 style='color:red;'>Лицензия недействительна</h2>
		<?php }?>
		<textarea name=license style='width:420px; height:100px;'><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['config']->value->license, ENT_QUOTES, 'UTF-8', true);?>
</textarea>
		</div>
		<div class=block>	
		    <input class="button_green button_save" type="submit" name="" value="Сохранить" />
		    <a href='http://alexshop-sms.com/check?domain=<?php echo htmlspecialchars($_SERVER['HTTP_HOST'], ENT_QUOTES, 'UTF-8', true);?>
'>Проверить лицензию</a>
		</div>
	</div>

	<div id="column_right">
		<div class=block>
		<h2>Лицензионное соглашение</h2>

        <textarea style='width:420px; height:250px;'>
           1. Общие положения

        1.1. Настоящее Лицензионное соглашение (далее Соглашение) является публичной офертой и заключается между пользователем программного продукта "AlexShopCMS" (далее Пользователь) и обществом с ограниченной ответственностью "Шифтрезет" (далее Разработчик).
        1.2. Перед использованием Продукта внимательно ознакомьтесь с условиями данного Соглашения. В случае несогласия, Пользователь вправе отказаться от услуг, предоставляемых разработчиком и не использовать программный продукт AlexShopCMS.
        1.3. Продукт содержит компоненты, на которые не распространяется действие настоящего Соглашения. Эти компоненты предоставляются и распространяются свободно в соответствии с собственными лицензиями. Таковыми компонентами являются:

        - Визуальный редактор TinyMCE;
        - Файловый менеджер SMExplorer;
        - Менеджер изображений SMImage;
        - Редактор кода Codemirror;
        - Скрипт просмотра изображений EnlargeIt.
        </textarea>
		</div> 
	</div>
	<!-- Левая колонка свойств товара (The End)-->
</form>
<!-- Основная форма (The End) -->
<?php }
}
