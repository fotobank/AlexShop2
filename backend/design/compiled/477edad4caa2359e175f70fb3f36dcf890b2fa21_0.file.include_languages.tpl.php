<?php
/* Smarty version 3.1.29, created on 2016-08-05 14:51:36
  from "O:\domains\okay\backend\design\html\include_languages.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57a47dc8349fa9_25719137',
  'file_dependency' => 
  array (
    '477edad4caa2359e175f70fb3f36dcf890b2fa21' => 
    array (
      0 => 'O:\\domains\\okay\\backend\\design\\html\\include_languages.tpl',
      1 => 1466581588,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57a47dc8349fa9_25719137 ($_smarty_tpl) {
?>

<style type="text/css">
<!--
.languages {
    width:100%;
    display:table;
    margin-bottom:20px;
}
.languages a{
    border:1px solid #ABADB3;
    padding:3px 5px;
    margin-right:5px;
    background: #FFFFFF;
    text-decoration:none;
    color:#787878;
    line-height:normal;
}
.languages a.active, .languages a:hover{
    color:#18A5FF;
    border:1px solid #18A5FF;
}
.add_lang{
    display:none;
}

-->
</style>

<?php if ($_smarty_tpl->tpl_vars['product']->value->id) {?>
    <?php $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable($_smarty_tpl->tpl_vars['product']->value->id, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'id', 0);
}
if ($_smarty_tpl->tpl_vars['category']->value->id) {?>
    <?php $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable($_smarty_tpl->tpl_vars['category']->value->id, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'id', 0);
}
if ($_smarty_tpl->tpl_vars['brand']->value->id) {?>
    <?php $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable($_smarty_tpl->tpl_vars['brand']->value->id, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'id', 0);
}
if ($_smarty_tpl->tpl_vars['feature']->value->id) {?>
    <?php $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable($_smarty_tpl->tpl_vars['feature']->value->id, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'id', 0);
}
if ($_smarty_tpl->tpl_vars['post']->value->id) {?>
    <?php $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable($_smarty_tpl->tpl_vars['post']->value->id, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'id', 0);
}
if ($_smarty_tpl->tpl_vars['page']->value->id) {?>
    <?php $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable($_smarty_tpl->tpl_vars['page']->value->id, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'id', 0);
}
if ($_smarty_tpl->tpl_vars['payment_method']->value->id) {?>
    <?php $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable($_smarty_tpl->tpl_vars['payment_method']->value->id, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'id', 0);
}
if ($_smarty_tpl->tpl_vars['delivery']->value->id) {?>
    <?php $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable($_smarty_tpl->tpl_vars['delivery']->value->id, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'id', 0);
}?>

<?php if ($_smarty_tpl->tpl_vars['languages']->value) {?>
    <div class='languages'>
    <?php
$_from = $_smarty_tpl->tpl_vars['languages']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_lang_0_saved_item = isset($_smarty_tpl->tpl_vars['lang']) ? $_smarty_tpl->tpl_vars['lang'] : false;
$_smarty_tpl->tpl_vars['lang'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['lang']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['lang']->value) {
$_smarty_tpl->tpl_vars['lang']->_loop = true;
$__foreach_lang_0_saved_local_item = $_smarty_tpl->tpl_vars['lang'];
?>
        <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('lang_id'=>$_smarty_tpl->tpl_vars['lang']->value->id,'id'=>$_smarty_tpl->tpl_vars['id']->value),$_smarty_tpl);?>
" data-label='<?php echo $_smarty_tpl->tpl_vars['lang']->value->label;?>
' <?php if ($_smarty_tpl->tpl_vars['lang']->value->id == $_smarty_tpl->tpl_vars['lang_id']->value) {?>class='active'<?php }?>><?php echo $_smarty_tpl->tpl_vars['lang']->value->name;
if ($_smarty_tpl->tpl_vars['langs']->value[$_smarty_tpl->tpl_vars['lang']->value->id]) {?>&crarr;<?php }?></a>
    <?php
$_smarty_tpl->tpl_vars['lang'] = $__foreach_lang_0_saved_local_item;
}
if ($__foreach_lang_0_saved_item) {
$_smarty_tpl->tpl_vars['lang'] = $__foreach_lang_0_saved_item;
}
?>
    </div>
<?php }
}
}
