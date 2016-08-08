<?php

    if(!$registry->managers->access('products')) {
        exit();
    }
    $limit = 100;
    
    $keyword = $registry->request->get('query', 'string');
    $feature_id = $registry->request->get('feature_id', 'string');
    
    $query = $registry->db->placehold('SELECT DISTINCT po.value 
        FROM __options po
        WHERE 
            value LIKE "'.$registry->db->escape($keyword).'%" 
            AND feature_id=? 
        ORDER BY po.value 
        LIMIT ?
    ', $feature_id, $limit);
    
    $registry->db->query($query);
    
    $options = $registry->db->results('value');
    
    $res = new \stdClass;
    $res->query = $keyword;
    $res->suggestions = $options;
    header("Content-type: application/json; charset=UTF-8");
    header("Cache-Control: must-revalidate");
    header("Pragma: no-cache");
    header("Expires: -1");
    print json_encode($res);