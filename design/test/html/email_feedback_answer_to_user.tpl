{* Письмо ответа на комметарий пользователю *}
{$subject = 'Ответ на заявку' scope=parent}
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
</head>
<body>
<h1 style="text-align: center;font: 18px;background: #41ade2;color: #fff;padding: 5px; width: 800px;">
    Вы оставили заявку ({$feedback->date|date} {$feedback->date|time}):
</h1>
<div style="border: 1px dashed #41ade2;padding: 5px;margin-left: 10px;width: 800px;">
    {$feedback->message|escape|nl2br}
</div>
<h2>Ответ:</h2>
<div style="border: 1px dashed #41ade2;padding: 5px;margin-left: 10px;width: 800px;">{$text|escape}</div>
</body>
</html>