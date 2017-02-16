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

<script src = "/backend/design/js/jqGrid/js/i18n/grid.locale-ru.js"></script>
    <script src = "/backend/design/js/jqGrid/js/jquery.jqGrid.min.js"></script>
    <script src = "/backend/design/js/jqGrid/js/jq.grid.admin.translations.js"></script>
    <script src = "/backend/design/js/jquery.filtertable/jquery.filtertable.min.js"></script>

    <link rel = "stylesheet" type = "text/css" media = "screen" href = "/backend/design/js/jqGrid/css/ui.jqgrid.css"/>
    <link rel = "stylesheet" type = "text/css" media = "screen"
          href = "/backend/design/js/jqGrid/css/ui.jqgrid-main.css"/>

{* Заголовок *}
<div id = "header">
	<h1>Переводы</h1>
	<a class = "add" href = "{url module=TranslationAdmin}">Добавить перевод</a>
</div>
<div id = "main_table">
    <div class = "clearfix">
    <h2 class = "streamlined">переменные используемые в шаблонах</h2>
        <form action = "#" id = "form-search-autocomplete" method = "post">
            <div id = "search">
                <input id = "input-filter" class = "search" type = "text" value = "" placeholder = "Search...">
                <button class = "search_button"></button>
            </div>
        </form>
    </div>
     <table id = "list"></table>
     <div id = "grid-pager"></div>
</div>
