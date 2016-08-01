<?php /* Smarty version Smarty-3.1.18, created on 2016-08-01 17:23:08
         compiled from "backend\design\html\delivery.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20408579f5b4c71a4b2-06158600%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dbbbf6ec9f7ec19468c03fae1083bffc869ab5ec' => 
    array (
      0 => 'backend\\design\\html\\delivery.tpl',
      1 => 1466581588,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20408579f5b4c71a4b2-06158600',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'manager' => 0,
    'delivery' => 0,
    'languages' => 0,
    'message_success' => 0,
    'message_error' => 0,
    'lang_id' => 0,
    'currency' => 0,
    'config' => 0,
    'payment_methods' => 0,
    'payment_method' => 0,
    'delivery_payments' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_579f5b4c823ef2_09014543',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_579f5b4c823ef2_09014543')) {function content_579f5b4c823ef2_09014543($_smarty_tpl) {?>
<?php $_smarty_tpl->_capture_stack[0][] = array('tabs', null, null); ob_start(); ?>
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
	<li class="active">
        <a href="index.php?module=DeliveriesAdmin">Доставка</a>
    </li>
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
    <?php if (in_array('languages',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=TranslationsAdmin">Переводы</a>
        </li>
    <?php }?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<?php if ($_smarty_tpl->tpl_vars['delivery']->value->id) {?>
    <?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable($_smarty_tpl->tpl_vars['delivery']->value->name, null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>
<?php } else { ?>
    <?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Новый способ доставки', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>
<?php }?>

<?php echo $_smarty_tpl->getSubTemplate ('tinymce_init.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>



<script>
    $(window).on("load", function() {

        // Удаление изображений
        $(".images a.delete").click(function () {
            $("input[name='delete_image']").val('1');
            $(this).closest("ul").fadeOut(200, function () {
                $(this).remove();
            });
            return false;
        });
    });
</script>


<?php if ($_smarty_tpl->tpl_vars['languages']->value) {?><?php echo $_smarty_tpl->getSubTemplate ('include_languages.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['message_success']->value) {?>
    <!-- Системное сообщение -->
    <div class="message message_success">
        <span class="text"><?php if ($_smarty_tpl->tpl_vars['message_success']->value=='added') {?>Способ доставки добавлен<?php } elseif ($_smarty_tpl->tpl_vars['message_success']->value=='updated') {?>Способ доставки изменен<?php }?></span>
        <?php if ($_GET['return']) {?>
        <a class="button" href="<?php echo $_GET['return'];?>
">Вернуться</a>
        <?php }?>
    </div>
    <!-- Системное сообщение (The End)-->
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['message_error']->value) {?>
    <!-- Системное сообщение -->
    <div class="message message_error">
        <span class="text"><?php if ($_smarty_tpl->tpl_vars['message_error']->value=='empty_name') {?>Введите название<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['message_error']->value;?>
<?php }?></span>
        <a class="button" href="">Вернуться</a>
    </div>
    <!-- Системное сообщение (The End)-->
<?php }?>


<!-- Основная форма -->
<form method=post id=product enctype="multipart/form-data">
    <input type=hidden name="session_id" value="<?php echo $_SESSION['id'];?>
">
    <input type="hidden" name="lang_id" value="<?php echo $_smarty_tpl->tpl_vars['lang_id']->value;?>
" />
	<div id="name">
		<input class="name" name=name type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['delivery']->value->name, ENT_QUOTES, 'UTF-8', true);?>
"/> 
		<input name=id type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['delivery']->value->id;?>
"/> 
		<div class="checkbox">
			<input name=enabled value='1' type="checkbox" id="active_checkbox" <?php if ($_smarty_tpl->tpl_vars['delivery']->value->enabled) {?>checked<?php }?>/>
            <label class="visible_icon" for="active_checkbox">Активен</label>
		</div>
	</div> 

	<!-- Левая колонка свойств товара -->
	<div id="column_left">
		<!-- Параметры страницы -->
		<div class="block layer">
			<h2>Стоимость доставки</h2>
			<ul>
				<li><label class=property>Стоимость</label><input name="price" class="okay_small_inp" type="text" value="<?php echo $_smarty_tpl->tpl_vars['delivery']->value->price;?>
" /> <?php echo $_smarty_tpl->tpl_vars['currency']->value->sign;?>
</li>
				<li><label class=property>Бесплатна от</label><input name="free_from" class="okay_small_inp" type="text" value="<?php echo $_smarty_tpl->tpl_vars['delivery']->value->free_from;?>
" /> <?php echo $_smarty_tpl->tpl_vars['currency']->value->sign;?>
</li>
				<li><label class=property for="separate_payment">Оплачивается отдельно</label><input id="separate_payment" name="separate_payment" type="checkbox" value="1" <?php if ($_smarty_tpl->tpl_vars['delivery']->value->separate_payment) {?>checked=""<?php }?> /></li>
			</ul>
		</div>
		<!-- Параметры страницы (The End)-->

	</div>
	<!-- Левая колонка свойств товара (The End)--> 
	
	<!-- Левая колонка свойств товара -->
	<div id="column_right">
        <div class="block layer images">
            <h2>Изображение</h2>
            <input class='upload_image' name="image" type="file"/>
            <input type="hidden" name="delete_image" value=""/>
            <?php if ($_smarty_tpl->tpl_vars['delivery']->value->image) {?>
                <ul>
                    <li>
                        <a href='#' class="delete"></a>
                        <img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['resize'][0][0]->resize_modifier($_smarty_tpl->tpl_vars['delivery']->value->image,100,100,false,$_smarty_tpl->tpl_vars['config']->value->resized_deliveries_dir);?>
" alt="" />
                    </li>
                </ul>
            <?php }?>
        </div>

		<div class="block layer">
		<h2>Возможные способы оплаты</h2>
		<ul>
		<?php  $_smarty_tpl->tpl_vars['payment_method'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['payment_method']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['payment_methods']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['payment_method']->key => $_smarty_tpl->tpl_vars['payment_method']->value) {
$_smarty_tpl->tpl_vars['payment_method']->_loop = true;
?>
			<li>
			<input type=checkbox name="delivery_payments[]" id="payment_<?php echo $_smarty_tpl->tpl_vars['payment_method']->value->id;?>
" value='<?php echo $_smarty_tpl->tpl_vars['payment_method']->value->id;?>
' <?php if (in_array($_smarty_tpl->tpl_vars['payment_method']->value->id,$_smarty_tpl->tpl_vars['delivery_payments']->value)) {?>checked<?php }?>> <label for="payment_<?php echo $_smarty_tpl->tpl_vars['payment_method']->value->id;?>
"><?php echo $_smarty_tpl->tpl_vars['payment_method']->value->name;?>
</label><br>
			</li>
		<?php } ?>
		</ul>		
		</div>
	</div>
	<!-- Левая колонка свойств товара (The End)--> 
	
	<!-- Описагние товара -->
	<div class="block layer">
		<h2>Описание</h2>
		<textarea name="description" class="editor_small"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['delivery']->value->description, ENT_QUOTES, 'UTF-8', true);?>
</textarea>
	</div>
	<!-- Описание товара (The End)-->
	<input class="button_green button_save" type="submit" name="" value="Сохранить" />
	
</form>
<!-- Основная форма (The End) -->

<?php }} ?>
