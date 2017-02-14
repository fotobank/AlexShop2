<?php
/*******************************************************************
 *
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
 *     веб-ресурса.
 * -----------------------------------------------------------------
 *                  ---  Техническая поддержка ---
 *  E-Mail: alexjurii@gmail.com
 *  Skype: jurii.od.ua
 *  Mobile: +80-94-94-77-0-70
 *  Copyright (c) 2013 - 2017
 *
 *******************************************************************/

use api\Registry;

class TranslationsAdmin extends Registry
{

    public function fetch()
    {

        if ($this->settings->table_translation == 'jq_grid') {
            return $this->design->fetch('jq_grid_translations.tpl');
        } elseif ($this->settings->table_translation == 'js_grid') {
            return $this->design->fetch('js_grid_translations.tpl');
        }

            if ($this->request->method('post')){
                // Действия с выбранными
                $ids = $this->request->post('check');
                if (is_array($ids)){
                    switch ($this->request->post('action')) {
                        case 'delete': {
                            foreach ($ids as $id){
                                $this->languages->delete_translation($id);
                            }
                            break;
                        }
                    }
                }
            }

            $filter = [];
            $filter['lang'] = $this->design->get_var('lang_label');
            $filter['sort'] = $this->request->get('sort', 'string');
            $this->design->assign('sort', $filter['sort']);

            $translations = $this->languages->get_translations($filter);
            $this->design->assign('translations', $translations);

            return $this->design->fetch('translations.tpl');

    }

}
