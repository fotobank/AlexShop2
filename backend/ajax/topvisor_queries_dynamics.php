<?php
    // Проверка сессии для защиты от xss
    if(!$registry->request->checkSession()) {
        trigger_error('Session expired', E_USER_WARNING);
        exit();
    }
    $res = new \stdClass();
    
    if($registry->managers->access('topvisor')) {
        $registry->design->set_templates_dir('backend/design/html');
        $registry->design->set_compiled_dir(SYS_DIR . 'assests/compiled/smarty/' . $theme);
        
        $project_id = $registry->request->post('project_id', 'integer');
        $searcher = $registry->request->post('searcher');
        $region_key = $registry->request->post('region_key');
        $region_lang = $registry->request->post('region_lang');
        $group_id = $registry->request->post('group_id', 'integer');
        $page = $registry->request->post('page', 'integer');
        $dates = $registry->request->post('dates');
        $dates = explode('---', $dates);
        $date1 = date('Y-m-d', strtotime($dates[0]));
        $date2 = date('Y-m-d', strtotime($dates[1]));
        
        $res = new \stdClass();
        $queries_dynamics = $registry->topvisor->get_queries_dynamics($project_id, $searcher, $region_key, $region_lang, $group_id, $date1, $date2, $page);
        $queries_dynamics->scheme->dates = array_reverse($queries_dynamics->scheme->dates);
        foreach ($queries_dynamics->phrases as $phrase) {
            $phrase->dates = array_reverse($phrase->dates);
        }
        $registry->design->assign('queries_dynamics', $queries_dynamics);
        
        $dates = array();
        foreach ($queries_dynamics->scheme->dates as $d) {
            $dates[] = $d->date;
        }
        if (!empty($dates)) {
            $qd_summary = $registry->topvisor->get_queries_dynamics_summary($project_id, $searcher, $region_key, $region_lang, $group_id, min($dates), max($dates));
            $registry->design->assign('qd_summary', $qd_summary);
        }
        $res->content = $registry->design->fetch('topvisor_queries_dynamics.tpl');
        $res->data = $queries_dynamics;
    }
    
    header("Content-type: application/json; charset=UTF-8");
    header("Cache-Control: must-revalidate");
    header("Pragma: no-cache");
    header("Expires: -1");
    print json_encode($res);
