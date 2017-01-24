<?php
use api\Registry;

require_once __DIR__ . '/system/configs/define/config.php';
require_once SYS_DIR . 'core' . DS . 'boot.php';
?>

<html>
<head>
	<title>Восстановления пароля администратора</title>
	<meta http-equiv = "Content-Type" content = "text/html; charset=utf8"/>
	<meta http-equiv = "Content-Language" content = "ru"/>
</head>
<style>

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
     h1, h2 {
         display: block;
         font-weight: bold;
         color: #243541;
     }
     h1 {
         font-size: 24px;
         margin: 34px 0 25px;
     }
     h2 {
         font-size: 20px;
         color: #243541;
         margin: 30px 0 25px;
     }

     #system_logo {
         height: 120px;
         background-color: #091A33;
     }

     form {
         display: inline-block;
         background-color: #f7f7f7;
         padding: 22px 25px;
         border: 1px solid #56b9ff;
         margin-bottom: 15px;
         /*width: 300px;*/
     }
     .form_group {
         text-align: left;
         margin-bottom: 12px;
     }
     .form_group label {
         display: inline-block;
         width: auto;
         margin-right: 20px;
         font-weight: 300;
         float: right;
     }
     .form_group input {
         height: 24px;
         width: 100%;
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
         padding: 9px 20px;
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

    p {
        font-size: 19px;
    }
</style>

<body>
<div style = 'width:100%; height:100%;'>

<?php
$registry = new Registry();

// Если пришли по ссылке из письма
if ($c = $registry->request->get('code')){
    // Код не совпадает - прекращяем работу
    if (empty($_SESSION['admin_password_recovery_code']) || empty($c) || $_SESSION['admin_password_recovery_code'] !== $c){
           header('Location:password.php');
           exit();
    }

    // IP не совпадает - прекращяем работу
    if (empty($_SESSION['admin_password_recovery_ip']) || empty($_SERVER['REMOTE_ADDR']) || $_SESSION['admin_password_recovery_ip'] !== $_SERVER['REMOTE_ADDR']){
           header('Location:password.php');
           exit();
    }

    // Если запостили пароль
    if ($new_password = $registry->request->post('new_password')){
        // Удаляем из сесси код, чтобы больше никто не воспользовался ссылкой
        unset($_SESSION['admin_password_recovery_code'], $_SESSION['admin_password_recovery_ip']);

        // Новый логин и пароль
        $new_login = $registry->request->post('new_login');
        $new_password = $registry->request->post('new_password');
        $manager = $registry->managers->get_manager($new_login);
        if (!$registry->managers->update_manager($manager->id, ['password' => $new_password, 'cnt_try' => 0, 'last_try' => null])){
            $registry->managers->add_manager(['login' => $new_login, 'password' => $new_password]);
        }

        print '
        <div id="system_logo">
            <img src="backend/design/images/system_logo.png" alt="AlexShop CMS">
        </div>
            <h1>Восстановление пароля администратора</h1>
            <p>
            Новый пароль установлен
            </p>
            <p>
            <a href="' . $registry->root_url . '/backend/index.php?module=AuthAdmin">Перейти в панель входа</a>
            </p>
            ';
    } else {
        // Форма указания нового логина и пароля
        print '
        <div id="system_logo">
            <img src="backend/design/images/system_logo.png" alt="AlexShop CMS">
        </div>
            <h1>Восстановление пароля администратора</h1>
            <form method="post">
            <div class="form_group">
                <label>Новый логин:</label>
            	<input type="text" name="new_login">
             </div> 
             <div class="form_group">
                <label>Новый пароль:</label>
            	<input type="password" name="new_password">
             </div> 
             <a class="recovery" href="' . $registry->root_url . '/backend/index.php?module=AuthAdmin">Перейти в панель входа</a>
            	<input class="button" type="submit" value="Сохранить логин и пароль"> 
            </form>
        ';
    }
} else {
    // восстановление пароля по email
    print '
        <div id="system_logo">
            <img src="backend/design/images/system_logo.png" alt="AlexShop CMS">
        </div>
        <h1>Восстановление пароля администратора</h1>
        <p>
            <h2>Введите email администратора</h2>
            <form method="post" action="' . $registry->config->root_url . '/password.php" >
            <div class="form_group">
                <label>Email:</label>
            	<input type="text" name="email">
             </div> 
             <a class="recovery" href="' . $registry->root_url . '/backend/index.php?module=AuthAdmin">Перейти в панель входа</a>
            	<input class="button" type="submit" value="Восстановить пароль">
             	
            </form>
        </p>
    ';

    $admin_email = $registry->settings->admin_email;

    if (isset($_POST['email'])){
        if ($_POST['email'] === $admin_email){
            $code = $registry->config->token(random_int(1, mt_getrandmax()) . random_int(1, mt_getrandmax()) . random_int(1, mt_getrandmax()));
            $_SESSION['admin_password_recovery_code'] = $code;
            $_SESSION['admin_password_recovery_ip'] = $_SERVER['REMOTE_ADDR'];

            $message = 'Вы или кто-то другой запросил ссылку на восстановление пароля администратора.<br>';
            $message .= 'Для смены пароля перейдите по ссылке ' . $registry->config->root_url . '/password.php?code=' . $code . '<br>';
            $message .= 'Если письмо пришло вам по ошибке, проигнорируйте его.';

            $registry->notify->email($admin_email, 'Восстановление пароля администратора ' . $registry->settings->site_name, $message, $registry->settings->notify_from_email);
        }
        print 'Вам отправлена ссылка для восстановления пароля. Если письмо вам не пришло, значит вы неверно указали email или что-то не так с хостингом';
    }
}
?>


</div>
</body>
</html>