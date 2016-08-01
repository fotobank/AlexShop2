<?php /* Smarty version Smarty-3.1.18, created on 2016-08-01 16:52:18
         compiled from "backend\design\html\yametrika.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19555579f5412467934-27755056%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '20c6c8621bb756835faae7dc7523a079eecebd8e' => 
    array (
      0 => 'backend\\design\\html\\yametrika.tpl',
      1 => 1466581588,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19555579f5412467934-27755056',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'manager' => 0,
    'message_success' => 0,
    'settings' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_579f54125175d4_10671657',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_579f54125175d4_10671657')) {function content_579f54125175d4_10671657($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'O:\\domains\\okay\\Smarty\\libs\\plugins\\modifier.date_format.php';
?><?php $_smarty_tpl->_capture_stack[0][] = array('tabs', null, null); ob_start(); ?>
    <li>
        <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'StatsAdmin'),$_smarty_tpl);?>
">Статистика</a>
    </li>
    
    <li>
        <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'ReportStatsAdmin','filter'=>null,'status'=>null),$_smarty_tpl);?>
">Отчет о продажах</a>
    </li>
    <li>
        <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'CategoryStatsAdmin','category'=>null,'brand'=>null,'supplier'=>null,'date_from'=>null,'date_to'=>null),$_smarty_tpl);?>
">Категоризация продаж</a>
    </li>
    
	<?php if (in_array('yametrika',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li class="active">
            <a href="index.php?module=YametrikaAdmin">Яндекс.Метрика</a>
        </li>
    <?php }?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>


<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable("Яндекс.Метрика", null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>


<script src="design/js/amcharts/amcharts.js" type="text/javascript"></script>
<script src="design/js/amcharts/serial.js" type="text/javascript"></script>
<script>

	var chart;

	$(document).ready(function() {
		getCallback();
	});
	
	function getCallback()
	{
		var link2PHP = "ajax/metrika.php";
		var period = $("#period_selector").val();
		var counter = [];
			$.ajax ({
				type: "GET",
				url:link2PHP,
				data: { periodfor: period },
				dataType: "jsonp",
				async: false,
				jsonp: "callback",
				jsonpCallback: 'jsonCallback2',
				contentType: "application/json",
				success: function(json) {
					$.each(json.data.reverse(), function (index,value){
                        var data = value.date[6]+value.date[7] + '-'+ value.date[4]+value.date[5]+'-'+value.date[2]+ value.date[3];
						var metrika = {
							'date2': data,
							'visits2': value.visits,  /*Визиты*/
							'visitors2': value.visitors,  /*Посетители*/
							'page_views': value.page_views,  /*Просмотры*/
							'new_visitors': value.new_visitors, /*Новые посетители*/
							'denial': value.denial /*Отказы*/
						};
						counter.push(metrika);
						console.log(metrika);
					});
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(xhr.status);
					console.log(thrownError);
				}
			});
			initChart(counter);
	}
	
	function initChart(json)
	{
		var chart = AmCharts.makeChart("container", {
				"pathToImages": "design/js/amcharts/images/",
				"type": "serial",
				"theme": "light",
				"dataDateFormat": "DD:MM:YY",
				"language": "ru",
				"titles": [{
					"text": "Я.Метрика",
					"size": 15
				}],
				"legend": {
					"equalWidths": true,
					"useGraphSettings": true,
					"valueAlign": "right",
					"valueWidth": 120

				},
				"valueAxes": [ {
					"id": "visitsAxis",
					"axisAlpha": 0,
					"gridAlpha": 0,
					"labelsEnabled": false,
					"position": "left"
				}, {
					"id": "visitorsAxis",
					"axisAlpha": 0,
					"gridAlpha": 0,
					"inside": false,
					"position": "right",
					"title": "Количество"
				}],
				"graphs": [  {
					"bullet": "round",
					"bulletBorderAlpha": 1,
					"balloonText": "Посетителей:[[value]]",

					"legendPeriodValueText": "Всего: [[value.sum]]",
					"legendValueText": "[[value]]",
					"title": "Посетителей",
					"fillAlphas": 0.6,
					"valueField": "visitors2",
					"valueAxis": "visitorsAxis"
				},
				{
					"balloonText": "Посещений:[[value]]",
					"bullet": "round",
					"bulletBorderAlpha": 1,
					"useLineColorForBulletBorder": true,
					"bulletColor": "#FFFFFF",
					"bulletSizeField": "townSize",
					"dashLengthField": "dashLength",

					"labelPosition": "right",
					"legendPeriodValueText": "Всего: [[value.sum]]",
					"legendValueText": "[[value]]",
					"title": "Посещений",
					"fillAlphas": 0,
					"valueField": "visits2",
					"valueAxis": "visitorsAxis"
				},
				{
					"balloonText": "Просмотры страниц:[[value]]",
					"bullet": "round",
					"bulletBorderAlpha": 1,
					"useLineColorForBulletBorder": true,
					"bulletColor": "#FFFFFF",
					"bulletSizeField": "townSize",
					"dashLengthField": "dashLength",

					"labelPosition": "right",
					"legendPeriodValueText": "Всего: [[value.sum]]",
					"legendValueText": "[[value]]",
					"title": "Просмотров",
					"fillAlphas": 0,
					"valueField": "page_views",
					"valueAxis": "visitorsAxis"
				},
				{
					"balloonText": "Новые посетители:[[value]]",
					"bullet": "round",
					"bulletBorderAlpha": 1,
					"useLineColorForBulletBorder": true,
					"bulletColor": "#FFFFFF",
					"bulletSizeField": "townSize",
					"dashLengthField": "dashLength",

					"labelPosition": "right",
					"legendPeriodValueText": "Всего: [[value.sum]]",
					"legendValueText": "[[value]]",
					"title": "Новых посетителей",
					"fillAlphas": 0,
					"valueField": "new_visitors",
					"valueAxis": "visitorsAxis"
				},
				{
					"balloonText": "Отказы:[[value]]",
					"bullet": "round",
					"bulletBorderAlpha": 1,
					"useLineColorForBulletBorder": true,
					"bulletColor": "#FFFFFF",
					"bulletSizeField": "townSize",
					"dashLengthField": "dashLength",

					"labelPosition": "right",
					"legendPeriodValueText": "Всего: [[value.sum]]",
					"legendValueText": "[[value]]",
					"title": "Отказов",
					"fillAlphas": 0,
					"valueField": "denial",
					"valueAxis": "visitorsAxis"
				}
				],
				"chartScrollbar": {
				
					"gridCount": 7,
					"scrollbarHeight": 25,
					"graphType": "line",
					"usePeriod": "WW",
					"backgroundColor": "#56b9ff",
					"graphFillColor": "#56b9ff",
					"graphFillAlpha": 0.5,
					"gridColor": "#555",
					"gridAlpha": 1,
					"selectedBackgroundColor": "#444",
					"selectedGraphFillAlpha": 1
				},
				"chartCursor": {
					"categoryBalloonDateFormat": "DD MMM",
					"cursorAlpha": 0.1,
					"cursorColor":"#56b9ff",
					"fullWidth":true,
					"valueBalloonsEnabled": true,
					"zoomable": true
				},
				"dataProvider": json ,
				"dataDateFormat": "DD:MM:YY",
				"categoryField": "date2"
			});
	}
	
		
</script>



<div id="header">
	<h1>Яндекс.Метрика для сайта</h1> 	
</div>

<?php if ($_smarty_tpl->tpl_vars['message_success']->value) {?>
    <!-- Системное сообщение -->
    <div class="message message_success">
        <span class="text">
        <?php if ($_smarty_tpl->tpl_vars['message_success']->value=='saved') {?>Настройки сохранены<?php }?>
        </span>
        <?php if ($_GET['return']) {?>
        <a class="button" href="<?php echo $_GET['return'];?>
">Вернуться</a>
        <?php }?>
    </div>
    <!-- Системное сообщение (The End)-->
<?php }?>

<!-- Счетчики -->
    <div class="block layer">
        <?php if (!$_smarty_tpl->tpl_vars['settings']->value->yandex_metrika_app_id||!$_smarty_tpl->tpl_vars['settings']->value->yandex_metrika_token) {?>
            <h2 style="color: red;">Заполните поля (ID приложения) и/или (Токен) в настройках магазина</h2>
        <?php }?>
            <h2>Статистика</h2>
                <select id="period_selector" name="period">
                      <option value="<?php echo smarty_modifier_date_format(time(),"%Y%m%d");?>
">За сегодня</option> <!-- today -->
                      <option value="<?php echo smarty_modifier_date_format("-1 day","%Y%m%d");?>
">За вчера</option> <!-- yesterday -->
                      <option value="<?php echo smarty_modifier_date_format("-7 days","%Y%m%d");?>
">За неделю</option> <!-- week -->
                      <option value="<?php echo smarty_modifier_date_format("-1 month","%Y%m%d");?>
">За месяц</option> <!-- month -->
                      <option value="<?php echo smarty_modifier_date_format("-3 month","%Y%m%d");?>
">За квартал</option> <!-- quarter -->
                      <option value="<?php echo smarty_modifier_date_format("-1 year","%Y%m%d");?>
">За год</option> <!-- year -->
                </select>
        <input class="button_green" id="show_statistic" type="button" onclick="getCallback()" value="Отобразить" />

        <div>
            <div id="container" style="width: 100%; height: 800px;"></div>
        </div>
    </div>
<!-- @Счетчики -->
		
		<?php }} ?>
