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
                url: sPage + '?module=AjaxTranslationsAdmin',
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

        function createGrid() {
            if (colN.length != colM.length) {
                console.error("(colN = " + colN.length + " ; colM = " + colM.length + ")" + $.jgrid.regional["ru"].errors.model);
                return void(0);
            }

            $("#grid-translations-table").jqGrid({
                autowidth: true,
                height: "100%",
                colNames: colN,
                colModel: colM,
                sortname: 'id',
                sortorder: "asc",
                caption: "Переводы переменных в шаблонах",
                pager: "#grid-translations-pager",
                datatype: "json",
                viewrecords: true,
                url: sPage + '?module=AjaxTranslationsAdmin',
                mtype: "POST",
                rowList: [10, 20, 30, 50, 100],
                rowNum: 20,
                sortable:true,
                loadonce: false, // загрузка только один раз
                excelexport: true,
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
            }).jqGrid("navGrid", "#grid-translations-pager",
                {view:true, del:true, add:true, edit:true}, // показать/скрыть кнопки добавить/редактировать/удалить/поиск/обновить
                {  // опции для редактирования
                    modal: false, // диалог модальный
                    url: sPage + '?module=AjaxTranslationsAdmin', // бэкэнд
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
                        // var retMess = JSON.parse(response.responseText);
                        // console.log(retMess.message);

                        var json = eval("(" + response.responseText + ");");
                        return [!json.message, json.message];
                    },

                    serializeEditData: serialize // описание функции в начале
                },
                {  // опции для добавления, все так же как и прошлый раз
                    modal: true,
                    url: sPage + '?module=AjaxTranslationsAdmin',
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
                    modal: false,
                    url: sPage + '?module=AjaxTranslationsAdmin',
                    mtype: "POST",
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
            );
        }
    });

});
