<?php
/*************************************************
 * Framework Component
 * name      AlexShop_CMS
 * created   by Alex production
 * version   1.0
 * author    Alex Jurii <alexjurii@gmail.com>
 * Copyright (c) 2016
 ************************************************/

namespace api;

class Lang extends Registry
{

    public $tables = [
        'product' => 'products',
        'variant' => 'variants',
        'brand' => 'brands',
        'category' => 'categories',
        'feature' => 'features',
        'blog' => 'blog',
        'page' => 'pages',
        'currency' => 'currencies',
        'delivery' => 'delivery',
        'payment' => 'payment_methods',
        'banner_image' => 'banners_images'
    ];

    public $languages;
    public $lang_id;

    /**
     * Lang constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->init_languages();
    }

    public function lang_list()
    {
        $langs['ru'] = (object)['name' => 'Русский', 'label' => 'ru'];
        $langs['uk'] = (object)['name' => 'Украинский', 'label' => 'uk'];
        $langs['by'] = (object)['name' => 'Белорусский', 'label' => 'by'];
        $langs['en'] = (object)['name' => 'Английский', 'label' => 'en'];
        $langs['ch'] = (object)['name' => 'Китайский', 'label' => 'ch'];
        $langs['de'] = (object)['name' => 'Немецкий', 'label' => 'de'];
        $langs['fr'] = (object)['name' => 'Французский', 'label' => 'fr'];

        return $langs;
    }

    public function get_fields($object = '')
    {
        $fields['categories'] = ['name', 'name_h1', 'meta_title', 'meta_keywords', 'meta_description', 'annotation', 'description', 'auto_meta_title', 'auto_meta_keywords', 'auto_meta_desc', 'auto_body'];
        $fields['brands'] = ['name', 'meta_title', 'meta_keywords', 'meta_description', 'annotation', 'description'];
        $fields['products'] = ['name', 'meta_title', 'meta_keywords', 'meta_description', 'annotation', 'body', 'special'];
        $fields['variants'] = ['name'];
        $fields['blog'] = ['name', 'meta_title', 'meta_keywords', 'meta_description', 'annotation', 'text'];
        $fields['pages'] = ['name', 'meta_title', 'meta_keywords', 'meta_description', 'header', 'body'];
        $fields['features'] = ['name'];
        $fields['delivery'] = ['name', 'description'];
        $fields['payment_methods'] = ['name', 'description'];
        $fields['currencies'] = ['name', 'sign'];
        $fields['banners_images'] = ['name', 'alt', 'title', 'description', 'url'];

        if ($object && !empty($fields[$object])){
            return $fields[$object];
        } else {
            return $fields;
        }
    }

    /**
     * @param array $params
     *
     * @return \stdClass
     * @throws \exception\DbException
     */
    public function get_query(array $params = [])
    {
        $lang = (isset($params['lang']) && $params['lang'] ? $params['lang'] : $this->lang_id());
        $object = $params['object'];

        if (!empty($params['px'])){
            $px = $params['px'];
        } else {
            $px = $object[0];
        }

        $this->db->query("SHOW TABLES LIKE '%__languages%'");
        $exist = $this->db->result();

        if (isset($lang) && $exist && null !== $this->languages){
            /*$f = 'l';
            $lang_join = 'LEFT JOIN __lang_'.$this->tables[$object].' l ON l.'.$object.'_id='.$px.'.id AND l.lang_id = '.(int)$lang;*/
            $f = (isset($params['px_lang']) && $params['px_lang'] ? $params['px_lang'] : 'l');
            $lang_join = 'LEFT JOIN __lang_' . $this->tables[$object] . ' ' . $f . ' ON ' . $f . '.' . $object . '_id=' . $px . '.id AND ' . $f . '.lang_id = ' . (int)$lang;
        } else {
            $f = $px;
            $lang_join = '';
        }
        $lang_col = $f . '.' . implode(', ' . $f . '.', $this->get_fields($this->tables[$object]));

        $result = new \stdClass;
        $result->join = $lang_join;
        $result->fields = $lang_col;

        return $result;
    }

    /**
     * @return array|bool|float|int|mixed|null
     */
    public function lang_id()
    {
        if (null === $this->languages){
            return false;
        }

        if (isset($this->lang_id)){
            return $this->lang_id;
        }

        if ($this->request->get('lang_id', 'integer')){
            unset($_SESSION['lang_id']);
            $this->lang_id = $_SESSION['lang_id'] = $this->request->get('lang_id', 'integer');
        }

        if ($this->request->get('lang_label', 'string') && !$this->request->get('lang_id', 'integer')){
            $lang_id = null;
            foreach ($this->languages as $l){
                if ($this->request->get('lang_label', 'string') == $l->label){
                    $lang_id = $l->id;
                    break;
                }
            }
            $this->lang_id = $_SESSION['lang_id'] = $lang_id;

            return $this->lang_id;
        }

        if (empty($this->lang_id) && !empty($_SESSION['lang_id']) && !empty($this->languages[$_SESSION['lang_id']])){
            $this->lang_id = $_SESSION['lang_id'];
        }
        /*if(empty($this->lang_id) && $this->settings->lang_default) {
            $this->lang_id = $this->settings->lang_default;
        }*/

        if (empty($this->lang_id)){
            $first_lang = reset($this->languages);
            $this->lang_id = $first_lang->id;
        }

        return $this->lang_id;
    }

    public function set_lang_id($id)
    {
        $this->lang_id = $_SESSION['lang_id'] = $id;
    }


    public function languages($filter = [])
    {
        if (null === $this->languages){
            $this->init_languages();
        }

        if (!empty($filter['id'])){
            return $this->languages[$filter['id']];
        }

        if (!empty($filter['label'])){
            foreach ($this->languages as $lang){
                if ($lang->label == $filter['label']){
                    return $lang;
                }
            }
        }
        if (!empty($filter['labels'])){
            $langs = [];
            foreach ($this->languages as $lang){
                $langs[$lang->id] = $lang->label;
            }

            return $langs;
        }

        return $this->languages;
    }

    public function init_languages()
    {
        if (null !== $this->languages){
            return $this->languages;
        }

        if ($langs = $this->get_languages()){
            foreach ($langs as $l){
                $this->languages[$l->id] = $l;
            }
        } else {
            return false;
        }
    }

    public function get_language($id)
    {
        $query = $this->db->placehold('SELECT * FROM __languages WHERE id=? LIMIT 1', (int)$id);
        $this->db->query($query);

        return $this->db->result();
    }

    public function get_translations_where_label($label)
    {
        $query = $this->db->placehold("SELECT * FROM __translations WHERE label=? LIMIT 1", (string)$label);
        $this->db->query($query);

        return $this->db->result();
    }

    public function get_languages($filter = [])
    {
        $this->db->query("SHOW TABLES LIKE '%__languages%'");
        if (!$this->db->result()){
            return false;
        }

        $not_default = '';
        if (!empty($filter['not_default'])){
            $not_default = 'AND `is_default` != 1';
        }
        $query = "SELECT * FROM __languages WHERE 1 $not_default ORDER BY position";
        if ($this->db->query($query)){
            return $this->db->results();
        } else {
            return false;
        }
    }

    public function update_language($id, $data)
    {
        $data = (object)$data;

        $language = $this->get_language($id);

        if (isset($data->is_default)){
            $this->db->query('UPDATE __languages SET is_default=0 WHERE is_default=1');
            $this->settings->lang_default = $id;
        }

        $query = $this->db->placehold('UPDATE __languages SET ?% WHERE id IN(?@)', $data, (array)$id);
        $this->db->query($query);

        if (isset($data->label) && !empty($language) && $language->label !== $data->label){
            foreach ($this->tables as $table){
                $this->db->query('UPDATE __lang_' . $table . ' SET lang_label=? WHERE lang_id=?', $data->label, $id);
            }
        }

        return $id;
    }

    /**
     * @param $data
     *
     * @return bool|mixed
     * @throws \exception\DbException
     */
    public function add_language($data)
    {
        $data = (object)$data;
        $languag = null;

        $languages = $this->get_languages();
        $data->position = 1;
        if (!empty($languages)){
            $languag = reset($languages);
            $data->position = $languag->position + 1;
        }

        $query = $this->db->placehold('INSERT INTO __languages SET ?%', $data);
        if (!$this->db->query($query)){
            return false;
        }

        // если нету поля в переводах добавим его
        $this->db->query('SHOW FIELDS FROM __translations WHERE field=?', 'lang_' . $data->label);
        if (!$this->db->result()){
            $this->db->query("ALTER TABLE __translations ADD COLUMN `lang_$data->label` VARCHAR(255) NOT NULL DEFAULT ''");
        }

        $last_id = $this->db->insert_id();

        if ($last_id){
            $description_fields = $this->get_fields();

            foreach ($this->tables as $object => $tab){
                $this->db->query('
               INSERT INTO __lang_' . $tab . ' (' . implode(',', $description_fields[$tab]) . ', ' . $object . '_id, lang_id, lang_label) 
               SELECT ' . implode(',', $description_fields[$tab]) . ', id, ?, ?
               FROM __' . $tab . '', $last_id, $data->label
                );
            }

            if (!empty($languages)){
                $this->db->query('SELECT * FROM __options WHERE lang_id=?', $languag->id);
                $options = $this->db->results();
                if (!empty($options)){
                    foreach ($options as $o){
                        $this->db->query('REPLACE INTO __options SET lang_id=?, value=?, product_id=?, feature_id=?, translit=?', $last_id, $o->value, $o->product_id, $o->feature_id, $o->translit);
                    }
                }
            } else {
                $this->db->query('UPDATE __options SET lang_id=?', $last_id);
            }

            return $last_id;
        }
    }

    public function delete_language($id, $save_main = false)
    {
        if (!empty($id)){
            $lang = $this->get_language($id);
            if (!$lang->is_default){
                $query = $this->db->placehold("DELETE FROM __languages WHERE id=? LIMIT 1", (int)$id);
                $this->db->query($query);

                foreach ($this->tables as $table){
                    $this->db->query('DELETE FROM  __lang_' . $table . " WHERE lang_id=?", (int)$id);
                }

                if (!$save_main){
                    $this->db->query('DELETE FROM  __options WHERE lang_id=?', (int)$id);
                } else {
                    $this->db->query('UPDATE __options SET lang_id=0 WHERE lang_id=?', (int)$id);
                }
            }
        }
    }

    public function action_data($object_id, $data, $object)
    {
        if (!in_array($object, array_keys($this->tables))){
            return false;
        }

        $this->db->query('
             SELECT count(*) AS count FROM __lang_' . $this->tables[$object] . ' 
             WHERE lang_id=? 
             AND ' . $object . '_id=? 
             LIMIT 1', $data->lang_id, $object_id
        );
        $data_lang = $this->db->result('count');
        $result = '';

        // вставить или обновить перевод
        if ($data_lang == 0){
            $object_fild = $object . '_id';
            $data->$object_fild = $object_id;
            $query = $this->db->placehold('INSERT INTO __lang_' . $this->tables[$object] . ' SET ?%', $data);
            $this->db->query($query);
            $result = 'add';
        } elseif ($data_lang == 1) {
            $this->db->query('UPDATE __lang_' . $this->tables[$object] . ' SET ?% WHERE lang_id=? AND ' .
                $object . '_id=?', $data, $data->lang_id, $object_id);
            $result = 'update';
        }

        return $result;
    }

    public function get_description($data, $object)
    {
        if (!in_array($object, array_keys($this->tables))){
            return false;
        }

        $languages = $this->languages();
        if (empty($languages)){
            return false;
        }
        $languag = reset($languages);
        $fields = $this->get_fields($this->tables[$object]);
        $intersect = array_intersect($fields, array_keys((array)$data));

        if (!empty($intersect)){
            $description = new \stdClass;
            foreach ($fields as $f){
                if (isset($data->$f)){
                    $description->$f = $data->$f;
                }
                if ($languag->id != $this->lang_id()){
                    unset($data->$f);
                }
            }
            $result = new \stdClass();
            $result->description = $description;

            return $result;
        }

        return false;
    }

    public function action_description($object_id, $description, $object, $update_lang = null)
    {
        if (!in_array($object, array_keys($this->tables))){
            return false;
        }

        $languages = $this->languages();
        if (null === $this->languages){
            return;
        }

        $fields = $this->get_fields($this->tables[$object]);
        if (!empty($fields)){
            if ($update_lang){
                $upd_languages[] = $languages[$update_lang];
            } else {
                $upd_languages = $languages;
            }
            foreach ($upd_languages as $lang){
                $description->lang_id = $lang->id;
                $this->action_data($object_id, $description, $object);
            }

            return;
        } else {
            return;
        }
    }

    /**
     * количество строк в таблице
     *
     * @param null|string $qWhere
     *
     * @return int
     */
    public function get_count($qWhere = null)
    {
        $query = $this->db->placehold("SELECT COUNT(id) AS count FROM __translations " . $qWhere);
        $this->db->query($query);

        return (int)$this->db->result()->count;
    }

    /* Translation start */
    public function get_translation($id)
    {
        $query = $this->db->placehold("SELECT * FROM __translations WHERE id=? LIMIT 1", (int)$id);
        $this->db->query($query);

        return $this->db->result();
    }

    /**
     * @param $filter
     *
     * @return array
     * @throws \Exception
     */
    public function get_search($filter): array
    {
        $qWhere = ' WHERE ';
        $firstElem = true;
        //объединяем все полученные условия
        foreach ($filter['searchData']->rules as $rule){

            if (!$firstElem){
                //объединяем условия (с помощью AND или OR)
                if (in_array($filter['searchData']->groupOp, $filter['allowedOperations'])){
                    $qWhere .= ' ' . $filter['searchData']->groupOp . ' ';
                } else {
                    //если получили не существующее условие - возвращаем описание ошибки
                    throw new \Exception('Cool hacker is here!!! :)');
                }
            } else {
                $firstElem = false;
            }
            //вставляем условия
            if (in_array($rule->field, $filter['allowedFields'])){
                $rule->data = addslashes($rule->data);
                $qWhere .= "`" . preg_replace('/-|\'|\"/', '', $rule->field) . "`";
                switch ($rule->op) {
                    case 'eq': // равно
                        $qWhere .= " = '" . $rule->data . "'";
                        break;
                    case 'ne': // не равно
                        $qWhere .= " <> '" . $rule->data . "'";
                        break;
                    case 'bw': // начинаетя с
                        $qWhere .= " LIKE '" . $rule->data . "%'";
                        break;
                    case 'cn': // содержит
                        $qWhere .= " LIKE '%" . $rule->data . "%'";
                        break;
                    case 'bn':
                        $qWhere .= " NOT LIKE '" . $rule->data . "%'";
                        break;
                    case 'ew':
                        $qWhere .= " LIKE '%" . $rule->data . "'";
                        break;
                    case 'en':
                        $qWhere .= " NOT LIKE '%" . $rule->data . "'";
                        break;
                    case 'nc':
                        $qWhere .= " NOT LIKE '%" . $rule->data . "%'";
                        break;
                    case 'nu':
                        $qWhere .= ' IS NULL';
                        break;
                    case 'nn':
                        $qWhere .= ' IS NOT NULL';
                        break;
                    case 'in':
                        $qWhere .= " IN ('" . str_replace(',', "','", $rule->data) . "')";
                        break;
                    case 'ni':
                        $qWhere .= " NOT IN ('" . str_replace(',', "','", $rule->data) . "')";
                        break;

                    default:
                        throw new \Exception('Cool hacker is here!!! :)');
                }
            } else {
                //если получили не существующее условие - возвращаем описание ошибки
                throw new \Exception('Cool hacker is here!!! :)');
            }
        }

        $firstRowIndex = $filter['page'] * $filter['limit'] - $filter['limit'];

        //получаем массив искомых переводов
        $this->db->query('
                 SELECT * FROM __translations ' . $qWhere . ' 
                 ORDER BY ' . $filter['sortingField'] . ' ' . $filter['sortingOrder'] . '
                 LIMIT ' . $firstRowIndex . ', ' . $filter['limit']
        );

        return $this->db->results();
    }

    /**
     * @param array $filter
     *
     * @return array
     */
    public function get_translations($filter = [])
    {
        $order = 'ORDER BY label';
        $lang = '*';
        if (!empty($filter['lang'])){
            $lang = 'id, label, lang_' . $filter['lang'] . ' as value';
        } elseif (isset($filter['langs']) && is_array($filter['langs']) && 0 !== count($filter['langs'])) {
            $lang = 'id, label';
            foreach ($filter['langs'] as $name_lang){
                $lang .= ', lang_' . $name_lang . ' ';
            }
        }

        // сортировка для старого варианта таблицы
        if (!empty($filter['sort'])){
            switch ($filter['sort']) {
                case 'label_desc':
                    $order = 'ORDER BY label DESC';
                    break;
                case 'date':
                    $order = 'ORDER BY id';
                    break;
                case 'date_desc':
                    $order = 'ORDER BY id DESC';
                    break;
                case 'translation':
                    if (!empty($filter['lang'])){
                        $order = 'ORDER BY value';
                    }
                    break;
                case 'translation_desc':
                    if (!empty($filter['lang'])){
                        $order = 'ORDER BY value DESC';
                    }
                    break;
            }
        }
        if (!empty($filter['sortingField']) && !empty($filter['sortingOrder'])){
            $order = 'ORDER BY ' . $filter['sortingField'] . ' ' . $filter['sortingOrder'];
        }
        if (!empty($filter['limit'])){

            if (!empty($filter['start'])){
                $limit = 'LIMIT ' . $filter['start'] . ', ' . $filter['limit'];
            } else {
                $limit = 'LIMIT ' . $filter['limit'];
            }

            $query = "SELECT $lang FROM __translations $order $limit";
            if ($this->db->query($query)){
                return $this->db->results();
            }
        }

        $query = 'SELECT ' . $lang . " FROM __translations WHERE 1 $order";
        if ($this->db->query($query)){
            return $this->db->results();
        }
    }

    /**
     * функция поиска с автодополнением
     * для использования WHERE MATCH(`label`, `lang_ru`, `lang_en`, `lang_uk`)
     * в базе надо задать индекс таблицы с типом FULLTEXT, объединяющий в себе перечень полей для поиска
     *
     * @param $filter
     *
     * @return array
     * @internal param $query
     */
    public function get_autocomplete($filter)
    {

        $order = 'ORDER BY id';
        $lang = '*';
        // добавление языков
        if (!empty($filter['lang'])){
            $lang = 'label, lang_' . $filter['lang'] . ' as value';
        } elseif (isset($filter['langs']) && is_array($filter['langs']) && 0 !== count($filter['langs'])) {
            $lang = 'label';
            foreach ($filter['langs'] as $name_lang){
                $lang .= ', lang_' . $name_lang . ' ';
            }
        }

        if (!empty($filter['sortingField']) && !empty($filter['sortingOrder'])){
            $order = 'ORDER BY ' . $filter['sortingField'] . ' ' . $filter['sortingOrder'];
        }

        $query = $this->db->placehold("SELECT `id`, $lang
                    FROM __translations
                    WHERE MATCH($lang) 
                    AGAINST(? IN BOOLEAN MODE) $order", '*' . $filter['query'] . '*');
        if ($this->db->query($query)){
            return $this->db->results();
        }
    }

    public function update_translation($id, $data)
    {
        $query = $this->db->placehold("UPDATE __translations SET ?% WHERE id IN(?@)", $data, (array)$id);
        $this->db->query($query);
        $this->dump_translation();

        return $id;
    }

    public function add_translation($data)
    {
        $query = $this->db->placehold('INSERT INTO __translations SET ?%', $data);
        if (!$this->db->query($query)){
            return false;
        }
        $last_id = $this->db->insert_id();
        $this->dump_translation();

        return $last_id;
    }

    public function update_translation_file()
    {
        $translations = $this->get_translations();
        $languages = $this->get_languages();
        $theme_dir = 'design/' . $this->settings->theme;

        // ALL
        $filephp = $theme_dir . '/translation.php';
        $filephp = fopen($filephp, 'wb');
        $row = "<?PHP\n\n";
        foreach ($languages as $l){
            $row .= "$" . "languages['" . $l->label . "']='" . $l->name . "';\n";
        }
        foreach ($languages as $l){
            $row .= "\n//" . $l->name . "\n\n";

            foreach ($translations as $t){
                $lang = 'lang_' . $l->label;
                $row .= "$" . "lang['" . $l->label . "']['" . $t->label . "'] = '" . $this->db->escape($t->$lang) . "';\n";
            }
        }
        fwrite($filephp, $row);
        fclose($filephp);
    }

    public function update_translation_config_js()
    {
        $translations = $this->get_translations();

        // THEME JS
        $theme_dir = 'design/' . $this->settings->theme;
        $filejs = $theme_dir . '/lang.js';
        $filejs = fopen($filejs, 'wb');
        $js = "var lang = new Array();\n";

        $lang_id = $this->lang_id();
        $set_lang = $this->languages(['id' => $lang_id]);

        foreach ($translations as $t){
            if ($t->in_config){
                $lang = 'lang_' . $set_lang->label;
                $js .= "\nlang['" . $t->label . "'] = '" . mysqli_escape_string($this->db->getMysqli(), $t->$lang) . "';";
            }
        }
        fwrite($filejs, $js);
        fclose($filejs);
    }

    /**
     * удаление одной строки
     *
     * @param $id
     */
    public function delete_translation($id)
    {
        if (!empty($id)){
            $query = $this->db->placehold("DELETE FROM __translations WHERE id=? LIMIT 1", (int)$id);
            $this->db->query($query);
        }
    }

    /**
     * удаление множества строк
     *
     * @param array $ids
     *
     * @throws \exception\DbException
     */
    public function delete_translations($ids)
    {
        if (!empty($ids)){
            $this->db->query('DELETE FROM __translations WHERE id IN(?@)', $ids);
        }
    }

    public function set_translation()
    {
        $this->db->query('TRUNCATE TABLE __translations');

        $theme_dir = 'design/' . $this->settings->theme;
        $filename = $theme_dir . '/translation.sql';
        if (file_exists($filename)){
            $this->db->restore($filename);
        }
    }

    public function dump_translation()
    {
        $theme_dir = 'design/' . $this->settings->theme;
        $filename = $theme_dir . '/translation.sql';
        $filename = fopen($filename, 'wb');

        $this->db->dump_table('s_translations', $filename);
        //chmod($filename, 0777);
        fclose($filename);
    }
    /* Translation end */

}
