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

    /**
     * @var string value returned by session_name()
     */
    protected $name;

    /**
     * конструктор
     */
    public function __construct()
    {
        $this->start();
        if(null !==$_SESSION)
        {
            $this->properties = &$_SESSION;
        }

    }

    /**
     * Does a session started and is it currently active?
     * @api
     * @return bool
     */
    public function sessionExists()
    {
        $sid = defined('SID') ? constant('SID') : false;
        if ($sid !== false && $this->getId()) {
            return true;
        }
        if (headers_sent()) {
            return true;
        }
        return false;
    }

    /**
     * Start session
     *
     * if No session currently exists, attempt to start it. Calls
     * {@link isValid()} once session_start() is called, and raises an
     * exception if validation fails.
     *
     * @api
     * @return void
     * @throws SessionException
     */
    public function start()
    {
        if ($this->sessionExists()) {
            return;
        }
        session_start();
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
        if (!$this->cookieExists() || !$this->sessionExists()) {
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
                $_SERVER['REQUEST_TIME'] - 42000,
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
        if (null === $this->name) {
            $this->name = session_name();
        }
        return $this->name;
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

        if (!preg_match('/^[a-zA-Z0-9]+$/', $name)) {
            throw new SessionException(
                'Name provided contains invalid characters; must be alphanumeric only'
            );
        }

        $this->name = $name;
        session_name($name);
        return $this;
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
            return session_regenerate_id((bool) $deleteOldSession);
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
}