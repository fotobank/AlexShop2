<?php

use api\Registry;
use exception\CommonException;

class AjaxTranslationsAdminException extends CommonException
{
}

/**
 * Class AjaxTranslationsAdmin
 */
class AjaxTranslationsAdmin extends Registry
{

    public function fetch()
    {
        $filter['langs'] = $this->design->get_var('langs_label');

        // Обработка действий
        if ($this->request->method('post')){

            if (is_ajax()){

                // ajax вывод заголовка jqGrid таблицы
                if (!empty($this->request->post('jqgrid_heading', 'integer'))){
                    $this->head_table($filter['langs']);
                }
                // ajax вывод jqGrid таблицы
                if ($this->request->post('_search', 'string') == 'false'){
                    $this->body_table($filter);
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
     * названия колонок в таблице
     * @param $langs
     */
    protected function head_table($langs)
    {
        $lang_list = $this->languages->lang_list();
        $head = ['id', 'переменная в шаблоне'];
        foreach ($langs as $short_lang){
            $head[] = mb_strtolower($lang_list["$short_lang"]->name);
        }
        $model = $this->model_table($langs);

        $json = json_encode(['head' => $head, 'model' => $model]);
        $this->response($json);
    }

    /**
     * разметка таблицы
     *
     * @param $langs_label
     *
     * @return array
     */
    private function model_table($langs_label)
    {
        $model[] = [
            'name' => 'id', 'index' => 'id', 'readOnly' => true, 'width' => 15, 'editable' => false, 'search' => false
        ];
        $model[] = ['name' => 'label', 'index' => 'label', 'searchrules' => ['required' => true], 'editable' => true, 'edittype' => 'textarea', 'width' => 80];
        foreach ($langs_label as $lang){
            $model[] = ['name' => "lang_$lang", 'index' => "lang_$lang", 'searchrules' => ['required' => true], 'editable' => true, 'edittype' => 'textarea', 'width' => 80];
        };

        return $model;
    }

    /**
     * вывод результата
     *
     * @param $json
     */
    protected function response($json)
    {
        header('Content-type: application/json; charset=UTF-8');
        header('Cache-Control: must-revalidate');
        header('Pragma: no-cache');
        header('Expires: -1');
        print $json;
        exit();
    }

    /**
     * @param $filter
     */
    protected function body_table($filter)
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

        $json = json_encode($this->languages->get_translations($filter));
        $this->response($json);
    }

    /**
     * @param $filter
     */
    protected function search($filter)
    {
        try {
            //читаем параметры
            $filter['curPage'] = $this->request->post('page', 'integer');
            $filter['rowsPerPage'] = $this->request->post('rows', 'integer');
            $filter['sortingField'] = $this->request->post('sidx', 'string');
            $filter['sortingOrder'] = $this->request->post('sord', 'string');

            // допустимые колонки таблицы
            $filter['allowedFields'] = ['id', 'label'];
            foreach ($filter['langs'] as $short_lang){
                $filter['allowedFields'][] = 'lang_' . $short_lang;
            }

            // допустимый маркер
            $filter['allowedOperations'] = ['AND', 'OR'];

            $filter['searchData'] = json_decode($_POST['filters']);

            //ограничение на количество условий
            if (count($filter['searchData']->rules) > 10){
                throw new AjaxTranslationsAdminException('Cool hacker is here!!! :)');
            }

            $translations = $this->languages->get_search($filter);
            //определяем количество записей в таблице
            $totalRows = count($translations);

            //сохраняем номер текущей страницы, общее количество страниц и общее количество записей
            $response = new stdClass();
            $response->page = $filter['curPage'];
            $response->total = ceil($totalRows / $filter['rowsPerPage']);
            $response->records = $totalRows;

            $rows = [];
            foreach ($translations as $key => $row){
                $rows[$key]['id'] = $row->id;
                $rows[$key]['cell'] = [$row->id, $row->label];
                foreach ($filter['langs'] as $short_lang){
                    $rows[$key]['cell'][] = $row->{'lang_' . $short_lang};
                }
            }
            $response->rows = $rows;
            $response = json_encode($response);
            $this->response($response);

        } catch (AjaxTranslationsAdminException $e) {

            $json = json_encode(['errMess' => 'Error: ' . $e->getMessage()]);
            $this->response($json);
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

        $exist_label = $this->languages->get_language_where_label($translation->label);

        $error = $this->db->getMysqli()->error;

        $registry_object = $this->{$translation->label};
        $success = false;
        if (!$translation->label){
            $error .= ' присутствуют путые поля';
        } elseif ($exist_label && $exist_label->id != $translation->id) {
            $error .= ' запись "'.$translation->id.'" уже существует';
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

        $json = ($error != '') ? ['message' => 'Error: ' . $error] : ['message' => 'Success: ' . $success];

        $json = json_encode($json);
        $this->response($json);
    }

    /**
     * удаление записи
     */
    protected function delete()
    {
        $id = $this->request->post('id', 'integer');
        $this->languages->delete_translation($id);

        $error = $this->db->getMysqli()->error;
        $json = ($error != '') ? ['message' => 'Error: ' . $error] : ['message' => 'Success: запись удалена'];

        $json = json_encode($json);
        $this->response($json);
    }

}