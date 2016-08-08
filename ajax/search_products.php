<?php

include __DIR__ . '/../system/configs/define/config.php';
/** @noinspection PhpIncludeInspection */
include SYS_DIR . 'core' . DS . 'boot.php';

define('IS_CLIENT', true);
$registry = new Registry();
$limit = 30;

$lang_id = $registry->languages->lang_id();
$language = $registry->languages->languages(['id' => $lang_id]);

$lang_link = '';
$first_lang = $registry->languages->languages();
if (!empty($first_lang)){
    $first_lang = reset($first_lang);
    if ($first_lang->id != $language->id){
        $lang_link = $language->label . '/';
    }
}
$px = ($lang_id ? 'l' : 'p');
$lang_sql = $registry->languages->get_query(['object' => 'product']);

$keyword = $registry->request->get('query', 'string');
$keyword_filter = '';
if (!empty($keyword)){
    $keywords = explode(' ', $keyword);
    foreach ($keywords as $kw){
        $kw = $registry->db->escape($kw);
        if ($kw !== ''){
            $keyword_filter .= $registry->db->placehold("AND (
                        $px.name LIKE '%$kw%'
                        OR $px.meta_keywords LIKE '%$kw%'
                        OR p.id in (SELECT product_id FROM __variants WHERE sku LIKE '%$kw%')
                    ) ");
        }
    }
}
$registry->db->query("SELECT 
            p.id,
            p.url,
            $px.name, 
            i.filename as image 
        FROM __products p 
        $lang_sql->join
        LEFT JOIN __images i ON i.product_id=p.id AND i.position=(SELECT MIN(position) FROM __images WHERE product_id=p.id LIMIT 1)
        WHERE 
            1
            $keyword_filter
            AND visible=1
            GROUP BY p.id
        ORDER BY p.name 
        LIMIT ?
    ", $limit);
$products = $registry->db->results();

$suggestions = [];
$ids = [];
$variants = [];
$res = new \stdClass;
$res->query = $keyword;

if (0 !== count($products)){

    foreach ($products as $p){
        $ids[] = $p->id;
    }
    foreach ($registry->variants->get_variants(['product_id' => $ids]) as $v){
        $variants[$v->product_id][] = $v;
    }

    $currencies = $registry->money->get_currencies(['enabled' => 1]);
    if (isset($_SESSION['currency_id'])){
        $currency = $registry->money->get_currency($_SESSION['currency_id']);
    } else {
        $currency = reset($currencies);
    }

    foreach ($products as $product){

        $suggestion = new stdClass();
        if (null !== $product->image){
            $product->image = $registry->design->resize_modifier($product->image, 35, 35);
        }
        $suggestion->price = $registry->money->convert($variants[$product->id][0]->price, $currency->id);
        $suggestion->value = $product->name;
        $suggestion->data = $product;
        $suggestion->lang = $lang_link;
        $suggestions[] = $suggestion;

    }
}

$res->suggestions = $suggestions;
header('Content-type: application/json; charset=UTF-8');
header('Cache-Control: must-revalidate');
header('Pragma: no-cache');
header('Expires: -1');
print json_encode($res);