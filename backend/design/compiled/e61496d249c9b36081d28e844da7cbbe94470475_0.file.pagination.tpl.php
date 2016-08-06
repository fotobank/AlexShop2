<?php
/* Smarty version 3.1.29, created on 2016-08-05 13:46:05
  from "O:\domains\okay\backend\design\html\pagination.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57a46e6d6251d9_38781122',
  'file_dependency' => 
  array (
    'e61496d249c9b36081d28e844da7cbbe94470475' => 
    array (
      0 => 'O:\\domains\\okay\\backend\\design\\html\\pagination.tpl',
      1 => 1457286012,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57a46e6d6251d9_38781122 ($_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['pages_count']->value > 1) {?>



<?php echo '<script'; ?>
 type="text/javascript" src="design/js/ctrlnavigate.js"><?php echo '</script'; ?>
>           

<!-- Листалка страниц -->
<div id="pagination">
	
	
	<?php $_smarty_tpl->tpl_vars['visible_pages'] = new Smarty_Variable(5, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'visible_pages', 0);?>

	
	<?php $_smarty_tpl->tpl_vars['page_from'] = new Smarty_Variable(1, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'page_from', 0);?>
	
	
	<?php if ($_smarty_tpl->tpl_vars['current_page']->value > floor($_smarty_tpl->tpl_vars['visible_pages']->value/2)) {?>
		<?php $_smarty_tpl->tpl_vars['page_from'] = new Smarty_Variable(max(1,$_smarty_tpl->tpl_vars['current_page']->value-floor($_smarty_tpl->tpl_vars['visible_pages']->value/2)-1), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'page_from', 0);?>
	<?php }?>	
	
	
	<?php if ($_smarty_tpl->tpl_vars['current_page']->value > $_smarty_tpl->tpl_vars['pages_count']->value-ceil($_smarty_tpl->tpl_vars['visible_pages']->value/2)) {?>
		<?php $_smarty_tpl->tpl_vars['page_from'] = new Smarty_Variable(max(1,$_smarty_tpl->tpl_vars['pages_count']->value-$_smarty_tpl->tpl_vars['visible_pages']->value-1), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'page_from', 0);?>
	<?php }?>
	
	
	<?php $_smarty_tpl->tpl_vars['page_to'] = new Smarty_Variable(min($_smarty_tpl->tpl_vars['page_from']->value+$_smarty_tpl->tpl_vars['visible_pages']->value,$_smarty_tpl->tpl_vars['pages_count']->value-1), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'page_to', 0);?>

	
	<a class="<?php if ($_smarty_tpl->tpl_vars['current_page']->value == 1) {?>selected<?php } else { ?>droppable<?php }?>" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>1),$_smarty_tpl);?>
">1</a>
	
		
	<?php
$__section_pages_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_pages']) ? $_smarty_tpl->tpl_vars['__smarty_section_pages'] : false;
$__section_pages_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['page_to']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_pages_0_start = (int)@$_smarty_tpl->tpl_vars['page_from']->value < 0 ? max(0, (int)@$_smarty_tpl->tpl_vars['page_from']->value + $__section_pages_0_loop) : min((int)@$_smarty_tpl->tpl_vars['page_from']->value, $__section_pages_0_loop);
$__section_pages_0_total = min(($__section_pages_0_loop - $__section_pages_0_start), $__section_pages_0_loop);
$_smarty_tpl->tpl_vars['__smarty_section_pages'] = new Smarty_Variable(array());
if ($__section_pages_0_total != 0) {
for ($__section_pages_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_pages']->value['index'] = $__section_pages_0_start; $__section_pages_0_iteration <= $__section_pages_0_total; $__section_pages_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_pages']->value['index']++){
?>
			
		<?php $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable((isset($_smarty_tpl->tpl_vars['__smarty_section_pages']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pages']->value['index'] : null)+1, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'p', 0);?>	
			
		<?php if (($_smarty_tpl->tpl_vars['p']->value == $_smarty_tpl->tpl_vars['page_from']->value+1 && $_smarty_tpl->tpl_vars['p']->value != 2) || ($_smarty_tpl->tpl_vars['p']->value == $_smarty_tpl->tpl_vars['page_to']->value && $_smarty_tpl->tpl_vars['p']->value != $_smarty_tpl->tpl_vars['pages_count']->value-1)) {?>	
		<a class="<?php if ($_smarty_tpl->tpl_vars['p']->value == $_smarty_tpl->tpl_vars['current_page']->value) {?>selected<?php }?>" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>$_smarty_tpl->tpl_vars['p']->value),$_smarty_tpl);?>
">...</a>
		<?php } else { ?>
		<a class="<?php if ($_smarty_tpl->tpl_vars['p']->value == $_smarty_tpl->tpl_vars['current_page']->value) {?>selected<?php } else { ?>droppable<?php }?>" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>$_smarty_tpl->tpl_vars['p']->value),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['p']->value;?>
</a>
		<?php }?>
	<?php
}
}
if ($__section_pages_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_pages'] = $__section_pages_0_saved;
}
?>

	
	<a class="<?php if ($_smarty_tpl->tpl_vars['current_page']->value == $_smarty_tpl->tpl_vars['pages_count']->value) {?>selected<?php } else { ?>droppable<?php }?>"  href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>$_smarty_tpl->tpl_vars['pages_count']->value),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['pages_count']->value;?>
</a>
	
	<a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>'all'),$_smarty_tpl);?>
">все сразу</a>
	<?php if ($_smarty_tpl->tpl_vars['current_page']->value > 1) {?><a id="PrevLink" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>$_smarty_tpl->tpl_vars['current_page']->value-1),$_smarty_tpl);?>
">←назад</a><?php }?>
	<?php if ($_smarty_tpl->tpl_vars['current_page']->value < $_smarty_tpl->tpl_vars['pages_count']->value) {?><a id="NextLink" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>$_smarty_tpl->tpl_vars['current_page']->value+1),$_smarty_tpl);?>
">вперед→</a><?php }?>	
	
</div>
<!-- Листалка страниц (The End) -->
<?php }
}
}
