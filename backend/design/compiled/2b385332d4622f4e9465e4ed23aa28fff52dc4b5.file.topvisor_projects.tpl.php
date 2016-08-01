<?php /* Smarty version Smarty-3.1.18, created on 2016-08-01 17:28:53
         compiled from "backend\design\html\topvisor_projects.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11286579f5ca5ba5615-17360891%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2b385332d4622f4e9465e4ed23aa28fff52dc4b5' => 
    array (
      0 => 'backend\\design\\html\\topvisor_projects.tpl',
      1 => 1466581588,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11286579f5ca5ba5615-17360891',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'balance' => 0,
    'settings' => 0,
    'message_success' => 0,
    'message_error' => 0,
    'api_results' => 0,
    'id' => 0,
    'projects' => 0,
    'project' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_579f5ca5c8fc46_00455995',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_579f5ca5c8fc46_00455995')) {function content_579f5ca5c8fc46_00455995($_smarty_tpl) {?>
<?php $_smarty_tpl->_capture_stack[0][] = array('tabs', null, null); ob_start(); ?>
    <li class="active">
        <a href="index.php?module=TopvisorProjectsAdmin">Топвизор</a>
    </li>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>


<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Топвизор проекты', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>

<div id="topvisor_heading" style="overflow: visible">
    <?php if ($_smarty_tpl->tpl_vars['balance']->value!=='') {?><span>Апометр</span> <?php } else { ?>Введите API Key <?php }?>
    <div class="helper_wrap">
        <a class="top_help" id="show_help_search" href="https://www.youtube.com/watch?v=46WgnX9JAxo" target="_blank"></a>
        <div class="right helper_block topvisor_help">
            <p>Видеоинструкция по разделу</p>
        </div>
    </div>
	<span id="balans_heading"><?php if ($_smarty_tpl->tpl_vars['balance']->value!=='') {?>Баланс: <span><?php echo $_smarty_tpl->tpl_vars['balance']->value;?>
р.</span><?php }?></span>
</div>

<form id="topvisor_key_form" method="post">
    <input type="hidden" name="session_id" value="<?php echo $_SESSION['id'];?>
"/>
    <label class="property">API key</label>
    <input name="topvisor_key" class="okay_inp" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->topvisor_key, ENT_QUOTES, 'UTF-8', true);?>
" />
    <input class="button" type="submit" value="Сохранить" name="api_settings"/>

    <a class="topvisor_link" href="https://topvisor.ru/?inv=64152" target="_blank">Перейти в Топвизор</a>
</form>

<?php if ($_smarty_tpl->tpl_vars['message_success']->value) {?>
<div class="message message_success">
	<span class="text"><?php if ($_smarty_tpl->tpl_vars['message_success']->value=='added') {?>Проект добавлен<?php } elseif ($_smarty_tpl->tpl_vars['message_success']->value=='delete') {?>Проекты были успешно удалены<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['message_success']->value;?>
<?php }?></span>
	<?php if ($_GET['return']) {?>
        <a class="button" href="<?php echo $_GET['return'];?>
">Вернуться</a>
	<?php }?>
</div>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['message_error']->value) {?>
<div class="message message_error">
	<span class="text">
        <?php if ($_smarty_tpl->tpl_vars['message_error']->value=='delete') {?>
            Проекты с id: 
            <?php  $_smarty_tpl->tpl_vars['result'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['result']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['api_results']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['result']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['result']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['result']->key => $_smarty_tpl->tpl_vars['result']->value) {
$_smarty_tpl->tpl_vars['result']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['result']->key;
 $_smarty_tpl->tpl_vars['result']->iteration++;
 $_smarty_tpl->tpl_vars['result']->last = $_smarty_tpl->tpl_vars['result']->iteration === $_smarty_tpl->tpl_vars['result']->total;
?>
                <?php echo $_smarty_tpl->tpl_vars['id']->value;?>
<?php if (!$_smarty_tpl->tpl_vars['result']->last) {?>,<?php }?>
            <?php } ?>
             - не были удалёны
        <?php } elseif ($_smarty_tpl->tpl_vars['message_error']->value=='empty_site') {?>
            Сайт должен быть заполнен.
        <?php } elseif ($_smarty_tpl->tpl_vars['message_error']->value=='Wrong API KEY') {?>
            Неверный API Key &nbsp;
            <a class="topvisor_link" href="https://topvisor.ru/?inv=64152" target="_blank">Перейти в Топвизор</a>
        <?php } elseif ($_smarty_tpl->tpl_vars['message_error']->value=='unknown_error') {?>
            Неизвестная ошибка. Возможно у вас нет соединения с интернетом.
        <?php } else { ?>
            <?php echo $_smarty_tpl->tpl_vars['message_error']->value;?>

        <?php }?>
    </span>
    <?php if ($_GET['return']) {?>
        <a class="button" href="<?php echo $_GET['return'];?>
">Вернуться</a>
	<?php }?>
</div>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['balance']->value!=='') {?>
    <div id="apometr">
        <div class="filter">
            <select class="searcher ajax_freeze">
                <option value="0">Yandex</option>
                <option value="1">Google</option>
                <option value="2">go.Mail</option>
                <option value="5">Bing</option>
            </select>
            <select class="region ajax_freeze">
                <option value="213:ru">Москва</option>
                <option value="2:ru">Санкт-Петербург</option>
                <option value="143:uk">Киев</option>
                <option value="157:be">Минск</option>
            </select>
            <input type="hidden" class="date_month" value="<?php echo date('Y-m-01');?>
" />
        </div>

        <div class="content">
            <div class="apometr"></div>
        </div>
    </div>
        <div id="header">
            <h1>Проекты</h1>
        </div>
        <form id="topvisor_projects_form" method="post">
            <input type="hidden" name="session_id" value="<?php echo $_SESSION['id'];?>
"/>
            <div id="list">
                <div class="projects_head">
                    <div class="checkbox cell">@</div>
                    <div class="cell project_name">Сайт проекта</div>
                    <div class="cell query_frequency">Состояние проверки, %</div>
                    <div class="cell query_position">Проверка позиций</div>
                    <div class="clear"></div>
                </div>
                <?php  $_smarty_tpl->tpl_vars['project'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['project']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['projects']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['project']->key => $_smarty_tpl->tpl_vars['project']->value) {
$_smarty_tpl->tpl_vars['project']->_loop = true;
?>
                    <div class="row">
                        <div class="checkbox cell">
                            <input type="checkbox" id="<?php echo $_smarty_tpl->tpl_vars['project']->value->id;?>
" name="check[]" value="<?php echo $_smarty_tpl->tpl_vars['project']->value->id;?>
"/>
                            <label for="<?php echo $_smarty_tpl->tpl_vars['project']->value->id;?>
"></label>
                        </div>
                        <div class="cell project_name">
                            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'TopvisorProjectAdmin','id'=>$_smarty_tpl->tpl_vars['project']->value->id,'return'=>$_SERVER['REQUEST_URI']),$_smarty_tpl);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['project']->value->site, ENT_QUOTES, 'UTF-8', true);?>
</a>
                        </div>
                        <div class="cell query_frequency">
                            <span class="percent_of_parse_val"><?php echo $_smarty_tpl->tpl_vars['project']->value->percent_of_parse;?>
</span>
                            <a href="javascript:;" class="check_percent_of_parse" data-id="<?php echo $_smarty_tpl->tpl_vars['project']->value->id;?>
" title="Обновить статус"></a>
                        </div>
                        <div class="cell query_position">
                            <a href="javascript:;" class="check_positions" data-id="<?php echo $_smarty_tpl->tpl_vars['project']->value->id;?>
"><span class="button_blue">Проверить</span>(<?php echo $_smarty_tpl->tpl_vars['project']->value->price;?>
р.)</a>
                        </div>
                        <div class="icons cell">
                            <a class="delete" title="Удалить" href="#"></a>
                        </div>
                        <div class="clear"></div>
                    </div>
                <?php } ?>
                <div class="row">
                    <div class="cell">
                        <label>Введите сайт: </label>
                        <input class="okay_inp" type="text" name="new_site" value=""/>
                    </div>
                    <div class="icons cell brand">
                        <input class="button" type="submit" name="add_project" value="Добавить проект"/>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <div id="action">
                <label id="check_all" class="dash_link">Выбрать все</label>
                <span id="select">
                <select name="action">
                    <option value="delete">Удалить</option>
                </select>
                </span>
                <input id="apply_action" class="button" type="submit" value="Применить"/>
            </div>

        </form>
<?php }?>


<script src="design/js/jquery/datepicker/jquery.ui.datepicker-ru.js"></script>
<script>
var apometr_data = new Array();
$(function() {

    
    <?php if ($_smarty_tpl->tpl_vars['balance']->value!=='') {?>
    
    // поисковые системы и регионы
    $(document).on('change', '#apometr .filter select', function() {
        apometr_ajax();
    });
    $('#apometr .searcher').trigger('change');
    
    function apometr_ajax() {
        $('.ajax_freeze').attr('disabled', true);
        $("#apometr .apometr").datepicker('disable');
        var searcher = $('#apometr .searcher').val(), 
            region = $('#apometr .region').val().split(':'), 
            date_month = $('#apometr .date_month').val();
        
        $.ajax({
			type: 'POST',
			url: 'ajax/topvisor.php',
			data: {'searcher': searcher, 'region_key': region[0], region_lang: region[1], date_month: date_month, module: 'apometr', session_id: '<?php echo $_SESSION['id'];?>
'},
			success: function(data){
                apometr_data = data.res;
                $('#apometr .apometr').datepicker('refresh');
                $('.ajax_freeze').attr('disabled', false);
                $("#apometr .apometr").datepicker('enable');
                $("#apometr .apometr .ui-datepicker-calendar td").each(function() {
                    if ($(this).attr('title')) {
                        $(this).append('<span class="apometr_am">' + $(this).attr('title') + '</span>');
                        $(this).removeAttr('title')
                    }
                });
			},
			dataType: 'json'
		});
    }
    
    $('#apometr .apometr').datepicker({
        firstDay: 1,
        dateFormat: 'dd.mm.yy',
        numberOfMonths: 1,
        showOtherMonths: true,
        selectOtherMonths: true,
        onChangeMonthYear: function(year, month, inst) {
            $('#apometr .date_month').val(year+'-'+(month < 10 ? '0'+month : month)+'-01');
            apometr_ajax();
        },
        beforeShowDay: function (date) {
            var d = date.getDate(), m = date.getMonth()+1, y = date.getFullYear();
            m = (m < 10 ? '0'+m : m);
            d = (d < 10 ? '0'+d : d);
            var fdate = y+'-'+m+'-'+d;
            
            var classes = '';
            var title = '';
            if (apometr_data[fdate]) {
                if (apometr_data[fdate].Am >= 0 && apometr_data[fdate].Am < 1) {
                    // sunny
                    classes = 'weather1';
                } else if (apometr_data[fdate].Am >=1 && apometr_data[fdate].Am < 2) {
                    // 1/2 sunny
                    classes = 'weather2';
                } else if (apometr_data[fdate].Am >=2 && apometr_data[fdate].Am < 4) {
                    // 1rain
                    classes = 'weather3';
                } else if (apometr_data[fdate].Am >=4 && apometr_data[fdate].Am < 6) {
                    // 3rain
                    classes = 'weather4';
                } else if (apometr_data[fdate].Am >=6 && apometr_data[fdate].Am < 9) {
                    // 1cloud&lightning
                    classes = 'weather5';
                } else if (apometr_data[fdate].Am >=9) {
                    // 2cloud&lightning
                    classes = 'weather6';
                }
                if (apometr_data[fdate].is_update != 0) {
                    classes += ' update_green';
                }
                if (apometr_data[fdate].is_update_text != 0) {
                    classes += ' update_red';
                }
                title = apometr_data[fdate].Am;
            }
            return [false, classes, title];
        }
    });
    
    $('.check_positions').on('click', function() {
        var elem = $(this);
        if (elem.data('id')) {
            $.ajax({
    			type: 'POST',
    			url: 'ajax/topvisor.php',
    			data: {'id': elem.data('id'), module: 'check_positions', session_id: '<?php echo $_SESSION['id'];?>
'},
    			success: function(data){
    				if (data.result != 1) {
    				    alert(data.message);
    				}
                    elem.closest('.row').find('.percent_of_parse_val').html('0');
    			},
    			dataType: 'json'
    		});
        }
    });

    $('.check_percent_of_parse').on('click', function() {
        var elem = $(this);
        if (elem.data('id')) {
            $.ajax({
                type: 'POST',
                url: 'ajax/topvisor.php',
                data: {'id': elem.data('id'), module: 'check_percent_of_parse', session_id: '<?php echo $_SESSION['id'];?>
'},
                success: function(data){
                    elem.closest('.query_frequency').find('.percent_of_parse_val').html(data.percent);
                },
                dataType: 'json'
            });
        }
    });
    
    <?php }?>
    
    

	
	// Выделить все
	$("#check_all").click(function() {
		$('#list input[type="checkbox"][name*="check"]').attr('checked', $('#list input[type="checkbox"][name*="check"]:not(:checked)').length>0);
	});	

	// Удалить
	$("a.delete").click(function() {
		$('#list input[type="checkbox"][name*="check"]').attr('checked', false);
		$(this).closest("div.row").find('input[type="checkbox"][name*="check"]').attr('checked', true);
		$(this).closest("form").find('select[name="action"] option[value=delete]').attr('selected', true);
		$(this).closest("form").submit();
	});
	
	// Подтверждение удаления
	$("form").submit(function() {
		if($('#list input[type="checkbox"][name*="check"]:checked').length>0)
			if($('select[name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
				return false;	
	});
 	
});
</script>

<?php }} ?>
