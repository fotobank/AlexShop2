<?php
use proxy\Config;


/*******************************************************************

 * ******** --- AlexShop CMS  Created by Jury V. Alex --- **********
 * **    Система Управления Контентом Сайта интернет магазина    ***
 * *****************************************************************
 * 1. Данный скрипт защищен правом интеллектуальной собственности.
 * 2. Скрипт распространяется бесплатно по лицензии MIT независимо
 *     от способа его приобретения.
 * 3. Независимым разработикам разрешено вносить изменения,
 *     улучшающие работу данного скрипта, с уведомлением автора.
 * 4. При заказе разработки сайта, с использованием данного
 *     скрипта, цену выставляет исполнитель.
 * 5. За содержание и работу сайта ответственность несет владелец
 *     веб-ресурса. Разработчик снимает с себя всякую ответственность
 *     за возможный ущерб, связанный с работой скрипта или
 *     за недополученную прибыль.
 * -----------------------------------------------------------------
 *                  ---  Техническая поддержка ---
 *  E-Mail: alexjurii@gmail.com
 *  Skype: jurii.od.ua
 *  Mobile: +80-94-94-77-0-70
 *  Copyright (c) 2013 - 2017

 *******************************************************************/

class ServiceAdmin
{
    private $service_modules = ['AntiShell', 'MySqlDumper'];

    /**
     * @return mixed
     */
    public function fetch() {
        // Подключаем первый из разрешенных модуль
        foreach ($this->service_modules as $module){
            $modules_permissions = Config::getData('modules_permissions');
            if(array_key_exists($module, $modules_permissions)){
                if (api()->managers->access($modules_permissions[$module])){
                    $module_path = __DIR__ . '/' . $module . '.php';
                    if (is_readable($module_path)){
                        include($module_path);
                        /** @var object $obj */
                        $obj = new $module;
                        return $obj->fetch();
                    }
                    break;
                }
            }
        }
        return 'access denied';
    }

}
