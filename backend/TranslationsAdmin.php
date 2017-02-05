<?php

use api\Registry;

class TranslationsAdmin extends Registry
{

    public function fetch()
    {
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
        $filter['langs'] = $this->design->get_var('langs_label');
        $filter['sort'] = $this->request->get('sort', 'string');
        $this->design->assign('sort', $filter['sort']);

        if (is_ajax()){

            $head = $this->getHeadTable($filter['langs']);
            $translations = $this->languages->get_translations($filter);
            $body = $this->getBodyTable($filter['langs'], $translations);
            $table = ['head' => $head, 'body' => $body];

            header("Content-type: application/json; charset=UTF-8");
            header("Cache-Control: must-revalidate");
            header("Pragma: no-cache");
            header("Expires: -1");
            $json = json_encode($table);
            print $json;
            exit();
        }

        $translations = $this->languages->get_translations($filter);
        $this->design->assign('translations', $translations);

        return $this->design->fetch('translations.tpl');
    }

    /**
     * шапка таблицы
     *
     * @param $langs_label
     *
     * @return array
     */
    private function getHeadTable($langs_label)
    {
        $head[] = ['name' => "id", 'sorter' => "number", 'autosearch' => false, 'readOnly' => true, 'width' => 35];
        $head[] = ['name' => "название переменной", 'type' => "textarea", 'autosearch' => true, 'validate' => "required"];
        foreach ($langs_label as $lang){
            $head[] = ['name' => "$lang", 'type' => 'textarea', 'autosearch' => true];
        };
        $head[] = ['type' => 'control'];

        return $head;
    }

    /**
     * @param array $langs_label
     * @param array $translations
     *
     * @return array
     */
    private function getBodyTable($langs_label, $translations)
    {
        $body = [];
        foreach ($translations as $key => $trans){
            $body[$key] = ['id' => $trans->id, 'название переменной' => "$trans->label"];
            foreach ($langs_label as $type){
                $body[$key] += ["$type" => $trans->{'lang_'.$type}];
            }
        }

        return $body;
    }

}