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

lass DooFlashMessenger {

	/**
	* Namespace for session, default is dooFlashMessenger
	* @var string namespace
	*/
	protected $_namespace = 'dooFlashMessenger';

	/**
	* Array of messages
	* @var array messages
	*/
	static protected $_messages = array();

	/**
	* Constructor
	* @return void
	*/
	public function __construct() {

		if (!isset($_SESSION)) {
			session_start();
		}

		if (!isset($_SESSION[$this->_namespace])) {
			$_SESSION[$this->_namespace] = array();
		}

		if (count($_SESSION[$this->_namespace]) > 0) {
			foreach ($_SESSION[$this->_namespace] as $k => $message) {
				self::$_messages[] .= $message;
				unset($_SESSION[$this->_namespace][$k]);
			}
		}
	}

	/**
	* Set namespace, default is doo
	* @param string $namespace Namespace
	*/
	public function setNamespace($namespace = 'doo') {
        $this->_namespace = $namespace;
        return $this;
    }

	/**
	* Returns true if there are messages and false if not
	* @return bool
	*/
	public function hasMessages() {
		if (count(self::$_messages) > 0) {
			return true;
		}
		return false;
	}

	/**
	* Add message to message array
	* @param string $message Message
	*/
    public function addMessage($message) {
		if ($message != "") {
			$_SESSION[$this->_namespace][] = $message;
		}
        return $this;
    }

	/**
	* Get messages that are stored
	* @return array Messages in array
	*/

    public function getMessages() {
        if ($this->hasMessages()) {
            return self::$_messages;
        }
        return array();
    }

	/**
	* Clear all messages in array
	* @return bool
	*/
    public function clearMessages() {
        if ($this->hasMessages()) {
            self::$_messages = null;
            return true;
        }
        return false;
    }

	/**
	* Returns how many messages are stored in message array
	* @return int
	*/
	public function countMessages() {
		return count(self::$_messages);
	}

	/**
	* Display messages echoing all messages, use this from view script
	*/
	public function displayMessages() {
		if ($this->hasMessages()) {
			$output = '<div class="'.$this->_namespace.'_flashm">';
			if ($this->countMessages() == 1) {
				$output .= '<span class="'.$this->_namespace . '_inner">'
				. self::$_messages[0] . '</span>';
			} else {
			$output .= '<ul>';
				foreach (self::$_messages as $message) {
					$output .= '<li>' . $message . '</li>';
				}
				$output .= '</ul>';
			}
			$output .= '</div>';
			echo $output;
			// clear messages
			$this->clearMessages();
		}
	}

	public function addWrapper() {

	}
}
