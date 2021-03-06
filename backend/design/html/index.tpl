<!DOCTYPE html>
<html>
<head>
    <meta http-equiv = "Content-Type" content = "text/html; charset=UTF-8"/>
    <META HTTP-EQUIV = "Pragma" CONTENT = "no-cache">
    <META HTTP-EQUIV = "Expires" CONTENT = "-1">
    <title>{$meta_title}</title>
    <link rel = "icon" href = "/backend/design/images/favicon.png" type = "image/x-icon">
    <link rel = "stylesheet" type = "text/css" href = "/backend/design/css/style.css"/>
    <link rel = "stylesheet" type = "text/css" href = "/backend/design/js/jquery/jquery-ui.css" media = "screen"/>
    <link rel = "stylesheet" type = "text/css" href = "/backend/design/js/autocomplete/styles.css" media = "screen"/>
    <script src = "/backend/design/js/jquery/jquery-1.12.4.js"></script>
    {*<script src = "/backend/design/js/jquery/jquery-1.7.1.min.js"></script>*}
    <script src = "/backend/design/js/jquery/jquery-ui.min.js"></script>
    <script src = "/backend/design/js/jquery/jquery.form.js"></script>
    <script src = "/backend/design/js/autocomplete/jquery.autocomplete.js"></script>
    <script src = "/backend/design/js/jquery.cookie.js"></script>
    <script src = "/backend/design/js/store.js/store.min.js"></script>
    <script src = "/backend/design/js/combined.js"></script>

    <meta name = "viewport" content = "width=1024">

</head>
<body>
{if $smarty.get.module == "ProductAdmin"
|| $smarty.get.module == "CategoryAdmin"
|| $smarty.get.module == "BrandAdmin"
|| $smarty.get.module == "PostAdmin"
|| $smarty.get.module == "PageAdmin"}
    <script>
    $(window).on("load", function () {
        var title = $("input[name='meta_title']"),
            keywords = $("input[name='meta_keywords']"),
            desc = $("textarea[name='meta_description']");
        number = title.val().length;
        $(".count_title_symbol").html(number);
        $(".word_title").html(title.val().split(/[\s\.\?]+/).length);

        number = keywords.val().length;
        $(".count_keywords_symbol").html(number);
        $(".word_keywords").html(keywords.val().split(/[\s\.\?]+/).length);

        number = desc.text().length;
        $(".count_desc_symbol").html(number);
        $(".word_desc").html(desc.val().split(/[\s\.\?]+/).length);

        title.keyup(function count() {
            number = title.val().length;
            $(".count_title_symbol").html(number);
            total_words = $(this).val().split(/[\s\.\?]+/).length;
            $(".word_title").html(total_words);
        });
        keywords.keyup(function count() {
            number = keywords.val().length;
            $(".count_keywords_symbol").html(number);
            total_words = $(this).val().split(/[\s\.\?]+/).length;
            $(".word_keywords").html(total_words);
        });
        desc.keyup(function count() {
            number = desc.val().length;
            $(".count_desc_symbol").html(number);
            total_words = $(this).val().split(/[\s\.\?]+/).length;
            $(".word_desc").html(total_words);
        });

        $('input,textarea,select, a.delete').bind('keyup change click', function () {
            $('.fast_save').show();
        });

        $('.fast_save').on('click', function () {
            $('input[type=submit]').first().trigger('click');
        });
    });
</script>
{/if}
{*определяем текущий язык и id сессии*}
<script>
var current_lang = "{$lang_label}";
var session_id = "{$smarty.session.id}";
</script>
<a href = '{$config->root_url}/{$lang_link}' class = 'admin_bookmark'></a>
<div class = "container">

    <div class = "left">
        {include file="left.tpl"}
    </div>

    <div id = "main">
        <ul id = "tab_menu">

    {if in_array($tab, $manager->permissions)}
        <li {if $activity ne ""}class ={$activity}{/if}>
          <a href = "index.php?module=GroupsAdmin">Группы</a>
        </li>
    {/if}
            {$smarty.capture.tabs}
            <div class = "clearfix"></div>
            {$smarty.capture.tabs_setting}

        </ul>
        <div id = "middle">
            {$content}
        </div>
        <div id = "footer">
            <span>&copy; 2016</span>
            <a href = 'http://alexshop-sms.com'>AlexShop SMS {$config->version}</a>
            <span>Вы вошли как {$manager->login}.</span>
            <a href = '{$config->root_url}?logout' id = "logout">Выход</a>
        </div>
    </div>
</div>

<div class = "fast_save">
    <input class = "button_green button_save" type = "submit" name = "" value = "Сохранить"/>
</div>
<script>
    if (typeof jQuery == 'undefined') {
        console.error('jQuery не загружен');
    } else {
        console.log('jQuery загружен');
    }
</script>
</body>
</html>
