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
class Mailer {

	/**
	 * Mail charset set
	 * @var string
	 */
	protected $_charset = null;

	/**
	 * Mail headers
	 */
	protected $_headers = null;

	/**
	 * From address
	 * @var string
	 */
	protected $_from = null;

	/**
	 * To address
	 * @var string
	 */
	protected $_to = [];

	/**
	 * Email subject
	 * @var string
	 */
	protected $_subject = null;

	/**
	 * Email date
	 * @var string
	 */
	protected $_date = null;

	/**
	 * Email body text
	 * @var string
	 */
	protected $_bodyText = false;

	/**
	 * Email body HTML
	 */
	protected $_bodyHtml = false;

	/**
	 * Email content type
	 */
	protected $_type = null;

	/**
	 * Attachments for email
	 *
	 * @var array
	 */
	protected $_attachments = [];

	/**
	 * End of line combo to use in headers
	 * Some OS / Mail Servers require an alternative line ending
	 * @var string
	 */
	protected $_headerEOL = "\r\n";

	/**
	 * Flag if email has attachments
	 * @var bool
	 */
	public $hasAttachments = false;

	/**
	 * Class constructor
	 *
	 * @param string $charset Charset for mail, default (utf-8)
	 * @param string $headerEOL The string to use for end of line in the mail headers (Note: Use double quotes when defining this)
	 */
	public function __construct($charset = 'utf-8', $headerEOL = null) {
		if ($headerEOL == null) {
			$os = strtoupper(substr(PHP_OS, 0, 3));
			if ($os == 'WIN') {
				$this->_headerEOL = "\r\n";
			} elseif ($os == 'MAC') {
				$this->_headerEOL = "\r";
			} else {
				$this->_headerEOL = "\n";
			}
		} else {
			$this->_headerEOL = $headerEOL;
		}
	}

	/**
	 * Set body text
	 *
	 * @param string $bodyText Text for message body
	 */
	public function setBodyText($bodyText) {
		$this->_bodyText = $bodyText;
	}

	/**
	 * Set body HTML
	 *
	 * @param string $bodyHtml HTML for message body
	 */
	public function setBodyHtml($bodyHtml) {
		$this->_bodyHtml = $bodyHtml;
	}

	/**
	 * Set email subject
	 * @param string $subject Email subject
	 * @param bool $encode Force encoding of subject
	 */
	public function setSubject($subject, $encode=false) {
		if ($encode == true) {
			$this->_subject = '=?' . $this->_charset . '?B?' . base64_encode($subject) . '?=';
		} else {
			$this->_subject = $subject;
		}
	}

	/**
	 * Set from field
	 *
	 * @param string $email Email address for from field
	 * @param string $name Name of sender
	 */
	public function setFrom($email, $name=null) {
		$this->_from = ['email' => $email, 'name' => $name];
	}

	/**
	 * Add email address for to field
	 *
	 * @param string $email Email for reciever
	 * @param string $name Name of person you are sending email
	 */
	public function addTo($email, $name=null) {
		if ($email != '') {
			array_push($this->_to, [$email, $name]);
		}
	}

	/**
	 * Add attachment to email
	 *
	 * @var string $file
	 */
	public function addAttachment($file, $filename=null) {
		if (file_exists($file) && (is_file($file))) {
			// read file
			$tmpFile = fopen($file, 'rb');
			$data = fread($tmpFile, filesize($file));
			fclose($tmpFile);
			// add to array

			if (empty($filename)) {
				$filename = basename($file);
			}

			array_push(
				$this->_attachments,
				array(
					'file_name' => $filename,
					'file_type' => filetype($file),
					'file_data' => $data
				)
			);
			
			$this->hasAttachments = true;
		}
	}

	/**
	 * Get to functon returns all recievers of email
	 *
	 * @param bool $header If header is true (first value true) it will return
	 * to params for header.
	 */
	private function getTo($headers=false) {
		$tmp = "";
		foreach ($this->_to as $to) {
			if (isset($to[0])) {
				$name = (isset($to[1])) ? $to[1] : '';
				if (!$headers)
					$tmp .= $to[0] . ', ';
				else
					$tmp .= $name . '<' . $to[0] . '>, ';
			}
		}
		return substr($tmp, 0, -2);
	}

	/*
	 * Create headers and send email
	 *
	 * @return bool Returns true if mail is sent.
	 */
	public function send() {

		$random_hash = 'x' . md5(time()) . 'x';
		$boundryMixed = 'DooPHP-mixed-' . $random_hash;		// Boundry for mixed content type (ie. Text and File Attachments)
		$boundryAlt   = 'DooPHP-alt-' . $random_hash;		// Boundry for Alternative mail types (ie. plain and html)

		// add from
		$from = $this->_from;
		$fromName = (isset($from['name'])) ? $from['name'] : '';
		$fromEmail = (isset($from['email'])) ? $from['email'] : '';
		$header = 'From: ' . $fromName . " <{$fromEmail}>" . $this->_headerEOL;

		// Define the default mime boundry for a mixed format mail
		$header .= 'MIME-Version: 1.0' . $this->_headerEOL;
		$header .= "Content-Type: multipart/mixed; boundary=\"{$boundryMixed}\"" . $this->_headerEOL . $this->_headerEOL;

		// We specify a default message informing old mail client users this is a multi part message
		$body = 'This is a multi-part message in MIME format.' . $this->_headerEOL . $this->_headerEOL;

		// Define the secondary mime boundry for the alternative content types (Plain and HTML)
		$body .= "--{$boundryMixed}" . $this->_headerEOL;
		$body .= "Content-Type: multipart/alternative; boundary=\"{$boundryAlt}\"" . $this->_headerEOL . $this->_headerEOL;

		if ($this->_bodyText !== false) {
			$body.= "--{$boundryAlt}" . $this->_headerEOL;
			$body.= "Content-Type: text/plain; charset=\"{$this->_charset}\"" . $this->_headerEOL;
			$body.= 'Content-Transfer-Encoding: 7bit' . $this->_headerEOL . $this->_headerEOL;
			$body.= $this->_bodyText;
			$body.= $this->_headerEOL . $this->_headerEOL;
		}
		
		if ($this->_bodyHtml !== false) {
			$body.= "--{$boundryAlt}" . $this->_headerEOL;
			$body.= "Content-Type: text/html; charset=\"{$this->_charset}\"" . $this->_headerEOL;
			$body.= 'Content-Transfer-Encoding: 7bit' . $this->_headerEOL . $this->_headerEOL;
			$body.= $this->_bodyHtml;
			$body.= $this->_headerEOL . $this->_headerEOL;
		}

		// Close the alternative mime boundry before we try to more mixed content types ie. attachments
		$body .= "--{$boundryAlt}--" . $this->_headerEOL . $this->_headerEOL;

		// add attachments if there are any
		if ($this->hasAttachments === true) {
			foreach ($this->_attachments as $a) {
				$body .= "--{$boundryMixed}" . $this->_headerEOL;
				$body .= 'Content-Type: ' . $a['file_type'] . '; name="' . $a['file_name'] . '"' . $this->_headerEOL;
				$body .= 'Content-Disposition: attachment; filename="' . $a['file_name'] . '"' . $this->_headerEOL;
				$body .= 'Content-Transfer-Encoding: base64' . $this->_headerEOL . $this->_headerEOL;
				$body .= chunk_split(base64_encode($a['file_data'])) . $this->_headerEOL . $this->_headerEOL;
			}
		}

		// Close the mixed mime boundry
		$body .= "--{$boundryMixed}--" . $this->_headerEOL . $this->_headerEOL;

		// mail it
		if (mail($this->getTo(true), $this->_subject, $body, $header)) {
			return true;
		}
		return false;
	}

}
