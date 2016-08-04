<?php

require_once('View.php');

class BlogView extends View {
    
    public function fetch() {
        $url = $this->request->get('url', 'string');
        if(!empty($url)) {
            return $this->fetch_post($url);
        } else {
            return $this->fetch_blog();
        }
    }
    
    private function fetch_post($url) {
        // Выбираем пост из базы
        $post = $this->blog->get_post($url);
        
        // Если не найден - ошибка
        if(!$post || (!$post->visible && empty($_SESSION['admin']))) {
            return false;
        }
        
        //lastModify
        $this->setHeaderLastModify($post->last_modify);
        
        // Автозаполнение имени для формы комментария
        if(!empty($this->user)) {
            $this->design->assign('comment_name', $this->user->name);
            $this->design->assign('comment_email', $this->user->email);
        }
        
        // Принимаем комментарий
        if ($this->request->method('post') && $this->request->post('comment')) {
            $comment = new stdClass;
            $comment->name = $this->request->post('name');
            $comment->email = $this->request->post('email');
            $comment->text = $this->request->post('text');
            $captcha_code =  $this->request->post('captcha_code', 'string');
            
            // Передадим комментарий обратно в шаблон - при ошибке нужно будет заполнить форму
            $this->design->assign('comment_text', $comment->text);
            $this->design->assign('comment_name', $comment->name);
            $this->design->assign('comment_email', $comment->email);
            
            // Проверяем капчу и заполнение формы
            if ($this->settings->captcha_post && ($_SESSION['captcha_code'] != $captcha_code || empty($captcha_code))) {
                $this->design->assign('error', 'captcha');
            } elseif (empty($comment->name)) {
                $this->design->assign('error', 'empty_name');
            } elseif (empty($comment->text)) {
                $this->design->assign('error', 'empty_comment');
            } else {
                // Создаем комментарий
                $comment->object_id = $post->id;
                $comment->type      = 'blog';
                $comment->ip        = $_SERVER['REMOTE_ADDR'];
                
                // Если были одобренные комментарии от текущего ip, одобряем сразу
                $this->db->query('SELECT 1 FROM __comments WHERE approved=1 AND ip=? LIMIT 1', $comment->ip);
                if($this->db->num_rows()>0)
                	$comment->approved = 1;
                
                // Добавляем комментарий в базу
                $comment_id = $this->comments->add_comment($comment);
                
                // Отправляем email
                $this->notify->email_comment_admin($comment_id);
                
                // Приберем сохраненную капчу, иначе можно отключить загрузку рисунков и постить старую
                unset($_SESSION['captcha_code']);
                header('location: '.$_SERVER['REQUEST_URI'].'#comment_'.$comment_id);
            }
        }

        // Связанные товары
        $related_ids = array();
        $related_products = array();
        foreach($this->blog->get_related_products(array('post_id'=>$post->id)) as $p) {
            $related_ids[] = $p->related_id;
            $related_products[$p->related_id] = null;
        }
        if(!empty($related_ids)) {
            foreach($this->products->get_products(array('id'=>$related_ids, 'visible'=>1)) as $p) {
                $related_products[$p->id] = $p;
            }

            $related_products_images = $this->products->get_images(array('product_id'=>array_keys($related_products)));
            foreach($related_products_images as $related_product_image) {
                if(isset($related_products[$related_product_image->product_id])) {
                    $related_products[$related_product_image->product_id]->images[] = $related_product_image;
                }
            }
            $related_products_variants = $this->variants->get_variants(array('product_id'=>array_keys($related_products)));
            foreach($related_products_variants as $related_product_variant) {
                if(isset($related_products[$related_product_variant->product_id])) {
                    $related_products[$related_product_variant->product_id]->variants[] = $related_product_variant;
                }
            }
            foreach($related_products as $id=>$r) {
                if(is_object($r)) {
                    $r->image = $r->images[0];
                    $r->variant = $r->variants[0];
                } else {
                    unset($related_products[$id]);
                }
            }
            $this->design->assign('related_products', $related_products);
        }
        
        // Комментарии к посту
        $comments = $this->comments->get_comments(array('has_parent'=>false, 'type'=>'blog', 'object_id'=>$post->id, 'approved'=>1, 'ip'=>$_SERVER['REMOTE_ADDR']));
        $children = array();
        foreach ($this->comments->get_comments(array('has_parent'=>true, 'type'=>'blog', 'object_id'=>$post->id, 'approved'=>1, 'ip'=>$_SERVER['REMOTE_ADDR'])) as $c) {
            $children[$c->parent_id][] = $c;
        }
        $this->design->assign('comments', $comments);
        $this->design->assign('children', $children);
        $this->design->assign('post',      $post);
        
        // Соседние записи
        $this->design->assign('next_post', $this->blog->get_next_post($post->id));
        $this->design->assign('prev_post', $this->blog->get_prev_post($post->id));
        
        // Мета-теги
        $this->design->assign('meta_title', $post->meta_title);
        $this->design->assign('meta_keywords', $post->meta_keywords);
        $this->design->assign('meta_description', $post->meta_description);
        
        return $this->design->fetch('post.tpl');
    }
    
    private function fetch_blog() {
        //lastModify
        $this->db->query("SELECT b.last_modify FROM __blog b");
        $last_modify = $this->db->results('last_modify');
        $last_modify[] = $this->settings->lastModifyPosts;
        if ($this->page) {
            $last_modify[] = $this->page->last_modify;
        }
        $this->setHeaderLastModify(max($last_modify));
        
        // Количество постов на 1 странице
        $items_per_page = max(1, (int)$this->settings->posts_num);
        
        $filter = array();
        
        // Выбираем только видимые посты
        $filter['visible'] = 1;
        
        // Текущая страница в постраничном выводе
        $current_page = $this->request->get('page', 'integer');
        
        // Если не задана, то равна 1
        $current_page = max(1, $current_page);
        $this->design->assign('current_page_num', $current_page);
        
        // Вычисляем количество страниц
        $posts_count = $this->blog->count_posts($filter);
        
        // Показать все страницы сразу
        if($this->request->get('page') == 'all') {
            $items_per_page = $posts_count;
        }
        
        $pages_num = ceil($posts_count/$items_per_page);
        $this->design->assign('total_pages_num', $pages_num);
        
        $filter['page'] = $current_page;
        $filter['limit'] = $items_per_page;
        
        // Выбираем статьи из базы
        $posts = $this->blog->get_posts($filter);
        if(empty($posts)) {
            return false;
        }
        
        // Передаем в шаблон
        $this->design->assign('posts', $posts);
        
        // Метатеги
        if($this->page) {
            $this->design->assign('meta_title', $this->page->meta_title);
            $this->design->assign('meta_keywords', $this->page->meta_keywords);
            $this->design->assign('meta_description', $this->page->meta_description);
        }
        $body = $this->design->fetch('blog.tpl');
        return $body;
    }
}