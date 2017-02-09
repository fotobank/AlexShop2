<?php

use api\Registry;

class AjaxTranslationsAdmin extends Registry
{

    public function fetch()
    {
        $filter = [];
        $filter['langs'] = $this->design->get_var('langs_label');

        // Обработка действий
        if ($this->request->method('post')){

            if (is_ajax()){

                // ajax вывод заголовка jqGrid таблицы
                if (!empty($this->request->post('jqgrid_heading', 'integer'))){
                    $this->put_ajax_head($filter['langs']);
                }
                // ajax вывод jqGrid таблицы
                if ($this->request->post('_search', 'string') == 'false'){
                    $this->put_ajax_body($filter);
                // поиск
                } elseif ($this->request->post('_search', 'string') == 'true') {
                    $this->search($filter);
                }
                // редактирование или добавление записей
                $mode = $this->request->post('oper', 'string');
                if ($mode == 'edit' || $mode == 'add'){
                    $this->edit();
                }
                // удаление
                if (!empty($this->request->post('oper', 'string') == 'del')){
                    $this->delete();
                }
            }
        }
        exit();
    }

    /**
     *
     */
    protected function delete() {
        $id = $this->request->post('id', 'integer');
        $this->languages->delete_translation($id);

        $error = $this->db->getMysqli()->error;
        $mess = ($error != '') ? ['message' => 'Error: ' . $error] : ['message' => 'Success: запись удалена'];

        header('Content-type: application/json; charset=UTF-8');
        header('Cache-Control: must-revalidate');
        header('Pragma: no-cache');
        header('Expires: -1');
        $json = json_encode($mess);
        print $json;
        exit();
    }

    /**
     * @param $filter
     */
    protected function search($filter)
    {
        try {
            //читаем параметры
            $curPage = $this->request->post('page', 'integer');
            $rowsPerPage = $this->request->post('rows', 'integer');
            $sortingField = $this->request->post('sidx', 'string');
            $sortingOrder = $this->request->post('sord', 'string');

            $qWhere = '';
            if (isset($_POST['_search']) && $_POST['_search'] == 'true'){

                $allowedFields = ['id', 'label'];
                foreach ($filter['langs'] as $short_lang){
                    $allowedFields[] = 'lang_' . $short_lang;
                }

                $allowedOperations = ['AND', 'OR'];

                $searchData = json_decode($_POST['filters']);

                //ограничение на количество условий
                if (count($searchData->rules) > 10){
                    throw new Exception('Cool hacker is here!!! :)');
                }

                $qWhere = ' WHERE ';
                $firstElem = true;
                //объединяем все полученные условия
                foreach ($searchData->rules as $rule){

                    if (!$firstElem) {
                    //объединяем условия (с помощью AND или OR)
                    if (in_array($searchData->groupOp, $allowedOperations)){
                        $qWhere .= ' ' . $searchData->groupOp . ' ';
                    } else {
                        //если получили не существующее условие - возвращаем описание ошибки
                        throw new Exception('Cool hacker is here!!! :)');
                    }
                    }
                    else {
                        $firstElem = false;
                    }
                    //вставляем условия
                    if (in_array($rule->field, $allowedFields)){
                        switch ($rule->op) {
                            case 'eq': // равно
                                $qWhere .= $rule->field . " = '" . $this->db->escape($rule->data)."'";
                                break;
                            case 'ne': // не равно
                                $qWhere .= $rule->field . " <> '" . $this->db->escape($rule->data)."'";
                                break;
                            case 'bw': // начинаетя с
                                $qWhere .= $rule->field . " LIKE '" . $this->db->escape($rule->data . '%')."'";
                                break;
                            case 'cn': // содержит
                                $qWhere .= $rule->field . " LIKE '" . $this->db->escape('%' . $rule->data . '%')."'";
                                break;
                            default:
                                throw new Exception('Cool hacker is here!!! :)');
                        }
                    } else {
                        //если получили не существующее условие - возвращаем описание ошибки
                        throw new Exception('Cool hacker is here!!! :)');
                    }

                }
            }

            $firstRowIndex = $curPage * $rowsPerPage - $rowsPerPage;

            //получаем массив искомых переводов
            $this->db->query('
                 SELECT * FROM __translations ' . $qWhere . ' 
                 ORDER BY ' . $sortingField . ' ' . $sortingOrder . '
                 LIMIT ' . $firstRowIndex . ', ' . $rowsPerPage
            );
            $translations = $this->db->results();

            //определяем количество записей в таблице
            $totalRows =  $this->languages->get_count($qWhere);

            //сохраняем номер текущей страницы, общее количество страниц и общее количество записей
            $response = new stdClass();
            $response->page = $curPage;
            $response->total = ceil($totalRows / $rowsPerPage);
            $response->records = $totalRows;

            $rows = [];
            foreach ($translations as $key => $row) {
                $rows[$key]['id'] = $row->id;
                $rows[$key]['cell'] = [$row->id, $row->label];
                foreach ($filter['langs'] as $short_lang){
                    $rows[$key]['cell'][] = $row->{'lang_' . $short_lang};
                }
            }
            $response->rows = $rows;
            echo json_encode($response);
        } catch (Exception $e) {
            echo json_encode(['errMess' => 'Error: ' . $e->getMessage()]);
        }
    }

    /**
     *
     */
    protected function edit()
    {
        $translation = new stdClass();
        $languages = $this->languages->get_languages();

        if ($languages){
            foreach ($languages as $lang){
                $field = 'lang_' . $lang->label;
                $translation->$field = $this->request->post($field, 'string');
            }
        }

        $translation->id = $this->request->post('id', 'integer');
        $translation->label = trim($this->request->post('label', 'string'));

        $this->db->query("SELECT * FROM __translations WHERE label=? LIMIT 1", $translation->label);
        $exist_label = $this->db->result();

        $error = $this->db->getMysqli()->error;

        $registry_object = $this->{$translation->label};
        $success = false;
        if (!$translation->label){
            $error .= ' присутствуют путые поля';
        } elseif ($exist_label && $exist_label->id != $translation->id) {
            $error .= ' запись уже существует';
        } elseif (!empty($registry_object)) {
            $error .= ' переменная является классом';
        } else {
            if ($translation->id == '_empty'){
                $translation->id = $this->languages->add_translation($translation);
                $success = 'перевод добавлен';
            } else {
                $this->languages->update_translation($translation->id, $translation);
                $success = 'запись обновлена';
            }
            $this->languages->update_translation_file();
            $this->languages->update_translation_config_js();
        }

        $mess = ($error != '') ? ['message' => 'Error: ' . $error] : ['message' => 'Success: ' . $success];

        header('Content-type: application/json; charset=UTF-8');
        header('Cache-Control: must-revalidate');
        header('Pragma: no-cache');
        header('Expires: -1');
        $json = json_encode($mess);
        print $json;
        exit();
    }

    /**
     * @param $filter
     */
    protected function put_ajax_body($filter)
    {
        // Получаем номер страницы. Сначала jqGrid ставит его в 1.
        $filter['page'] = $this->request->post('page', 'integer');

        // сколько строк мы хотим иметь в таблице - rowNum параметр
        $filter['limit'] = $this->request->post('rows', 'integer');

        // Колонка для сортировки. Сначала sortname параметр
        // затем index из colModel
        $filter['sidx'] = $this->request->post('sidx', 'string');

        // Порядок сортировки.
        $filter['sord'] = $this->request->post('sord', 'string');

        // Если колонка сортировки не указана, то будем
        // сортировать по первой колонке.
        if (!$filter['sidx']) $filter['sidx'] = 1;

        // Вычисляем количество строк для навигации..
        $count = $this->languages->get_count();

        // Вычисляем общее количество страниц.
        if ($count > 0 && $filter['limit'] > 0){
            $total_pages = ceil($count / $filter['limit']);
        } else {
            $total_pages = 0;
        }
        // Если запрашиваемый номер страницы больше общего количества страниц,
        // то устанавливаем номер страницы в максимальный.
        if ($filter['page'] > $total_pages) $filter['page'] = $total_pages;

        // Вычисляем начальное смещение строк.
        $filter['start'] = $filter['limit'] * $filter['page'] - $filter['limit'];

        // Если начальное смещение отрицательно, то устанавливаем его в 0.
        // Например, когда пользователь выбрал 0 в качестве запрашиваемой страницы.
        if ($filter['start'] < 0) $filter['start'] = 0;

        $body = $this->languages->get_translations($filter);

        header("Content-type: application/json; charset=UTF-8");
        header("Cache-Control: must-revalidate");
        header("Pragma: no-cache");
        header("Expires: -1");
        $json = json_encode($body);
        print $json;
        exit();
    }

    /**
     * шапка таблицы
     *
     * @param $langs_label
     *
     * @return array
     */
    private function get_grid_model($langs_label)
    {
        $head[] = [
            'name' => 'id', 'index' => 'id', 'readOnly' => true, 'width' => 15, 'editable' => false, 'search' => false
        ];
        $head[] = ['name' => 'label', 'index' => 'label', 'searchrules' => ['required' => true], 'editable' => true, 'edittype' => 'textarea', 'width' => 80];
        foreach ($langs_label as $lang){
            $head[] = ['name' => "lang_$lang", 'index' => "lang_$lang", 'searchrules' => ['required' => true], 'editable' => true, 'edittype' => 'textarea', 'width' => 80];
        };

        return $head;
    }

    /**
     * @param $langs
     */
    protected function put_ajax_head($langs)
    {
        $lang_list = $this->languages->lang_list();
        $head = ['id', 'переменная в шаблоне'];
        foreach ($langs as $short_lang){
            $head[] = mb_strtolower($lang_list["$short_lang"]->name);
        }
        $model = $this->get_grid_model($langs);

        header("Content-type: application/json; charset=UTF-8");
        header("Cache-Control: must-revalidate");
        header("Pragma: no-cache");
        header("Expires: -1");
        $json = json_encode(['head' => $head, 'model' => $model]);
        print $json;
        exit();
    }

}