<?php

use api\Registry;

header("Content-type: application/json; charset=UTF-8");
header("Cache-Control: must-revalidate");
header("Pragma: no-cache");
header("Expires: -1");


include __DIR__ . '/../system/configs/define/config.php';
/** @noinspection PhpIncludeInspection */
include SYS_DIR . 'core' . DS . 'boot.php';

$registry = new Registry();



$output = array('success' => 0, 'value' => 0, 'message' => '');
if ($registry->request->method('get') && $registry->request->get('id') && $registry->request->get('rate')){
	$this_id = $registry->request->get('id');

	if(!isset($_SESSION['comment_rate_ids'])) {
	    $_SESSION['comment_rate_ids'] = [];
	}
	if(in_array($this_id, $_SESSION['comment_rate_ids'], true)) {
		$output['message'] = 'Вы уже голосовали за этот комментарий!';
		echo json_encode($output);
		return false;
	}

	$this_comment = $registry->comments->get_comment($this_id);

	
	if($registry->request->get('rate') == 'down'){
		$this_comment->rate_down += 1;
		$output['value'] = $this_comment->rate_down;
	}else{
		$this_comment->rate_up += 1;
		$output['value'] = $this_comment->rate_up;
	}

	$registry->comments->update_comment($this_id, $this_comment);

	$_SESSION['comment_rate_ids'][] = $this_id;
}
$output['success'] = 1;
echo json_encode($output);
return false;