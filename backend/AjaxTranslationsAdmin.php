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
                if (!empty($this->request->post('jqgrid_body', 'integer'))){
                    $this->put_ajax_body($filter);
                }
            }
        }
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
        $filter['sort'] = $this->request->post('sort', 'string');

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
        $head[] = ['name' => 'label', 'index' => 'label', 'editable' => true, 'edittype' => 'textarea', 'width' => 80];
        foreach ($langs_label as $lang){
            $head[] = ['name' => "lang_$lang", 'index' => "lang_$lang", 'editable' => true, 'edittype' => 'textarea', 'width' => 80];
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