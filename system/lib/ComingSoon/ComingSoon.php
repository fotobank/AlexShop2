<?php

/*************************************************
  Framework Component
  name      AlexShop_CMS
  created   by Alex production
  version   1.0
  author    Alex Jurii <alexjurii@gmail.com>
  Copyright (c) 2013 - 2016
 ************************************************/

namespace api\ComingSoon;

use api\Registry;
use exception\CommonException;
use proxy\Config;


class ComingSoonException extends CommonException
{
}


class ComingSoon extends Registry
{
    // конфиг класса
    protected $conf;
    // перевод мнтерфейса
    protected $lang;

    public function __construct()
    {
        parent::__construct();
        $this->conf = Config::getData('soon_subscribe_config');
        $this->checkTable();
        $this->init();
    }

    public function init() {
        
        // Including language
        $language_path = 'languages/' . $this->conf['current_language'] . '.php';
        require($language_path);

        $language = $this->languages->languages(array('id'=>$this->languages->lang_id()))->label;
        $db_table = '__'.$this->conf['db_table_settings'];

        // Get the configuration and language from the database
        $sql = $this->db->placehold("SELECT setting, language, value 
                FROM  $db_table
                WHERE language = ?
                OR language = '00'", $language);

        $this->db->query($sql);
        $results = $this->db->results();
        if ($this->db->num_rows() > 0){
            foreach ($results as $key) {
                if ($key->language == '00'){
                    $this->conf[$key->setting] = stripslashes($key->value);
                } else {
                    $lang[$key->setting] = stripslashes($key->value);
                }
            }
        }
    }

    /**
     * создание при необходимости таблиц
     * @throws ComingSoonException
     */
    public function checkTable()
    {
        try {
            if (!$this->db->tableExists($this->conf['db_table_subscribers'])){
                // install subscribers table
             $sql = $this->db->placehold('CREATE TABLE IF NOT EXISTS ' . $this->db->prefixTable($this->conf['db_table_settings']) . " (
            `id` INT(10) NOT NULL AUTO_INCREMENT,
            `email` VARCHAR(150) NOT NULL COLLATE 'utf8_bin',
            `subscribed` TINYINT(1) NOT NULL,
            `language` VARCHAR(2) NOT NULL COLLATE 'utf8_bin',
            PRIMARY KEY (`id`),
            INDEX `email` (`email`)
            )
            COLLATE=utf8_bin
            DEFAULT CHARSET=utf8
            ENGINE=MyISAM
            AUTO_INCREMENT=1
            ;");
                $this->db->query($sql);
            }

            if (!$this->db->tableExists($this->conf['db_table_settings'])){
                // install settings table
                $sql = $this->db->placehold('CREATE TABLE IF NOT EXISTS ' . $this->db->prefixTable($this->conf['db_table_settings']) . ' (
			id INT(5) NOT NULL AUTO_INCREMENT,
			setting VARCHAR(150) COLLATE utf8_bin NOT NULL,
			`language` VARCHAR(2) COLLATE utf8_bin NOT NULL,
			`value` LONGTEXT COLLATE utf8_bin NOT NULL,
			PRIMARY KEY (id)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;');
                $this->db->query($sql);
            }
        } catch (ComingSoonException $e) {
            throw new ComingSoonException($e);
        }
    }

    /**
     * URL of the directory of the coming soon landing page
     *
     * @param      $s
     * @param bool $use_forwarded_host
     *
     * @return string
     */
    public function url_origin($s, $use_forwarded_host = false)
    {
        $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true : false;
        $sp = strtolower($s['SERVER_PROTOCOL']);
        $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
        $port = $s['SERVER_PORT'];
        $port = ((!$ssl && $port == '80') || ($ssl && $port == '443')) ? '' : ':' . $port;
        $host = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : $s['SERVER_NAME']);

        return $protocol . '://' . $host . $port;
    }
    

    public function verifyFormToken($form)
    {
        // check if a session is started and a token is transmitted, if not return an error
        $check_sess = $form . '_token';
        if (!isset($_SESSION[$check_sess])){
            return false;
        }
        // check if the form is sent with token in it
        if (!isset($_POST['token'])){
            return false;
        }
        // compare the tokens against each other if they are still the same
        if ($_SESSION[$form . '_token'] !== $_POST['token']){
            return false;
        }

        return true;
    }

    /**
     * @param $lang_txt_id
     * @param array $languages
     *
     * @return string
     * @internal param $language
     */
    protected function editTxt($lang_txt_id, $languages)
    {
        $data = '';
        if ($this->conf['multilingual']){
            foreach ($languages as $key => $value){
                $data .= "
                <label for = \"{$lang_txt_id}_{$key}\"><img
                        src = \"images/languages/{$key}.png\" width = \"16\" height = \"11\"/></label>
                <textarea rows = \"0\" cols = \"80\" id = \"{$lang_txt_id}_{$key}\"
                          name = \"{$lang_txt_id}_{$key}\">$this->languageTxt($key, $lang_txt_id)</textarea>
                <br/>
                ";


            }
        } else {
            $language = $this->conf['current_language'];
            $data .= "
            <label for = \"{$lang_txt_id}_{$language}\"><img
                    src = \"images/languages/{$this->conf['current_language']}.png\" width = \"16\"
                    height = \"11\"/></label>
            <textarea rows = \"0\" cols = \"80\" id = \"{$lang_txt_id}_{$language}\"
                      name = \"{$lang_txt_id}_{$language}\">$this->languageTxt($this->conf['current_language'], $lang_txt_id)</textarea>
            <br/>
            ";
        }
        return $data;
    }


    /**
     * @param $lang_id
     * @param $lang_txt_id
     *
     * @return bool|int|object|\stdClass|string
     * @throws \Exception
     */
    protected function languageTxt($lang_id, $lang_txt_id)
    {
        $sql = $this->db->placehold("
               SELECT value 
               FROM `".$this->db->prefixTable($this->conf['db_table_settings'])."` 
               WHERE language = '$lang_id' 
               AND setting = '" . $lang_txt_id . "'"
        );
        $this->db->query($sql);
        $result = $this->db->result();
        if ($this->db->num_rows() > 0){

            $result =  htmlspecialchars_decode(stripslashes($result));

            return $result;

        } else {
            
            require('languages/' . $lang_id . '.php');
            $txt = $this->lang[$lang_txt_id];
            require('languages/' . $this->conf['current_language'] . '.php');
            $sql = $this->db->placehold("
                   SELECT setting, value 
                   FROM `" . $this->db->prefixTable($this->conf['db_table_settings']) ."` 
                   WHERE language='" . $this->conf['current_language'] . "'"
            );
            $this->db->query($sql);
            if ($this->db->num_rows() > 0){
                $results = $this->db->results();
                foreach ($results as $row) {
              //      $lang[$row->0] = $row->1;
                }
            }
            $result = htmlspecialchars_decode($txt);

            return $result;
        }
    }


    /**
     * @param $lang_id
     *
     * @return bool|int|object|\stdClass|string
     */
    protected function aboutTxt($lang_id)
    {
        $sql = $this->db->placehold("
               SELECT value 
               FROM `" . $this->db->prefixTable($this->conf['db_table_settings']) ."` 
               WHERE language = '" . $lang_id . "' 
               AND setting = 'about_txt'"
        );
        $this->db->query($sql);
        $result = $this->db->result();
        if ($this->db->num_rows() > 0){
            $result = htmlspecialchars_decode(stripslashes($result));
            return $result;
        } else {
            $about_tmp = htmlspecialchars_decode(include('languages/' . $lang_id . '-about.html'));
            $result =  substr($about_tmp, 0, strlen($about_tmp) - 2);

            return $result;
        }
    }


}