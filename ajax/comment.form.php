<?php

use api\Registry;
use proxy\Session;

include __DIR__ . '/../system/configs/define/config.php';
/** @noinspection PhpIncludeInspection */
include SYS_DIR . 'core' . DS . 'boot.php';

header('Content-type: application/json; charset=UTF-8');
header('Cache-Control: must-revalidate');
//header("Pragma: no-cache");
header('Expires: -1');


$registry = new Registry();

$comment = new stdClass;
$comment->parent = $registry->request->get('parent');
$comment->type = $registry->request->get('type');
$comment->object_id = $registry->request->get('object_id');
$comment->ip        = $_SERVER['REMOTE_ADDR'];

$comment_id = 0;
// Автозаполнение имени для формы комментария
if(!empty($registry->user))
	{$registry->design->assign('comment_name', $registry->user->name);}

$registry->design->assign('lang', $registry->translations);

// Принимаем комментарий
if ($registry->request->method('post') && $registry->request->post('comment'))
{
	$comment->name = $registry->request->post('name');
	$comment->email = $registry->request->post('email');
	$comment->text = $registry->request->post('text');
	$captcha_code =  $registry->request->post('captcha_code', 'string');
	
	// Передадим комментарий обратно в шаблон - при ошибке нужно будет заполнить форму
	$registry->design->assign('comment', $comment);
	
	// Проверяем капчу и заполнение формы
	if (empty($captcha_code) || Session::get('captcha_code') != $captcha_code)
	{
		$registry->design->assign('error', 'captcha');
	}
	elseif (empty($comment->name))
	{
		$registry->design->assign('error', 'empty_name');
	}
	elseif (empty($comment->email))
	{
		$registry->design->assign('error', 'empty_email');
	}
	elseif (empty($comment->text))
	{
		$registry->design->assign('error', 'empty_comment');
	}
	else
	{
		// Создаем комментарий
		// Если были одобренные комментарии от текущего ip, одобряем сразу
		$registry->db->query("SELECT 1 FROM __comments WHERE approved=1 AND ip=? LIMIT 1", $comment->ip);
		if($registry->db->num_rows()>0)
			{$comment->approved = 1;}
		
		// Добавляем комментарий в базу
		$comment_id = $registry->comments->add_comment($comment);
		
		// Отправляем email
		$registry->notify->email_comment_admin($comment_id);

		//возвращаем аяксом новый комментарий
		$new_comment = $registry->comments->get_comment($comment_id);
		$registry->design->assign('new_comment', $comment);
		$output = $registry->design->fetch('view/ajax/comment.tpl');

		echo json_encode($output);
		
		// Приберем сохраненную капчу, иначе можно отключить загрузку рисунков и постить старую
        Session::del('captcha_code');
        return false;
	}

}
$output = $registry->design->fetch('ajax/comment.form.tpl');
echo json_encode($output);
return false;