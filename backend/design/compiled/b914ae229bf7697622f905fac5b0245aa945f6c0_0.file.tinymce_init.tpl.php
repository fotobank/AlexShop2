<?php
/* Smarty version 3.1.29, created on 2016-08-07 00:44:19
  from "O:\domains\okay\backend\design\html\tinymce_init.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57a65a33141490_31394261',
  'file_dependency' => 
  array (
    'b914ae229bf7697622f905fac5b0245aa945f6c0' => 
    array (
      0 => 'O:\\domains\\okay\\backend\\design\\html\\tinymce_init.tpl',
      1 => 1457286012,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57a65a33141490_31394261 ($_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['config']->value->subfolder != '/') {?>
    <?php echo '<script'; ?>
 type="text/javascript" src="/<?php echo $_smarty_tpl->tpl_vars['config']->value->subfolder;?>
backend/design/js/tinymce_jq/tinymce.min.js"><?php echo '</script'; ?>
>
<?php } else { ?>
    <?php echo '<script'; ?>
 type="text/javascript" src="/backend/design/js/tinymce_jq/tinymce.min.js"><?php echo '</script'; ?>
>
<?php }?>

<?php echo '<script'; ?>
>
    $(function(){
        tinyMCE.init({
            selector: "textarea.editor_large, textarea.editor_small",
            plugins: [
                "advlist autolink lists link image preview anchor responsivefilemanager",
                "code fullscreen save textcolor colorpicker charmap nonbreaking",
                "insertdatetime media table contextmenu paste imagetools"
            ],
            toolbar_items_size : 'small',
            menubar:'file edit insert view format table tools',
            toolbar1: "fontselect formatselect fontsizeselect | bold italic underline | alignleft aligncenter alignright | bullist numlist | forecolor backcolor | table | link unlink anchor media image | fullscreen code",
            statusbar: true,
            font_formats: "Andale Mono=andale mono,times;"+
            "Arial=arial,helvetica,sans-serif;"+
            "Arial Black=arial black,avant garde;"+
            "Book Antiqua=book antiqua,palatino;"+
            "Comic Sans MS=comic sans ms,sans-serif;"+
            "Courier New=courier new,courier;"+
            "Georgia=georgia,palatino;"+
            "Helvetica=helvetica;"+
            "Impact=impact,chicago;"+
            "Symbol=symbol;"+
            "Tahoma=tahoma,arial,helvetica,sans-serif;"+
            "Terminal=terminal,monaco;"+
            "Times New Roman=times new roman,times;"+
            "Trebuchet MS=trebuchet ms,geneva;"+
            "Verdana=verdana,geneva;"+
            "Webdings=webdings;"+
            "Wingdings=wingdings,zapf dingbats",


            image_advtab: true,
            <?php if ($_smarty_tpl->tpl_vars['config']->value->subfolder != '/') {?>
            external_filemanager_path:"/<?php echo $_smarty_tpl->tpl_vars['config']->value->subfolder;?>
backend/design/js/filemanager/",
            filemanager_title:"Файловый менеджер" ,
            external_plugins: { "filemanager" : "/<?php echo $_smarty_tpl->tpl_vars['config']->value->subfolder;?>
backend/design/js/filemanager/plugin.min.js"},
            <?php } else { ?>
            external_filemanager_path:"/backend/design/js/filemanager/",
            filemanager_title:"Файловый менеджер" ,
            external_plugins: { "filemanager" : "/backend/design/js/filemanager/plugin.min.js"},
            <?php }?>


            save_enablewhendirty: true,
            save_title: "save",
            theme_advanced_buttons3_add : "save",
            save_onsavecallback: function() {
                $("[type='submit']").trigger("click");
                },

            language : "ru",
            /* Замена тега P на BR при разбивке на абзацы
             force_br_newlines : true,
             force_p_newlines : false,
             forced_root_block : '',
             */
            setup : function(ed) {
                ed.on('keyup change', (function() {
                    set_meta();
                }));
            }

            });
    });

<?php echo '</script'; ?>
><?php }
}
