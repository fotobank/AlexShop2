<?php /* Smarty version Smarty-3.1.18, created on 2016-08-01 16:52:39
         compiled from "backend\design\html\export.tpl" */ ?>
<?php /*%%SmartyHeaderCode:31001579f5427dc3070-30121735%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ce668956068100032761359c80fed14d3ab3aa8e' => 
    array (
      0 => 'backend\\design\\html\\export.tpl',
      1 => 1466581588,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '31001579f5427dc3070-30121735',
  'function' => 
  array (
    'categories_tree' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
  ),
  'variables' => 
  array (
    'manager' => 0,
    'config' => 0,
    'message_error' => 0,
    'export_files_dir' => 0,
    'brands' => 0,
    'categories' => 0,
    'b' => 0,
    'c' => 0,
    'level' => 0,
  ),
  'has_nocache_code' => 0,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_579f5427e99e28_97942285',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_579f5427e99e28_97942285')) {function content_579f5427e99e28_97942285($_smarty_tpl) {?><?php $_smarty_tpl->_capture_stack[0][] = array('tabs', null, null); ob_start(); ?>
	<?php if (in_array('import',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=ImportAdmin">Импорт</a>
        </li>
    <?php }?>
	<li class="active">
        <a href="index.php?module=ExportAdmin">Экспорт</a>
    </li>
    <?php if (in_array('import',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=MultiImportAdmin">Импорт переводов</a>
        </li>
    <?php }?>
    <?php if (in_array('export',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=MultiExportAdmin">Экспорт переводов</a>
        </li>
    <?php }?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Экспорт товаров', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>

<script src="<?php echo $_smarty_tpl->tpl_vars['config']->value->root_url;?>
/backend/design/js/piecon/piecon.js"></script>
<script>

	
var in_process=false;
var field = '',
    value = '';

$(function() {

    $('.fn-type').on('change', function() {
        $('.fn-select').hide();
        $('.fn-select.fn-select'+$(this).val()).show();
    });

	// On document load
	$('input#start').click(function() {
        var elem = $('.fn-select:visible');
        if (elem) {
            field = elem.attr('name');
            value = elem.val();
        }
 
 		Piecon.setOptions({fallback: 'force'});
 		Piecon.setProgress(0);
    	$("#progressbar").progressbar({ value: 0 });

    	$("#start").hide('fast');
		do_export();
    
	});
  
	function do_export(page)
	{
		page = typeof(page) != 'undefined' ? page : 1;
        var data = {page: page};
        if (field && value) {
            data[field] = value;
        }
        
		$.ajax({
 			 url: "ajax/export.php",
 			 	data: data,
 			 	dataType: 'json',
  				success: function(data){
  				
    				if(data && !data.end)
    				{
    					Piecon.setProgress(Math.round(100*data.page/data.totalpages));
    					$("#progressbar").progressbar({ value: 100*data.page/data.totalpages });
    					do_export(data.page*1+1);
    				}
    				else
    				{	
	    				if(data && data.end)
	    				{
	    					Piecon.setProgress(100);
	    					$("#progressbar").hide('fast');
	    					window.location.href = 'files/export/export.csv';
    					}
    				}
  				},
				error:function(xhr, status, errorThrown) {
					alert(errorThrown+'\n'+xhr.responseText);
        		}  				
  				
		});
	
	} 
	
});

</script>

<style>
	.ui-progressbar-value { background-image: url(design/images/progress.gif); background-position:left; border-color: #009ae2;}
	#progressbar{ clear: both; height:29px; }
	#result{ clear: both; width:100%;}
	#download{ display:none;  clear: both; }
</style>


<?php if ($_smarty_tpl->tpl_vars['message_error']->value) {?>
    <!-- Системное сообщение -->
    <div class="message message_error">
        <span class="text">
        <?php if ($_smarty_tpl->tpl_vars['message_error']->value=='no_permission') {?>Установите права на запись в папку <?php echo $_smarty_tpl->tpl_vars['export_files_dir']->value;?>

        <?php } else { ?><?php echo $_smarty_tpl->tpl_vars['message_error']->value;?>
<?php }?>
        </span>
    </div>
    <!-- Системное сообщение (The End)-->
<?php }?>


<div>
	<h1>Экспорт товаров</h1>
	<?php if ($_smarty_tpl->tpl_vars['message_error']->value!='no_permission') {?>
	    <div id='progressbar'></div>
        <div id="start">
            <input class="button_green" id="start" type="button" name="" value="Экспортировать" />
            <select class="fn-type">
                <option value="0">Все товары</option>
                <?php if ($_smarty_tpl->tpl_vars['brands']->value) {?><option value="1">По брендам</option><?php }?>
                <?php if ($_smarty_tpl->tpl_vars['categories']->value) {?><option value="2">По категориям</option><?php }?>
            </select>
            <?php if ($_smarty_tpl->tpl_vars['brands']->value) {?>
                <select class="fn-select fn-select1" name="brand_id" style="display: none;">
                    <?php  $_smarty_tpl->tpl_vars['b'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['b']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['brands']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['b']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['b']->key => $_smarty_tpl->tpl_vars['b']->value) {
$_smarty_tpl->tpl_vars['b']->_loop = true;
 $_smarty_tpl->tpl_vars['b']->index++;
 $_smarty_tpl->tpl_vars['b']->first = $_smarty_tpl->tpl_vars['b']->index === 0;
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['b']->value->id;?>
" <?php if ($_smarty_tpl->tpl_vars['b']->first) {?>selected=""<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['b']->value->name, ENT_QUOTES, 'UTF-8', true);?>
</option>
                    <?php } ?>
                </select>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['categories']->value) {?>
                <select class="fn-select fn-select2" name="category_id" style="display: none;">
                    <?php if (!function_exists('smarty_template_function_categories_tree')) {
    function smarty_template_function_categories_tree($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['categories_tree']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
                        <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value) {
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['c']->value->id;?>
"><?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['sp'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['sp']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['name'] = 'sp';
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['level']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['total']);
?>&nbsp;&nbsp;&nbsp;&nbsp;<?php endfor; endif; ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->name, ENT_QUOTES, 'UTF-8', true);?>
</option>
                            <?php smarty_template_function_categories_tree($_smarty_tpl,array('categories'=>$_smarty_tpl->tpl_vars['c']->value->subcategories,'level'=>$_smarty_tpl->tpl_vars['level']->value+1));?>

                        <?php } ?>
                    <?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;
foreach (Smarty::$global_tpl_vars as $key => $value) if(!isset($_smarty_tpl->tpl_vars[$key])) $_smarty_tpl->tpl_vars[$key] = $value;}}?>

                    <?php smarty_template_function_categories_tree($_smarty_tpl,array('categories'=>$_smarty_tpl->tpl_vars['categories']->value,'level'=>0));?>

                </select>
            <?php }?>
        </div>
	<?php }?>
</div><?php }} ?>
