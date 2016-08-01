<?php /* Smarty version Smarty-3.1.18, created on 2016-08-01 16:53:30
         compiled from "backend\design\html\banners_image.tpl" */ ?>
<?php /*%%SmartyHeaderCode:25085579f545a104cc1-35071873%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '01ec51a52e755549ed6558f7fe633e02b95f5472' => 
    array (
      0 => 'backend\\design\\html\\banners_image.tpl',
      1 => 1466581588,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '25085579f545a104cc1-35071873',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'banners_image' => 0,
    'languages' => 0,
    'message_success' => 0,
    'message_error' => 0,
    'lang_id' => 0,
    'banners' => 0,
    'banner' => 0,
    'config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_579f545a1d7bf6_79541541',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_579f545a1d7bf6_79541541')) {function content_579f545a1d7bf6_79541541($_smarty_tpl) {?>
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

<?php if ($_smarty_tpl->tpl_vars['banners_image']->value->id) {?>
    <?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable($_smarty_tpl->tpl_vars['banners_image']->value->name, null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>
<?php } else { ?>
    <?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Добавить баннер', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>
<?php }?>



<script>
$(function() {

	// Удаление изображений
	$(".images a.delete").click( function() {
		$("input[name='delete_image']").val('1');
		$(this).closest("ul").fadeOut(200, function() { $(this).remove(); });
		return false;
	});
	  
});
</script>
 


<?php if ($_smarty_tpl->tpl_vars['languages']->value) {?><?php echo $_smarty_tpl->getSubTemplate ('include_languages.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('id'=>$_smarty_tpl->tpl_vars['banners_image']->value->id), 0);?>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['message_success']->value) {?>
    <!-- Системное сообщение -->
    <div class="message message_success">
        <span class="text"><?php if ($_smarty_tpl->tpl_vars['message_success']->value=='added') {?>Баннер добавлен<?php } elseif ($_smarty_tpl->tpl_vars['message_success']->value=='updated') {?>Баннер обновлен<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['message_success']->value;?>
<?php }?></span>
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
		<input class="name" name=name type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['banners_image']->value->name, ENT_QUOTES, 'UTF-8', true);?>
"/> 
		<input name=id type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['banners_image']->value->id;?>
"/> 
		<div class="checkbox">
			<input name=visible value='1' type="checkbox" id="active_checkbox" <?php if ($_smarty_tpl->tpl_vars['banners_image']->value->visible) {?>checked<?php }?>/>
            <label class="visible_icon" for="active_checkbox">Активен</label>
        </div>
	</div> 
	
	<?php if ($_smarty_tpl->tpl_vars['banners']->value) {?>
	<div id="product_categories">
		<select name="banner_id">
			<?php  $_smarty_tpl->tpl_vars['banner'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['banner']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['banners']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['banner']->key => $_smarty_tpl->tpl_vars['banner']->value) {
$_smarty_tpl->tpl_vars['banner']->_loop = true;
?>
				<option value='<?php echo $_smarty_tpl->tpl_vars['banner']->value->id;?>
' <?php if ($_smarty_tpl->tpl_vars['banners_image']->value->banner_id==$_smarty_tpl->tpl_vars['banner']->value->id) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['banner']->value->name;?>
</option>
			<?php } ?>
		</select>
	</div>
	<?php }?>
		
	<!-- Левая колонка -->
	<div id="column_left">
		<!-- Параметры страницы -->
		<div class="block layer">
			<h2>Параметры баннера</h2>
			<ul>
				<li><label class=property>Адрес (URL)</label><input name="url" class="okay_inp" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['banners_image']->value->url, ENT_QUOTES, 'UTF-8', true);?>
" /></li>
				<li><label class=property>Alt изображения</label><input name="alt" class="okay_inp" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['banners_image']->value->alt, ENT_QUOTES, 'UTF-8', true);?>
" /></li>
				<li><label class=property>Title изображения</label><input name="title" class="okay_inp" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['banners_image']->value->title, ENT_QUOTES, 'UTF-8', true);?>
" /></li>
				<li><label class=property>Описание</label><textarea name="description" class="okay_inp" ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['banners_image']->value->description, ENT_QUOTES, 'UTF-8', true);?>
</textarea></li>
			</ul>
		</div>
		<!-- Параметры страницы (The End)-->
	</div>
	<!-- Левая колонка свойств товара (The End)--> 
	
	<!-- Правая колонка свойств товара -->	
	<div id="column_right">
		
		<!-- Изображение категории -->	
		<div class="block layer images">
			<h2>Изображение</h2>
			<input class='upload_image' name=image type=file>			
			<input type=hidden name="delete_image" value="">
			<?php if ($_smarty_tpl->tpl_vars['banners_image']->value->image) {?>
			<ul>
				<li>
					<a href='#' class="delete"></a>
					<img src="../<?php echo $_smarty_tpl->tpl_vars['config']->value->banners_images_dir;?>
<?php echo $_smarty_tpl->tpl_vars['banners_image']->value->image;?>
" alt="" />
				</li>
			</ul>
			<?php }?>
		</div>
	</div>
	<!-- Правая колонка свойств товара (The End)--> 

	<!-- Описание категории (The End)-->
	<input class="button_green button_save" type="submit" name="" value="Сохранить" />
	
</form>
<!-- Основная форма (The End) -->

<?php }} ?>
