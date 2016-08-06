<?php
/* Smarty version 3.1.29, created on 2016-08-05 13:46:05
  from "O:\domains\okay\backend\design\html\index.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57a46e6d732a80_39039809',
  'file_dependency' => 
  array (
    'c08f547b41df92a75ad7970a301bcf677555f93d' => 
    array (
      0 => 'O:\\domains\\okay\\backend\\design\\html\\index.tpl',
      1 => 1470377883,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:left.tpl' => 1,
  ),
),false)) {
function content_57a46e6d732a80_39039809 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
    <META HTTP-EQUIV="Expires" CONTENT="-1">
    <title><?php echo $_smarty_tpl->tpl_vars['meta_title']->value;?>
</title>
    <link rel="icon" href="design/images/favicon.png" type="image/x-icon">
    <link href="design/css/style.css" rel="stylesheet" type="text/css" />
    <?php echo '<script'; ?>
 src="design/js/jquery/jquery.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="design/js/jquery/jquery.form.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="design/js/jquery/jquery-ui.min.js"><?php echo '</script'; ?>
>
    <link rel="stylesheet" type="text/css" href="design/js/jquery/jquery-ui.css" media="screen" />
    <meta name="viewport" content="width=1024">

</head>
<body>
<?php if ($_GET['module'] == "ProductAdmin" || $_GET['module'] == "CategoryAdmin" || $_GET['module'] == "BrandAdmin" || $_GET['module'] == "PostAdmin" || $_GET['module'] == "PageAdmin") {
echo '<script'; ?>
>
    $(window).on("load", function() {
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
            total_words=$(this).val().split(/[\s\.\?]+/).length;
            $(".word_title").html(total_words);
        });
        keywords.keyup(function count() {
            number = keywords.val().length;
            $(".count_keywords_symbol").html(number);
            total_words=$(this).val().split(/[\s\.\?]+/).length;
            $(".word_keywords").html(total_words);
        });
        desc.keyup(function count() {
            number = desc.val().length;
            $(".count_desc_symbol").html(number);
            total_words=$(this).val().split(/[\s\.\?]+/).length;
            $(".word_desc").html(total_words);
        });

        $('input,textarea,select, a.delete').bind('keyup change click',function(){
           $('.fast_save').show();
        });

        $('.fast_save').on('click',function(){
           $('input[type=submit]').first().trigger('click');
        });
    });
<?php echo '</script'; ?>
>
<?php }?>
<a href='<?php echo $_smarty_tpl->tpl_vars['config']->value->root_url;?>
/<?php echo $_smarty_tpl->tpl_vars['lang_link']->value;?>
' class='admin_bookmark'></a>

<div class="container">

    <div class="left">
        <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:left.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    </div>

    <div id="main">
        <ul id="tab_menu">
            <?php echo (isset($_smarty_tpl->_cache['__smarty_capture']['tabs']) ? $_smarty_tpl->_cache['__smarty_capture']['tabs'] : null);?>

        </ul>
        <div id="middle">
            <?php echo $_smarty_tpl->tpl_vars['content']->value;?>

        </div>
        <div id="footer">
            <span>&copy; 2016</span>
            <a href='http://alexshop-sms.com'>AlexShop SMS <?php echo $_smarty_tpl->tpl_vars['config']->value->version;?>
</a>
            <span>Вы вошли как <?php echo $_smarty_tpl->tpl_vars['manager']->value->login;?>
.</span>
            <a href='<?php echo $_smarty_tpl->tpl_vars['config']->value->root_url;?>
?logout' id="logout">Выход</a>
        </div>
    </div>
</div>

<div class="fast_save">
    <input class="button_green button_save" type="submit" name="" value="Сохранить"/>
</div>
</body>
</html>

<?php }
}
