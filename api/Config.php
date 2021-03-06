<?php
/*************************************************
  Framework Component
  name      AlexShop_CMS
  created   by Alex production
  version   1.0
  author    Alex Jurii <alexjurii@gmail.com>
  Copyright (c) 2016
 ************************************************/

/**
 * Класс-обертка для конфигурационного файла с настройками магазина
 * В отличие от класса Settings, Config оперирует низкоуровневыми настройками, например найстройками базы данных.
 */

namespace api;

/**
 * Class Config
 *
 * @property $this smarty_html_minify
 *
 */
class Config
{

    public $version = '1.2.1';

    // Файл для хранения настроек
    public $config_file = 'config/config.php';

    private $vars = [];

    // В конструкторе записываем настройки файла в переменные этого класса
    // для удобного доступа к ним. Например: $registry->config->db_user
    public function __construct()
    {
        // Читаем настройки из дефолтного файла
        $ini = parse_ini_file(dirname(__DIR__) . '/' . $this->config_file);
        // Записываем настройку как переменную класса
        foreach ($ini as $var => $value){
            $this->vars[$var] = $value;
        }

        // Вычисляем DOCUMENT_ROOT вручную, так как иногда в нем находится что-то левое
        $localpath = getenv('SCRIPT_NAME');
        $absolutepath = getenv('SCRIPT_FILENAME');
        $_SERVER['DOCUMENT_ROOT'] = substr($absolutepath, 0, strpos($absolutepath, $localpath));

        // Адрес сайта - тоже одна из настроек, но вычисляем его автоматически, а не берем из файла
        $script_dir1 = realpath(dirname(__DIR__));
        $script_dir2 = realpath($_SERVER['DOCUMENT_ROOT']);
        $subdir = trim(substr($script_dir1, strlen($script_dir2)), "/\\");

        // Протокол
        $protocol = strtolower(substr($_SERVER['SERVER_PROTOCOL'], 0, 5)) == 'https' ? 'https' : 'http';
        if ($_SERVER['SERVER_PORT'] == 443){
            $protocol = 'https';
        } elseif (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
            $protocol = 'https';
        } elseif ((!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') ||
            (!empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on')) {
            $protocol = 'https';
        }


        $this->vars['protocol'] = $protocol;
        $this->vars['root_url'] = $protocol . '://' . rtrim($_SERVER['HTTP_HOST']);
        if (!empty($subdir)){
            $this->vars['root_url'] .= '/' . $subdir;
        }

        // Подпапка в которую установлен CMS относительно корня веб-сервера
        $this->vars['subfolder'] = $subdir . '/';

        // Определяем корневую директорию сайта
        $this->vars['root_dir'] = dirname(__DIR__) . '/';

        // Максимальный размер загружаемых файлов
        $max_upload = (int)(ini_get('upload_max_filesize'));
        $max_post = (int)(ini_get('post_max_size'));
        $memory_limit = (int)(ini_get('memory_limit'));
        $this->vars['max_upload_filesize'] = min($max_upload, $max_post, $memory_limit) * 1024 * 1024;

        // Соль (разная для каждой копии сайта, изменяющаяся при изменении config-файла)
        $s = stat(dirname(__DIR__) . '/' . $this->config_file);
        $this->vars['salt'] = md5(md5_file(dirname(__DIR__) . '/' . $this->config_file) . $s['dev'] . $s['ino'] . $s['uid'] . $s['mtime']);

        // Часовой пояс
        if (!empty($this->vars['php_timezone'])){
            date_default_timezone_set($this->vars['php_timezone']);
        }
    }

    public function __get($name)
    {
        if (isset($this->vars[$name])){
            return $this->vars[$name];
        } else {
            return null;
        }
    }

    public function __set($name, $value)
    {
        # Запишем конфиги
        if (isset($this->vars[$name])){
            $conf = file_get_contents(dirname(__DIR__) . '/' . $this->config_file);
            $conf = preg_replace('/' . $name . "\s*=.*\n/i", $name . ' = ' . $value . "\r\n", $conf);
            $cf = fopen(dirname(__DIR__) . '/' . $this->config_file, 'w');
            fwrite($cf, $conf);
            fclose($cf);
            $this->vars[$name] = $value;
        }
    }

    public function __isset($name)
    {
        return isset($this->vars[$name]);
    }

    public function token($text)
    {
        return md5($text . $this->salt);
    }

    public function check_token($text, $token)
    {
        if (!empty($token) && $token === $this->token($text)){
            return true;
        }

        return false;
    }
}