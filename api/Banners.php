<?php

require_once('Okay.php');

class Banners extends Okay {
    
    public function get_banners_images($filter = array()) {
        // По умолчанию
        $limit = 100;
        $page = 1;
        $banner_id_filter = '';
        $banners_images_id_filter = '';
        $keyword_filter = '';
        $visible_filter = '';
        $group_by = '';
        $order = 'bi.position DESC';
        
        if(isset($filter['limit'])) {
            $limit = max(1, (int)$filter['limit']);
        }
        
        if(isset($filter['page'])) {
            $page = max(1, (int)$filter['page']);
        }
        
        $sql_limit = $this->db->placehold(' LIMIT ?, ? ', ($page-1)*$limit, $limit);
        
        if(!empty($filter['id'])) {
            $banners_images_id_filter = $this->db->placehold('AND bi.id in(?@)', (array)$filter['id']);
        }
        
        if(!empty($filter['banner_id'])) {
            $banner_id_filter = $this->db->placehold('AND bi.banner_id in(?@)', (array)$filter['banner_id']);
        }
        
        if(isset($filter['visible'])) {
            $visible_filter = $this->db->placehold('AND bi.visible=?', (int)$filter['visible']);
        }
        
        if(!empty($filter['sort'])) {
            switch ($filter['sort']) {
                case 'position':
                    $order = 'bi.position DESC';
                    break;
                case 'name':
                    /*$order = 'bi.name';
                    break;*/
            }
        }
        
        if(!empty($filter['keyword'])) {
            $keywords = explode(' ', $filter['keyword']);
            foreach($keywords as $keyword) {
                $kw = $this->db->escape(trim($keyword));
                $keyword_filter .= $this->db->placehold("AND bi.name LIKE '%$kw%' OR bi.alt LIKE '%$kw%' OR bi.title LIKE '%$kw%' OR bi.description LIKE '%$kw%'");
            }
        }
        
        $lang_sql = $this->languages->get_query(array('object'=>'banner_image', 'px'=>'bi'));
        $query = "SELECT 
                bi.id, 
                bi.banner_id, 
                bi.image, 
                bi.position, 
                bi.visible, 
                $lang_sql->fields 
            FROM __banners_images bi
            $lang_sql->join
            WHERE 
                1 
                $banners_images_id_filter 
                $banner_id_filter 
                $visible_filter 
                $keyword_filter
            $group_by
            ORDER BY $order 
            $sql_limit
        ";
        
        $this->db->query($query);
        return $this->db->results();
    }
    
    public function count_banners_images($filter = array()) {
        $banner_id_filter = '';
        $banners_images_id_filter = '';
        $keyword_filter = '';
        $visible_filter = '';
        
        if(!empty($filter['banner_id'])) {
            $banner_id_filter = $this->db->placehold('AND bi.banner_id in(?@)', (array)$filter['banner_id']);
        }
        
        if(!empty($filter['id'])) {
            $banners_images_id_filter = $this->db->placehold('AND bi.id in(?@)', (array)$filter['id']);
        }
        
        if(!empty($filter['keyword'])) {
            $keywords = explode(' ', $filter['keyword']);
            foreach($keywords as $keyword) {
                $kw = $this->db->escape(trim($keyword));
                $keyword_filter .= $this->db->placehold("AND bi.name LIKE '%$kw%' OR bi.alt LIKE '%$kw%' OR bi.title LIKE '%$kw%' OR bi.description LIKE '%$kw%'");
            }
        }
        
        if(isset($filter['visible'])) {
            $visible_filter = $this->db->placehold('AND bi.visible=?', intval($filter['visible']));
        }
        
        $query = "SELECT count(distinct bi.id) as count 
            FROM __banners_images AS bi
            WHERE 
                1 
                $banner_id_filter 
                $banners_images_id_filter 
                $keyword_filter 
                $visible_filter 
        ";
        
        $this->db->query($query);
        return $this->db->result('count');
    }
    
    public function get_banners_image($id) {
        if(!is_int($id)) {
           return false;
        }
        $banner_id_filter = $this->db->placehold("AND bi.id=?", intval($id));
        
        $lang_sql = $this->languages->get_query(array('object'=>'banner_image', 'px'=>'bi'));
        $query = $this->db->placehold("SELECT 
                bi.id, 
                bi.banner_id, 
                bi.image, 
                bi.position, 
                bi.visible, 
                $lang_sql->fields 
            FROM __banners_images bi 
            $lang_sql->join
            WHERE 
                1 
                $banner_id_filter
            LIMIT 1
        ", $id);
        $this->db->query($query);
        $banners_image = $this->db->result();
        return $banners_image;
    }
    
    public function add_banners_image($banners_image) {
        $banners_image = (object)$banners_image;
        // Проверяем есть ли мультиязычность и забираем описания для перевода
        $result = $this->languages->get_description($banners_image, 'banner_image');
        
        if($this->db->query("INSERT INTO __banners_images SET ?%", $banners_image)) {
            $id = $this->db->insert_id();
            $this->db->query("UPDATE __banners_images SET position=id WHERE id=?", $id);
            
            // Если есть описание для перевода. Указываем язык для обновления
            if(!empty($result->description)) {
                $this->languages->action_description($id, $result->description, 'banner_image');
            }
            return $id;
        } else {
            return false;
        }
    }
    
    public function update_banners_image($id, $banners_image) {
        $banners_image = (object)$banners_image;
        // Проверяем есть ли мультиязычность и забираем описания для перевода
        $result = $this->languages->get_description($banners_image, 'banner_image');
        
        $query = $this->db->placehold("UPDATE __banners_images SET ?% WHERE id in (?@) LIMIT ?", $banners_image, (array)$id, count((array)$id));
        if($this->db->query($query)) {
            // Если есть описание для перевода. Указываем язык для обновления
            if(!empty($result->description)) {
                $this->languages->action_description($id, $result->description, 'banner_image', $this->languages->lang_id());
            }
            return $id;
        } else {
            return false;
        }
    }
    
    public function delete_banners_image($id) {
        if(!empty($id)) {
            $this->db->query("SELECT image FROM __banners_images WHERE id=?", (int)$id);
            $image = $this->db->result('image');
            
            $query = $this->db->placehold("DELETE FROM __banners_images WHERE id=? LIMIT 1", (int)$id);
            if($this->db->query($query)) {
                if (!empty($image)) {
                    @unlink($this->config->root_dir.$this->config->banners_images_dir.$image);
                }
                $this->db->query("DELETE FROM __lang_banners_images where banner_image_id=?", (int)$id);
                return true;
            }
        }
        return false;
    }
    
    /*public function duplicate_banners_image($id) {
        $banners_image = $this->get_banners_image($id);
        $banners_image->id = null;
        $banners_image->image = '';
        
        // Сдвигаем товары вперед и вставляем копию на соседнюю позицию
        $this->db->query('UPDATE __banners_images SET position=position+1 WHERE position>?', $banners_image->position);
        $new_id = $this->banners->add_banners_image($banners_image);
        $this->db->query('UPDATE __banners_images SET position=? WHERE id=?', $banners_image->position+1, $new_id);
        
        return $new_id;
    }*/
    
    //группы баннеров
    public function get_banners($filter = array()) {
        $visible_filter = '';
        $banners = array();
        
        if(isset($filter['visible'])) {
            $visible_filter = $this->db->placehold('AND visible = ?', intval($filter['visible']));
        }
        
        $query = "SELECT * FROM __banners WHERE 1 $visible_filter ORDER BY position";
        
        $this->db->query($query);
        
        foreach($this->db->results() as $banner) {
            $banners[$banner->id] = $banner;
        }
        
        return $banners;
    }
    
    public function get_banner($id, $visible = false, $show_filter_array = array()) {
        if(!is_int($id)) {
            return false;
        }
        
        $is_visible = '';
        $show_filter = '';
        
        if($visible) {
            $is_visible = 'AND visible=1';
        }
        
        if(!empty($show_filter_array)) {
            foreach($show_filter_array as $k=>$sfa) {
                if(empty($sfa)) {
                    unset($show_filter_array[$k]);
                    continue;
                }
                $show_filter_array[$k] = $this->db->placehold($k." regexp '[[:<:]](?)[[:>:]]'", (int)$show_filter_array[$k]);
            }
            $show_filter_array[] = 'show_all_pages=1';
            $show_filter = 'AND (' . implode(' OR ',$show_filter_array) . ')';
        }
        
        $query = $this->db->placehold("SELECT * FROM __banners WHERE id=? $is_visible $show_filter LIMIT 1", $id);
        $this->db->query($query);
        $banner = $this->db->result();
        return $banner;
    }
    
    public function update_banner($id, $banner) {
        $query = $this->db->placehold('UPDATE __banners SET ?% WHERE id in (?@) LIMIT ?', $banner, (array)$id, count((array)$id));
        if($this->db->query($query)) {
            return $id;
        } else {
            return false;
        }
    }
    
    public function add_banner($banner) {
        $banner = (array) $banner;
        
        if($this->db->query('INSERT INTO __banners SET ?%', $banner)) {
            $id = $this->db->insert_id();
            $this->db->query('UPDATE __banners SET position=id WHERE id=?', $id);
            return $id;
        } else {
            return false;
        }
    }
    
    public function delete_banner($id) {
        if(!empty($id)) {
            $this->db->query('SELECT id FROM __banners_images where banner_id=?', (int)$id);
            $banners_images_ids = $this->db->results('id');
            if (!empty($banners_images_ids)) {
                foreach ($banners_images_ids as $bi_id) {
                    $this->delete_banners_image($bi_id);
                }
            }
            
            $query = $this->db->placehold("DELETE FROM __banners WHERE id=? LIMIT 1", (int)$id);
            if($this->db->query($query)) {
                return true;
            }
        }
        return false;
    }
    
}
