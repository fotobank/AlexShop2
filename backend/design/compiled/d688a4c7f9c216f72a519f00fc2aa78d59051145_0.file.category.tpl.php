<?php /* Smarty version 3.1.27, created on 2016-08-13 07:05:14
         compiled from "backend\design\html\category.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1396857ae9c7a2388e6_54815987%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd688a4c7f9c216f72a519f00fc2aa78d59051145' => 
    array (
      0 => 'backend\\design\\html\\category.tpl',
      1 => 1470644112,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1396857ae9c7a2388e6_54815987',
  'variables' => 
  array (
    'manager' => 0,
    'category' => 0,
    'languages' => 0,
    'message_success' => 0,
    'lang_link' => 0,
    'config' => 0,
    'message_error' => 0,
    'lang_id' => 0,
    'cats' => 0,
    'cat' => 0,
    'level' => 0,
    'categories' => 0,
    'features' => 0,
    'feature' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57ae9c7a3e6443_45714684',
  'tpl_function' => 
  array (
    'category_select' => 
    array (
      'called_functions' => 
      array (
      ),
      'compiled_filepath' => 'backend/design/compiled\\d688a4c7f9c216f72a519f00fc2aa78d59051145_0.file.category.tpl.php',
      'uid' => 'd688a4c7f9c216f72a519f00fc2aa78d59051145',
      'call_name' => 'smarty_template_function_category_select_1396857ae9c7a2388e6_54815987',
    ),
  ),
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57ae9c7a3e6443_45714684')) {
function content_57ae9c7a3e6443_45714684 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_replace')) require_once 'O:\\domains\\okay\\vendor\\smarty\\smarty\\libs\\plugins\\modifier.replace.php';

$_smarty_tpl->properties['nocache_hash'] = '1396857ae9c7a2388e6_54815987';
?>

<?php $_smarty_tpl->_capture_stack[0][] = array('tabs', null, null); ob_start(); ?>
	<?php if (in_array('products',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=ProductsAdmin">Товары</a>
        </li>
    <?php }?>
	<li class="active">
        <a href="index.php?module=CategoriesAdmin">Категории</a>
    </li>
	<?php if (in_array('brands',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=BrandsAdmin">Бренды</a>
        </li>
    <?php }?>
	<?php if (in_array('features',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=FeaturesAdmin">Свойства</a>
        </li>
    <?php }?>
    <?php if (in_array('special',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=SpecialAdmin">Промо-изображения</a>
        </li>
    <?php }?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<?php if ($_smarty_tpl->tpl_vars['category']->value->id) {?>
    <?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_Variable($_smarty_tpl->tpl_vars['category']->value->name, null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>
<?php } else { ?>
    <?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_Variable('Новая категория', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>
<?php }?>

<?php echo $_smarty_tpl->getSubTemplate ('tinymce_init.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>



<?php echo '<script'; ?>
 src="design/js/autocomplete/jquery.autocomplete-min.js"><?php echo '</script'; ?>
>
    <style>
        .autocomplete-suggestions{
            width: auto!important;
        }
    </style>
<?php echo '<script'; ?>
>
    $(window).on("load", function() {
        // Удаление изображений
        $(".images a.delete").click( function() {
            $("input[name='delete_image']").val('1');
            $(this).closest("ul").fadeOut(200, function() { $(this).remove(); });
            return false;
        });

        // Автозаполнение мета-тегов
        meta_title_touched = true;
        meta_keywords_touched = true;
        meta_description_touched = true;

        if($('input[name="meta_title"]').val() == generate_meta_title() || $('input[name="meta_title"]').val() == '')
            meta_title_touched = false;
        if($('input[name="meta_keywords"]').val() == generate_meta_keywords() || $('input[name="meta_keywords"]').val() == '')
            meta_keywords_touched = false;
        if($('textarea[name="meta_description"]').val() == generate_meta_description() || $('textarea[name="meta_description"]').val() == '')
            meta_description_touched = false;

        $('input[name="meta_title"]').change(function() { meta_title_touched = true; });
        $('input[name="meta_keywords"]').change(function() { meta_keywords_touched = true; });
        $('textarea[name="meta_description"]').change(function() { meta_description_touched = true; });

        $('input[name="name"]').keyup(function() { set_meta(); });

    });

    function set_meta()
    {
        if(!meta_title_touched)
            $('input[name="meta_title"]').val(generate_meta_title());
        if(!meta_keywords_touched)
            $('input[name="meta_keywords"]').val(generate_meta_keywords());
        if(!meta_description_touched)
            $('textarea[name="meta_description"]').val(generate_meta_description());
        if(!$('#block_translit').is(':checked'))
            $('input[name="url"]').val(generate_url());
    }

    function generate_meta_title()
    {
        name = $('input[name="name"]').val();
        return name;
    }

    function generate_meta_keywords()
    {
        name = $('input[name="name"]').val();
        return name;
    }

    function generate_meta_description()
    {
        if(typeof(tinyMCE.get("annotation")) =='object')
        {
            description = tinyMCE.get("annotation").getContent().replace(/(<([^>]+)>)/ig," ").replace(/(\&nbsp;)/ig," ").replace(/^\s+|\s+$/g, '').substr(0, 512);
            return description;
        }
        else
            return $('textarea[name=annotation]').val().replace(/(<([^>]+)>)/ig," ").replace(/(\&nbsp;)/ig," ").replace(/^\s+|\s+$/g, '').substr(0, 512);
    }

    function generate_url()
    {
        url = $('input[name="name"]').val();
        url = url.replace(/[\s]+/gi, '-');
        url = translit(url);
        url = url.replace(/[^0-9a-z_\-]+/gi, '').toLowerCase();
        return url;
    }

    function translit(str)
    {
        var ru=("А-а-Б-б-В-в-Ґ-ґ-Г-г-Д-д-Е-е-Ё-ё-Є-є-Ж-ж-З-з-И-и-І-і-Ї-ї-Й-й-К-к-Л-л-М-м-Н-н-О-о-П-п-Р-р-С-с-Т-т-У-у-Ф-ф-Х-х-Ц-ц-Ч-ч-Ш-ш-Щ-щ-Ъ-ъ-Ы-ы-Ь-ь-Э-э-Ю-ю-Я-я").split("-")
        var en=("A-a-B-b-V-v-G-g-G-g-D-d-E-e-E-e-E-e-ZH-zh-Z-z-I-i-I-i-I-i-J-j-K-k-L-l-M-m-N-n-O-o-P-p-R-r-S-s-T-t-U-u-F-f-H-h-TS-ts-CH-ch-SH-sh-SCH-sch-'-'-Y-y-'-'-E-e-YU-yu-YA-ya").split("-")
        var res = '';
        for(var i=0, l=str.length; i<l; i++)
        {
            var s = str.charAt(i), n = ru.indexOf(s);
            if(n >= 0) { res += en[n]; }
            else { res += s; }
        }
        return res;
    }
<?php echo '</script'; ?>
>


<h2>
    <div class="helper_wrap" style="margin-left: -6px">
        <a class="top_help" id="show_help_search" href="https://www.youtube.com/watch?v=pAgDKW7lqmM" target="_blank"></a>
        <div class="right helper_block topvisor_help">
            <p>Видеоинструкция по разделу</p>
        </div>
    </div>
</h2>
<br>

<?php if ($_smarty_tpl->tpl_vars['languages']->value) {
echo $_smarty_tpl->getSubTemplate ('include_languages.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
}?>

<?php if ($_smarty_tpl->tpl_vars['message_success']->value) {?>
    <!-- Системное сообщение -->
    <div class="message message_success">
        <span class="text"><?php if ($_smarty_tpl->tpl_vars['message_success']->value == 'added') {?>Категория добавлена<?php } elseif ($_smarty_tpl->tpl_vars['message_success']->value == 'updated') {?>Категория обновлена<?php } else {
echo $_smarty_tpl->tpl_vars['message_success']->value;
}?></span>
        <a class="link" target="_blank" href="../<?php echo $_smarty_tpl->tpl_vars['lang_link']->value;?>
catalog/<?php echo $_smarty_tpl->tpl_vars['category']->value->url;?>
">Открыть категорию на сайте</a>
        <?php if ($_GET['return']) {?>
        <a class="button" href="<?php echo $_GET['return'];?>
">Вернуться</a>
        <?php }?>
        <span class="share">
            <a href="#" onClick='window.open("http://vkontakte.ru/share.php?url=<?php echo urlencode($_smarty_tpl->tpl_vars['config']->value->root_url);?>
/catalog/<?php echo urlencode($_smarty_tpl->tpl_vars['category']->value->url);?>
&title=<?php echo urlencode($_smarty_tpl->tpl_vars['category']->value->name);?>
&description=<?php echo urlencode($_smarty_tpl->tpl_vars['category']->value->description);?>
&image=<?php echo urlencode($_smarty_tpl->tpl_vars['config']->value->root_url);?>
/files/categories/<?php echo urlencode($_smarty_tpl->tpl_vars['category']->value->image);?>
&noparse=true","displayWindow","width=700,height=400,left=250,top=170,status=no,toolbar=no,menubar=no");return false;'>
            <img src="<?php echo $_smarty_tpl->tpl_vars['config']->value->root_url;?>
/backend/design/images/vk_icon.png" /></a>
            <a href="#" onClick='window.open("http://www.facebook.com/sharer.php?u=<?php echo urlencode($_smarty_tpl->tpl_vars['config']->value->root_url);?>
/catalog/<?php echo urlencode($_smarty_tpl->tpl_vars['category']->value->url);?>
","displayWindow","width=700,height=400,left=250,top=170,status=no,toolbar=no,menubar=no");return false;'>
            <img src="<?php echo $_smarty_tpl->tpl_vars['config']->value->root_url;?>
/backend/design/images/facebook_icon.png" /></a>
            <a href="#" onClick='window.open("http://twitter.com/share?text=<?php echo urlencode($_smarty_tpl->tpl_vars['category']->value->name);?>
&url=<?php echo urlencode($_smarty_tpl->tpl_vars['config']->value->root_url);?>
/catalog/<?php echo urlencode($_smarty_tpl->tpl_vars['category']->value->url);?>
&hashtags=<?php echo urlencode(smarty_modifier_replace($_smarty_tpl->tpl_vars['category']->value->meta_keywords,' ',''));?>
","displayWindow","width=700,height=400,left=250,top=170,status=no,toolbar=no,menubar=no");return false;'>
            <img src="<?php echo $_smarty_tpl->tpl_vars['config']->value->root_url;?>
/backend/design/images/twitter_icon.png" /></a>
        </span>
    </div>
    <!-- Системное сообщение (The End)-->
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['message_error']->value) {?>
    <!-- Системное сообщение -->
    <div class="message message_error">
        <span class="text"><?php if ($_smarty_tpl->tpl_vars['message_error']->value == 'url_exists') {?>Категория с таким адресом уже существует<?php } elseif ($_smarty_tpl->tpl_vars['message_error']->value == 'empty_name') {?>Введите название<?php } elseif ($_smarty_tpl->tpl_vars['message_error']->value == 'empty_url') {?>Введите адрес<?php } elseif ($_smarty_tpl->tpl_vars['message_error']->value == 'url_wrong') {?>Адрес не должен начинаться или заканчиваться символом '-'<?php } else {
echo $_smarty_tpl->tpl_vars['message_error']->value;
}?></span>
        <a class="button" href="">Вернуться</a>
    </div>
    <!-- Системное сообщение (The End)-->
<?php }?>


<!-- Основная форма -->
<form method=post id=product enctype="multipart/form-data">
    <input type=hidden name="session_id" value="<?php echo $_SESSION['id'];?>
">
    <input type="hidden" name="lang_id" value="<?php echo $_smarty_tpl->tpl_vars['lang_id']->value;?>
" />
	<div id="name">
		<input class="name" name=name type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['category']->value->name, ENT_QUOTES, 'UTF-8', true);?>
"/> 
		<input name=id type="hidden" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['category']->value->id, ENT_QUOTES, 'UTF-8', true);?>
"/> 
		<div class="checkbox">
			<input name=visible value='1' type="checkbox" id="active_checkbox" <?php if ($_smarty_tpl->tpl_vars['category']->value->visible) {?>checked<?php }?>/>
            <label class="visible_icon" for="active_checkbox">Активна</label>
		</div>
        <div class="checkbox">
			<a class="yandex" data-to_yandex="1" href="javascript:;">В Я.Маркет</a>
            &nbsp;&nbsp;&nbsp;
            <a class="yandex" data-to_yandex="0" href="javascript:;">Из Я.Маркета</a>
		</div>
	</div> 

	<div id="product_categories">
			<select name="parent_id">
				<option value='0'>Корневая категория</option>
				
				<?php $_smarty_tpl->callTemplateFunction ('category_select', $_smarty_tpl, array('cats'=>$_smarty_tpl->tpl_vars['categories']->value), true);?>

			</select>
	</div>
		
	<!-- Левая колонка свойств товара -->
	<div id="column_left">
			
		<!-- Параметры страницы -->
		<div class="block layer">
			<h2>Параметры страницы</h2>
			<ul>
                <li>
                    <label class="property" for="block_translit">Заблокировать авто генерацию ссылки</label>
                    <input type="checkbox" id="block_translit" <?php if ($_smarty_tpl->tpl_vars['category']->value->id) {?>checked=""<?php }?> />
                    <div class="helper_wrap">
                        <a href="javascript:;" id="show_help_search" class="helper_link"></a>
                        <div class="right helper_block">
                            <b>Запрещает изменение URL.</b>
                            <span>Используется для предотвращения случайного изменения URL</span>
                            <span>Активируется после сохранения категории с заполненным полем адрес.
                            </span>
                        </div>
                    </div>
                </li>
				<li>
                    <label class="property">H1 заголовок
                        <div class="helper_wrap">
                            <a href="javascript:;" id="show_help_search" class="helper_link"></a>
                            <div class="right helper_block">
                                <span>
                                  Если поле не заполнено то в H1 подставляется название категории
                                </span>
                            </div>
                        </div>
                    </label>
                    <input name="name_h1" class="order_inp" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['category']->value->name_h1, ENT_QUOTES, 'UTF-8', true);?>
" />
                </li>
                <li>
                    <label class="property">Имя для Я.Маркета
                        <div class="helper_wrap">
                            <a href="javascript:;" id="show_help_search" class="helper_link"></a>
                            <div class="right helper_block">
                                <span>Категория Я.Маркета, в которую необходимо размещать товары из данной категории.</span>
                                <span>Начните вводить название категории и выберите подходящий вариант из выпадающего списка</span>
                            </div>
                        </div>
                    </label>
                    <input type="text" class="input_autocomplete" name="yandex_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['category']->value->yandex_name, ENT_QUOTES, 'UTF-8', true);?>
" placeholder='Выберите категорию'/>
                </li>
				<li>
                    <label class=property>Адрес (URL)</label>
                    <div class="page_url">/catalog/</div>
                    <input name="url" class="page_url" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['category']->value->url, ENT_QUOTES, 'UTF-8', true);?>
" />
                </li>
				<li>
                    <label class=property>Title (<span class="count_title_symbol"></span>/<span class="word_title"></span>)
                        <div class="helper_wrap">
                            <a href="javascript:;" id="show_help_search" class="helper_link"></a>
                            <div class="right helper_block">
                                <b>Название страницы</b>
                                <span>В скобках указывается количество символов/слов в строке</span>
                            </div>
                        </div>
                    </label>
                    <input name="meta_title" class="order_inp" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['category']->value->meta_title, ENT_QUOTES, 'UTF-8', true);?>
" />
                </li>
				<li>
                    <label class=property>Keywords (<span class="count_keywords_symbol"></span>/<span class="word_keywords"></span>)
                        <div class="helper_wrap">
                            <a href="javascript:;" id="show_help_search" class="helper_link"></a>
                            <div class="right helper_block">
                                <b>Ключевые слова страницы</b>
                                <span> В скобках указывается количество символов/слов в строке</span>
                            </div>
                        </div>
                    </label>
                    <input name="meta_keywords" class="order_inp" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['category']->value->meta_keywords, ENT_QUOTES, 'UTF-8', true);?>
" />
                </li>
				<li>
                    <label class=property>Description (<span class="count_desc_symbol"></span>/<span class="word_desc"></span>)
                        <div class="helper_wrap">
                            <a href="javascript:;" id="show_help_search" class="helper_link"></a>
                            <div class="right helper_block">
                                <b>Текст описания страницы,</b>
                                <span>который используется поисковыми системами для формирования сниппета.</span><span>В скобках указывается количество символов/слов в строке</span>
                            </div>
                        </div>
                    </label>
                    <textarea name="meta_description" class="order_inp"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['category']->value->meta_description, ENT_QUOTES, 'UTF-8', true);?>
</textarea>
                </li>
			</ul>
		</div>
		<!-- Параметры страницы (The End)-->
	</div>
	<!-- Левая колонка свойств товара (The End)--> 
	
	<!-- Правая колонка свойств товара -->	
	<div id="column_right">
		
		<!-- Изображение категории -->	
		<div class="block layer images">
			<h2>Изображение категории</h2>
			<input class='upload_image' name=image type=file>			
			<input type=hidden name="delete_image" value="">
			<?php if ($_smarty_tpl->tpl_vars['category']->value->image) {?>
			<ul>
				<li>
					<a href='#' class="delete"></a>
					<img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['resize'][0][0]->resize_modifier($_smarty_tpl->tpl_vars['category']->value->image,100,100,false,$_smarty_tpl->tpl_vars['config']->value->resized_categories_dir);?>
" alt="" />
				</li>
			</ul>
			<?php }?>
		</div>
	</div>
	<!-- Правая колонка свойств товара (The End)--> 
    
    <div id="column_left">
        <div class="block layer">
    		<h2>Мета данные карточки товара
                <div class="helper_wrap">
                    <a href="javascript:;" id="show_help_search" class="helper_link"></a>
                    <div class="right helper_block">
                        <span>С помощью даных полей можно автоматически сгенерировать мета данные для товаров этой категории.</span>
                        <span>Вставки типа <b style="display: inline;">{$brand}</b> заменятся на соответствующие значения этого товара.</span>
                        <span> Возможные варианты вставок перечислены ниже.</span>
                    </div>
                </div>
                <div class="helper_wrap" style="margin-left: 5px; margin-top: -8px;">
                    <a class="top_help" id="show_help_search" href="https://www.youtube.com/watch?v=HM3ONkDbu0o" target="_blank"></a>
                    <div class="right helper_block topvisor_help">
                        <p>Видеоинструкция по данному функционалу</p>
                    </div>
                </div>
            </h2>
            <ul>
                
                <li>{$category} - Название категории</li>
				<li>{$category_h1} - Н1 заголовок категории</li>
                <li>{$brand} - Название бренда</li>
                <li>{$product} - Название товара</li>
                <li>{$price} - Цена товара</li>
                <li>{$sitename} - Название сайта</li>
                
                <?php
$_from = $_smarty_tpl->tpl_vars['features']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['feature'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['feature']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['feature']->value) {
$_smarty_tpl->tpl_vars['feature']->_loop = true;
$foreach_feature_Sav = $_smarty_tpl->tpl_vars['feature'];
?>
                    <?php if ($_smarty_tpl->tpl_vars['feature']->value->auto_name_id && $_smarty_tpl->tpl_vars['feature']->value->auto_value_id) {?>
                    <li>
                        <span>"<?php echo $_smarty_tpl->tpl_vars['feature']->value->name;?>
": </span>
                        <span>название - {$<?php echo $_smarty_tpl->tpl_vars['feature']->value->auto_name_id;?>
};</span>
                        <span>значение - {$<?php echo $_smarty_tpl->tpl_vars['feature']->value->auto_value_id;?>
}</span>
                    </li>
                    <?php }?>
                <?php
$_smarty_tpl->tpl_vars['feature'] = $foreach_feature_Sav;
}
?>
            </ul>
    		<ul>
                <li><label class="property">Title</label><textarea name="auto_meta_title" class="order_inp"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['category']->value->auto_meta_title, ENT_QUOTES, 'UTF-8', true);?>
</textarea></li>
                <li><label class="property">Keywords</label><textarea name="auto_meta_keywords" class="order_inp"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['category']->value->auto_meta_keywords, ENT_QUOTES, 'UTF-8', true);?>
</textarea></li>
    			<li><label class="property">Description</label><textarea name="auto_meta_desc" class="order_inp"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['category']->value->auto_meta_desc, ENT_QUOTES, 'UTF-8', true);?>
</textarea></li>
    		</ul>
    	</div>
    </div>
    <div class="block layer">
		<h2>Шаблон описания товаров из данной категории
            <div class="helper_wrap">
                <a href="javascript:;" id="show_help_search" class="helper_link"></a>
                <div class="right helper_block">
                    <span> Если у товара не задано полное описание, то в описание будет подставляться текст из данного поля.</span>
                    <span>Для создание шаблонных описаний можно использовать те же вставки что и для мета данных.</span>
                </div>
            </div>
            <div class="helper_wrap" style="margin-left: 5px; margin-top: -8px;">
                <a class="top_help" id="show_help_search" href="https://www.youtube.com/watch?v=gtvt8JlVGCE" target="_blank"></a>
                <div class="right helper_block topvisor_help">
                    <p>Видеоинструкция по данному функционалу</p>
                </div>
            </div>
        </h2>
        <textarea name="auto_body" class="editor_small"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['category']->value->auto_body, ENT_QUOTES, 'UTF-8', true);?>
</textarea>
    </div>
    
    <div class="block layer">
		<h2>Краткое описание</h2>
		<textarea name="annotation" class="editor_small"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['category']->value->annotation, ENT_QUOTES, 'UTF-8', true);?>
</textarea>
	</div>
    
	<!-- Описагние категории -->
	<div class="block layer">
		<h2>Полное описание</h2>
		<textarea name="description" class="editor_large"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['category']->value->description, ENT_QUOTES, 'UTF-8', true);?>
</textarea>
	</div>
	<!-- Описание категории (The End)-->
	<input class="button_green button_save" type="submit" name="" value="Сохранить" />
	
</form>
<!-- Основная форма (The End) -->


<?php echo '<script'; ?>
>
$(function() {
    $("a.yandex").click(function() {
		var icon = $(this);
        var id = $(this).parent().parent().find('input[name="id"]').val();
        var state = $(this).data('to_yandex');
		$.ajax({
			type: 'POST',
			url: 'ajax/update_object.php',
			data: {'object': 'category_yandex', 'id': id, 'values': {'to_yandex': state}, 'session_id': '<?php echo $_SESSION['id'];?>
'},
			success: function(data){
                icon.parent().find('a.yandex.success_yandex').removeClass('success_yandex');
				icon.parent().find('a.yandex.fail_yandex').removeClass('fail_yandex');
                if (data == -1) {
                    icon.addClass('fail_yandex');
                } else if (data) {
				    icon.addClass('success_yandex');
				} else {
				    icon.removeClass('success_yandex');
				}
			},
			dataType: 'json'
		});	
		return false;	
	});
    $('.input_autocomplete').autocomplete({
        serviceUrl:'ajax/market.php?module=search_market&session_id=<?php echo $_SESSION['id'];?>
',
        minChars:1,
        noCache: false,
        onSelect:
                function(suggestions) {
                    $(this).closest('div').find('input[name*="yandex_name"]').val(suggestions.data);
                }
    });
    $(".input_autocomplete").trigger('click');
});
<?php echo '</script'; ?>
>

<?php }
}
?><?php
/* smarty_template_function_category_select_1396857ae9c7a2388e6_54815987 */
if (!function_exists('smarty_template_function_category_select_1396857ae9c7a2388e6_54815987')) {
function smarty_template_function_category_select_1396857ae9c7a2388e6_54815987($_smarty_tpl,$params) {
$saved_tpl_vars = $_smarty_tpl->tpl_vars;
$params = array_merge(array('level'=>0), $params);
foreach ($params as $key => $value) {
$_smarty_tpl->tpl_vars[$key] = new Smarty_Variable($value);
}?>
                    <?php
$_from = $_smarty_tpl->tpl_vars['cats']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['cat'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['cat']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['cat']->value) {
$_smarty_tpl->tpl_vars['cat']->_loop = true;
$foreach_cat_Sav = $_smarty_tpl->tpl_vars['cat'];
?>
                        <?php if ($_smarty_tpl->tpl_vars['category']->value->id != $_smarty_tpl->tpl_vars['cat']->value->id) {?>
                            <option value='<?php echo $_smarty_tpl->tpl_vars['cat']->value->id;?>
' <?php if ($_smarty_tpl->tpl_vars['category']->value->parent_id == $_smarty_tpl->tpl_vars['cat']->value->id) {?>selected<?php }?>><?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['sp'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['sp']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['name'] = 'sp';
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['level']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['total']);
?>&nbsp;&nbsp;&nbsp;&nbsp;<?php endfor; endif;
echo $_smarty_tpl->tpl_vars['cat']->value->name;?>
</option>
                            <?php $_smarty_tpl->callTemplateFunction ('category_select', $_smarty_tpl, array('cats'=>$_smarty_tpl->tpl_vars['cat']->value->subcategories,'level'=>$_smarty_tpl->tpl_vars['level']->value+1), false);?>

                        <?php }?>
                    <?php
$_smarty_tpl->tpl_vars['cat'] = $foreach_cat_Sav;
}
?>
				<?php foreach (Smarty::$global_tpl_vars as $key => $value){
if ($_smarty_tpl->tpl_vars[$key] === $value) $saved_tpl_vars[$key] = $value;
}
$_smarty_tpl->tpl_vars = $saved_tpl_vars;
}
}
/*/ smarty_template_function_category_select_1396857ae9c7a2388e6_54815987 */

?>
