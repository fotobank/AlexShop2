<?php
/**
 * @created   by PhpStorm
 * @package   example.php
 * @version   1.0
 * @author    Alex Jurii <jurii@mail.ru>
 * @link      http://alex.od.ua
 * @copyright Àâòîğñêèå ïğàâà (C) 2000-2015, Alex Jurii
 * @date:     14.05.2015
 * @time:     15:58
 * @license   MIT License: http://opensource.org/licenses/MIT
 */


require_once(__DIR__.'/SendMail.php');

SendMail::from('admin@mail.ru', 'Àäìèí')  // Àäğåñ è èìÿ îòïğàâèòåëÿ.
// Âòîğîé àğãóìåíò íå îáÿçàòåëåí.

		 ->to('user@mail.ru', 'Âàñÿ')  /* Àäğåñ è èìÿ àäğåñàòà
                                           (ìîæíî ìàññèâ àäğåñîâ).

                                       $toUsers = array(
                                           array('user@mail.ru', 'Âàñèëèé'),
                                           array('user2@mail.ru', 'Àíäğåé')
                                       );

                                       èëè

                                       $toUsers = array('user@mail.ru',
                                           'user2@mail.ru');

                                       */


// Òåìà ñîîáùåíèÿ.
		 ->subject('Òåìà ñîîáùåíèÿ')

	// Òåëî ñîîáùåíèÿ.
		 ->message('Òåëî ñîîáùåíèÿ')

	// Ïóòü äî ïğèêğåïëÿåìîãî ôàéëà (ìîæíî ìàññèâ).
		 ->files(__DIR__ . '/files/image.jpg')

	// Óâåäîìëÿòü. Ïî óìîë÷àíèş false.
		 ->notify(true)

	// Ïğèîğèòåò ïèñüìà. True, åñëè âàæíîå. Ïî óìîë÷àíèş false.
		 ->important(true)

	// Êîäèğîâêà (ïî óìîë÷àíèş utf-8)
		 ->charset('utf-8')

	// set_time_limit (ïî óìîë÷àíèş == 30ñ.)
		 ->time_limit(30)

	// Òèï ñîîáùåíèÿ (ïî óìîë÷àíèş text/plain)
		 ->content_type(SendMail::CONTENT_TYPE_PLAIN)

	// Òèï êîíâåğòàöèè ñîîáùåíèÿ (ïî óìîë÷àíèş 'quoted-printable').
		 ->content_encoding(SendMail::CONTENT_ENCODING_QUOTED_PRINTTABLE)

	// Îòïğàâêà ïî÷òû
		 ->send();