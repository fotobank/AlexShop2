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

use proxy\Config as Options;

class Managers extends Registry
{

    // все существующие разрешения
    public $permissions_list = [];

    // все менеджеры
    private $all_managers = [];

    public function __construct()
    {
        $this->permissions_list = array_keys(Options::getData('managers_permissions'));
        parent::__construct();
    }

    private function init_managers()
    {
        $this->all_managers = [];
        $this->db->query('SELECT * FROM __managers ORDER BY id');
        foreach ($this->db->results() as $m){
            $this->all_managers[$m->id] = $m;
            if (!is_null($m->permissions)){
                $m->permissions = explode(',', $m->permissions);
                foreach ($m->permissions as &$permission){
                    $permission = trim($permission);
                }
            } else {
                $m->permissions = $this->permissions_list;
            }
        }
    }

    public function get_managers()
    {
        if (empty($this->all_managers)){
            $this->init_managers();
        }

        return $this->all_managers;
    }

    public function manager_cookie($cookie_remember)
    {
        $this->db->query("
                  SELECT  `id`, `login`, TIMESTAMPDIFF(SECOND, current_timestamp, `valid_period`) AS `diff`
                  FROM __managers WHERE `cookie` = ?", $cookie_remember);

        return $this->db->result();
    }

    public function delete_cookie($manager, $type)
    {
        $this->db->query("
               UPDATE __managers 
               SET `cookie` = SUBSTRING(MD5(RAND()) FROM 1 FOR 24),
                `valid_period`= DATE_ADD(current_timestamp, INTERVAL 1 SECOND) 
               WHERE $type = ?", (string)$manager);
    }

    public function count_managers()
    {
        return count($this->all_managers);
    }

    public function get_manager($id = null)
    {
        if (empty($this->all_managers)){
            $this->init_managers();
        }
        // Если не запрашивается по логину, отдаём текущего менеджера или false
        if (empty($id)){
            if (!empty($_SESSION['admin'])){
                $id = $_SESSION['admin'];
            }/* else {
                // Тестовый менеджер, если отключена авторизация
                $m = new \stdClass();
                $m->login = 'manager';
                $m->permissions = $this->permissions_list;
                return $m;
            }*/
        }
        if (is_int($id) && isset($this->all_managers[$id])){
            return $this->all_managers[$id];
        } elseif (is_string($id)) {
            foreach ($this->all_managers as $m){
                if ($m->login == $id){
                    return $m;
                }
            }
        }

        return false;
    }

    public function add_manager($manager)
    {
        $manager = (object)$manager;
        if (!empty($manager->password)){
            // захешировать пароль
            $manager->password = $this->crypt_apr1_md5($manager->password);
        }
        if (is_array($manager->permissions)){
            if (count(array_diff($this->permissions_list, $manager->permissions)) > 0){
                $manager->permissions = implode(",", $manager->permissions);
            } else {
                // все права
                $manager->permissions = null;
            }
        }
        $this->db->query('INSERT INTO __managers SET ?%', $manager);
        $id = $this->db->insert_id();
        $this->init_managers();

        return $id;
    }

    public function update_manager($id, $manager)
    {
        $manager = (object)$manager;
        if (!empty($manager->password)){
            // захешировать пароль
            $manager->password = $this->crypt_apr1_md5($manager->password);
        }
        // права
        if (isset($manager->permissions) && is_array($manager->permissions)){
            if (count(array_diff($this->permissions_list, $manager->permissions)) > 0){
                $manager->permissions = implode(",", array_intersect($this->permissions_list, $manager->permissions));
            } else {
                // все права
                $manager->permissions = null;
            }
        }

        if (isset($manager->valid_period)){
            $valid_period = $manager->valid_period;
            unset($manager->valid_period);
            $this->db->query("
               UPDATE __managers 
               SET ?%, `valid_period`= DATE_ADD(current_timestamp, INTERVAL $valid_period) 
               WHERE id=?", $manager, (int)$id);

        } else {

            $this->db->query('UPDATE __managers SET ?% WHERE id=?', $manager, (int)$id);
        }

        $this->init_managers();

        return $id;
    }

    public function delete_manager($id)
    {
        if (!empty($id)){
            $this->db->query('DELETE FROM __managers WHERE id=?', (int)$id);
            $this->init_managers();

            return true;
        }

        return false;
    }

    public function hash_cookie($manager)
    {

        $salt = bin2hex(random_bytes(11));

        return hash('sha512', $salt . $manager);
    }

    private function crypt_apr1_md5($plainpasswd, $salt = '')
    {
        if (empty($salt)){
            $salt = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 8);
        }
        $len = strlen($plainpasswd);
        $text = $plainpasswd . '$apr1$' . $salt;
        $bin = pack("H32", md5($plainpasswd . $salt . $plainpasswd));
        for ($i = $len; $i > 0; $i -= 16){
            $text .= substr($bin, 0, min(16, $i));
        }
        for ($i = $len; $i > 0; $i >>= 1){
            $text .= ($i & 1) ? chr(0) : $plainpasswd{0};
        }
        $bin = pack("H32", md5($text));
        for ($i = 0; $i < 1000; $i++){
            $new = ($i & 1) ? $plainpasswd : $bin;
            if ($i % 3) $new .= $salt;
            if ($i % 7) $new .= $plainpasswd;
            $new .= ($i & 1) ? $bin : $plainpasswd;
            $bin = pack("H32", md5($new));
        }
        $tmp = '';
        for ($i = 0; $i < 5; $i++){
            $k = $i + 6;
            $j = $i + 12;
            if ($j == 16) $j = 5;
            $tmp = $bin[$i] . $bin[$k] . $bin[$j] . $tmp;
        }
        $tmp = chr(0) . chr(0) . $bin[11] . $tmp;
        $tmp = strtr(strrev(substr(base64_encode($tmp), 2)),
            "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/",
            "./0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz");

        return "$" . "apr1" . "$" . $salt . "$" . $tmp;
    }

    /**
     * проверяет доступ к модулю
     * @param $module
     *
     * @return bool
     */
    public function access($module)
    {
        $manager = $this->get_manager();
        if (is_array($manager->permissions)){
            return in_array($module, $manager->permissions, true);
        } else {
            return false;
        }
    }

    public function check_password($password, $crypt_pass)
    {
        $salt = explode('$', $crypt_pass);
        $salt = $salt[2];

        return ($crypt_pass == $this->crypt_apr1_md5($password, $salt));
    }
}
