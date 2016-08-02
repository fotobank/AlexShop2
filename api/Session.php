<?php

/**
 * Framework Component
 * @name      ALEX_CMS
 * @created   by PhpStorm
 * @package   Session.php
 * @version   1.0
 * @author    Alex Jurii <jurii@mail.ru>
 * @link      http://alex.od.ua
 * @copyright Авторские права (C) 2000-2016, Alex Jurii
 * @date      :     02.08.2016
 * @time      :     12:16
 * @license   MIT License: http://opensource.org/licenses/MIT
 */

/**
 * Class Session
 */
class Session
{
    protected $sessionName = '_encrypted';
    protected $lifetime = 3600;
    protected $checkIP = true;
    protected $autoRegenerateID = true;

    protected $running = false;

    /**
     * Session constructor.
     */
    public function __construct()
    {
        ini_set('session.use_cookies', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.gc_maxlifetime', $this->lifetime);
    }

    /**
     * @param $key
     *
     * @return null
     */
    public function get($key)
    {
        if(!$this->running){
            $this->start();
        }
        if (isset($_SESSION[$key])){
            return $_SESSION[$key];
        } else {
            return null;
        }
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        if (!$this->running){
            $this->start();
        }
        $_SESSION[$key] = $value;
    }

    /**
     * @param $key
     */
    public function unset($key)
    {
        if (!$this->running){
            $this->start();
        }
        unset($_SESSION[$key]);
    }

    /**
     * @param $key
     *
     * @return null
     */
    public function cut($key)
    {
        $val = $this->getVal($key);
        $this->unsetVal($key);

        return $val;
    }

    /**
     *
     */
    public function clear()
    {
        if (!$this->running){
            $this->start();
        }
        $_SESSION = [];
    }

    /**
     * Метод стартует сессию, проверяет время жизни сессии и идентификатор клиента
     */
    protected function start()
    {
        $this->phpSessionInit();
        if ($this->autoRegenerateID){
            $this->regenerateID();
        }
        if ($this->isExpired() || $this->isWrongFingerprint()){
            if (!$this->autoRegenerateID){
                $this->regenerateID();
            }
            $_SESSION = [];
        }
        $this->running = true;
    }

    /**
     * Метод инициализирует механизм сессий PHP
     */
    protected function phpSessionInit()
    {
        if (!isset($_SESSION)){
            session_name($this->sessionName);
            session_start();
        } else {
            $sn = session_name();

            /** Todo сделать обработку ошибок */
            if ($sn != $this->sessionName){
                die('Error: hostile session "' . $sn . '" already started.');
            }
        }
    }

    /**
     *
     */
    public function regenerateID()
    {
        session_regenerate_id(true);
    }

    /**
     * @return bool
     */
    protected function isExpired()
    {
        $la = '__lastActivity';
        $now = time();
        $limit = $now - $this->lifetime;

        if (isset($_SESSION[$la]) && $_SESSION[$la] < $limit){
            return true;
        }
        $_SESSION[$la] = $now;

        return false;
    }

    /**
     * @return bool
     */
    protected function isWrongFingerprint()
    {
        $cf = '__clientFingerprint';

        $fingerprint = $_SERVER['HTTP_USER_AGENT'] .
            $_SERVER['HTTP_ACCEPT_LANGUAGE'] .
            $_SERVER['HTTP_ACCEPT_CHARSET'] .
            $_SERVER['HTTP_ACCEPT_ENCODING'] .
            $_SERVER['HTTP_CONNECTION'];

        if ($this->checkIP){
            $fingerprint .= $_SERVER['REMOTE_ADDR'];
        }
        if (!isset($_SESSION[$cf])){
            $_SESSION[$cf] = md5($fingerprint);
            return false;
        }
        if ($_SESSION[$cf] != md5($fingerprint)){
            return true;
        }
        return false;
    }
}