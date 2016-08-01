<?php /* Smarty version Smarty-3.1.18, created on 2016-08-01 16:52:04
         compiled from "backend\design\html\reportstats.tpl" */ ?>
<?php /*%%SmartyHeaderCode:30749579f54047798d6-63088893%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3afeed0742b036977f351c2dd519717e59b8bdc2' => 
    array (
      0 => 'backend\\design\\html\\reportstats.tpl',
      1 => 1467208466,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '30749579f54047798d6-63088893',
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
    'date_filter' => 0,
    'date_from' => 0,
    'date_to' => 0,
    'status' => 0,
    'sort_prod' => 0,
    'page' => 0,
    'category' => 0,
    'report_stat_purchases' => 0,
    'total_summ' => 0,
    'purchase' => 0,
    'total_amount' => 0,
    'c' => 0,
    'currency' => 0,
    'settings' => 0,
    'categories' => 0,
    'level' => 0,
  ),
  'has_nocache_code' => 0,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_579f5404a02073_96768363',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_579f5404a02073_96768363')) {function content_579f5404a02073_96768363($_smarty_tpl) {?>

    <script src="design/js/jquery/datepicker/jquery.ui.datepicker-ru.js"></script>

    <script>

        $(function() {

            $('input[name="date_from"]').datepicker({
                regional:'ru'
            });

            $('input[name="date_to"]').datepicker({
                regional:'ru'
            });

        });
    </script>

    <style>

        #list td, #list th { padding: 7px 5px; text-align: left; }
        #list td.c, #list th.c { text-align: center; }
        .sort.top:before { content:"↑ "; border-bottom:none; }
        .sort.bottom:before { content: "↓ "; border-bottom:none; }
        #list tfoot { background: #d0d0d0; }

    </style>




<?php $_smarty_tpl->_capture_stack[0][] = array('tabs', null, null); ob_start(); ?>
    <li>
        <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'StatsAdmin'),$_smarty_tpl);?>
">Статистика</a>
    </li>
    <li class="active">
        <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'ReportStatsAdmin','filter'=>null,'status'=>null),$_smarty_tpl);?>
">Отчет о продажах</a>
    </li>
    <li>
        <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'CategoryStatsAdmin','category'=>null,'brand'=>null,'supplier'=>null,'date_from'=>null,'date_to'=>null),$_smarty_tpl);?>
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
<script>
    <?php if ($_smarty_tpl->tpl_vars['date_filter']->value) {?>
        var date_filter = '<?php echo $_smarty_tpl->tpl_vars['date_filter']->value;?>
';
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['date_from']->value) {?>
        var date_from = '<?php echo $_smarty_tpl->tpl_vars['date_from']->value;?>
';
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['date_to']->value) {?>
        var date_to = '<?php echo $_smarty_tpl->tpl_vars['date_to']->value;?>
';
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['status']->value) {?>
        var status = '<?php echo $_smarty_tpl->tpl_vars['status']->value;?>
';
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['sort_prod']->value) {?>
        var sort_prod = '<?php echo $_smarty_tpl->tpl_vars['sort_prod']->value;?>
';
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['page']->value) {?>
        var page = '<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
';
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['category']->value) {?>
    var category = '<?php echo $_smarty_tpl->tpl_vars['category']->value;?>
';
    <?php }?>
</script>


    <script type="text/javascript">
        $(function() {
            $('input#start').click(function () {
                do_export();

            });
            function do_export(page) {
                page = typeof(page) != 'undefined' ? page : 1;
                category = typeof(category) != 'undefined' ? category : 0;
                date_filter = typeof(date_filter) != 'undefined' ? date_filter : 0;
                date_from = typeof(date_from) != 'undefined' ? date_from : 0;
                date_to = typeof(date_to) != 'undefined' ? date_to : 0;
                status =  typeof(status) != 'undefined' ? status : 0;
                sort_prod = typeof(sort_prod) != 'undefined' ? sort_prod : 0;
                $.ajax({
                    url: "ajax/export_stat_products.php",
                    data: {
                        page: page,
                        category: category,
                        date_filter: date_filter,
                        date_from: date_from,
                        date_to: date_to,
                        status: status,
                        sort_prod: sort_prod
                    },
                    dataType: 'json',
                    success: function () {

                        window.location.href = 'files/export/export_stat_products.csv';
                    },
                    error: function (xhr, status, errorThrown) {
                        alert(errorThrown + '\n' + xhr.responseText);
                    }
                });
            }
        });
    </script>



<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Отчет о продажах', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>

<div id="chart_div" style="width:900px;height:900px;display:none;">
    <div id="chart_cont"></div>
    <div id="chart_amount" style="margin-top:25px;"></div>
</div>


<div id="header">
    <h1>Отчет по заказам</h1>
    <input class="button_green" id="start" type="button" name="" value="Скачать" />
</div>

<div id="main_list">
    <?php echo $_smarty_tpl->getSubTemplate ('pagination.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <form id="form_list" method="post">
        <input type="hidden" name="session_id" value="<?php echo $_SESSION['id'];?>
">

        <div id="list">

            <?php $_smarty_tpl->tpl_vars['total_summ'] = new Smarty_variable(0, null, 0);?>
            <?php $_smarty_tpl->tpl_vars['total_amount'] = new Smarty_variable(0, null, 0);?>

            <table class="table_blue" width="100%">
                <thead class="thead">
                    <tr>
                        <th width="27%">Категория</th>
                        <th width="40%">Наименование товара</th>
                        <th width="20%" class="c"><a class="sort <?php if ($_smarty_tpl->tpl_vars['sort_prod']->value=='price') {?>top<?php } elseif ($_smarty_tpl->tpl_vars['sort_prod']->value=='price_in') {?>bottom<?php }?>" href="<?php if ($_smarty_tpl->tpl_vars['sort_prod']->value=='price') {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('sort_prod'=>'price_in'),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('sort_prod'=>'price'),$_smarty_tpl);?>
<?php }?>">Сумма продаж</a>
                        </th>
                        <th width="13%" class="c"><a class="sort <?php if ($_smarty_tpl->tpl_vars['sort_prod']->value=='amount') {?>top<?php } elseif ($_smarty_tpl->tpl_vars['sort_prod']->value=='amount_in') {?>bottom<?php }?>" href="<?php if ($_smarty_tpl->tpl_vars['sort_prod']->value=='amount') {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('sort_prod'=>'amount_in'),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('sort_prod'=>'amount'),$_smarty_tpl);?>
<?php }?>">Кол-во</a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php  $_smarty_tpl->tpl_vars['purchase'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['purchase']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['report_stat_purchases']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['purchase']->key => $_smarty_tpl->tpl_vars['purchase']->value) {
$_smarty_tpl->tpl_vars['purchase']->_loop = true;
?>
                    <?php $_smarty_tpl->tpl_vars['total_summ'] = new Smarty_variable($_smarty_tpl->tpl_vars['total_summ']->value+$_smarty_tpl->tpl_vars['purchase']->value->sum_price, null, 0);?>
                    <?php $_smarty_tpl->tpl_vars['total_amount'] = new Smarty_variable($_smarty_tpl->tpl_vars['total_amount']->value+$_smarty_tpl->tpl_vars['purchase']->value->amount, null, 0);?>
                    <tr>
                        <td>
                            <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['purchase']->value->category->path; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value) {
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
                                <?php echo $_smarty_tpl->tpl_vars['c']->value->name;?>
/
                            <?php } ?>
                        </td>
                        <td>
                            <a title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['purchase']->value->product_name, ENT_QUOTES, 'UTF-8', true);?>
" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'ReportStatsProdAdmin','id'=>$_smarty_tpl->tpl_vars['purchase']->value->product_id,'return'=>$_SERVER['REQUEST_URI']),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['purchase']->value->product_name;?>
</a> <?php echo $_smarty_tpl->tpl_vars['purchase']->value->variant_name;?>

                        </td>
                        <td class="c"><?php echo $_smarty_tpl->tpl_vars['purchase']->value->sum_price;?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8', true);?>
</td>
                        <td class="c"><?php echo $_smarty_tpl->tpl_vars['purchase']->value->amount;?>
 <?php echo $_smarty_tpl->tpl_vars['settings']->value->units;?>
</td>
                    </tr>
                <?php } ?>
                </tbody>
                <tfoot>
                    <tr class="top_row">
                        <td  colspan="4"></td>
                    </tr>
                    <tr>
                        <th></th>
                        <th style="text-align: right">Итого:</th>
                        <th class="c"><?php echo sprintf('%.2f',$_smarty_tpl->tpl_vars['total_summ']->value);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8', true);?>
</th>
                        <th class="c"><?php echo $_smarty_tpl->tpl_vars['total_amount']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['settings']->value->units;?>
</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </form>

</div>

<!-- Меню -->
<div id="right_menu">

    <form class="date_filter" method="get">

        <div class="date_filter_title">
            <span>Заказы за период</span>
            <div class="helper_wrap">
                <a id="show_help_filter" class="helper_link" href="javascript:;"></a>
                <div id="help_date_filter" class="helper_block">
                    <span> Если не указана дата «С», то выбираются заказы начиная с самого первого.</span>
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

        <input type="hidden" name="module" value="ReportStatsAdmin">
        <input type="hidden" name="date_filter" value="">
          
        <input id="apply_action" class="button" type="submit" value="Применить">
        
    </form>

    <span class="right_block_name">Статусы заказов</span>
    <ul id="status-order">
        <li <?php if (!$_smarty_tpl->tpl_vars['status']->value) {?>class="selected"<?php }?>><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>null),$_smarty_tpl);?>
">Все заказы</a></li>
        <li <?php if ($_smarty_tpl->tpl_vars['status']->value==1) {?>class="selected"<?php }?>><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>1),$_smarty_tpl);?>
">Новые</a></li>
        <li <?php if ($_smarty_tpl->tpl_vars['status']->value==2) {?>class="selected"<?php }?>><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>2),$_smarty_tpl);?>
">Принятые</a></li>
        <li <?php if ($_smarty_tpl->tpl_vars['status']->value==3) {?>class="selected"<?php }?>><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>3),$_smarty_tpl);?>
">Выполенные</a></li>
        <li <?php if ($_smarty_tpl->tpl_vars['status']->value==4) {?>class="selected"<?php }?>><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>4),$_smarty_tpl);?>
">Удаленные</a></li>
    </ul>

    <span class="right_block_name">Период</span>
    <ul id="filter-date">
        <li <?php if (!$_smarty_tpl->tpl_vars['date_filter']->value) {?>class="selected"<?php }?>><a onclick="show_fields();" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('date_filter'=>null,'date_to'=>null,'date_from'=>null,'filter_check'=>null),$_smarty_tpl);?>
">Все заказы</a></li>
        <li <?php if ($_smarty_tpl->tpl_vars['date_filter']->value=='today') {?>class="selected"<?php }?>><a onclick="show_fields();" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('date_filter'=>'today','date_to'=>null,'date_from'=>null,'filter_check'=>null),$_smarty_tpl);?>
">Сегодня</a></li>
        <li <?php if ($_smarty_tpl->tpl_vars['date_filter']->value=='this_week') {?>class="selected"<?php }?>><a onclick="show_fields();" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('date_filter'=>'this_week','date_to'=>null,'date_from'=>null,'filter_check'=>null),$_smarty_tpl);?>
">Текущая неделя</a></li>
        <li <?php if ($_smarty_tpl->tpl_vars['date_filter']->value=='this_month') {?>class="selected"<?php }?>><a onclick="show_fields();" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('date_filter'=>'this_month','date_to'=>null,'date_from'=>null,'filter_check'=>null),$_smarty_tpl);?>
">Текущий месяц</a></li>
        <li <?php if ($_smarty_tpl->tpl_vars['date_filter']->value=='this_year') {?>class="selected"<?php }?>><a onclick="show_fields();" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('date_filter'=>'this_year','date_to'=>null,'date_from'=>null,'filter_check'=>null),$_smarty_tpl);?>
">Текущий год</a></li>
        <li <?php if ($_smarty_tpl->tpl_vars['date_filter']->value=='yesterday') {?>class="selected"<?php }?>><a onclick="show_fields();" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('date_filter'=>'yesterday','date_to'=>null,'date_from'=>null,'filter_check'=>null),$_smarty_tpl);?>
">Вчера</a></li>
        <li <?php if ($_smarty_tpl->tpl_vars['date_filter']->value=='last_week') {?>class="selected"<?php }?>><a onclick="show_fields();" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('date_filter'=>'last_week','date_to'=>null,'date_from'=>null,'filter_check'=>null),$_smarty_tpl);?>
">Предыдущая неделя</a></li>
        <li <?php if ($_smarty_tpl->tpl_vars['date_filter']->value=='last_month') {?>class="selected"<?php }?>><a onclick="show_fields();" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('date_filter'=>'last_month','date_to'=>null,'date_from'=>null,'filter_check'=>null),$_smarty_tpl);?>
">Предыдущий месяц</a></li>
        <li <?php if ($_smarty_tpl->tpl_vars['date_filter']->value=='last_year') {?>class="selected"<?php }?>><a onclick="show_fields();" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('date_filter'=>'last_year','date_to'=>null,'date_from'=>null,'filter_check'=>null),$_smarty_tpl);?>
">Предыдущий год</a></li>
        <li <?php if ($_smarty_tpl->tpl_vars['date_filter']->value=='last_24hour') {?>class="selected"<?php }?>><a onclick="show_fields();" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('date_filter'=>'last_24hour','date_to'=>null,'date_from'=>null,'filter_check'=>null),$_smarty_tpl);?>
">Последние 24 часа</a></li>
        <li <?php if ($_smarty_tpl->tpl_vars['date_filter']->value=='last_7day') {?>class="selected"<?php }?>><a onclick="show_fields();" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('date_filter'=>'last_7day','date_to'=>null,'date_from'=>null,'filter_check'=>null),$_smarty_tpl);?>
">Последние 7 дней</a></li>
        <li <?php if ($_smarty_tpl->tpl_vars['date_filter']->value=='last_30day') {?>class="selected"<?php }?>><a onclick="show_fields();" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('date_filter'=>'last_30day','date_to'=>null,'date_from'=>null,'filter_check'=>null),$_smarty_tpl);?>
">Последние 30 дней</a></li>
    </ul>
    


    <?php if (!function_exists('smarty_template_function_categories_tree')) {
    function smarty_template_function_categories_tree($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['categories_tree']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
        <?php if ($_smarty_tpl->tpl_vars['categories']->value) {?>
            <ul class="cats_right<?php if ($_smarty_tpl->tpl_vars['level']->value>1) {?> sub_menu<?php }?>">
                <?php if ($_smarty_tpl->tpl_vars['categories']->value[0]->parent_id==0) {?>
                    <li <?php if (!$_smarty_tpl->tpl_vars['category']->value->id) {?>class="selected"<?php }?>><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('category_id'=>null,'brand_id'=>null),$_smarty_tpl);?>
">Все категории</a></li>
                <?php }?>
                <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value) {
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
                    <li category_id="<?php echo $_smarty_tpl->tpl_vars['c']->value->id;?>
" <?php if ($_GET['category_id']==$_smarty_tpl->tpl_vars['c']->value->id) {?>class="selected"<?php } else { ?>class="droppable category"<?php }?>>
                        <a href='<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['c']->value->id;?>
<?php $_tmp1=ob_get_clean();?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('keyword'=>null,'brand_id'=>null,'page'=>'all','category_id'=>$_tmp1),$_smarty_tpl);?>
'><?php echo $_smarty_tpl->tpl_vars['c']->value->name;?>
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



</div>
<!-- Меню  (The End) -->





    <script>

        $(function() {

            // Сортировка списка
            $("#labels").sortable({
                items:             "li",
                tolerance:         "pointer",
                scrollSensitivity: 40,
                opacity:           0.7
            });


            $('.slide_menu').on('click',function(){
                if($(this).hasClass('open')){
                    $(this).removeClass('open');
                }
                else{
                    $(this).addClass('open');
                }
                $(this).parent().next().slideToggle(500);
            });
            $('.cats_right li.selected').parents().removeClass('sub_menu');
            $('.cats_right li.selected').parents().prev().find('span').addClass('open');
        });

    </script>

<?php }} ?>
