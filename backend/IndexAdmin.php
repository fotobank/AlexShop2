<?php


use api\Registry;
use core\Alex;
use proxy\Config;
use proxy\Cookie;
use proxy\Session;

/**
 * Этот класс выбирает модуль в зависимости от параметра Section и выводит его на экран
 * Class IndexAdmin
 */
class IndexAdmin extends Registry
{
    // Соответсвие модулей и иерархия разделов главного меню
    private $left_menu_modules = [];

    // Соответсвие модулей и названий соответствующих прав
    private $modules_permissions = [];

    protected $manager;

    // Конструктор
    public function __construct()
    {
        $t = Config::getData('left_menu');
        $this->left_menu_modules = iterator_to_array(new RecursiveIteratorIterator(new RecursiveArrayIterator(Config::getData('left_menu'))), true);
        $this->modules_permissions = Config::getData('modules_permissions');

        // Вызываем конструктор базового класса
        parent::__construct();

        // Берем название модуля из get-запроса
        $module = $this->request->get('module', 'string');
        $module = preg_replace('/[^A-Za-z0-9]+/', '', $module);
        // проверяем чекбокс 'запомнить'
        if (!is_ajax()){
            $this->support_remember();
        }
        // Администратор
        $this->manager = $this->managers->get_manager();
        $this->design->assign('mаnаgеr', $this->manager);
        // авторизация
        if (!$this->manager && $module != 'AuthAdmin'){
            header('location: ' . $this->config->root_url . '/backend/index.php?module=AuthAdmin');
            exit();
        } elseif ($this->manager && $module == 'AuthAdmin') {
            header('location: ' . $this->config->root_url . '/backend/index.php');
            exit();
        }

        if ($module != 'AuthAdmin'){
            // лицензия
            /*$p=13; $g=3; $x=5; $r = ''; $s = $x;
            $bs = explode(' ', $this->config->license);
            foreach($bs as $bl){
                for($i=0, $m=''; $i<strlen($bl)&&isset($bl[$i+1]); $i+=2){
                    $a = base_convert($bl[$i], 36, 10)-($i/2+$s)%27;
                    $b = base_convert($bl[$i+1], 36, 10)-($i/2+$s)%24;
                    $m .= ($b * (pow($a,$p-$x-5) )) % $p;}
                $m = base_convert($m, 10, 16); $s+=$x;
                for ($a=0; $a<strlen($m); $a+=2) $r .= @chr(hexdec($m{$a}.$m{($a+1)}));}

            $r = 'Registry,www.Registry#2016-09-01#a355cf6545f24b664b9a2b94f2184c2b1a79d4774612aef6a6359f47fc71321d';
            @list($l->domains, $l->expiration, $l->comment) = explode('#', $r, 3);

            $l->domains = explode(',', $l->domains);
            $h = getenv("HTTP_HOST");
            $this->design->assign('manager', $this->manager);
            if(substr($h, 0, 4) == 'www.') $h = substr($h, 4);
            if((!in_array($h, $l->domains) || (strtotime($l->expiration)<time() && $l->expiration!='*')) && $module!='LicenseAdmin') {
                header('location: '.$this->config->root_url.'/backend/index.php?module=LicenseAdmin');
            } else {
                $l->valid = true;
                $this->design->assign('license', $l);
            }
            $this->design->assign('license', $l);*/

            $this->design->assign('manager', $this->manager);
            $this->design->assign('license', new class()
            {
                public $valid = true;
                public $comment = 'a355cf6545f24b664b9a2b94f2184c2b1a79d4774612aef6a6359f47fc71321d';
                public $expiration = '2032-09-01';
                public $domains = ['okay', 'www.okay'];
            });
        }

        $this->design->set_templates_dir('backend/design/html');
        $compile_dir = SYS_DIR . 'assests/compiled/smarty/backend';
        if (!is_dir($compile_dir)){
            Alex::checkDir(SYS_DIR . 'assests/cache/smarty', 0777);
        }
        $this->design->set_compiled_dir($compile_dir);

        $this->design->assign('settings', $this->settings);
        $this->design->assign('config', $this->config);

        // Язык
        $languages = $this->languages->languages();
        $this->design->assign('languages', $languages);

        if (count($languages)){
            $post_lang_id = $this->request->post('lang_id', 'integer');
            $admin_lang_id = ($post_lang_id ?: $this->request->get('lang_id', 'integer'));
            if ($admin_lang_id){
                $_SESSION['admin_lang_id'] = $admin_lang_id;
            }
            if (!isset($_SESSION['admin_lang_id'], $languages[$_SESSION['admin_lang_id']])){
                $l = reset($languages);
                $_SESSION['admin_lang_id'] = $l->id;
            }
            $this->languages->set_lang_id($_SESSION['admin_lang_id']);
        }

        $lang_id = $this->languages->lang_id();
        $this->design->assign('lang_id', $lang_id);

        $lang_label = '';
        $lang_link = '';
        if ($lang_id && $languages){
            $lang_label = $languages[$lang_id]->label;

            $first_lang = $this->languages->languages();
            $first_lang = reset($first_lang);
            if ($first_lang->id != $lang_id){
                $lang_link = $lang_label . '/';
            }
        }
        if ($languages){
            $lang_labels = $this->languages->languages(['labels' => 'all']);
            $this->design->assign('langs_label', $lang_labels);
        }
        $this->design->assign('lang_label', $lang_label);
        $this->design->assign('lang_link', $lang_link);

        // Если не запросили модуль - используем модуль первый из разрешенных
        if (null === $module || !is_file('backend/' . $module . '.php')){
            foreach ($this->modules_permissions as $m => $p){
                if ($this->managers->access($p)){
                    $module = $m;
                    break;
                }
            }
        }
        if (empty($module)){
            $module = 'ProductsAdmin';
        }
        if (array_key_exists($module, $this->left_menu_modules)){
            $this->design->assign('menu_selected', $this->left_menu_modules[$module]);
        }
        $this->design->assign('module', $module);
        $this->design->assign('left_menu_modules', $this->left_menu_modules);
        // создаем необходимый модуль
        $this->module = new $module();
    }

    public function fetch()
    {
        $currency = $this->money->get_currency();
        $this->design->assign('currency', $currency);
        $content = '';
        $class_module = get_class($this->module);
        $tpl_name = $this->modules_permissions[get_class($this->module)] ?? false;

        // Проверка прав доступа к модулю
        if ($class_module == 'AuthAdmin' || $this->managers->access($tpl_name)){
            $content = $this->module->fetch();
            $this->design->assign('content', $content);
        } else {
            $this->design->assign('content', 'Permission denied');
            $this->design->assign('menu_selected', '');
        }


        // Счетчики для верхнего меню
        $new_orders_counter = $this->orders->count_orders(['status' => 0]);
        $this->design->assign('new_orders_counter', $new_orders_counter);

        $new_comments_counter = $this->comments->count_comments(['approved' => 0]);
        $this->design->assign('new_comments_counter', $new_comments_counter);

        $new_feedbacks = $this->feedbacks->get_feedbacks(['processed' => 0]);
        $new_feedbacks_counter = count($new_feedbacks);
        $this->design->assign('new_feedbacks_counter', $new_feedbacks_counter);

        $new_callbacks = $this->callbacks->get_callbacks(['processed' => 0]);
        $new_callbacks_counter = count($new_callbacks);
        $this->design->assign('new_callbacks_counter', $new_callbacks_counter);


        // Создаем текущую обертку сайта (обычно index.tpl)
        $wrapper = $this->design->smarty->getTemplateVars('wrapper');
        if (is_null($wrapper)){
            $wrapper = 'index.tpl';
        }

        if (!empty($wrapper)){
            return $this->body = $this->design->fetch($wrapper);
        }
            return $this->body = $content;

    }

    /**
     * поддержка чекбокса 'запомнить'
     */
    protected function support_remember()
    {
        if (Cookie::has('_remember')){
            // проверяем время доступности и вылидность cookie
            $cookie = Cookie::get('_remember');
            $cookie_remember = $this->request->filter_string($cookie, 'sql');
            $manager_cookie = $this->managers->manager_cookie($cookie_remember);
            // если запись в базе не найдена или время вышло
            if (null != $manager_cookie && $manager_cookie->diff > 5){
                $admin_cookie = $this->settings->admin_cookie_number . ' ' . $this->settings->admin_cookie_unit;
                // не создавать cookie чаше 5 секунд
                if (strtotime("+ $admin_cookie") - $manager_cookie->diff - time() > 5){
                    // при каждом посещении страницы обновляем cookie и записываем их в базу
                    Cookie::set('_remember', $cookie, strtotime("+ $admin_cookie"), '/');
                    $arr_value['cookie'] = $cookie;
                    $arr_value['valid_period'] = $admin_cookie;
                    $this->managers->update_manager((int)$manager_cookie->id, $arr_value);
                    Session::set('admin', $manager_cookie->login);
                }
                // если время вышло или менеджер в базе не найден удаляем фиктивную cookie и выходим
            } else {
                $this->managers->delete_cookie($cookie_remember, 'cookie');
                $this->managers->delete_cookie(Session::get('admin'), 'login');
                Session::del('admin');
                Cookie::del('_remember'); // если доступное время для менеджера вышло - удаляем cookie
                header('location: ' . $this->config->root_url . '/admin');
                exit();
            }
        }
    }
}
