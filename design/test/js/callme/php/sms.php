<?php
// sms settings

$s['id']  = '';
$s['key'] = '';
$s['log'] = '';
$s['pss'] = '';

// custom sender, add and approve it in sms-service before changing
$s['frm'] = 'callme'; 

// phone number without '+'
$s['num'] = ''; 

// choose from: bytehand.com, sms.ru, rocketsms.by, infosmska.ru, sms-sending.ru, smsaero.ru
$s['prv'] = ''; 

function sendSMS($msg) {
	global $s;
	$u['sms.ru'] = 'sms.ru/sms/send?api_id='.uc($s['key']).'&to='.uc($s['num']).'&text='.uc($msg);
	$u['bytehand.com'] = 'bytehand.com:3800/send?id='.uc($s['id']).'&key='.uc($s['key']).'&to='.uc($s['num']).'&partner=callme&from='.uc($s['frm']).'&text='.uc($msg);
	$u['sms-sending.ru'] = 'lcab.sms-sending.ru/lcabApi/sendSms.php?login='.uc($s['log']).'&password='.uc($s['pss']).'&txt='.uc($msg).'&to='.uc($s['num']);
	$u['infosmska.ru'] = 'api.infosmska.ru/interfaces/SendMessages.ashx?login='.uc($s['log']).'&pwd='.uc($s['pss']).'&sender=SMS&phones='.uc($s['num']).'&message='.uc($msg);
	$u['rocketsms.by'] = 'api.rocketsms.by/simple/send?username='.uc($s['log']).'&password='.md5(uc($s['pss'])).'&phone='.uc($s['num']).'&text='.uc($msg);
	$u['smsaero.ru'] = 'gate.smsaero.ru/send/?user='.uc($s['log']).'&password='.md5 (uc($s['pss'])).'&to='.uc($s['num']).'&text='.uc($msg).'&from='.uc($s['frm']);
	@$r = file_get_contents('http://'.$u[$s['prv']]);
	return $r;
}

function uc ($s) {
	return urlencode($s);
}
?>