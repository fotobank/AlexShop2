<?php /* Smarty version Smarty-3.1.18, created on 2016-08-01 16:22:00
         compiled from "backend\design\html\auth.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16046579f4cf821daa1-35411078%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '464208130c0eeebd60930b3c9b2a05a1ec09ec13' => 
    array (
      0 => 'backend\\design\\html\\auth.tpl',
      1 => 1467281696,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16046579f4cf821daa1-35411078',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'manager' => 0,
    'error_message' => 0,
    'limit_cnt' => 0,
    'login' => 0,
    'config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_579f4cf82b6059_53588504',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_579f4cf82b6059_53588504')) {function content_579f4cf82b6059_53588504($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['wrapper'] = new Smarty_variable('', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['wrapper'] = clone $_smarty_tpl->tpl_vars['wrapper'];?>
<html>
<title>Административная панель</title>
<link rel="icon" href="design/images/favicon.png" type="image/x-icon">
    <body>
        <style type="text/css" scoped>
            @import url(https://fonts.googleapis.com/css?family=Roboto:400,500,700&subset=latin,cyrillic);
            body {
                padding: 0;
                margin: 0;
                text-align: center;
                font-size: 14px;
                font-family: 'Roboto', sans-serif;
                background-color: #e4e5e5;
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
            <img src="design/images/system_logo.png" alt="OkayCMS" />
        </div>
        <?php if (!$_smarty_tpl->tpl_vars['manager']->value) {?>
        <h2 class="heading">ВХОД В СИСТЕМУ</h2>
        <?php if ($_smarty_tpl->tpl_vars['error_message']->value) {?>
            <div class="message_error">
                <?php if ($_smarty_tpl->tpl_vars['error_message']->value=='auth_wrong') {?>
                    Неверно введены логин или пароль.
                    <?php if ($_smarty_tpl->tpl_vars['limit_cnt']->value) {?><br>Осталось <?php echo $_smarty_tpl->tpl_vars['limit_cnt']->value;?>
 попыт<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->tpl_vars['limit_cnt']->value,'ка','ок','ки');?>
<?php }?>
                <?php } elseif ($_smarty_tpl->tpl_vars['error_message']->value=='limit_try') {?>
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
</html><?php }} ?>
