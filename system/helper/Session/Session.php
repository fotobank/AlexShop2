<?php
/*************************************************
  Framework Component
  name      AlexShop_CMS
  created   by Alex production
  version   1.0
  author    Alex Jurii <alexjurii@gmail.com>
  Copyright (c) 2013 - 2016
 ************************************************/

namespace helper\Session;

use helper\ArrayHelper\ArrayHelper;
use proxy;
use exception\SessionException;
use lib\Config\Config;


/**
 * Class Session
 */
class Session extends ArrayHelper
{
    public $version = 1.2;

    protected $session_name;
    protected $life_time; // время жизни сессии
    protected $check_ip; // включить если у админа постоянный Ip
    protected $auto_life_time_regenerate_id; // регенерировать ли сессию если время life_time вышло
    protected $auto_regenerate_id; // при каждом обновлении страницы менять session Id

    protected $old_id;
    protected $running = false;


    /**
     * конструктор
     *
     * @param Config $config
     *
     * @throws \exception\SessionException
     */
    public function __construct(Config $config)
    {
        $config = $config->getData('session');
        foreach($config as $key => $value){

            if(property_exists($this, $key)){
                $this->$key = $value;
            } else {
                throw new SessionException('Свойство класса "helper\Session" -> "$'.$key.'" не найдено!');
            }
        }
        ini_set('session.use_cookies', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.gc_maxlifetime', $this->life_time);
        ini_set('session.cookie_lifetime', 0); // 0 - пока браузер не закрыт
    }

    /**
     * Метод стартует сессию, проверяет время жизни сессии и идентификатор клиента
     */
    public function start()
    {
        $this->phpSessionInit();

        // продление времени работы сессии если пользователь ещё в online
        if ($this->auto_life_time_regenerate_id && $this->isExpired()){
            $this->regenerateId();
        }

        // проверка на неправильный снимок сесии
        $this->isWrongFingerprint();
        $this->running = true;
    }

    /**
     * @return bool
     */
    protected function isExpired()
    {
        $la = '__lastActivity';
        $now = time();
        $limit = $now - $this->life_time;

        if (isset($_SESSION[$la]) && $_SESSION[$la] < $limit){
            return true;
        }
        $_SESSION[$la] = $now;

        return false;
    }

    /**
     * @return bool
     * защита от кражи сессии подменой браузера или ip
     */
    protected function isWrongFingerprint()
    {
        $cf = '__clientFingerprint';

        $fingerprint = $_SERVER['HTTP_USER_AGENT'] .
            $_SERVER['HTTP_ACCEPT_LANGUAGE'] .
            $_SERVER['HTTP_ACCEPT_CHARSET'] .
            $_SERVER['HTTP_CONNECTION'];

        if ($this->check_ip){
            $fingerprint .= $_SERVER['REMOTE_ADDR'];
        }
        if (!isset($_SESSION[$cf])){

            $_SESSION[$cf] = md5($fingerprint);

        } elseif($_SESSION[$cf] != md5($fingerprint)){
            // уничтожаем сессию
            $this->destroy();
        }
    }


    /**
     * Метод инициализирует механизм сессий PHP
     */
    protected function phpSessionInit()
    {
        if ($this->sessionExists()) {
            $sn = session_name();
            if ($sn != $this->session_name || $this->auto_regenerate_id){
                $this->regenerateId();
            }

        } else {
            session_name($this->session_name);
            session_start();
            $this->old_id = session_id();
            $this->properties = &$_SESSION;
        }
        // сохраняем в сессию откуда пришел пользователь
        if (!isset($_SESSION['origURL'])) {
            $_SESSION['origURL'] = $_SERVER['HTTP_REFERER'];
        }

    }

    /**
     * Get session ID
     *
     * Proxies to {@link session_id()}
     *
     * @return string
     */
    public function getId()
    {
        return session_id();
    }

    public function destroy()
    {
        if (!$this->sessionExists()) {
            return;
        }
        session_destroy();
        // send expire cookies
        $this->expireSessionCookie();
        // clear session data
        unset($_SESSION);
    }

    /**
     * Returns true if session ID is set
     *
     * @return bool
     */
    public function cookieExists()
    {
        return proxy\Cookie::has(session_name());
    }

    /**
     * Get session name
     *
     * Proxies to {@link session_name()}.
     *
     * @return string
     */
    public function getName()
    {
        return session_name();
    }

    /**
     * Attempt to set the session name
     *
     * If the session has already been started, or if the name provided fails
     * validation, an exception will be raised.
     *
     * @param  string $name
     * @throws SessionException
     * @return Session
     */
    public function setName($name)
    {
        if ($this->sessionExists()) {
            throw new SessionException(
                'Cannot set session name after a session has already started'
            );
        }

        if (!ctype_alnum($name)) {
            throw new SessionException(
                'Name provided contains invalid characters; must be alphanumeric only'
            );
        }

        $this->session_name = $name;
        session_name($name);
        return $this;
    }

    /**
     * Does a session started and is it currently active?
     * @api
     * @return bool
     */
    public function sessionExists()
    {
        return  session_id() ? true : false;
    }

    /**
     * Set the session cookie lifetime
     *
     * If a session already exists, destroys it (without sending an expiration
     * cookie), regenerates the session ID, and restarts the session.
     *
     * @param  int $ttl in seconds
     * @return void
     */
    public function setSessionCookieLifetime($ttl)
    {
        // Set new cookie TTL
        session_set_cookie_params($ttl);
        if ($this->sessionExists()) {
            // There is a running session so we'll regenerate id to send a new cookie
            $this->regenerateId();
        }
    }

    /**
     * Expire the session cookie
     *
     * Sends a session cookie with no value, and with an expiry in the past.
     *
     * @return void
     */
    public function expireSessionCookie()
    {
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                $this->getName(),
                '',
                time() + $this->life_time,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }
    }

    /**
     * Regenerate id
     *
     * Regenerate the session ID, using session save handler's
     * native ID generation Can safely be called in the middle of a session.
     *
     * @param  bool $deleteOldSession
     * @return bool
     */
    public function regenerateId($deleteOldSession = false)
    {
        if ($this->sessionExists()) {
            $this->old_id = session_id();
            session_regenerate_id((bool) $deleteOldSession);
            $this->properties = &$_SESSION;
        }
    }
    /**
     * Set session ID
     *
     * Can safely be called in the middle of a session.
     *
     * @param  string $id
     * @throws SessionException
     * @return Session
     */
    public function setId($id)
    {
        if ($this->sessionExists()) {
            throw new SessionException(
                'Session has already been started, to change the session ID call regenerateId()'
            );
        }
        session_id($id);
        return $this;
    }

    /**
     * Проверка id сессии для защиты от xss
     */
    public function check_session() {
        if(isset($_POST, $_POST['session_id'])) {
            if(empty($_POST['session_id']) || $_POST['session_id'] != $this->old_id) {
                unset($_POST);
                return false;
            }
        }
        return true;
    }
}