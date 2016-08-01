<?php /* Smarty version Smarty-3.1.18, created on 2016-08-01 16:52:15
         compiled from "backend\design\html\category_stats.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10898579f540f3af4c4-87493442%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '52ac037308a6cb6b27cfb7c5e67e6a5249d846d8' => 
    array (
      0 => 'backend\\design\\html\\category_stats.tpl',
      1 => 1467208466,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10898579f540f3af4c4-87493442',
  'function' => 
  array (
    'categories_list_tree' => 
    array (
      'parameter' => 
      array (
        'level' => 0,
      ),
      'compiled' => '',
    ),
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
    'category' => 0,
    'brand' => 0,
    'date_from' => 0,
    'date_to' => 0,
    'settings' => 0,
    'currency' => 0,
    'categories' => 0,
    'level' => 0,
    'categories_list' => 0,
    'total_amount' => 0,
    'total_price' => 0,
    'c' => 0,
    'brands' => 0,
    'b' => 0,
  ),
  'has_nocache_code' => 0,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_579f540f52e228_93367959',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_579f540f52e228_93367959')) {function content_579f540f52e228_93367959($_smarty_tpl) {?><?php $_smarty_tpl->_capture_stack[0][] = array('tabs', null, null); ob_start(); ?>
    <li>
        <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'StatsAdmin'),$_smarty_tpl);?>
">Статистика</a>
    </li>
    <li>
        <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'ReportStatsAdmin','filter'=>null,'status'=>null),$_smarty_tpl);?>
">Отчет о продажах</a>
    </li>
    <li class="active">
        <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'CategoryStatsAdmin','category'=>null,'brand'=>null,'date_from'=>null,'date_to'=>null),$_smarty_tpl);?>
">Категоризация продаж</a>
    </li>
    <?php if (in_array('yametrika',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=YametrikaAdmin">Яндекс.Метрика</a>
        </li>
    <?php }?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Категоризация продаж', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>


<script>
    <?php if ($_smarty_tpl->tpl_vars['category']->value) {?>
        var category = <?php echo $_smarty_tpl->tpl_vars['category']->value->id;?>
;
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['brand']->value) {?>
        var brand = <?php echo $_smarty_tpl->tpl_vars['brand']->value->id;?>
;
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['date_from']->value) {?>
        var date_from = '<?php echo $_smarty_tpl->tpl_vars['date_from']->value;?>
';
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['date_to']->value) {?>
        var date_to = '<?php echo $_smarty_tpl->tpl_vars['date_to']->value;?>
';
    <?php }?>
</script>

    <script src="design/js/jquery/datepicker/jquery.ui.datepicker-ru.js"></script>
    <script type="text/javascript">

        $(function() {
            $('input[name="date_from"]').datepicker({
                regional:'ru'
            });

            $('input[name="date_to"]').datepicker({
                regional:'ru'
            });

            $('input#start').click(function () {
                do_export();

            });
            function do_export(page) {
                page = typeof(page) != 'undefined' ? page : 1;
                category = typeof(category) != 'undefined' ? category : 0;
                brand = typeof(brand) != 'undefined' ? brand : 0;
                date_from = typeof(date_from) != 'undefined' ? date_from : 0;
                date_to = typeof(date_to) != 'undefined' ? date_to : 0;
                $.ajax({
                    url: "ajax/export_stat.php",
                    data: {
                        page: page,
                        category: category,
                        brand: brand,
                        date_from: date_from,
                        date_to: date_to
                    },
                    dataType: 'json',
                    success: function () {

                            window.location.href = 'files/export/export_stat.csv';
                    },
                    error: function (xhr, status, errorThrown) {
                        alert(errorThrown + '\n' + xhr.responseText);
                    }

                });

            }
        });
    </script>


<div>
    <div id="header">
        <h1>
            Категоризация продаж<br />
            <?php echo $_smarty_tpl->tpl_vars['category']->value->name;?>
 <?php echo $_smarty_tpl->tpl_vars['brand']->value->name;?>

        </h1>
        <input class="button_green" id="start" type="button" name="" value="Скачать" />
    </div>

    <div id="main_list">
        <div id="list">
            <table class="table_blue" width="100%">
                <thead class="thead">
                    <tr>
                        <td>Категория</td>
                        <td class="stats_amount">Количество, <?php echo $_smarty_tpl->tpl_vars['settings']->value->units;?>
</td>
                        <td class="stats_price">Сумма, <?php echo $_smarty_tpl->tpl_vars['currency']->value->sign;?>
</td>
                    </tr>
                </thead>
                <tbody>
                <?php if (!function_exists('smarty_template_function_categories_list_tree')) {
    function smarty_template_function_categories_list_tree($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['categories_list_tree']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
                    <?php if ($_smarty_tpl->tpl_vars['categories']->value) {?>
                        <?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value) {
$_smarty_tpl->tpl_vars['category']->_loop = true;
?>
                            <tr>
                                <td style="padding-left:<?php echo ($_smarty_tpl->tpl_vars['level']->value+1)*15;?>
px"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['category']->value->name, ENT_QUOTES, 'UTF-8', true);?>
</td>
                                <td class="stats_amount"><?php if ($_smarty_tpl->tpl_vars['category']->value->amount) {?><b><?php echo $_smarty_tpl->tpl_vars['category']->value->amount;?>
</b><?php } else { ?><?php echo $_smarty_tpl->tpl_vars['category']->value->amount;?>
<?php }?> <?php echo $_smarty_tpl->tpl_vars['settings']->value->units;?>
</td>
                                <td class="stats_price"><?php if ($_smarty_tpl->tpl_vars['category']->value->price) {?><b><?php echo $_smarty_tpl->tpl_vars['category']->value->price;?>
</b><?php } else { ?><?php echo $_smarty_tpl->tpl_vars['category']->value->price;?>
<?php }?> <?php echo $_smarty_tpl->tpl_vars['currency']->value->sign;?>
</td>
                                <?php smarty_template_function_categories_list_tree($_smarty_tpl,array('categories'=>$_smarty_tpl->tpl_vars['category']->value->subcategories,'level'=>$_smarty_tpl->tpl_vars['level']->value+1));?>

                            </tr>
                        <?php } ?>
                    <?php }?>
                <?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;
foreach (Smarty::$global_tpl_vars as $key => $value) if(!isset($_smarty_tpl->tpl_vars[$key])) $_smarty_tpl->tpl_vars[$key] = $value;}}?>

                <?php smarty_template_function_categories_list_tree($_smarty_tpl,array('categories'=>$_smarty_tpl->tpl_vars['categories_list']->value));?>

                </tbody>
                <tfoot>
                    <tr class="top_row">
                        <td  colspan="3"></td>
                    </tr>
                    <tr>
                        <th style="text-align: right">Итого</th>
                        <th><?php echo $_smarty_tpl->tpl_vars['total_amount']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['settings']->value->units;?>
</th>
                        <th style="text-align: right"><?php echo $_smarty_tpl->tpl_vars['total_price']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['currency']->value->sign;?>
</th>
                    </tr>
                </tfoot>
            </table>
        </div>
          
    </div>
</div>
    <div id="right_menu">
        
            <form class="date_filter" method="get">
                <div class="date_filter_title">
                    <span>Выбрать период</span>
                    <div class="helper_wrap">
                        <a id="show_help_filter" class="helper_link" href="javascript:;"></a>
                        <div id="help_date_filter" class="helper_block">
                            <span> Если не указана дата «С», то выбираются продажи начиная с самой первой.</span>
                            <span> Если не указана конечная дата «По», то автоматом подставляется текущая дата.</span>
                        </div>
                    </div>
                </div>
                <div class="form_group">
                    <label for="from_date">C</label>
                    <input id="from_date" class="okay_inp" type=text name=date_from value='<?php echo $_smarty_tpl->tpl_vars['date_from']->value;?>
' />
                </div>

                <div class="form_group">
                    <label for="to_date">По</label>
                    <input id="to_date" class="okay_inp" type=text name=date_to value='<?php echo $_smarty_tpl->tpl_vars['date_to']->value;?>
' />
                </div>

                <input type="hidden" name="module" value="CategoryStatsAdmin" />
                <input id="apply_action" class="button_green" type="submit" value="Применить" />
            </form>
        <h4>Категории</h4>
        <?php if (!function_exists('smarty_template_function_categories_tree')) {
    function smarty_template_function_categories_tree($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['categories_tree']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
            <?php if ($_smarty_tpl->tpl_vars['categories']->value) {?>
                <ul class="cats_right<?php if ($_smarty_tpl->tpl_vars['level']->value>1) {?> sub_menu<?php }?>" >
                    <?php if ($_smarty_tpl->tpl_vars['categories']->value[0]->parent_id==0) {?>
                        <li <?php if (!$_smarty_tpl->tpl_vars['category']->value->id) {?>class="selected"<?php }?>>
                            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('category'=>null,'brand'=>null),$_smarty_tpl);?>
">Все категории</a>
                        </li>
                    <?php }?>
                    <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value) {
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
                        <li <?php if ($_smarty_tpl->tpl_vars['category']->value->id==$_smarty_tpl->tpl_vars['c']->value->id) {?>class="selected"<?php }?>>
                            <a href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['c']->value->id;?>
<?php $_tmp1=ob_get_clean();?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('brand'=>null,'supplier'=>null,'category'=>$_tmp1),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['c']->value->name;?>
</a>
                            <?php if ($_smarty_tpl->tpl_vars['c']->value->subcategories) {?><span class="slide_menu"></span><?php }?>
                        </li>
                        <?php smarty_template_function_categories_tree($_smarty_tpl,array('categories'=>$_smarty_tpl->tpl_vars['c']->value->subcategories,'level'=>$_smarty_tpl->tpl_vars['level']->value+1));?>

                    <?php } ?>
                </ul>
            <?php }?>
        <?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;
foreach (Smarty::$global_tpl_vars as $key => $value) if(!isset($_smarty_tpl->tpl_vars[$key])) $_smarty_tpl->tpl_vars[$key] = $value;}}?>

        <?php smarty_template_function_categories_tree($_smarty_tpl,array('categories'=>$_smarty_tpl->tpl_vars['categories']->value,'level'=>1));?>


        <h4>Бренды</h4>
        <?php if ($_smarty_tpl->tpl_vars['brands']->value) {?>
            <ul>
                <li <?php if (!$_smarty_tpl->tpl_vars['brand']->value->id) {?>class="selected"<?php }?>>
                    <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('brand'=>null),$_smarty_tpl);?>
">Все бренды</a>
                </li>
                <?php  $_smarty_tpl->tpl_vars['b'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['b']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['brands']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['b']->key => $_smarty_tpl->tpl_vars['b']->value) {
$_smarty_tpl->tpl_vars['b']->_loop = true;
?>
                    <li brand_id="<?php echo $_smarty_tpl->tpl_vars['b']->value->id;?>
" <?php if ($_smarty_tpl->tpl_vars['brand']->value->id==$_smarty_tpl->tpl_vars['b']->value->id) {?>class="selected"<?php } else { ?>class="droppable brand"<?php }?>>
                        <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('brand'=>$_smarty_tpl->tpl_vars['b']->value->id),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['b']->value->name;?>
</a>
                    </li>
                <?php } ?>
            </ul>
        <?php }?>
    </div>
    <!-- Меню  (The End) -->
<script>
    $(function(){
        $('.slide_menu').on('click',function(){
            if($(this).hasClass('open')){
                $(this).removeClass('open');
            }
            else{
                $(this).addClass('open');
            }
            $(this).parent().next().slideToggle(500);
        })
    });
</script>
<?php }} ?>
