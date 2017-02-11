<?php

use api\Registry;

class TranslationsAdmin extends Registry
{

    public function fetch()
    {

        if ($this->settings->admin_table == 'old_table'){

            // Обработка действий
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

        } elseif ($this->settings->admin_table == 'jq_grig') {
            return $this->design->fetch('jq_grid_translations.tpl');
        } elseif ($this->settings->admin_table == 'js_grig') {
            return $this->design->fetch('js_grid_translations.tpl');
        }

    }

}
