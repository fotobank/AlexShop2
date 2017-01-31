<?php
use api\Registry;

require_once __DIR__ . '/system/configs/define/config.php';
require_once SYS_DIR . 'core' . DS . 'boot.php';

if (!empty($_SERVER['HTTP_USER_AGENT'])){
    session_name(md5($_SERVER['HTTP_USER_AGENT']));
}

$head = '
<html>
<head>
    <meta http-equiv = "Content-Type" content = "text/html; charset=UTF-8"/>
    <meta http-equiv = "Content-Language" content = "ru"/>
    <meta http-equiv = "pragma" content = "no-cache">
    <meta http-equiv = "cache-control" content = "no-cache">
    <meta http-equiv = "expires" content = "-1">
    <title>Восстановления пароля администратора</title>
    <link rel = "icon" href = "/backend/design/images/favicon.png" type = "image/x-icon">
    <link href = "/backend/design/css/auth.css" rel = "stylesheet" type = "text/css"/>
</head>
<body>
<div style = "width:100%; height:100%;">
<div id="system_logo">
<img src="backend/design/images/system_logo.png" alt="AlexShop CMS">
</div>
';


$registry = new Registry();

// Если пришли по ссылке из письма
$c = $registry->request->get('code');
if (!$c){
    // Код не совпадает - прекращяем работу
    if (empty($_SESSION['admin_password_recovery_code']) || empty($c) || $_SESSION['admin_password_recovery_code'] !== $c){
//        header('Location:admin');
//        exit();
    }

    // IP не совпадает - прекращяем работу
    if (empty($_SESSION['admin_password_recovery_ip']) || empty($_SERVER['REMOTE_ADDR']) || $_SESSION['admin_password_recovery_ip'] !== $_SERVER['REMOTE_ADDR']){
//        header('Location:admin');
//        exit();
    }

    // Если запостили логин и пароль
    if ($new_password = $registry->request->post('new_password')){
        // Новый логин
        $new_login = $registry->request->post('new_login');
        $manager = $registry->managers->get_manager($new_login);
        if (!$registry->managers->update_manager($manager->id, ['password' => $new_password, 'cnt_try' => 0, 'last_try' => null])){
            $registry->managers->add_manager(['login' => $new_login, 'password' => $new_password]);
        }
        // Удаляем из сессии код, чтобы больше никто не воспользовался ссылкой
        unset($_SESSION['admin_password_recovery_code'], $_SESSION['admin_password_recovery_ip']);

        echo $head,
            '
            <h1>Восстановление пароля администратора</h1>
            <div class = "message_ok">
            <p>Новый пароль установлен</p>
            </div>   
            <a href="' . $registry->root_url . '/backend/index.php?module=AuthAdmin">Перейти в панель входа</a>
            ';
    } else {
        // Форма указания нового логина и пароля
        echo $head,
        '
            <h1>Восстановление пароля администратора</h1>
             <form id="loginForm" method="post" action="' . $registry->config->root_url . '/password.php" >
            <div class = "field">
                <label for = "autx_login">Новый логин:&nbsp;&nbsp;</label>
            	<div class = "input"><input id = "autx_login" type="text" name="new_login"></div>
             </div> 
            <div class = "field">
                <label for = "autx_password">Новый пароль:</label>
            	<div class = "input"><input id = "autx_password" type="password" name="new_password"></div>
             </div> 
              <div class="submit">
             <a id = "return" class="recovery" href="' . $registry->root_url . '/backend/index.php?module=AuthAdmin">Перейти в панель входа</a>
            	<input class="button" type="submit" value="Сохранить"> 
            	</div>
            </form>
        ';
    }
} else {
    // восстановление пароля по email
    echo $head,
    '
        <h1>Восстановление пароля администратора</h1>
        <p>
            <form id="loginForm" method="post" action="' . $registry->config->root_url . '/password.php" >
            <div class="field">Введите email администратора:</div>
           <div class = "field">
                <label for = "autx_email">Email:</label>       
            	 <div class = "input"> <input id = "autx_email" type="text" name="email"></div> 	
             </div> 
             <div class="submit">
             <a id = "return" class="recovery" href="' . $registry->root_url . '/backend/index.php?module=AuthAdmin">Перейти в панель входа</a>
                <input class="button" type="submit" value="Восстановить">
                </div>
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
            echo '
            <div class = "message_ok">
            Вам отправлена ссылка для восстановления пароля. Если письмо вам не пришло, значит вы неверно указали email или что-то не так с хостингом.
            </div>';
        } else {
            echo '
            <div class = "message_error">
                Email не существует!
            </div>';
        }
    }
}
?>

</div>
        <div id = "footer">
            <span>&copy; 2016</span>
            <a href = 'http://alexshop-sms.com'>AlexShop CMS</a>
        </div>
</body>
<head>
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv = "cache-control" content = "no-cache">
</head>
</html>