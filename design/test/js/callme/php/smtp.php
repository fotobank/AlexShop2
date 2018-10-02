<?php
$config['smtp_username'] = ''; // smtp username
$config['smtp_port'] = '465'; // smtp port
$config['smtp_host'] = 'smtp.gmail.com'; // smtp server
$config['smtp_password'] = ''; // password
$config['smtp_charset'] = 'utf-8'; // encoding, usually utf-8
$config['smtp_from'] = 'Callme'; // sender name
	
function smtpmail($to='', $mail_to, $subject, $message, $headers='') {
	global $config;
	$SEND =	"Date: ".date("D, d M Y H:i:s") . " UT\r\n";
	$SEND .= 'Subject: =?'.$config['smtp_charset'].'?B?'.base64_encode($subject)."=?=\r\n";
	if ($headers) $SEND .= $headers."\r\n\r\n";
	else
	{
		$SEND .= "Reply-To: ".$config['smtp_username']."\r\n";
		$SEND .= "To: \"=?".$config['smtp_charset']."?B?".base64_encode($to)."=?=\" <$mail_to>\r\n";
		$SEND .= "MIME-Version: 1.0\r\n";
		$SEND .= "Content-Type: text/html; charset=\"".$config['smtp_charset']."\"\r\n";
		$SEND .= "Content-Transfer-Encoding: 8bit\r\n";
		$SEND .= "From: \"=?".$config['smtp_charset']."?B?".base64_encode($config['smtp_from'])."=?=\" <".$config['smtp_username'].">\r\n";
		$SEND .= "X-Priority: 3\r\n\r\n";
	}
	$SEND .=  $message."\r\n";

	if (!$socket = fsockopen($config['smtp_host'], $config['smtp_port'], $errno, $errstr, 30) ) {
		return array(false, $errno.": ".$errstr);
	}
 
	if (!server_parse($socket, "220", __LINE__)) return array(false, '');
 
	fputs($socket, "HELO " . $config['smtp_host'] . "\r\n");
	if (!server_parse($socket, "250", __LINE__)) {
		return array(false, 'Cannot sent HELLO!');
		fclose($socket);
	}
	fputs($socket, "AUTH LOGIN\r\n");
	if (!server_parse($socket, "334", __LINE__)) {
		return array(false, 'No answer for authorization');
		fclose($socket);
	}
	fputs($socket, base64_encode($config['smtp_username']) . "\r\n");
	if (!server_parse($socket, "334", __LINE__)) {
		return array(false, 'Login error');
		fclose($socket);
	}
	fputs($socket, base64_encode($config['smtp_password']) . "\r\n");
	if (!server_parse($socket, "235", __LINE__)) {
		return array(false, 'Password error');
		fclose($socket);
	}
	fputs($socket, "MAIL FROM: <".$config['smtp_username'].">\r\n");
	if (!server_parse($socket, "250", __LINE__)) {
		return array(false, 'Can\'t send MAIL FROM');
		fclose($socket);
	}
	fputs($socket, "RCPT TO: <" . $mail_to . ">\r\n");
 
	if (!server_parse($socket, "250", __LINE__)) {
		return array(false, 'Can\'t send RCPT TO');
		fclose($socket);
	}
	fputs($socket, "DATA\r\n");
 
	if (!server_parse($socket, "354", __LINE__)) {
		return array(false, 'Can\'t send DATA');
		fclose($socket);
	}
	fputs($socket, $SEND."\r\n.\r\n");
 
	if (!server_parse($socket, "250", __LINE__)) {
		return array(false, 'Can\'t send message body');
		fclose($socket);
	}

	fputs($socket, "QUIT\r\n");
	fclose($socket);
	return array(true, '');
}

function server_parse($socket, $response, $line = __LINE__) {
	global $config;
	while (@substr($server_response, 3, 1) != ' ') {
		if (!($server_response = fgets($socket, 256))) {
			return array(false, 'Error sending: '.$response.', '.$line);
		}
	}
	if (!(substr($server_response, 0, 3) == $response)) {
		return array(false, 'Error sending: '.$response.', '.$line);
	}
	return true;
}
?>