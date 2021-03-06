<?php

use api\Registry;

//for cron!
//chdir('/home/path/example.com/www');

$registry = new Registry();

//for cron! --- id языка в cron запросе
//$registry->languages->set_lang_id($argv[1]);
$language = $registry->languages->get_language($registry->languages->lang_id());

$l = '';
$lang_link = '';
if (!empty($language)) {
    $l = '_'.$language->label;
    $languages = $registry->languages->languages();
    $first = reset($languages);
    if ($first->id != $language->id) {
        $lang_link = $language->label.'/';
    }
}

$sub_sitemaps = glob($registry->config->root_dir."/sitemap".$l."_*.xml");
if(is_array($sub_sitemaps)) {
    foreach ($sub_sitemaps as $sitemap) {
        @unlink($sitemap);
    }
}
if (file_exists($registry->config->root_dir."/sitemap".$l.".xml")) {
    @unlink($registry->config->root_dir."sitemap".$l.".xml");
}
$sitemap_index = 1;
$url_index = 1;
//header("Content-type: text/xml; charset=UTF-8");
file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', '<?xml version="1.0" encoding="UTF-8"?>'."\n");
file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n", FILE_APPEND);

// Главная страница
//for cron!
//$registry->config->root_url = 'http://example.com';
$url = $registry->config->root_url.'/'.$lang_link;

file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t<url>"."\n", FILE_APPEND);
file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t\t<loc>$url</loc>"."\n", FILE_APPEND);
file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t\t<changefreq>daily</changefreq>"."\n", FILE_APPEND);
file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t\t<priority>1.0</priority>"."\n", FILE_APPEND);
file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t</url>"."\n", FILE_APPEND);

// Страницы
foreach($registry->pages->get_pages() as $p) {
    if($p->visible && $p->menu_id == 1 && $p->url) {
		$url = $registry->config->root_url.'/'.$lang_link.esc($p->url);
        $last_modify = array();
        if ($p->url == 'blog') {
            $registry->db->query("SELECT b.last_modify FROM __blog b");
            $last_modify = $registry->db->results('last_modify');
            $last_modify[] = $registry->settings->lastModifyPosts;
        }
        $last_modify[] = $p->last_modify;
        $last_modify = max($last_modify);
		$last_modify = substr($last_modify, 0, 10);
		file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t<url>"."\n", FILE_APPEND);
        file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t\t<loc>$url</loc>"."\n", FILE_APPEND);
        file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t\t<lastmod>$last_modify</lastmod>"."\n", FILE_APPEND);
        file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t\t<changefreq>daily</changefreq>"."\n", FILE_APPEND);
        file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t\t<priority>1.0</priority>"."\n", FILE_APPEND);
		file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t</url>"."\n", FILE_APPEND);
        if (++$url_index == 50000) {
            file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', '</urlset>'."\n", FILE_APPEND);
            $url_index=0;
            $sitemap_index++;
            file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', '<?xml version="1.0" encoding="UTF-8"?>'."\n");
            file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n", FILE_APPEND);
        }
    }
}

// Блог
foreach($registry->blog->get_posts(array('visible'=>1)) as $p) {
    $url = $registry->config->root_url.'/'.$lang_link.'blog/'.esc($p->url);
    $last_modify = substr($p->last_modify, 0, 10);
    file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t<url>"."\n", FILE_APPEND);
    file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t\t<loc>$url</loc>"."\n", FILE_APPEND);
    file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t\t<lastmod>$last_modify</lastmod>"."\n", FILE_APPEND);
    file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t\t<changefreq>daily</changefreq>"."\n", FILE_APPEND);
    file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t\t<priority>1.0</priority>"."\n", FILE_APPEND);
    file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t</url>"."\n", FILE_APPEND);
    if (++$url_index == 50000) {
        file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', '</urlset>'."\n", FILE_APPEND);
        $url_index=0;
        $sitemap_index++;
        file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', '<?xml version="1.0" encoding="UTF-8"?>'."\n");
        file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n", FILE_APPEND);
    }
}

// Категории
foreach($registry->categories->get_categories() as $c) {
    if($c->visible) {
        $url = $registry->config->root_url.'/'.$lang_link.'catalog/'.esc($c->url);
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
        file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t<url>"."\n", FILE_APPEND);
        file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t\t<loc>$url</loc>"."\n", FILE_APPEND);
        file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t\t<lastmod>$last_modify</lastmod>"."\n", FILE_APPEND);
        file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t\t<changefreq>daily</changefreq>"."\n", FILE_APPEND);
        file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t\t<priority>1.0</priority>"."\n", FILE_APPEND);
        file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t</url>"."\n", FILE_APPEND);
        if (++$url_index == 50000) {
            file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', '</urlset>'."\n", FILE_APPEND);{}
            $url_index=0;
            $sitemap_index++;
            file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', '<?xml version="1.0" encoding="UTF-8"?>'."\n");
            file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n", FILE_APPEND);
        }
    }
}

// Бренды
foreach($registry->brands->get_brands() as $b) {
    $url = $registry->config->root_url.'/'.$lang_link.'brands/'.esc($b->url);
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
    file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t<url>"."\n", FILE_APPEND);
    file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t\t<loc>$url</loc>"."\n", FILE_APPEND);
    file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t\t<lastmod>$last_modify</lastmod>"."\n", FILE_APPEND);
    file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t\t<changefreq>daily</changefreq>"."\n", FILE_APPEND);
    file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t\t<priority>1.0</priority>"."\n", FILE_APPEND);
    file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t</url>"."\n", FILE_APPEND);
    if (++$url_index == 50000) {
        file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', '</urlset>'."\n", FILE_APPEND);
        $url_index=0;
        $sitemap_index++;
        file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', '<?xml version="1.0" encoding="UTF-8"?>'."\n");
        file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n", FILE_APPEND);
    }
}

// Товары
$registry->db->query("SELECT url, last_modify FROM __products WHERE visible=1");
foreach($registry->db->results() as $p) {
    $url = $registry->config->root_url.'/'.$lang_link.'products/'.esc($p->url);
    $last_modify = substr($p->last_modify, 0, 10);
    file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t<url>"."\n", FILE_APPEND);
    file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t\t<loc>$url</loc>"."\n", FILE_APPEND);
    file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t\t<lastmod>$last_modify</lastmod>"."\n", FILE_APPEND);
    file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t\t<changefreq>weekly</changefreq>"."\n", FILE_APPEND);
    file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t\t<priority>0.5</priority>"."\n", FILE_APPEND);
    file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', "\t</url>"."\n", FILE_APPEND);
    if (++$url_index == 50000) {
        file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', '</urlset>'."\n", FILE_APPEND);
        $url_index=0;
        $sitemap_index++;
        file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', '<?xml version="1.0" encoding="UTF-8"?>'."\n");
        file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n", FILE_APPEND);
    }
}

file_put_contents('sitemap'.$l.'_'.$sitemap_index.'.xml', '</urlset>'."\n", FILE_APPEND);

$last_modify = date("Y-m-d");
file_put_contents('sitemap'.$l.'.xml', '<?xml version="1.0" encoding="UTF-8"?>'."\n");
file_put_contents('sitemap'.$l.'.xml', '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n", FILE_APPEND);
for ($i = 1; $i <= $sitemap_index; $i++) {
    $url = $registry->config->root_url.'/sitemap'.$l.'_'.$i.'.xml';
    file_put_contents('sitemap'.$l.'.xml', "\t<sitemap>"."\n", FILE_APPEND);
    file_put_contents('sitemap'.$l.'.xml', "\t\t<loc>$url</loc>"."\n", FILE_APPEND);
    file_put_contents('sitemap'.$l.'.xml', "\t\t<lastmod>$last_modify</lastmod>"."\n", FILE_APPEND);
    file_put_contents('sitemap'.$l.'.xml', "\t</sitemap>"."\n", FILE_APPEND);
}
file_put_contents('sitemap'.$l.'.xml', '</sitemapindex>'."\n", FILE_APPEND);

function esc($s) {
    return(htmlspecialchars($s, ENT_QUOTES, 'UTF-8'));
}