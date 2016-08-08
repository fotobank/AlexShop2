<?php

use api\Registry;

$registry = new Registry();

header("Content-type: text/xml; charset=UTF-8");
print '<?xml version="1.0" encoding="UTF-8"?>'."\n";
print '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

$languages = $registry->languages->languages();
$lang_link = '';
if (!empty($languages)) {
    $first_lang = reset($languages);
    if($_GET['lang_label']) {
        $language = $registry->languages->languages(array('id'=>$registry->languages->lang_id()));
    } else {
        $registry->languages->set_lang_id($first_lang->id);
    }
    if(!empty($language) && is_object($language) && $language->id != $first_lang->id) {
        $lang_link = $language->label.'/';
    }
}

// Главная страница
$url = $registry->config->root_url.'/'.$lang_link;
print "\t<url>"."\n";
print "\t\t<loc>$url</loc>"."\n";
print "\t\t<changefreq>daily</changefreq>"."\n";
print "\t\t<priority>1.0</priority>"."\n";
print "\t</url>"."\n";

// Страницы
foreach($registry->pages->get_pages() as $p) {
    if($p->visible && $p->menu_id == 1 && $p->url) {
        $url = $registry->config->root_url.'/'.$lang_link.esc($p->url);
        print "\t<url>"."\n";
        print "\t\t<loc>$url</loc>"."\n";
        //lastModify
        $last_modify = array();
        if ($p->url == 'blog') {
            $registry->db->query("SELECT b.last_modify FROM __blog b");
            $last_modify = $registry->db->results('last_modify');
            $last_modify[] = $registry->settings->lastModifyPosts;
        }
        $last_modify[] = $p->last_modify;
        $last_modify = max($last_modify);
		$last_modify = substr($last_modify, 0, 10);
        print "\t\t<lastmod>$last_modify</lastmod>"."\n";
        print "\t\t<changefreq>daily</changefreq>"."\n";
        print "\t\t<priority>1.0</priority>"."\n";
        
        print "\t</url>"."\n";
    }
}

// Блог
foreach($registry->blog->get_posts(array('visible'=>1)) as $p) {
    $url = $registry->config->root_url.'/'.$lang_link.'blog/'.esc($p->url);
    print "\t<url>"."\n";
    print "\t\t<loc>$url</loc>"."\n";
    //lastModify
    $last_modify = substr($p->last_modify, 0, 10);
    print "\t\t<lastmod>$last_modify</lastmod>"."\n";
    print "\t\t<changefreq>daily</changefreq>"."\n";
    print "\t\t<priority>1.0</priority>"."\n";
    
    print "\t</url>"."\n";
}

// Категории
foreach($registry->categories->get_categories() as $c) {
    if($c->visible) {
        $url = $registry->config->root_url.'/'.$lang_link.'catalog/'.esc($c->url);
        print "\t<url>"."\n";
        print "\t\t<loc>$url</loc>"."\n";
        //lastModify
        $last_modify = array();
        $registry->db->query("SELECT p.last_modify 
            FROM __products p 
            INNER JOIN __products_categories pc ON pc.product_id = p.id AND pc.category_id in(?@) 
            WHERE 1 
            GROUP BY p.id", $c->children);
        $res = $registry->db->results('last_modify');
        if (!empty($res)) {
            $last_modify = $res;
        }
        $last_modify[] = $c->last_modify;
		$last_modify = substr(max($last_modify), 0, 10);
        print "\t\t<lastmod>$last_modify</lastmod>"."\n";
        print "\t\t<changefreq>daily</changefreq>"."\n";
        print "\t\t<priority>1.0</priority>"."\n";
        
        print "\t</url>"."\n";
    }
}

// Бренды
foreach($registry->brands->get_brands() as $b) {
    $url = $registry->config->root_url.'/'.$lang_link.'brands/'.esc($b->url);
    print "\t<url>"."\n";
    print "\t\t<loc>$url</loc>"."\n";
    //lastModify
    $last_modify = array();
    $registry->db->query("SELECT p.last_modify
        FROM __products p 
        WHERE p.brand_id=?", $b->id);
    $res = $registry->db->results('last_modify');
    if (!empty($res)) {
        $last_modify = $res;
    }
    $last_modify[] = $b->last_modify;
	$last_modify = substr(max($last_modify), 0, 10);
    print "\t\t<lastmod>$last_modify</lastmod>"."\n";
    print "\t\t<changefreq>daily</changefreq>"."\n";
    print "\t\t<priority>1.0</priority>"."\n";
    
    print "\t</url>"."\n";
}

// Товары
$registry->db->query("SELECT url, last_modify FROM __products WHERE visible=1");
foreach($registry->db->results() as $p) {
    $url = $registry->config->root_url.'/'.$lang_link.'products/'.esc($p->url);
    print "\t<url>"."\n";
    print "\t\t<loc>$url</loc>"."\n";
    //lastModify
    $last_modify = substr($p->last_modify, 0, 10);
    print "\t\t<lastmod>$last_modify</lastmod>"."\n";
    print "\t\t<changefreq>weekly</changefreq>"."\n";
    print "\t\t<priority>0.5</priority>"."\n";
    
    print "\t</url>"."\n";
}

print '</urlset>'."\n";

function esc($s) {
    return(htmlspecialchars($s, ENT_QUOTES, 'UTF-8'));	
}