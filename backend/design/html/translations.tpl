{capture name=tabs}
    {if in_array('settings', $manager->permissions)}
        <li>
            <a href = "index.php?module=SettingsAdmin">Настройки</a>
        </li>
    {/if}
    {if in_array('currency', $manager->permissions)}
        <li>
            <a href = "index.php?module=CurrencyAdmin">Валюты</a>
        </li>
    {/if}
    {if in_array('delivery', $manager->permissions)}
        <li>
            <a href = "index.php?module=DeliveriesAdmin">Доставка</a>
        </li>
    {/if}
    {if in_array('payment', $manager->permissions)}
        <li>
            <a href = "index.php?module=PaymentMethodsAdmin">Оплата</a>
        </li>
    {/if}
    {if in_array('managers', $manager->permissions)}
        <li>
            <a href = "index.php?module=ManagersAdmin">Менеджеры</a>
        </li>
    {/if}
    {if in_array('languages', $manager->permissions)}
        <li>
            <a href = "index.php?module=LanguagesAdmin">Языки</a>
        </li>
    {/if}
    <li class = "active">
        <a href = "index.php?module=TranslationsAdmin">Переводы</a>
    </li>
{/capture}

{* Title *}
{$meta_title='Переводы' scope=parent}

{* Заголовок *}
<div id = "header">
	<h1>Переводы</h1>
	<a class = "add" href = "{url module=TranslationAdmin}">Добавить перевод</a>
</div>
<div id = "main_table">
    <div class = "clearfix">
    <h2 class = "streamlined">переменные используемые в шаблонах</h2>
<form id = "form-search" method = "get">
    <div id = "search">
        <input id = "input-filter" class = "search" type = "text" value = "" placeholder = "Search...">
        <input class = "search_button" type = "text" value = "">
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


<script type = "text/ecmascript" src = "design/js/jqGrid/js/jquery.jqGrid.min.js"></script>
    <script type = "text/ecmascript" src = "design/js/jqGrid/js/i18n/grid.locale-ru.js"></script>
    <link rel = "stylesheet" type = "text/css" media = "screen" href = "design/js/jqGrid/css/ui.jqgrid.css"/>
    <link rel = "stylesheet" type = "text/css" media = "screen" href = "design/js/jqGrid/css/ui.jqgrid-mail.css"/>



    <table id = "jqGrid"></table>
    <div id = "jqGridPager"></div>

    <script type = "text/javascript">

        $(document).ready(function () {


            var _cn = 'cookie_name';

            function delete_cookie(cookie) {
                $.cookie(cookie, null);
            }

            function getArrayCookie(cookie) {
                var cookie_str = $.cookie(cookie);
                var kv = [];
                var arr_c = { };
                if (cookie_str != null) {
                    var arr = cookie_str.split(';');
                    for (var i = 0; i < arr.length - 1; i++) {
                        kv = arr[i].split('=');
                        arr_c[kv[0]] = kv[1];
                    }
                }
                return arr_c;
            }
            function getParam(cookie, name) {
                var arr_c = getArrayCookie(cookie);
                return (arr_c[name] == null ) ? 0 : arr_c[name];
            }
            function setParam(cookie, name, value) {
                var arr_c = getArrayCookie(cookie);
                arr_c[name] = value;
                var cookie_str ='';
                for (var key in arr_c) {
                    cookie_str += key + '=' + arr_c[ key ] + ';';
                }
                $.cookie(cookie, cookie_str);
            }


                    jQuery(function ($) {

                        var ColN, ColM;
                        ColN = $.cookie("ColN");
                        ColM = $.cookie("ColM");
                        var sPath = window.location.pathname;
                        var sPage = sPath.substring(sPath.lastIndexOf('/') + 1);

                        if (typeof ColN == 'undefined' || typeof ColM == 'undefined') {
                            $.ajax({
                                url: sPage + '?module=TranslationsAdmin',
                                type: "POST",
                                data: "jqgrid_heading=1",
                                dataType: "json",
                                success: function (data, st) {
                                    if (st == "success") {
                                        ColN = data.head;//jqgrid heading data
                                        ColM = data.model; // its column model
                                        $.cookie("ColN", JSON.stringify(ColN), { expires: 1 });
                                        $.cookie("ColM", JSON.stringify(ColM), { expires: 1 });
                                    }
                                },
                                error: function () {
                                    alert("Error with AJAX callback");
                                }
                            });
                        }
                            createGrid();

                        function createGrid2() {
                            $("#jqGrid").jqGrid({
                                autowidth: true,
                                url: sPage + '?module=TranslationsAdmin',
                                editurl: sPage + '?module=TranslationsAdmin',
                                mtype: "POST",
                                ajaxGridOptions: {
                                    contentType: 'application/json; charset=utf-8',
                                    cache: false,
                                    data: {
                                        jqgrid_body: "1",
                                        sort: 'date' // соортировка по столбцу id
                                    }
                                },
                                datatype: "json",
                                viewrecords: true,
                                colNames: ColN,
                                colModel: ColM,
                                width: 945,
                                height: "100%",
                                rowNum: 20,
                                loadonce: true, // загрузка только один раз
                                rowList: [10, 20, 30, 40, 50, 100],
                                pager: "#jqGridPager",
//                    sortname: 'id', // сортировка по умолчанию по столбцу Id
//                    sortorder: "asc", // порядок сортировки
                                caption: "Переводы переменных в шаблонах",
//                    serializeGridData: function (postData) {
//                        return JSON.stringify(postData);
//                    },
//                    jsonReader: { repeatitems: false, root: "rows", page: "page", total: "total", records: "records" }
                            });
                        }

                        /**
                         * функция для построения select"a
                         * @param response ответ ajax"a
                         */
                        function build(response) {
                            var html = "", template = "<option value='[value]'>[name]</option>";
                            $(eval("(" + response.responseText + ")")).each(function (i, val) {
                                html += template.replace(/(\[([^\[\]]+)\])/g, function ($0, $1, $2) {
                                    return val[$2] || "";
                                });
                            });
                            return "<select>" + html + "</select>";
                        }

                        /**
                         * Эта функция формирует пост запрос и для массивов сформирует
                         * переменную вида letters=a,b,c,d,e
                         * я переделываю это все в letters[]=a,letters[]=b итд
                         * заодно экранирую всякую ересь вроде &<>
                         * @param data массив всех данных формы
                         */
                        function serialize(data) {
                            var str = [];
                            if (data.letters) {
                                data.letters = data.letters.split(",");
                            }
                            for (var i in data) {
                                if ($.isArray(data[i])) {
                                    for (var j in data[i]) {
                                        str.push(i + "[]=" + encodeURI(data[i][j]));
                                    }
                                } else {
                                    str.push(i + "=" + encodeURI(data[i]));
                                }
                            }
                            return str.join("&");
                        }

                        function createGrid() {
                            $("#jqGrid").jqGrid({
                                autowidth: true,
                                height: "100%",
                                colNames: ColN,
                                colModel: ColM,
                                sortname: 'id',
                                sortorder: "asc",
                                caption: "Переводы переменных в шаблонах",
                                pager: "#jqGridPager",
                                datatype: "json",
                                viewrecords: true,
                                url: sPage + '?module=TranslationsAdmin',
                                editurl: sPage + '?module=TranslationsAdmin',
                                mtype: "POST",
                                rowNum: 20,
                                //    loadonce: true, // загрузка только один раз
                                ajaxGridOptions: {
                                    cache: false,
                                    data: {
                                        jqgrid_body: "1",
                                        sort: 'date' // соортировка по столбцу id
                                    }
                                },
                                /**
                                 * Если пользователь запросил страницу номер которой больше чем максимальное
                                 * количество страниц, или меньше чем 1, эта функция вернет его обратно
                                 * в позволенные рамки
                                 */
                                onPaging: function (pgButton) {
                                    var curPage = $(this).jqGrid("getGridParam", "page");
                                    var lastPage = $(this).jqGrid("getGridParam", "lastpage");
                                    if (curPage < 1) {
                                        this.p.page = 1;
                                    }
                                    if (curPage > lastPage) {
                                        this.p.page = lastPage;
                                    }
                                }
                            }).jqGrid("navGrid", "#jqGridPager",
                                {}, // показать/скрыть кнопки добавить/редактировать/удалить/поиск/обновить
                                {  // опции для редактирования
                                    modal: false, // диалог модальный
                                    url: sPage + '?module=TranslationsAdmin', // бэкэнд
                                    closeAfterEdit: true, // закрыть диплог после редактирования
                                    reloadAfterSubmit: false, // перезагрузить таблицу после добавления
                                    mtype: "POST", // тип запроса, перекрывает все предыдущие настройки
                                    /**
                                     * с помощью этой функции можно показать ошибки заполнения формы
                                     * а так же вставить новый ряд с id который пришел с сервера
                                     * error - { "message" : "Epic Fail!" }
                                     * succes - { "message" : "" }
                                     * @param response
                                     */
                                    afterSubmit: function (response) {
                                        var json = eval("(" + response.responseText + ")");
                                        return [!json.message, json.message];
                                    },

                                    serializeEditData: serialize // описание функции в начале
                                },
                                {  // опции для добавления, все так же как и прошлый раз
                                    modal: true,
                                    url: sPage + '?module=TranslationsAdmin',
                                    closeAfterAdd: true, // закрыть диплог после добавления
                                    reloadAfterSubmit: false,
                                    mtype: "POST",
                                    afterSubmit: function (response) {
                                        var json = eval("(" + response.responseText + ")");
                                        return [!json.message, json.message, json.id];
                                    },
                                    /**
                                     * Отменяем магию которую сотворила эта же функция при редактировании
                                     * @param form форма
                                     */
                                    afterShowForm: function (form) {
                                        $("select", form).removeAttr("disabled");
                                    },
                                    serializeEditData: serialize
                                },
                                { // опции для удаления
                                    modal: true,
                                    url: sPage + '?module=TranslationsAdmin',
                                    reloadAfterSubmit: false,
                                    mtype: "POST",
                                    afterSubmit: function (response) {
                                        var json = eval("(" + response.responseText + ")");
                                        return [!json.message, json.message];
                                    },
                                    serializeDelData: serialize
                                },
                                { // опции поиска
                                    sopt: ["eq", "ne", "in", "cn"], // ограничиваю критерии
                                    multipleSearch: true, // можно искать по нескольким полям
                                    closeAfterSearch: true, // закрыть после поиска
                                    closeOnEscape: true // окно поиска закроется при нажатии на клавишу «Esc»;
                                }
                            );
                        }
                    });
                }
            );
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

$(function () {

    // Раскраска строк
    function colorize() {
        $("#list div.row:even").addClass('even');
        $("#list div.row:odd").removeClass('even');
    }

    // Раскрасить строки сразу
    colorize();
    // Выделить все
    $("#check_all").click(function () {
        $('#list input[type="checkbox"][name*="check"]').attr('checked', $('#list input[type="checkbox"][name*="check"]:not(:checked)').length > 0);
    });
    // Удалить
    $("a.delete").click(function () {
        $('#list input[type="checkbox"][name*="check"]').attr('checked', false);
        $(this).closest(".row").find('input[type="checkbox"][name*="check"]').attr('checked', true);
        $(this).closest("form").find('select[name="action"] option[value=delete]').attr('selected', true);
        $(this).closest("form").submit();
    });
    $("#list_form").submit(function () {
        if ($('select[name="action"]').val() == 'delete' && !confirm('Подтвердите удаление'))
            return false;
    });

});
</script>
{/literal}
