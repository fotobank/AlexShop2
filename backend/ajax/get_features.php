<?php

    if(!$registry->managers->access('products')) {
        exit();
    }
    
    $category_id = $registry->request->get('category_id', 'integer');
    $product_id = $registry->request->get('product_id', 'integer');
    
    if(!empty($category_id)) {
        $features = $registry->features->get_features(array('category_id'=>$category_id));
    } else {
        $features = $registry->features->get_features();
    }
    
    $options = array();
    if(!empty($product_id)) {
        $opts = $registry->features->get_product_options(array('product_id'=>$product_id));
        foreach($opts as $opt) {
            $options[$opt->feature_id] = $opt;
        }
    }
    
    foreach($features as $f) {
        if(isset($options[$f->id])) {
            $f->value = $options[$f->id]->value;
            $f->translit = $options[$f->id]->translit;
        } else {
            $f->value = '';
            $f->translit = '';
        }
    }
    
    header("Content-type: application/json; charset=UTF-8");
    header("Cache-Control: must-revalidate");
    header("Pragma: no-cache");
    header("Expires: -1");
    print json_encode($features);
