<?php

	if(!$registry->managers->access('products')) {
        exit();
    }
    $limit = 100;

    if (!empty($_SESSION['admin_lang_id'])) {
        $registry->languages->set_lang_id($_SESSION['admin_lang_id']);
    }
    $lang_id  = $registry->languages->lang_id();
    $px = ($lang_id ? 'l' : 'p');
    $lang_sql = $registry->languages->get_query(array('object'=>'product', 'px'=>'p'));
    
    $keyword = $registry->request->get('query', 'string');
    $keywords = explode(' ', $keyword);
    $keyword_sql = '';
    foreach($keywords as $keyword) {
        $kw = $registry->db->escape(trim($keyword));
        $keyword_sql .= $registry->db->placehold("AND (
            $px.name LIKE '%$kw%' 
            OR $px.meta_keywords LIKE '%$kw%' 
            OR p.id in (SELECT product_id FROM __variants WHERE sku LIKE '%$kw%') 
        ) ");
    }
    
    $registry->db->query("SELECT 
            p.id, 
            $px.name, 
            i.filename as image 
        FROM __products p
        $lang_sql->join
        LEFT JOIN __images i ON i.product_id=p.id AND i.position=(SELECT MIN(position) FROM __images WHERE product_id=p.id LIMIT 1)
        WHERE 
            1 
            $keyword_sql 
        ORDER BY $px.name 
        LIMIT ?
    ", $limit);
    
    $products = $registry->db->results();
    
    $suggestions = array();
    foreach($products as $product) {
        if(!empty($product->image)) {
            $product->image = $registry->design->resize_modifier($product->image, 35, 35);
        }
        
        $suggestion = new \stdClass();
        $suggestion->value = $product->name;
        $suggestion->data = $product;
        $suggestions[] = $suggestion;
    }
    
    $res = new \stdClass;
    $res->query = $keyword;
    $res->suggestions = $suggestions;
    header("Content-type: application/json; charset=UTF-8");
    header("Cache-Control: must-revalidate");
    header("Pragma: no-cache");
    header("Expires: -1");
    print json_encode($res);