/**
 * Created by Jurii on 08.02.2017.
 */

$(document).ready(function () {

    jQuery(function ($) {

        var sPath = window.location.pathname;
        var sPage = sPath.substring(sPath.lastIndexOf('/') + 1);

        var colN = null, colM = null;
        colN = store.get( 'names_translations' );
        colM = store.get( 'models_translations' );

        if (colN == null || colM == null || colN.length != colM.length) {
            // получаем шапку таблицы
            $.ajax({
                url: sPage + '?module=JqGridAjaxTranslations',
                type: "POST",
                data: "jqgrid_heading=1",
                dataType: "json",
                success: function (data, st) {
                    if (st == "success") {
                        colN = data.head;//jqgrid heading data
                        colM = data.model; // its column model
                        store.set( "names_translations", colN );
                        store.set( "models_translations", colM );
                        // работаем в асинхронном режиме
                        createGrid();
                    }
                },
                error: function () {
                    alert("Error with AJAX callback");
                }
            });
            // для работы в ассинхронном режиме не выносим createGrid() в низ.
        } else {
            createGrid();
        }

        /**
         * Эта функция формирует пост запрос
         * для массивов letters=[a,b,c,d,e]
         * сформирует letters[]=a,letters[]=b и т.д.
         * + экранируется лишний код &<>
         * @param data array|string массив
         * @returns {string}
         */
        function serialize(data) {
            var str = [];
            if (data.letters) {
                data.letters = data.letters.split(",");
            }
            for (var i in data) {
                if (data.hasOwnProperty(i) && $.isArray(data[i])) {
                    for (var j in data[i]) {
                        if (data[i].hasOwnProperty(j) && $.isArray(data[i][j])) {
                            str.push(i + "[]=" + encodeURI(data[i][j]));
                        }
                    }
                } else {
                    str.push(i + "=" + encodeURI(data[i]));
                }
            }
            return str.join("&");
        }

        // для строчного редактирования
        var lastSel;

        function createGrid() {
            if (colN.length != colM.length) {
                console.error("(colN = " + colN.length + " ; colM = " + colM.length + ") " + $.jgrid.regional[currentlang].errors.model);
                return void(0);
            }

            $("#list").jqGrid({
                url: sPage + '?module=JqGridAjaxTranslations',
                mtype: "POST",
                datatype: "json",
                colNames: colN,
                colModel: colM,
                autowidth: true,
                height: "100%",
                regional : 'ru',
                sortname: 'id',
                sortorder: "desc",
                caption: "Переводы переменных в шаблонах",
                pager: "#grid-pager",
                viewrecords: true,
                rowList: [10, 20, 30, 50, 100],
                rowNum: 20,
                sortable:true,
                /** загрузка только один раз */
                loadonce: false,
                editurl: sPage + '?module=JqGridAjaxTranslations',
                /** редактирование двойным кликом */
                /*ondblClickRow: function(id){
                if(id && id!==lastSel){
                    jQuery(this).restoreRow(lastSel);
                    jQuery(this).editRow(id, false);
                    lastSel=id;
                }
                jQuery(this).editRow(id, true);
                },
                onSelectRow: function(id){
                    if(id && id!==lastSel){
                         jQuery(this).restoreRow(lastSel);
                    }
                },*/
                /** редактирование по одной ячейке */
                cellEdit: true,
                cellsubmit: 'remote',
                cellurl: sPage + '?module=JqGridAjaxTranslations',
                afterSaveCell: function () {
                    $(".label-message").remove();
                    $(".ui-jqgrid-title").after("<span class='label-message'><span id='success-message'>успешно сохранено</span></span>").show('slow');
                    setTimeout(function() { $("#success-message").hide('slow').remove(); }, 3000);
                },
                errorCell: function () {
                    $(".label-message").remove();
                    $(".ui-jqgrid-title").after("<span class='label-message'><span id='error-message'>ошибка сервера "+status+" при сохранении</span></span>").show('slow');
                    setTimeout(function() { $("#error-message").hide('slow').remove(); }, 3000);
                },

                /**
                 * Если пользователь запросил страницу номер которой больше чем максимальное
                 * количество страниц, или меньше чем 1, эта функция вернет его обратно
                 * в позволенные рамки
                 */
                onPaging: function () {
                    var curPage = $(this).jqGrid("getGridParam", "page");
                    var lastPage = $(this).jqGrid("getGridParam", "lastpage");
                    if (curPage < 1) {
                        this.p.page = 1;
                    }
                    if (curPage > lastPage) {
                        this.p.page = lastPage;
                    }
                }

            }).jqGrid("navGrid", "#grid-pager",
                {view:true, del:true, add:true, edit:true}, // показать/скрыть кнопки добавить/редактировать/удалить/поиск/обновить
                {  // опции для редактирования
                    modal: true, // диалог модальный
                    url: sPage + '?module=JqGridAjaxTranslations', // бэкэнд
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
                        var json = eval("(" + response.responseText + ");");
                        return [!json.message, json.message];
                    },

                    serializeEditData: serialize // описание функции в начале
                },
                {  // опции для добавления, все так же как и прошлый раз
                    modal: true,
                    url: sPage + '?module=JqGridAjaxTranslations',
                    closeAfterAdd: true, // закрыть диплог после добавления
                    mtype: "POST",
                    afterSubmit: function (response) {
                        var json = eval("(" + response.responseText + ");");
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
                    url: sPage + '?module=JqGridAjaxTranslations',
                    mtype: "POST",
                    closeAfterDelete: true,
                    afterSubmit: function (response) {
                        var json = eval("(" + response.responseText + ");");
                        return [!json.message, json.message];
                    },
                    serializeDelData: serialize
                },
                { // опции поиска
                    searchOnEnter: true,
                    showQuery: false,
                    width: 540,
                    sopt: ["cn", "eq", "ne", "bw"], // ограничиваю критерии
                    multipleSearch: true, // можно искать по нескольким полям
                    closeAfterSearch: true, // закрыть после поиска
                    closeOnEscape: true // окно поиска закроется при нажатии на клавишу «Esc»;
                }
            ).jqGrid('navButtonAdd',"#grid-pager",{
                caption: "",
                buttonicon: "ui-icon-closethick",
                onClickButton: function () {
                    store.remove( "names_translations" );
                    store.remove( "models_translations" );
                    $("#success-message-ok").remove();
                    $(".navtable .ui-icon-closethick").after("<span id='success-message-ok'>выполнено</span>").show('slow');
                    setTimeout(function() { $("#success-message-ok").hide('slow').remove(); }, 1000);
                },
                position: "last",
                title: "Очистить кеш названий столбцов"
            });
        }
        //эта функция добавляет GET параметр в запрос на получение
        //данных для таблицы и обновляет её
        function updateTable(value) {
            console.log('value = ' + value);
            /*jQuery("#list")
                .setGridParam({url: sPage + "?module=JqGridAjaxTranslations&sel_city=" + value, page: 1})
                .trigger("reloadGrid");*/
        }

        //настройка плагина Autocomplete
        //при возникновении события onSelect вызываем функцию updateTable
        $('#city_field').autocomplete({
            serviceUrl: sPage + '?module=JqGridAjaxTranslations',
            type: "POST",
            params: { 'search': 'autocomplete'},
            maxHeight:150,
        //    minChars: 2, //миниальное число символов
        //    deferRequestBy: 100, // отложить запрос на миллисекунд
            onSelect: function(value) {
                updateTable(value);
            }
        });

        //этот обработчик используется если посетитель ввел данные и нажал Enter
        $('#autocomplete_form').submit(function() {
        //    console.log('updateTable');
            updateTable($('#city_field').val());
            return false;
        });
    });

});
