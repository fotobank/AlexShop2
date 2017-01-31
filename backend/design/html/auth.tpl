{$wrapper = '' scope=parent}
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv = "X-UA-Compatible" content = "IE=edge">
    <meta name = "viewport" content = "width=device-width, initial-scale=1">
    <meta name = "description" content = "админ панель">
    <meta name = "author" content = "Alex">
    <meta http-equiv = "Content-Type" content = "text/html; charset=UTF-8"/>
    <meta http-equiv = "Content-Language" content = "ru"/>
    <meta http-equiv = "pragma" content = "no-cache">
    <meta http-equiv = "cache-control" content = "no-cache">
    <meta http-equiv = "expires" content = "-1">
    <title>Административная панель</title>
    <link rel = "icon" href = "/backend/design/images/favicon.png" type = "image/x-icon">
    <link href = "/backend/design/css/auth.css" rel = "stylesheet" type = "text/css"/>
</head>
<body>
        <div id = "system_logo">
            <img src = "/backend/design/images/system_logo.png" alt = "AlexShop CMS"/>
        </div>
        {if !$manager}
            <h1>ВХОД В СИСТЕМУ</h1>

                                {if $error_message}
            <div class = "message_error">
                {if $error_message == 'auth_wrong'}
                    Неверно введены логин или пароль.
                    {if $limit_cnt}<br>Осталось {$limit_cnt} попыт{$limit_cnt|plural:'ка':'ок':'ки'}{/if}
                {elseif $error_message == 'limit_try'}
                    Вы исчерпали количество попыток на сегодня.
                {/if}
                </div>
        {/if}


            <form id = "loginForm" action = "" method = "post">
        <input type = hidden name = "session_id" value = "{$smarty.session.id}">
    <div class = "field">
        <label for = "autx_login">Имя пользователя:</label>
        <div class = "input"><input id = "autx_login" type = "text" name = "login" value = "{$login}"/></div>
    </div>

    <div class = "field">
        <a href = "{$config->root_url}/password.php" id = "forgot">Забыли пароль?</a>
        <label for = "autx_password">Пароль:</label>
        <div class = "input"><input id = "autx_password" type = "password" name = "password" value = ""/></div>
    </div>

    <div class = "submit">
        {*<button type = "submit">Войти</button>*}
        <input class = "button" type = "submit" value = "Войти">
        <label id = "remember"><input name = "remember" type = "checkbox" value = ""/> Запомнить меня</label>
    </div>
</form>


        {else}

            <a href = "javascript:">Выйти ...</a>
        {/if}

        <div id = "footer">
            <span>&copy; 2016</span>
            <a href = 'http://alexshop-sms.com'>AlexShop CMS</a>
        </div>
</body>
<head>
<meta http-equiv = "pragma" content = "no-cache">
<meta http-equiv = "cache-control" content = "no-cache">
</head>
</html>