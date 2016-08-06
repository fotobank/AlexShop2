<?php
/* Smarty version 3.1.29, created on 2016-08-07 00:03:43
  from "O:\domains\okay\backend\design\html\auth.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57a650af0847b9_35446545',
  'file_dependency' => 
  array (
    '3e733b748d93acbbd66a61d5a5301e8e9bef8f08' => 
    array (
      0 => 'O:\\domains\\okay\\backend\\design\\html\\auth.tpl',
      1 => 1470517418,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57a650af0847b9_35446545 ($_smarty_tpl) {
$_smarty_tpl->tpl_vars['wrapper'] = new Smarty_Variable('', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'wrapper', 66);?>
<html>
<title>Административная панель</title>
<link rel="icon" href="design/images/favicon.png" type="image/x-icon">
    <body>
        <style type="text/css" scoped>
            /*@import url(https://fonts.googleapis.com/css?family=Roboto:400,500,700&subset=latin,cyrillic);*/
            body {
                padding: 0;
                margin: 0;
                text-align: center;
                /*font-size: 14px;*/
                /*font-family: 'Roboto', sans-serif;*/
                background-color: #e4e5e5;

                font-family: Verdana, sans-serif;
                font-size: 13px;
                font-weight: 400;
                font-style: normal;
                color: #000000;
                line-height: 1.53em;
                letter-spacing: 0;

            }
            #system_logo {
                height: 120px;
                background-color: #091A33;
            }
            .heading {
                display: block;
                font-weight: bold;
                font-size: 24px;
                color: #243541;
                margin: 24px 0 17px;
            }
            form {
                display: inline-block;
                background-color: #f7f7f7;
                padding: 22px 25px;
                border: 1px solid #56b9ff;
                margin-bottom: 15px;
                width: 250px;
            }
            .form_group {
                text-align: left;
                margin-bottom: 12px;
            }
            .form_group label {
                display: inline-block;
                width: 60px;
                font-weight: 300;
            }
            .form_group input {
                height: 24px;
                width: 180px;
                padding: 0 5px;
                background: #fff;
                border: 1px solid #d0d0d0;
            }
            input:focus {
                outline: none;
            }
            .button {
                background: #ffcc00;
                margin-top: 10px;
                border: none;
                border-radius: 2px;
                padding: 9px 31px;
                font-size: 16px;
                color:#353b3e;
                cursor: pointer;
                -webkit-transition: all 0.3s ease;
                -moz-transition: all 0.3s ease;
                -o-transition: all 0.3s ease;
                transition: all 0.3s ease;
            }
            .button:hover {
                color: #fff;
                background: #56b9ff;
            }
            .message_error {
                background-color: #a70606;
                padding: 12px;
                color: #fff;
                margin-bottom: 20px;
            }
            .recovery {
                color: #243541;
                margin-right: 5px;
            }
            .recovery:hover {
                text-decoration: none;
            }
        </style>
        <div id="system_logo">
            <img src="design/images/system_logo.png" alt="AlexShop CMS" />
        </div>
        <?php if (!$_smarty_tpl->tpl_vars['manager']->value) {?>
        <h2 class="heading">ВХОД В СИСТЕМУ</h2>
        <?php if ($_smarty_tpl->tpl_vars['error_message']->value) {?>
            <div class="message_error">
                <?php if ($_smarty_tpl->tpl_vars['error_message']->value == 'auth_wrong') {?>
                    Неверно введены логин или пароль.
                    <?php if ($_smarty_tpl->tpl_vars['limit_cnt']->value) {?><br>Осталось <?php echo $_smarty_tpl->tpl_vars['limit_cnt']->value;?>
 попыт<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->tpl_vars['limit_cnt']->value,'ка','ок','ки');
}?>
                <?php } elseif ($_smarty_tpl->tpl_vars['error_message']->value == 'limit_try') {?>
                    Вы исчерпали количество попыток на сегодня.
                <?php }?>
            </div>
        <?php }?>
        <form method="post">
            <input type=hidden name="session_id" value="<?php echo $_SESSION['id'];?>
">
            <div class="form_group">
                <label>Логин:</label>
                <input type="text" name="login" value="<?php echo $_smarty_tpl->tpl_vars['login']->value;?>
" autofocus="" tabindex="1">
            </div>
            <div class="form_group">
                <label>Пароль:</label>
                <input type="password" name="password" value="" tabindex="2">
            </div>
            <div>
                <a class="recovery" href="<?php echo $_smarty_tpl->tpl_vars['config']->value->root_url;?>
/password.php">Напомнить пароль</a>
                <input class="button" type="submit" value="Войти" tabindex="3">
            </div>
            
        </form>
        
    <?php } else { ?>
        <a href="javascript:;">Выйти ...</a>
    <?php }?>
    </body>
</html><?php }
}
