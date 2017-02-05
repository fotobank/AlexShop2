{capture name=tabs}
	{if in_array('settings', $manager->permissions)}
        <li>
            <a href="index.php?module=SettingsAdmin">Настройки</a>
        </li>
    {/if}
	{if in_array('currency', $manager->permissions)}
        <li>
            <a href="index.php?module=CurrencyAdmin">Валюты</a>
        </li>
    {/if}
	{if in_array('delivery', $manager->permissions)}
        <li>
            <a href="index.php?module=DeliveriesAdmin">Доставка</a>
        </li>
    {/if}
	{if in_array('payment', $manager->permissions)}
        <li>
            <a href="index.php?module=PaymentMethodsAdmin">Оплата</a>
        </li>
    {/if}
	{if in_array('managers', $manager->permissions)}
        <li>
            <a href="index.php?module=ManagersAdmin">Менеджеры</a>
        </li>
    {/if}
    {if in_array('languages', $manager->permissions)}
        <li>
            <a href="index.php?module=LanguagesAdmin">Языки</a>
        </li>
    {/if}
	<li class="active">
        <a href="index.php?module=TranslationsAdmin">Переводы</a>
    </li>
{/capture}

{* Title *}
{$meta_title='Переводы' scope=parent}

{* Заголовок *}
<div id="header">
	<h1>Переводы</h1>
	<a class="add" href="{url module=TranslationAdmin}">Добавить перевод</a>
</div>
<div id="main_table">
    <div class="clearfix">
    <h2 class="streamlined">переменные используемые в шаблонах</h2>
<form id="form-search" method="get">
    <div id="search">
        <input id="input-filter" class="search" type="text" value="" placeholder="Search...">
        <input class="search_button" type="text" value="">
    </div>
</form>
    </div>
    {*<div>Сортировка переводов:</div>*}
    {*<ul class="sort_translation">
        <li>
            <a {if $sort=='translation' || $sort=='translation_desc'} class="selected" {/if} href="{if $sort=='translation'}{url sort=translation_desc}{else}{url sort=translation}{/if}">По переводу &nbsp;{if $sort=='translation_desc'}&#8659;{else}&#8657;{/if}</a>
        </li>
        <li>
            <a {if $sort=='date' || $sort=='date_desc'} class="selected" {/if}href="{if $sort=='date'}{url sort=date_desc}{else}{url sort=date}{/if}">По новизне &nbsp;{if $sort=='date_desc'}&#8659;{else}&#8657;{/if}</a>
        </li>
        <li>
            <a {if $sort=='label' || $sort=='label_desc' || !$sort} class="selected" {/if}href="{if $sort=='label' || !$sort}{url sort=label_desc}{else}{url sort=null}{/if}">По переменной &nbsp;{if $sort=='label_desc'}&#8659;{else}&#8657;{/if}</a>
        </li>
    </ul>*}
	{*<form id="list_form" method="post">
        <input type="hidden" name="session_id" value="{$smarty.session.id}">

        <table id="list">
             <thead>
            <tr>
                <th>#</th>
                <th>название переменной</th>
                {foreach $langs_label as $lang}
                    <th>{$lang}</th>
                {/foreach}
                <th>#</th>
            </tr>
        </thead>
           <tbody>
            {foreach $translations as $translation}
                <tr class="{if !$translation->enabled}invisible{/if} row">
                    <td class="checkbox cell">
                        <input type="checkbox" id="{$translation->id}" name="check[]" value="{$translation->id}" />
                        <label for="{$translation->id}"></label>
                    </td>
                     <td class="name">
                        <span>
                         <a href="{url module=TranslationAdmin id=$translation->id return=$smarty.server.REQUEST_URI}">{$translation->label|escape}</a>
                         </span>
                    </td>
                    {foreach $langs_label as $lang}
                        <td class="name">
                        <span>
                            <a href="{url module=TranslationAdmin id=$translation->id return=$smarty.server.REQUEST_URI}">{$translation->lang_{$lang}|escape}</a>
                        </span>
                    </td>
                    {/foreach}
                    <td class="icons">
                        <a class="delete" title="Удалить" href="#"></a>
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>

        <div id="action">
        <label id="check_all" class='dash_link'>Выбрать все</label>
        <span id="select">
            <select name="action">
                <option value="delete">Удалить</option>
            </select>
        </span>
        <input id="apply_action" class="button_green" type="submit" value="Применить">
        </div>
	</form>*}
</div>


{*<div id="jsGrid"></div>*}

{*шапка таблицы*}
{capture name=head_trans}
    [
    {ldelim} name: "id", sorter: "number", autosearch: false, readOnly: true,  width: 35{rdelim},
    {ldelim} name: "название переменной", type: "textarea", autosearch: true, validate: "required" {rdelim},
    {foreach from=$langs_label item=lang}
        {ldelim} name: "{$lang}", type: "textarea", autosearch: true {rdelim},
    {/foreach}
    {ldelim} type: "control" {rdelim}
    ]
{/capture}

{*тело таблицы*}
{capture name=body_trans}
    [
    {foreach from=$translations item=trans}
        {ldelim}"id": "{$trans->id}", "название переменной": "{$trans->label|escape|strip}",
        {foreach from=$langs_label item=type}
            "{$type}": "{$trans->lang_{$type}|escape|strip}",
        {/foreach}
        {rdelim},
    {/foreach}
    ]
{/capture}


    <script type="text/ecmascript" src="design/js/jqGrid/js/jquery.jqGrid.min.js"></script>
    <script type="text/ecmascript" src="design/js/jqGrid/js/i18n/grid.locale-ru.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="design/js/jqGrid/css/ui.jqgrid.css" />


    <table id="jqGrid"></table>
    <div id="jqGridPager"></div>

    <script type="text/javascript">

        $(document).ready(function () {
            $("#jqGrid").jqGrid({
                url: 'index.php?module=TranslationsAdmin',
                editurl: 'clientArray',
                mtype: "GET",
                datatype: "json",
                page: 1,
                colModel: [
                    { label: 'Order ID', name: 'OrderID', key: true, width: 75 },
                    {   label: 'Order Date',
                        name: 'OrderDate',
                        width: 150,
                        editable: true,
                        edittype:"text",
                        editoptions: {
                            dataInit: function (element) {
                                $(element).datepicker({
                                    id: 'orderDate_datePicker',
                                    dateFormat: 'M/d/yy',
                                    //minDate: new Date(2010, 0, 1),
                                    maxDate: new Date(2020, 0, 1),
                                    showOn: 'focus'
                                });
                            }
                        }
                    }
                ],
                onSelectRow: editRow,
                viewrecords: true,
                width: 750,
                height: 250,
                rowNum: 20,
                pager: "#jqGridPager"
            });

            var lastSelection;

            function editRow(id) {
                if (id && id !== lastSelection) {
                    var grid = $("#jqGrid");
                    grid.jqGrid('restoreRow',lastSelection);

                    lastSelection = id;
                }
            }
        });

    </script>



























    {*<link type="text/css" rel="stylesheet" href="design/js/jsgrid/jsgrid.min.css" />*}
    {*<link type="text/css" rel="stylesheet" href="design/js/jsgrid/jsgrid-theme.min.css" />*}
    {*<script type="text/javascript" src="design/js/jsgrid/jsgrid.min.js"></script>*}
    {*<script type="text/javascript" src="design/js/jsgrid/i18n/jsgrid-ru.js"></script>*}

    <script>

       {*$("#jsGrid_").jsGrid({ldelim}*}
//            width: "100%",
//            height: "70%",
//
//            filtering: true,
//            inserting: true,
//            editing: true,
//            sorting: true,
//            paging: true,
//            autoload: true,
//            pageSize: 10,
//            pageButtonCount: 5,
//
            {*fields: {$smarty.capture.head_trans},*}
           {*data: {$smarty.capture.body_trans},*}

            /*loadData: function(filter) {
                return $.ajax({
                    type: "GET",
                    url: "index.php?module=TranslationsAdmin&get",
                    data: filter
                });
            },*/
            /*insertItem: function(item) {
                return $.ajax({
                    type: "POST",
                    url: "index.php?module=TranslationsAdmin&post",
                    data: item
                });
            },

            updateItem: function(item) {
                return $.ajax({
                    type: "PUT",
                    url: "index.php?module=TranslationsAdmin&put",
                    data: item
                });
            },

            deleteItem: function(item) {
                return $.ajax({
                    type: "DELETE",
                    url: "index.php?module=TranslationsAdmin&delete",
                    data: item
                });
            },*/

            /*invalidNotify: function(args) {
                var messages = $.map(args.errors, function(error) {
                    return error.field + ": " + error.message;
                });

                console.log(messages);
            }*/
//        });
//        jsGrid.locale("ru");
//        jsGrid.setDefaults("text", {
//            width: 150
//        });


    </script>

{literal}

<script>
//     $(document).ready(function() {
//         $('table').filterTable({
//             filterExpression: 'filterTableFindAll',
//            inputSelector: '#input-filter'
//         });
//     });
</script>

<script>

$(function() {

	// Раскраска строк
	function colorize()
	{
		$("#list div.row:even").addClass('even');
		$("#list div.row:odd").removeClass('even');
	}
	// Раскрасить строки сразу
	colorize();
	// Выделить все
	$("#check_all").click(function() {
		$('#list input[type="checkbox"][name*="check"]').attr('checked', $('#list input[type="checkbox"][name*="check"]:not(:checked)').length>0);
	});
	// Удалить 
	$("a.delete").click(function() {
		$('#list input[type="checkbox"][name*="check"]').attr('checked', false);
		$(this).closest(".row").find('input[type="checkbox"][name*="check"]').attr('checked', true);
		$(this).closest("form").find('select[name="action"] option[value=delete]').attr('selected', true);
		$(this).closest("form").submit();
	});
	$("#list_form").submit(function() {
		if($('select[name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
			return false;	
	});

});
</script>
{/literal}
