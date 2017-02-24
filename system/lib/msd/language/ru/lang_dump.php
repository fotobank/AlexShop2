<?php
$lang['L_DUMP_HEADLINE']='Создание резервной копии...';
$lang['L_GZIP_COMPRESSION']='GZip Сжатие';
$lang['L_SAVING_TABLE']='Сохранение таблицы ';
$lang['L_OF']='of';
$lang['L_ACTUAL_TABLE']='Актуальная таблица';
$lang['L_PROGRESS_TABLE']='Ход выполнения в таблице';
$lang['L_PROGRESS_OVER_ALL']='Общий прогресс';
$lang['L_ENTRY']='Вход';
$lang['L_DONE']='Закончено!';
$lang['L_DUMP_SUCCESSFUL']=' был успешно создан.';
$lang['L_UPTO']='вплоть до';
$lang['L_EMAIL_WAS_SEND']='Электронная почта успешно отправлена в ';
$lang['L_BACK_TO_CONTROL']='Продолжить';
$lang['L_BACK_TO_OVERVIEW']='Обзор базы данных';
$lang['L_DUMP_FILENAME']='Файл резервной копии: ';
$lang['L_WITHPRAEFIX']='с префиксом';
$lang['L_DUMP_NOTABLES']='Не найдены в базе данных таблиц "<b>%s</b>" ';
$lang['L_DUMP_ENDERGEBNIS']='Этот файл содержит "<b>%s</b>" таблиц с <b>%s</b> записи.<br>';
$lang['L_MAILERROR']='Отправка электронной почты не удалась!';
$lang['L_EMAILBODY_ATTACH']='Вложение содержит резервную копию вашего  MySQL-База данных.<br>Резервное копирование базы данных "%s"
<br><br>затем был создан файл:<br><br>"%s" <br><br>С наилучшими пожеланиями<br><br>MySQLDumper<br>';
$lang['L_EMAILBODY_MP_NOATTACH']='Была создана резервная копия Multipart.<br>Резервное копирование файлов не прикреплены к этой электронной почте!<br>Резервное копирование базы данных `%s`
<br><br>Были созданы следующие файлы:<br><br>"%s"
<br><br>С наилучшими пожеланиями<br><br>MySQLDumper<br>';
$lang['L_EMAILBODY_MP_ATTACH']='Была создана резервная копия Multipart.<br>Архивные файлы прикреплены к отдельным письмам.<br>Резервное копирование базы данных "%s"
<br><br>Были созданы следующие файлы:<br><br>%s <br><br>С наилучшими пожеланиями<br><br>MySQLDumper<br>';
$lang['L_EMAILBODY_FOOTER']='`<br><br>С наилучшими пожеланиями<br><br>MySQLDumper<br>';
$lang['L_EMAILBODY_TOOBIG']='Файл резервной копии превысил максимальный размер %s и не был прикреплен к этой электронной почте.<br>Резервное копирование базы данных "%s"
<br><br>Затем был создан файл:<br><br>"%s"
<br><br>С наилучшими пожеланиями<br><br>MySQLDumper<br>';
$lang['L_EMAILBODY_NOATTACH']='Файлы не вложены в это письмо!<br>Резервное копирование базы данных "%s"
<br><br>Затем был создан файл:<br><br>"%s"
<br><br>С наилучшими пожеланиями<br><br>MySQLDumper<br>';
$lang['L_EMAIL_ONLY_ATTACHMENT']=' ... только прикрепленные файлы.';
$lang['L_TABLESELECTION']='Выбор таблицы';
$lang['L_SELECTALL']='Выбрать все';
$lang['L_DESELECTALL']='Отменить все';
$lang['L_STARTDUMP']='Начало резервного копирования';
$lang['L_LASTBUFROM']='Последнее обновление от';
$lang['L_NOT_SUPPORTED']='Эта резервная копия не поддерживает эту функцию.';
$lang['L_MULTIDUMP']='Multi дамп: резервное копирование <b>%d</b> баз банныз закончилось.';
$lang['L_FILESENDFTP']='отправить файл по FTP... Пожалуйста, будьте терпеливы. ';
$lang['L_FTPCONNERROR']='FTP соединение не установлено! Связь с ';
$lang['L_FTPCONNERROR1']=' как пользователь ';
$lang['L_FTPCONNERROR2']=' не представляется возможным';
$lang['L_FTPCONNERROR3']='Не удалось загрузить FTP! ';
$lang['L_FTPCONNECTED1']='Связанные с ';
$lang['L_FTPCONNECTED2']=' на ';
$lang['L_FTPCONNECTED3']=' передача успешно';
$lang['L_NR_TABLES_SELECTED']='- с %s выбранные таблицы';
$lang['L_NR_TABLES_OPTIMIZED']='<span class=\'small\'>%s Оптимизация таблиц.</span>';
$lang['L_DUMP_ERRORS']='<p class="error">%s произошли ошибки: <a href="log.php?r=3">вид</a></p>';
$lang['L_FATAL_ERROR_DUMP']='Неустранимая ошибка: инструкцию CREATE таблицы "%s" в базе данных "%s" не удается прочитать!';
