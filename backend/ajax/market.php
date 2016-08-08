<?php

// Проверка сессии для защиты от xss
if(!$registry->request->check_session()) {
    trigger_error('Session expired', E_USER_WARNING);
    exit();
}

$res = new \stdClass();
if($registry->managers->access('categories')) {
    $module = $registry->request->post('module');
    $module = (!$module ? $registry->request->get('module') : $module);
    switch ($module) {
        case 'search_market': {
            $keyword = $registry->request->get('query');
            $keywords = explode(' ', $keyword);
            $categories = $registry->categories->get_market($keyword);

            $suggestions = array();
            foreach ($categories as $cats) {
                $suggestion = new \stdClass();
                $suggestion->data = $cats;
                $suggestion->value = $cats;
                $suggestions[] = $suggestion;
            }
            $res->query = $keyword;
            $res->suggestions = $suggestions;
            break;
        }
    }
}

header("Content-type: application/json; charset=UTF-8");
header("Cache-Control: must-revalidate");
header("Pragma: no-cache");
header("Expires: -1");
print json_encode($res);



