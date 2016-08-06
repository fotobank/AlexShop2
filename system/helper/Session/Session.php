<?php
/**
 * Framework Component
 * @name      ALEX_CMS
 * @author    Alex Jurii <jurii@mail.ru>
 *
 * The MIT License (MIT)
 *
 * Copyright (c) 2016
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace helper\Session;

use helper\ArrayHelper\ArrayHelper;
use proxy;
use exception\SessionException;


/**
 * Class Session
 */
class Session extends ArrayHelper
{

    protected $sessionName = '_encrypted';
    protected $lifetime = 3600; // 3600 = 1 час
    protected $checkIP = false; // включить если у админа постоянный Ip
    protected $autoRegenerateID = false; // всегда для этого сайта

    protected $running = false;


    /**
     * конструктор
     */
    public function __construct()
    {
        ini_set('session.use_cookies', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.gc_maxlifetime', $this->lifetime);
        ini_set('session.cookie_lifetime', 0); // 0 - пока браузер не закрыт

        $this->start();

        if(null !==$_SESSION)
        {
            $this->properties = &$_SESSION;
        }

    }

    /**
     * Метод стартует сессию, проверяет время жизни сессии и идентификатор клиента
     */
    public function start()
    {
        $this->phpSessionInit();
        // проверка времени работы сессии и на неправильный снимок
        if ($this->isExpired() || $this->isWrongFingerprint()){
          //  if (!$this->autoRegenerateID){
                 $this->regenerateId();
          //  }
        }
        $this->running = true;
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
            $_SERVER['HTTP_CONNECTION'];

        if ($this->checkIP){
            $fingerprint .= $_SERVER['REMOTE_ADDR'];
        }
        if (!isset($_SESSION[$cf])){
            $_SESSION[$cf] = md5($fingerprint);
            return false;
        }

        return ($_SESSION[$cf] != md5($fingerprint));
    }


    /**
     * Метод инициализирует механизм сессий PHP
     */
    protected function phpSessionInit()
    {
        if ($this->sessionExists()) {
            $sn = session_name();
            if ($sn != $this->sessionName || $this->autoRegenerateID){
                $this->regenerateId();
            }

        } else {
            session_name($this->sessionName);
            session_start();
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
                time() + $this->lifetime,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }
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

        $this->sessionName = $name;
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
     * Regenerate id
     *
     * Regenerate the session ID, using session save handler's
     * native ID generation Can safely be called in the middle of a session.
     *
     * @param  bool $deleteOldSession
     * @return bool
     */
    public function regenerateId($deleteOldSession = true)
    {
        if ($this->sessionExists()) {
            $ret =  session_regenerate_id((bool) $deleteOldSession);
            $this->expireSessionCookie();
            return $ret;
        } else {
            return false;
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
            if(empty($_POST['session_id']) || $_POST['session_id'] != session_id()) {
                unset($_POST);
                return false;
            }
        }
        return true;
    }
}