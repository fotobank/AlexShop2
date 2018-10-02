<?php // jQuery.Bukvus: Nazar Tokar, 2013 //

$to = "your@mail.ru"; // укажите здесь свою почту
function gF($s){
	$s = substr((htmlspecialchars($_GET[$s])), 0, 350);
	if (strlen($s) > 1) {
		return $s;
	}
}

$t = array( (gf("txt")), (gf("err")), (gf("url")));

$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
$headers .= "From: Bukvus 1.1.0 <noreply@".($_SERVER["HTTP_HOST"]).">\r\n"; 

$title = "Найдена ошибка";
$mess = $t[0];
if ($t[1]) {
	$mess .= "<hr>Комментарий: ".$t[1];
}
$mess .= "<hr>".$t[2];

mail($to, $title, $mess, $headers);

if ($t[0]) {	
	$t[1] = "ok";
	$t[2] = "Спасибо, данные об ошибке отправлены";
}
?>{
"result":  "<? echo $t[1]; ?>",
"message": "<? echo $t[2]; ?>"
}