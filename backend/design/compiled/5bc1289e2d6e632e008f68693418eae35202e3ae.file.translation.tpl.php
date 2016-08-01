<?php /* Smarty version Smarty-3.1.18, created on 2016-08-01 17:33:47
         compiled from "backend\design\html\translation.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21956579f5dcb8c63e3-82979886%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5bc1289e2d6e632e008f68693418eae35202e3ae' => 
    array (
      0 => 'backend\\design\\html\\translation.tpl',
      1 => 1467208466,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21956579f5dcb8c63e3-82979886',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'manager' => 0,
    'translation' => 0,
    'message_success' => 0,
    'message_error' => 0,
    'languages' => 0,
    'lang' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_579f5dcb98d797_53231883',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_579f5dcb98d797_53231883')) {function content_579f5dcb98d797_53231883($_smarty_tpl) {?><?php $_smarty_tpl->_capture_stack[0][] = array('tabs', null, null); ob_start(); ?>
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



<script>
$(function() {

	$('textarea').on( "focusout", function(){

	    label = $(this).val();
	    label = label.replace(/[\s]+/gi, '_');
	    label = translit(label);
	    label = label.replace(/[^0-9a-z_\-]+/gi, '').toLowerCase();

    	if(($('input[name="label"]').val() == label || $('input[name="label"]').val() == ''))
            $('input[name="label"]').val(label);
    });

});

function translit(str)
{
	var ru=("А-а-Б-б-В-в-Ґ-ґ-Г-г-Д-д-Е-е-Ё-ё-Є-є-Ж-ж-З-з-И-и-І-і-Ї-ї-Й-й-К-к-Л-л-М-м-Н-н-О-о-П-п-Р-р-С-с-Т-т-У-у-Ф-ф-Х-х-Ц-ц-Ч-ч-Ш-ш-Щ-щ-Ъ-ъ-Ы-ы-Ь-ь-Э-э-Ю-ю-Я-я").split("-")
	var en=("A-a-B-b-V-v-G-g-G-g-D-d-E-e-E-e-E-e-ZH-zh-Z-z-I-i-I-i-I-i-J-j-K-k-L-l-M-m-N-n-O-o-P-p-R-r-S-s-T-t-U-u-F-f-H-h-TS-ts-CH-ch-SH-sh-SCH-sch-'-'-Y-y-'-'-E-e-YU-yu-YA-ya").split("-")
 	var res = '';
	for(var i=0, l=str.length; i<l; i++)
	{
		var s = str.charAt(i), n = ru.indexOf(s);
		if(n >= 0) { res += en[n]; }
		else { res += s; }
    }
    return res;
}
</script>



<?php if ($_smarty_tpl->tpl_vars['translation']->value->id) {?>
<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable($_smarty_tpl->tpl_vars['translation']->value->label, null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>
<?php } else { ?>
<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Новый перевод', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['message_success']->value) {?>
    <!-- Системное сообщение -->
    <div class="message message_success">
        <span><?php if ($_smarty_tpl->tpl_vars['message_success']->value=='added') {?>Перевод добавлен<?php } elseif ($_smarty_tpl->tpl_vars['message_success']->value=='updated') {?>Перевод обновлен<?php }?></span>
        <a class="button" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'TranslationsAdmin'),$_smarty_tpl);?>
">Вернуться</a>
    </div>
    <!-- Системное сообщение (The End)-->
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['message_error']->value) {?>
    <!-- Системное сообщение -->
    <div class="message message_error">
        <span>
        <?php if ($_smarty_tpl->tpl_vars['message_error']->value=='label_empty') {?>Переменная пуста<?php }?>
        <?php if ($_smarty_tpl->tpl_vars['message_error']->value=='label_exists') {?>Переменная уже используется<?php }?>
        <?php if ($_smarty_tpl->tpl_vars['message_error']->value=='label_is_class') {?>Переменная с именем определённым в api/Okay.php не допустима!!!<?php }?>
        </span>
        <a class="button" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'TranslationsAdmin'),$_smarty_tpl);?>
">Вернуться</a>
    </div>
    <!-- Системное сообщение (The End)-->
<?php }?>


<!-- Основная форма -->
<form method=post id=product enctype="multipart/form-data">
<input type=hidden name="session_id" value="<?php echo $_SESSION['id'];?>
">
<input name=id type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['translation']->value->id;?>
"/>

	<div id="column_left">
		<div class="block">
			<h2>Перевод</h2>
            <BR>
			<ul>
				<li><label class=property>Переменная
                        <div class="helper_wrap">
                            <a href="javascript:;" id="show_help_search" class="helper_link"></a>
                            <div class="right helper_block">
                                <span>
                                    Название переменной, которая используется в шаблоне
                                </span>
                            </div>
                        </div>
                    </label>
                    <input name="label" class="okay_inp" type="text" value="<?php echo $_smarty_tpl->tpl_vars['translation']->value->label;?>
" /></li>
                <?php  $_smarty_tpl->tpl_vars['lang'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['lang']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['lang']->key => $_smarty_tpl->tpl_vars['lang']->value) {
$_smarty_tpl->tpl_vars['lang']->_loop = true;
?>
				<li>
                    <label class=property><?php echo $_smarty_tpl->tpl_vars['lang']->value->name;?>
</label>
                    <textarea name="lang_<?php echo $_smarty_tpl->tpl_vars['lang']->value->label;?>
" class="okay_inp"><?php echo $_smarty_tpl->tpl_vars['translation']->value->{'lang_'.$_smarty_tpl->tpl_vars['lang']->value->label};?>
</textarea>
                </li>
                <?php } ?>
			</ul>
		</div>
        <input class="button_green button_save" type="submit" name="" value="Сохранить" />
    </div>

</form>
<!-- Основная форма (The End) -->

<?php }} ?>
