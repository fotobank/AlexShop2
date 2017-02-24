<?php
$lang['L_INSTALLFINISHED']='<br>Установка завершена  --> <a href="index.php">запуск MySQLDumper</a><br>';
$lang['L_INSTALL_TOMENU']='Вернуться в главное меню';
$lang['L_INSTALLMENU']='Главное меню';
$lang['L_STEP']='Шаг';
$lang['L_INSTALL']='Установка';
$lang['L_UNINSTALL']='Удалить';
$lang['L_TOOLS']='Инструменты';
$lang['L_EDITCONF']='Изменить конфигурацию';
$lang['L_OSWEITER']='Продолжить без сохранения';
$lang['L_ERRORMAN']='<strong>Ошибка при сохранении конфигурации!</strong><br>Пожалуйста, отредактируйте файл ';
$lang['L_MANUELL']='вручную';
$lang['L_CREATEDIRS']='Создание каталогов';
$lang['L_INSTALL_CONTINUE']='Продолжить установку';
$lang['L_CONNECTTOMYSQL']='Подключение к MySQL ';
$lang['L_DBPARAMETER']='Параметры базы данных';
$lang['L_CONFIGNOTWRITABLE']='Я не могу писать в файл "config.php" .
Пожалуйста, используйте вашу FTP программу и установите права chmod на этот файл 0777.';
$lang['L_DBCONNECTION']='Подключение к базе данных';
$lang['L_CONNECTIONERROR']='Ошибка: не удается подключиться.';
$lang['L_CONNECTION_OK']='Подключение базы данных была создана.';
$lang['L_SAVEANDCONTINUE']='Сохранить и продолжить установку';
$lang['L_CONFBASIC']='Основной параметр';
$lang['L_INSTALL_STEP2FINISHED']='Параметры базы данных были успешно сохранены.';
$lang['L_INSTALL_STEP2_1']='Продолжить установку с параметрами по умолчанию';
$lang['L_LASTSTEP']='Окончание установки';
$lang['L_FTPMODE']='Создать необходимые каталоги в безопасном режиме';
$lang['L_IDOMANUAL']='Вы должны сами создать каталоги';
$lang['L_DOFROM']='Начиная от:';
$lang['L_FTPMODE2']='Создайте каталоги с FTP:';
$lang['L_CONNECT']='подключение';
$lang['L_DIRS_CREATED']='Каталоги созданы с правильными разрешениями.';
$lang['L_CONNECT_TO']='подключиться к';
$lang['L_CHANGEDIR']='перейти в директорию';
$lang['L_CHANGEDIRERROR']='изменение реж не было возможности';
$lang['L_FTP_OK']='Параметр FTP в порядке';
$lang['L_CREATEDIRS2']='Создание каталогов';
$lang['L_FTP_NOTCONNECTED']='FTP-соединение не установлено!';
$lang['L_CONNWITH']='Связь с';
$lang['L_ASUSER']='от имени пользователя';
$lang['L_NOTPOSSIBLE']='невозможно';
$lang['L_DIRCR1']='создать рабочую директорию';
$lang['L_DIRCR2']='создать директорию резервного копирования';
$lang['L_DIRCR4']='создать директорию логов';
$lang['L_DIRCR5']='создать конфигурацию директории';
$lang['L_INDIR']='В настоящее время в директории';
$lang['L_CHECK_DIRS']='Проверить мои каталоги';
$lang['L_DISABLEDFUNCTIONS']='Отключенные функции';
$lang['L_NOFTPPOSSIBLE']='У вас нет FTP функций!';
$lang['L_NOGZPOSSIBLE']='У вас нет функции сжатия!';
$lang['L_UI1']='Все рабочие каталоги, которые могут содержать резервные копии будут удалены.';
$lang['L_UI2']='Вы действительно хотите?';
$lang['L_UI3']='нет, отменить немедленно';
$lang['L_UI4']='да, продолжить';
$lang['L_UI5']='удалить рабочие каталоги';
$lang['L_UI6']='усе было успешно удаленно';
$lang['L_UI7']='Пожалуйста удалить скрипт каталога';
$lang['L_UI8']='На один уровень вверх';
$lang['L_UI9']='Ошибка, удаление не было возможности</p>Ошибка в каталоге ';
$lang['L_IMPORT']='Импорт конфигурации';
$lang['L_IMPORT3']='Конфигурация была загружена ...';
$lang['L_IMPORT4']='Конфигурация была сохранена.';
$lang['L_IMPORT5']='Запустите MySQLDumper';
$lang['L_IMPORT6']='В Меню установки';
$lang['L_IMPORT7']='Загрузка конфигурации';
$lang['L_IMPORT8']='Чтобы загрузить';
$lang['L_IMPORT9']='Это не является резервное копирование конфигурации !';
$lang['L_IMPORT10']='Конфигурация успешно загружена ...';
$lang['L_IMPORT11']='<strong>Сообщение об ошибке: </strong>Существуют проблемы с записью sql_statements';
$lang['L_IMPORT12']='<strong>Сообщение об ошибке: </strong>Существуют проблемы с записью config.php';
$lang['L_INSTALL_HELP_PORT']='(empty = Default Port)';
$lang['L_INSTALL_HELP_SOCKET']='(empty = Default Socket)';
$lang['L_TRYAGAIN']='Попробуйте еще раз';
$lang['L_SOCKET']='Сокет';
$lang['L_PORT']='Порт';
$lang['L_FOUND_DB']='Найти db';
$lang['L_FM_FILEUPLOAD']='Загрузить файл';
$lang['L_PASS']='Пароль';
$lang['L_NO_DB_FOUND_INFO']='Подключение к базе данных было успешно создано<br>
данные пользователя является действительными и были приняти MySQL-Server.<br>
Но MySQLDumper не смог найти какую - нибудь базу данных автоматичесски.<br>
Сценарий Автоматического обнаружения блокируется на некоторых серверах.<br>
Вы должны ввести имя базы данных вручную после установки.
Нажмите на кнопку "Конфигурация" "цепи параметр - дисплей" и введите имя базы данных.';
$lang['L_SAFEMODEDESC']='Так как PHP работает в safe_mode вы должны создать следующие каталоги вручную с помощью FTP - программы:';
$lang['L_ENTER_DB_INFO']='Сначала нажмите на кнопку "Подключиться к MySQL". Только если базы данных не могут быть обнаружены вам нужно ввести имя базы данных здесь.';
