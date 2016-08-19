<?php

// Проверка сессии для защиты от xss
if(!$registry->request->checkSession()) {
    trigger_error('Session expired', E_USER_WARNING);
    exit();
}

$id = (int)$registry->request->post('id');
$object = $registry->request->post('object');
$values = $registry->request->post('values');
$result = null;

switch ($object) {
    case 'product':
        if($registry->managers->access('products')) {
            $result = $registry->products->update_product($id, $values);
        }
        break;
    case 'variant':
        if($registry->managers->access('products')) {
            $result = $registry->variants->update_variant($id, $values);
        }
        break;
    case 'category':
        if($registry->managers->access('categories')) {
            $result = $registry->categories->update_category($id, $values);
        }
        break;
    case 'brands':
        if($registry->managers->access('brands')) {
            $result = $registry->brands->update_brand($id, $values);
        }
        break;
    case 'feature':
        if($registry->managers->access('features')) {
            $result = $registry->features->update_feature($id, $values);
        }
        break;
    case 'page':
        if($registry->managers->access('pages')) {
            $result = $registry->pages->update_page($id, $values);
        }
        break;
    case 'blog':
        if($registry->managers->access('blog')) {
            $result = $registry->blog->update_post($id, $values);
        }
        break;
    case 'delivery':
        if($registry->managers->access('delivery')) {
            $result = $registry->delivery->update_delivery($id, $values);
        }
        break;
    case 'payment':
        if($registry->managers->access('payment')) {
            $result = $registry->payment->update_payment_method($id, $values);
        }
        break;
    case 'currency':
        if($registry->managers->access('currency')) {
            $result = $registry->money->update_currency($id, $values);
        }
        break;
    case 'comment':
        if($registry->managers->access('comments')) {
            $result = $registry->comments->update_comment($id, $values);
        }
        break;
    case 'user':
        if($registry->managers->access('users')) {
            $result = $registry->users->update_user($id, $values);
        }
        break;
    case 'label':
        if($registry->managers->access('labels')) {
            $result = $registry->orders->update_label($id, $values);
        }
        break;
    case 'language':
        if($registry->managers->access('languages')) {
            $result = $registry->languages->update_language($id, $values);
        }
        break;
    case 'banner':
        if($registry->managers->access('banners')) {
            $result = $registry->banners->update_banner($id, $values);
        }
        break;
	case 'banners_image':
        if($registry->managers->access('banners')) {
            $result = $registry->banners->update_banners_image($id, $values);
        }
        break;
    case 'callback':
        if($registry->managers->access('callbacks')) {
            $result = $registry->callbacks->update_callback($id, $values);
        }
        break;
    case 'category_yandex':
    	if($registry->managers->access('products')) {
            $category = $registry->categories->get_category($id);
            $q = $registry->db->placehold('select v.id from __categories c'
                . ' right join __products_categories pc on c.id=pc.category_id'
                . ' right join __variants v on v.product_id=pc.product_id'
                . ' where c.id in(?@)', $category->children);
            $registry->db->query($q);
            $vids = $registry->db->results('id');
            if (count($vids) == 0) {
                $result = -1;
                break;
            }
            $q = $registry->db->placehold('update __variants set yandex=? where id in(?@)', (int)$values['to_yandex'], $vids);
            $result = (bool)$registry->db->query($q);
    	}
        break;
    case 'brand_yandex':
    	if($registry->managers->access('products')) {
            $q = $registry->db->placehold('select v.id from __products p'
                . ' left join __variants v on v.product_id=p.id'
                . ' where p.brand_id in(?@)', array($id));
            $registry->db->query($q);
            $vids = $registry->db->results('id');
            if (count($vids) == 0) {
                $result = -1;
                break;
            }
            $q = $registry->db->placehold('update __variants set yandex=? where id in(?@)', (int)$values['to_yandex'], $vids);
            $result = (bool)$registry->db->query($q);
    	}
        break;
    case 'feedback':
        if($registry->managers->access('feedbacks')) {
            $result = $registry->feedbacks->update_feedback($id, $values);
        }
        break;
}

header('Content-type: application/json; charset=UTF-8');
header('Cache-Control: must-revalidate');
header('Pragma: no-cache');
header('Expires: -1');
$json = json_encode($result);
print $json;
