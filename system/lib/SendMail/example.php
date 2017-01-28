<?php
/**
 * @created   by PhpStorm
 * @package   example.php
 * @version   1.0
 * @author    Alex Jurii <jurii@mail.ru>
 * @link      http://alex.od.ua
 * @copyright Авторские права (C) 2000-2015, Alex Jurii
 * @date:     14.05.2015
 * @time:     15:58
 * @license   MIT License: http://opensource.org/licenses/MIT
 */


require_once(__DIR__.'/SendMail.php');

SendMail::from('admin@mail.ru', 'Админ')  // Адрес и имя отправителя.
// Второй аргумент не обязателен.

		 ->to('user@mail.ru', 'Вася')  /* Адрес и имя адресата
                                           (можно массив адресов).

                                       $toUsers = array(
                                           array('user@mail.ru', 'Василий'),
                                           array('user2@mail.ru', 'Андрей')
                                       );

                                       или

                                       $toUsers = array('user@mail.ru',
                                           'user2@mail.ru');

                                       */


// Тема сообщения.
		 ->subject('Тема сообщения')

	// Тело сообщения.
		 ->message('Тело сообщения')

	// Путь до прикрепляемого файла (можно массив).
		 ->files(__DIR__ . '/files/image.jpg')

	// Уведомлять. По умолчанию false.
		 ->notify(true)

	// Приоритет письма. True, если важное. По умолчанию false.
		 ->important(true)

	// Кодировка (по умолчанию utf-8)
		 ->charset('utf-8')

	// set_time_limit (по умолчанию == 30с.)
		 ->time_limit(30)

	// Тип сообщения (по умолчанию text/plain)
		 ->content_type(SendMail::CONTENT_TYPE_PLAIN)

	// Тип конвертации сообщения (по умолчанию 'quoted-printable').
		 ->content_encoding(SendMail::CONTENT_ENCODING_QUOTED_PRINTTABLE)

	// Отправка почты
		 ->send();