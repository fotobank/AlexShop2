<?php /* Smarty version Smarty-3.1.18, created on 2016-08-02 05:40:11
         compiled from "backend\design\html\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:331257a0080bdfdb84-51281190%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '473c29aae9e10a719183d386707a91c51e78fa0d' => 
    array (
      0 => 'backend\\design\\html\\index.tpl',
      1 => 1467208466,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '331257a0080bdfdb84-51281190',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'meta_title' => 0,
    'config' => 0,
    'lang_link' => 0,
    'content' => 0,
    'manager' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_57a0080be99fa3_49930901',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57a0080be99fa3_49930901')) {function content_57a0080be99fa3_49930901($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
    <META HTTP-EQUIV="Expires" CONTENT="-1">
    <title><?php echo $_smarty_tpl->tpl_vars['meta_title']->value;?>
</title>
    <link rel="icon" href="design/images/favicon.png" type="image/x-icon">
    <link href="design/css/style.css" rel="stylesheet" type="text/css" />
    <script src="design/js/jquery/jquery.js"></script>
    <script src="design/js/jquery/jquery.form.js"></script>
    <script src="design/js/jquery/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="design/js/jquery/jquery-ui.css" media="screen" />
    <meta name="viewport" content="width=1024">

</head>
<body>
<?php if ($_GET['module']=="ProductAdmin"||$_GET['module']=="CategoryAdmin"||$_GET['module']=="BrandAdmin"||$_GET['module']=="PostAdmin"||$_GET['module']=="PageAdmin") {?>
<script>
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
</script>
<?php }?>
<a href='<?php echo $_smarty_tpl->tpl_vars['config']->value->root_url;?>
/<?php echo $_smarty_tpl->tpl_vars['lang_link']->value;?>
' class='admin_bookmark'></a>

<div class="container">

    <div class="left">
        <?php echo $_smarty_tpl->getSubTemplate ("left.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    </div>

    <div id="main">
        <ul id="tab_menu">
            <?php echo Smarty::$_smarty_vars['capture']['tabs'];?>

        </ul>
        <div id="middle">
            <?php echo $_smarty_tpl->tpl_vars['content']->value;?>

        </div>
        <div id="footer">
            <span>&copy; 2016</span>
            <a href='http://okay-cms.com'>Okay <?php echo $_smarty_tpl->tpl_vars['config']->value->version;?>
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

<?php }} ?>
