<?php
/* Smarty version 3.1.29, created on 2016-08-05 14:51:35
  from "O:\domains\okay\backend\design\html\product.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57a47dc792da73_28946404',
  'file_dependency' => 
  array (
    '082cb87c064e2ee824091e2f06b67f9972d6647f' => 
    array (
      0 => 'O:\\domains\\okay\\backend\\design\\html\\product.tpl',
      1 => 1466581588,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:tinymce_init.tpl' => 1,
    'file:include_languages.tpl' => 1,
  ),
  'tpl_function' => 
  array (
    'category_select' => 
    array (
      'called_functions' => 
      array (
      ),
      'compiled_filepath' => 'O:\\domains\\okay\\backend\\design\\compiled\\082cb87c064e2ee824091e2f06b67f9972d6647f_0.file.product.tpl.php',
      'uid' => '082cb87c064e2ee824091e2f06b67f9972d6647f',
      'call_name' => 'smarty_template_function_category_select_1662557a47dc6656d31_42457616',
    ),
  ),
),false)) {
function content_57a47dc792da73_28946404 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_replace')) require_once 'O:\\domains\\okay\\vendor\\smarty\\smarty\\libs\\plugins\\modifier.replace.php';
if (!is_callable('smarty_modifier_truncate')) require_once 'O:\\domains\\okay\\vendor\\smarty\\smarty\\libs\\plugins\\modifier.truncate.php';
$_smarty_tpl->_cache['capture_stack'][] = array('tabs', null, null); ob_start(); ?>
    <li class="active">
        <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'ProductsAdmin','category_id'=>$_smarty_tpl->tpl_vars['product']->value->category_id,'return'=>null,'brand_id'=>null,'id'=>null),$_smarty_tpl);?>
">Товары</a>
    </li>
    <?php if (in_array('categories',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        <li>
            <a href="index.php?module=CategoriesAdmin">Категории</a>
        </li>
    <?php }?>
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
    <?php }
list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_cache['capture_stack']);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
$_smarty_tpl->_cache['__smarty_capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<?php if ($_smarty_tpl->tpl_vars['product']->value->id) {?>
    <?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_Variable($_smarty_tpl->tpl_vars['product']->value->name, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'meta_title', 66);
} else { ?>
    <?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_Variable('Новый товар', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'meta_title', 66);
}?>


<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:tinymce_init.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>



<?php echo '<script'; ?>
 src="design/js/autocomplete/jquery.autocomplete-min.js"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
>
    $(window).on("load", function() {
    
    // Промо изображения
    $("#special_img img").click(function() {
 		var imgo        = $(this);
		var state       = $(this).attr('alt');
        var id = $('#name input[name=id]').val();
		imgo.addClass('loading_icon');
        $("#special_img	img.selected").removeClass('selected');
		$.ajax({
			type: 'POST',
			url: 'ajax/update_object.php',
			data: {'object': 'product', 'id': id, 'values': {'special': state}, 'session_id': '<?php echo $_SESSION['id'];?>
'},
			success: function(data){
				imgo.removeClass('loading_icon');
				imgo.addClass('selected');				
			},
			dataType: 'json'
		});	
		return false;	
	});
    $(".del_spec").click(function() {
        var id = $('#name input[name=id]').val();
      
		$.ajax({
			type: 'POST',
			url: 'ajax/update_object.php',
			data: {'object': 'product', 'id': id, 'values': {'special': ''}, 'session_id': '<?php echo $_SESSION['id'];?>
'},
			success: function(data){
               
                $("#special_img	img.selected").removeClass('selected');			
			},
			dataType: 'json'
		});	
		return false;	
	});
    // END Промо изображения

	// Добавление категории
	$('#product_categories .add').click(function() {
		$("#product_categories ul li:last").clone(false).appendTo('#product_categories ul').fadeIn('slow').find("select[name*=categories]:last").focus();
		$("#product_categories ul li:last span.add").hide();
		$("#product_categories ul li:last span.delete").show();
		return false;		
	});

	// Удаление категории
	$("#product_categories .delete").live('click', function() {
		$(this).closest("li").fadeOut(200, function() { $(this).remove(); });
		return false;
	});

	// Сортировка вариантов
	$("#variants_block").sortable({ items: '#variants ul' , axis: 'y',  cancel: '#header', handle: '.move_zone' });
	// Сортировка вариантов
	$("table.related_products").sortable({ items: 'tr' , axis: 'y',  cancel: '#header', handle: '.move_zone' });

	
	// Сортировка связанных товаров
	$(".sortable").sortable({
		items: "div.row",
		tolerance:"pointer",
		scrollSensitivity:40,
		opacity:0.7,
		handle: '.move_zone'
	});
		

	// Сортировка изображений
	$(".images ul").sortable({ tolerance: 'pointer'});

	// Удаление изображений
	$(".images a.delete").live('click', function() {
		 $(this).closest("li").fadeOut(200, function() { $(this).remove(); });
		 return false;
	});
	// Загрузить изображение с компьютера
	$('#upload_image').click(function() {
		$("<input class='upload_image' name=images[] type=file multiple  accept='image/jpeg,image/png,image/gif'>").appendTo('div#add_image').focus().click();
	});
	// Или с URL
	$('#add_image_url').click(function() {
		$("<input class='remote_image' name=images_urls[] type=text value='http://'>").appendTo('div#add_image').focus().select();
	});
	// Или перетаскиванием
	if(window.File && window.FileReader && window.FileList)
	{
		$("#dropZone").show();
		$("#dropZone").on('dragover', function (e){
			$(this).css('border', '1px solid #8cbf32');
		});
		$(document).on('dragenter', function (e){
			$("#dropZone").css('border', '1px dotted #8cbf32').css('background-color', '#c5ff8d');
		});
	
		dropInput = $('.dropInput').last().clone();
		
		function handleFileSelect(evt){
			var files = evt.target.files; // FileList object
			// Loop through the FileList and render image files as thumbnails.
		    for (var i = 0, f; f = files[i]; i++) {
				// Only process image files.
				if (!f.type.match('image.*')) {
					continue;
				}
			var reader = new FileReader();
			// Closure to capture the file information.
			reader.onload = (function(theFile) {
				return function(e) {
					// Render thumbnail.
					$("<li class=wizard><a href='' class='delete'></a><img onerror='$(this).closest(\"li\").remove();' src='"+e.target.result+"' /><input name=images_urls[] type=hidden value='"+theFile.name+"'></li>").appendTo('div .images ul');
					temp_input =  dropInput.clone();
					$('.dropInput').hide();
					$('#dropZone').append(temp_input);
					$("#dropZone").css('border', '1px solid #d0d0d0').css('background-color', '#ffffff');
					clone_input.show();
		        };
		      })(f);
		
		      // Read in the image file as a data URL.
		      reader.readAsDataURL(f);
		    }
		}
		$('.dropInput').live("change", handleFileSelect);
	};

	// Удаление варианта
	$('a.del_variant').click(function() {
		if($("#variants ul").size()>1)
		{
			$(this).closest("ul").fadeOut(200, function() { $(this).remove(); });
		}
		else
		{
			$('#variants_block .variant_name input[name*=variant][name*=name]').val('');
			$('#variants_block .variant_name').hide('slow');
			$('#variants_block').addClass('single_variant');
		}
		return false;
	});

	// Загрузить файл к варианту
	$('#variants_block a.add_attachment').click(function() {
		$(this).hide();
		$(this).closest('li').find('div.browse_attachment').show('fast');
		$(this).closest('li').find('input[name*=attachment]').attr('disabled', false);
		return false;		
	});
	
	// Удалить файл к варианту
	$('#variants_block a.remove_attachment').click(function() {
		closest_li = $(this).closest('li');
		closest_li.find('.attachment_name').hide('fast');
		$(this).hide('fast');
		closest_li.find('input[name*=delete_attachment]').val('1');
		closest_li.find('a.add_attachment').show('fast');
		return false;		
	});


	// Добавление варианта
	var variant = $('#new_variant').clone(true);
	$('#new_variant').remove().removeAttr('id');
	$('#variants_block span.add').click(function() {
		if(!$('#variants_block').is('.single_variant'))
		{
			$(variant).clone(true).appendTo('#variants').fadeIn('slow').find("input[name*=variant][name*=name]").focus();
		}
		else
		{
			$('#variants_block .variant_name').show('slow');
			$('#variants_block').removeClass('single_variant');		
		}
		return false;		
	});
	
	
	function show_category_features(category_id)
	{
		$('ul.prop_ul').empty();
		$.ajax({
			url: "ajax/get_features.php",
			data: {category_id: category_id, product_id: $("input[name=id]").val()},
			dataType: 'json',
			success: function(data){
				for(i=0; i<data.length; i++)
				{
					feature = data[i];
					
					line = $("<li><label class=property></label><input class='okay_inp option_value' type='text'/><input style='margin-left:175px;margin-top:2px;' readonly class='okay_inp grey_translit' type='text'/></li>");
					var new_line = line.clone(true);
					new_line.find("label.property").text(feature.name);
					new_line.find("input.option_value").attr('name', "options["+feature.id+"][value]").val(feature.value);
                    new_line.find("input:not(.option_value)").attr('name', "options["+feature.id+"][translit]").val(feature.translit);
					new_line.appendTo('ul.prop_ul').find("input.option_value")
					.autocomplete({
						serviceUrl:'ajax/options_autocomplete.php',
						minChars:0,
						params: {feature_id:feature.id},
						noCache: false,
                        onSelect:function(sugestion){
                            $(this).trigger('change');
                        }
					});
				}
			}
		});
		return false;
	}
	
	// Изменение набора свойств при изменении категории
	$('select[name="categories[]"]:first').change(function() {
		show_category_features($("option:selected",this).val());
	});

	// Автодополнение свойств
	$('ul.prop_ul input.option_value[name*=options]').each(function(index) {
		feature_id = $(this).closest('li').attr('feature_id');
		$(this).autocomplete({
			serviceUrl:'ajax/options_autocomplete.php',
			minChars:0,
			params: {feature_id:feature_id},
			noCache: false,
            onSelect:function(sugestion){
                $(this).trigger('change');
            }
		});
	}); 	
	
	// Добавление нового свойства товара
	var new_feature = $('#new_feature').clone(true);
	$('#new_feature').remove().removeAttr('id');
	$('#add_new_feature').click(function() {
		$(new_feature).clone(true).appendTo('ul.new_features').fadeIn('slow').find("input[name*=new_feature_name]").focus();
		return false;		
	});

	
	// Удаление связанного товара
	$(".related_products a.delete").live('click', function() {
		 $(this).closest("div.row").fadeOut(200, function() { $(this).remove(); });
		 return false;
	});
 

	// Добавление связанного товара 
	var new_related_product = $('#new_related_product').clone(true);
	$('#new_related_product').remove().removeAttr('id');
 
	$("input#related_products").autocomplete({
		serviceUrl:'ajax/search_products.php',
		minChars:0,
		noCache: false, 
		onSelect:
			function(suggestion){
				$("input#related_products").val('').focus().blur(); 
				new_item = new_related_product.clone().appendTo('.related_products');
				new_item.removeAttr('id');
				new_item.find('a.related_product_name').html(suggestion.data.name);
				new_item.find('a.related_product_name').attr('href', 'index.php?module=ProductAdmin&id='+suggestion.data.id);
				new_item.find('input[name*="related_products"]').val(suggestion.data.id);
				if(suggestion.data.image)
					new_item.find('img.product_icon').attr("src", suggestion.data.image);
				else
					new_item.find('img.product_icon').remove();
				new_item.show();
			},
		formatResult:
			function(suggestions, currentValue){
				var reEscape = new RegExp('(\\' + ['/', '.', '*', '+', '?', '|', '(', ')', '[', ']', '{', '}', '\\'].join('|\\') + ')', 'g');
				var pattern = '(' + currentValue.replace(reEscape, '\\$1') + ')';
  				return (suggestions.data.image?"<img align=absmiddle src='"+suggestions.data.image+"'> ":'') + suggestions.value.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>');
			}

	});
  

	// infinity
	$("input[name*=variant][name*=stock]").focus(function() {
		if($(this).val() == '∞')
			$(this).val('');
		return false;
	});

	$("input[name*=variant][name*=stock]").blur(function() {
		if($(this).val() == '')
			$(this).val('∞');
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
	$('select[name="brand_id"]').change(function() { set_meta(); });
	$('select[name="categories[]"]').change(function() { set_meta(); });
        $('textarea[name="annotation"]').change(function() { set_meta();  });

	$("#show_translit").on('click',function(){
		$(".grey_translit").slideToggle(500);
	});
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
	result = name;
	brand = $('select[name="brand_id"] option:selected').attr('brand_name');
	if(typeof(brand) == 'string' && brand!='')
			result += ', '+brand;
	$('select[name="categories[]"]').each(function(index) {
		c = $(this).find('option:selected').attr('category_name');
		if(typeof(c) == 'string' && c != '')
    		result += ', '+c;
	}); 
	return result;
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

function translit_option($elem)
{
	url = $elem.val();
	url = url.replace(/[\s-_]+/gi, '');
	url = translit(url);
	url = url.replace(/[^0-9a-z_\-]+/gi, '').toLowerCase();	
	return url;
}
$(function(){
    $('.option_value').live('keyup click change',function(){
        $(this).next().val(translit_option($(this)));
    });
});

<?php echo '</script'; ?>
>



<h2>
    <div class="helper_wrap" style="margin-left: -6px">
        <a class="top_help" id="show_help_search" href="https://www.youtube.com/watch?v=5vO7uMwM9VA" target="_blank"></a>
        <div class="right helper_block topvisor_help">
            <p>Видеоинструкция по разделу</p>
        </div>
    </div>
</h2>
<br>
<?php if ($_smarty_tpl->tpl_vars['languages']->value) {
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:include_languages.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}?>

<?php if ($_smarty_tpl->tpl_vars['message_success']->value) {?>
    <div class="message message_success">
        <span class="text"><?php if ($_smarty_tpl->tpl_vars['message_success']->value == 'added') {?>Товар добавлен<?php } elseif ($_smarty_tpl->tpl_vars['message_success']->value == 'updated') {?>Товар изменен<?php } else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['message_success']->value, ENT_QUOTES, 'UTF-8', true);
}?></span>
        <a class="link" target="_blank" href="../<?php echo $_smarty_tpl->tpl_vars['lang_link']->value;?>
products/<?php echo $_smarty_tpl->tpl_vars['product']->value->url;?>
">Открыть товар на сайте</a>
        <?php if ($_GET['return']) {?>
        <a class="button" href="<?php echo $_GET['return'];?>
">Вернуться</a>
        <?php }?>

        <span class="share">
            <a href="#" onClick='window.open("http://vkontakte.ru/share.php?url=<?php echo urlencode($_smarty_tpl->tpl_vars['config']->value->root_url);?>
/products/<?php echo urlencode($_smarty_tpl->tpl_vars['product']->value->url);?>
&title=<?php echo urlencode($_smarty_tpl->tpl_vars['product']->value->name);?>
&description=<?php echo urlencode($_smarty_tpl->tpl_vars['product']->value->annotation);?>
&image=<?php echo urlencode($_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['resize'][0][0]->resize_modifier($_smarty_tpl->tpl_vars['product_images']->value[0]->filename,1000,1000));?>
&noparse=true","displayWindow","width=700,height=400,left=250,top=170,status=no,toolbar=no,menubar=no");return false;'>
            <img src="<?php echo $_smarty_tpl->tpl_vars['config']->value->root_url;?>
/backend/design/images/vk_icon.png" /></a>
            <a href="#" onClick='window.open("http://www.facebook.com/sharer.php?u=<?php echo urlencode($_smarty_tpl->tpl_vars['config']->value->root_url);?>
/products/<?php echo urlencode($_smarty_tpl->tpl_vars['product']->value->url);?>
","displayWindow","width=700,height=400,left=250,top=170,status=no,toolbar=no,menubar=no");return false;'>
            <img src="<?php echo $_smarty_tpl->tpl_vars['config']->value->root_url;?>
/backend/design/images/facebook_icon.png" /></a>
            <a href="#" onClick='window.open("http://twitter.com/share?text=<?php echo urlencode($_smarty_tpl->tpl_vars['product']->value->name);?>
&url=<?php echo urlencode($_smarty_tpl->tpl_vars['config']->value->root_url);?>
/products/<?php echo urlencode($_smarty_tpl->tpl_vars['product']->value->url);?>
&hashtags=<?php echo urlencode(smarty_modifier_replace($_smarty_tpl->tpl_vars['product']->value->meta_keywords,' ',''));?>
","displayWindow","width=700,height=400,left=250,top=170,status=no,toolbar=no,menubar=no");return false;'>
            <img src="<?php echo $_smarty_tpl->tpl_vars['config']->value->root_url;?>
/backend/design/images/twitter_icon.png" /></a>
        </span>
    </div>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['message_error']->value) {?>
    <div class="message message_error">
        <span class="text"><?php if ($_smarty_tpl->tpl_vars['message_error']->value == 'url_exists') {?>Товар с таким адресом уже существует<?php } elseif ($_smarty_tpl->tpl_vars['message_error']->value == 'empty_name') {?>Введите название<?php } elseif ($_smarty_tpl->tpl_vars['message_error']->value == 'empty_url') {?>Введите адрес<?php } elseif ($_smarty_tpl->tpl_vars['message_error']->value == 'url_wrong') {?>Адрес не должен начинаться или заканчиваться символом '-'<?php } else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['message_error']->value, ENT_QUOTES, 'UTF-8', true);
}?></span>
        <?php if ($_GET['return']) {?>
        <a class="button" href="<?php echo $_GET['return'];?>
">Вернуться</a>
        <?php }?>
    </div>
<?php }?>
<form method=post id=product enctype="multipart/form-data">
    <input type=hidden name="session_id" value="<?php echo $_SESSION['id'];?>
">
    <input type="hidden" name="lang_id" value="<?php echo $_smarty_tpl->tpl_vars['lang_id']->value;?>
" />
    <div id="name">
        <input class="name" name=name type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value->name, ENT_QUOTES, 'UTF-8', true);?>
"/>
        <input name=id type="hidden" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value->id, ENT_QUOTES, 'UTF-8', true);?>
"/>

        <div class="checkbox">
            <input name=visible value='1' type="checkbox" id="active_checkbox" <?php if ($_smarty_tpl->tpl_vars['product']->value->visible) {?>checked<?php }?>/>
            <label class="visible_icon" for="active_checkbox">Активен</label>
        </div>
        <div class="checkbox">
            <input name=featured value="1" type="checkbox" id="featured_checkbox" <?php if ($_smarty_tpl->tpl_vars['product']->value->featured) {?>checked<?php }?>/>
            <label class="featured_icon" for="featured_checkbox">Хит продаж</label>
        </div>
    </div>
    <div id="product_brand" <?php if (!$_smarty_tpl->tpl_vars['brands']->value) {?>style='display:none;'<?php }?>>
        <label>Бренд</label>
        <select name="brand_id">
            <option value='0' <?php if (!$_smarty_tpl->tpl_vars['product']->value->brand_id) {?>selected<?php }?> brand_name=''>Не указан</option>
            <?php
$_from = $_smarty_tpl->tpl_vars['brands']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_brand_0_saved_item = isset($_smarty_tpl->tpl_vars['brand']) ? $_smarty_tpl->tpl_vars['brand'] : false;
$_smarty_tpl->tpl_vars['brand'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['brand']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['brand']->value) {
$_smarty_tpl->tpl_vars['brand']->_loop = true;
$__foreach_brand_0_saved_local_item = $_smarty_tpl->tpl_vars['brand'];
?>
                <option value='<?php echo $_smarty_tpl->tpl_vars['brand']->value->id;?>
' <?php if ($_smarty_tpl->tpl_vars['product']->value->brand_id == $_smarty_tpl->tpl_vars['brand']->value->id) {?>selected<?php }?> brand_name='<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['brand']->value->name, ENT_QUOTES, 'UTF-8', true);?>
'><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['brand']->value->name, ENT_QUOTES, 'UTF-8', true);?>
</option>
            <?php
$_smarty_tpl->tpl_vars['brand'] = $__foreach_brand_0_saved_local_item;
}
if ($__foreach_brand_0_saved_item) {
$_smarty_tpl->tpl_vars['brand'] = $__foreach_brand_0_saved_item;
}
?>
        </select>
    </div>
    <div id="product_categories" <?php if (!$_smarty_tpl->tpl_vars['categories']->value) {?>style='display:none;'<?php }?>>
        <label>Категория</label>
        <div>
            <ul>
                <?php
$_from = $_smarty_tpl->tpl_vars['product_categories']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_categories_1_saved = isset($_smarty_tpl->tpl_vars['__smarty_foreach_categories']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_categories'] : false;
$__foreach_categories_1_saved_item = isset($_smarty_tpl->tpl_vars['product_category']) ? $_smarty_tpl->tpl_vars['product_category'] : false;
$_smarty_tpl->tpl_vars['product_category'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['__smarty_foreach_categories'] = new Smarty_Variable(array());
$__foreach_categories_1_first = true;
$_smarty_tpl->tpl_vars['product_category']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['product_category']->value) {
$_smarty_tpl->tpl_vars['product_category']->_loop = true;
$_smarty_tpl->tpl_vars['__smarty_foreach_categories']->value['first'] = $__foreach_categories_1_first;
$__foreach_categories_1_first = false;
$__foreach_categories_1_saved_local_item = $_smarty_tpl->tpl_vars['product_category'];
?>
                    <li>
                        <select name="categories[]">
                            
                            <?php $_smarty_tpl->smarty->ext->_tplFunction->callTemplateFunction($_smarty_tpl, 'category_select', array('categories'=>$_smarty_tpl->tpl_vars['categories']->value,'selected_id'=>$_smarty_tpl->tpl_vars['product_category']->value->id), true);?>

                        </select>
                        <span <?php if (!(isset($_smarty_tpl->tpl_vars['__smarty_foreach_categories']->value['first']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_categories']->value['first'] : null)) {?>style='display:none;'<?php }?> class="f_right add">
                            <i class="dash_link">Дополнительная категория</i>
                        </span>
                        <span <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_categories']->value['first']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_categories']->value['first'] : null)) {?>style='display:none;'<?php }?> class="delete">
                            <i class="dash_link">Удалить</i>
                        </span>
                    </li>
                <?php
$_smarty_tpl->tpl_vars['product_category'] = $__foreach_categories_1_saved_local_item;
}
if ($__foreach_categories_1_saved) {
$_smarty_tpl->tpl_vars['__smarty_foreach_categories'] = $__foreach_categories_1_saved;
}
if ($__foreach_categories_1_saved_item) {
$_smarty_tpl->tpl_vars['product_category'] = $__foreach_categories_1_saved_item;
}
?>
            </ul>
        </div>
    </div>

    <div id="variants_block"
         <?php $_smarty_tpl->tpl_vars['first_variant'] = new Smarty_Variable($_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['first'][0][0]->first_modifier($_smarty_tpl->tpl_vars['product_variants']->value), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'first_variant', 0);
if (count($_smarty_tpl->tpl_vars['product_variants']->value) <= 1 && !$_smarty_tpl->tpl_vars['first_variant']->value->name) {?>class=single_variant<?php }?>>
        <ul id="header">
            <li class="variant_move"></li>
            <li class="variant_name">Название варианта</li>
            <li class="variant_sku">Артикул</li>
            <li class="variant_price">Цена</li>
            <li class="variant_discount">Валюта</li>
            <li class="variant_discount">Старая</li>
            <li class="variant_amount">Кол-во</li>
            <li class="variant_yandex">Яндекс</li>
        </ul>
        <div id="variants">
            <?php
$_from = $_smarty_tpl->tpl_vars['product_variants']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_variant_3_saved_item = isset($_smarty_tpl->tpl_vars['variant']) ? $_smarty_tpl->tpl_vars['variant'] : false;
$_smarty_tpl->tpl_vars['variant'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['variant']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['variant']->value) {
$_smarty_tpl->tpl_vars['variant']->_loop = true;
$__foreach_variant_3_saved_local_item = $_smarty_tpl->tpl_vars['variant'];
?>
                <ul>
                    <li class="variant_move">
                        <div class="move_zone"></div>
                    </li>
                    <li class="variant_name">
                        <input name="variants[id][]" type="hidden" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['variant']->value->id, ENT_QUOTES, 'UTF-8', true);?>
"/>
                        <input name="variants[name][]" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['variant']->value->name, ENT_QUOTES, 'UTF-8', true);?>
"/>
                        <a class="del_variant" href=""></a>
                    </li>
                    <li class="variant_sku">
                        <input name="variants[sku][]" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['variant']->value->sku, ENT_QUOTES, 'UTF-8', true);?>
"/>
                    </li>
                    <li class="variant_price">
                        <input name="variants[price][]" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['variant']->value->price, ENT_QUOTES, 'UTF-8', true);?>
"/>
                    </li>
                    <li class="variant_discount">
                        <select name="variants[currency_id][]">
                            <?php
$_from = $_smarty_tpl->tpl_vars['currencies']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_currency_4_saved_item = isset($_smarty_tpl->tpl_vars['currency']) ? $_smarty_tpl->tpl_vars['currency'] : false;
$_smarty_tpl->tpl_vars['currency'] = new Smarty_Variable();
$__foreach_currency_4_first = true;
$_smarty_tpl->tpl_vars['currency']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['currency']->value) {
$_smarty_tpl->tpl_vars['currency']->_loop = true;
$_smarty_tpl->tpl_vars['currency']->first = $__foreach_currency_4_first;
$__foreach_currency_4_first = false;
$__foreach_currency_4_saved_local_item = $_smarty_tpl->tpl_vars['currency'];
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['currency']->value->id;?>
" <?php if ($_smarty_tpl->tpl_vars['currency']->value->id == $_smarty_tpl->tpl_vars['variant']->value->currency_id) {?>selected=""<?php }?>><?php echo $_smarty_tpl->tpl_vars['currency']->value->code;?>
</option>
                            <?php
$_smarty_tpl->tpl_vars['currency'] = $__foreach_currency_4_saved_local_item;
}
if ($__foreach_currency_4_saved_item) {
$_smarty_tpl->tpl_vars['currency'] = $__foreach_currency_4_saved_item;
}
?>
                        </select>
                    </li>
                    <li class="variant_discount">
                        <input name="variants[compare_price][]" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['variant']->value->compare_price, ENT_QUOTES, 'UTF-8', true);?>
"/>
                    </li>
                    <li class="variant_amount">
                        <input name="variants[stock][]" type="text" value="<?php if ($_smarty_tpl->tpl_vars['variant']->value->infinity || $_smarty_tpl->tpl_vars['variant']->value->stock == '') {?>∞<?php } else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['variant']->value->stock, ENT_QUOTES, 'UTF-8', true);
}?>"/><?php echo $_smarty_tpl->tpl_vars['settings']->value->units;?>

                    </li>
                    <li class="variant_yandex">
                        <input id="ya_input_<?php echo $_smarty_tpl->tpl_vars['variant']->value->id;?>
" name="yandex[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['variant']->value->id, ENT_QUOTES, 'UTF-8', true);?>
]" value="1" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['variant']->value->yandex) {?>checked=""<?php }?>/>
                        <label class="yandex_icon" for="ya_input_<?php echo $_smarty_tpl->tpl_vars['variant']->value->id;?>
"></label>
                    </li>
                    <li class="variant_download">
                        <?php if ($_smarty_tpl->tpl_vars['variant']->value->attachment) {?>
                            <span class=attachment_name><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['variant']->value->attachment,25,'...',false,true);?>
</span>
                            <a href='#' class=remove_attachment></a>
                            <a href='#' class=add_attachment style='display:none;'></a>
                        <?php } else { ?>
                            <a href='#' class="add_attachment"></a>
                        <?php }?>
                        <div class=browse_attachment style='display:none;'>
                            <input type=file name=attachment[]>
                            <input type=hidden name=delete_attachment[]>
                        </div>
                    </li>
                </ul>
            <?php
$_smarty_tpl->tpl_vars['variant'] = $__foreach_variant_3_saved_local_item;
}
if ($__foreach_variant_3_saved_item) {
$_smarty_tpl->tpl_vars['variant'] = $__foreach_variant_3_saved_item;
}
?>
        </div>
        <ul id=new_variant style='display:none;'>
            <li class="variant_move">
                <div class="move_zone"></div>
            </li>
            <li class="variant_name">
                <input name="variants[id][]" type="hidden" value=""/>
                <input name="variants[name][]" type="text" value=""/>
                <a class="del_variant" href=""></a>
            </li>
            <li class="variant_sku">
                <input name="variants[sku][]" type="" value=""/>
            </li>
            <li class="variant_price">
                <input name="variants[price][]" type="" value=""/>
            </li>
            <li class="variant_discount">
                <select name="variants[currency_id][]">
                    <?php
$_from = $_smarty_tpl->tpl_vars['currencies']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_currency_5_saved_item = isset($_smarty_tpl->tpl_vars['currency']) ? $_smarty_tpl->tpl_vars['currency'] : false;
$_smarty_tpl->tpl_vars['currency'] = new Smarty_Variable();
$__foreach_currency_5_first = true;
$_smarty_tpl->tpl_vars['currency']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['currency']->value) {
$_smarty_tpl->tpl_vars['currency']->_loop = true;
$_smarty_tpl->tpl_vars['currency']->first = $__foreach_currency_5_first;
$__foreach_currency_5_first = false;
$__foreach_currency_5_saved_local_item = $_smarty_tpl->tpl_vars['currency'];
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['currency']->value->id;?>
" <?php if ($_smarty_tpl->tpl_vars['currency']->first) {?>selected=""<?php }?>><?php echo $_smarty_tpl->tpl_vars['currency']->value->code;?>
</option>
                    <?php
$_smarty_tpl->tpl_vars['currency'] = $__foreach_currency_5_saved_local_item;
}
if ($__foreach_currency_5_saved_item) {
$_smarty_tpl->tpl_vars['currency'] = $__foreach_currency_5_saved_item;
}
?>
                </select>
            </li>
            <li class="variant_discount">
                <input name="variants[compare_price][]" type="" value=""/>
            </li>
            <li class="variant_amount">
                <input name="variants[stock][]" type="" value="∞"/><?php echo $_smarty_tpl->tpl_vars['settings']->value->units;?>

            </li>
            <li class="variant_download">
                <a href='#' class=add_attachment></a>
                <div class=browse_attachment style='display:none;'>
                    <input type=file name=attachment[]>
                    <input type=hidden name=delete_attachment[]>
                </div>
            </li>
        </ul>

        <input class="button_green button_save" type="submit" name="" value="Сохранить"/>
        <span class="add" id="add_variant"><i class="dash_link">Добавить вариант</i></span>
    </div>
    <div id="column_left">

        <div class="block layer">
            <h2>Параметры страницы</h2>
            <ul>
                <li>
                    <label class="property" for="block_translit">Заблокировать авто генерацию ссылки</label>
                    <input type="checkbox" id="block_translit" <?php if ($_smarty_tpl->tpl_vars['product']->value->url) {?>checked=""<?php }?> />
                    <div class="helper_wrap">
                        <a href="javascript:;" id="show_help_search" class="helper_link"></a>
                        <div class="right helper_block" style="width: 207px;">
                            <b>Запрещает изменение URL.</b>
                            <span>Используется для предотвращения случайного изменения URL</span>
                            <span>Активируется после сохранения товара с заполненным полем адрес.</span>
                        </div>
                    </div>
                </li>
                <li>
                    <label class=property>Адрес (URL)</label>
                    <div class="page_url"> /products/</div>
                    <input name="url" class="page_url" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value->url, ENT_QUOTES, 'UTF-8', true);?>
"/></li>
                <li>
                    <label class=property>Title  (<span class="count_title_symbol"></span>/<span class="word_title"></span>)
                        <div class="helper_wrap">
                            <a href="javascript:;" id="show_help_search" class="helper_link"></a>
                            <div class="right helper_block">
                            	<b>Название страницы</b>
                            	<p>В скобках указывается количество символов/слов в строке</p>
                            </div>
                        </div>
                    </label>

                    <input name="meta_title" class="okay_inp word_count" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value->meta_title, ENT_QUOTES, 'UTF-8', true);?>
"/>
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
                    <input name="meta_keywords" class="okay_inp word_count" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value->meta_keywords, ENT_QUOTES, 'UTF-8', true);?>
"/>
                </li>
                <li>
                    <label class=property>Description (<span class="count_desc_symbol"></span>/<span class="word_desc"></span>)
                        <div class="helper_wrap">
                            <a href="javascript:;" id="show_help_search" class="helper_link"></a>
                            <div class="right helper_block">
                            	<b>Описание страницы</b>
                            	<span>Используется поисковыми системами для формирования сниппета</span>
                                <span>В скобках указывается количество символов/слов в строке</span>
                            </div>
                        </div>
                    </label>
                    <textarea name="meta_description" class="okay_inp"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value->meta_description, ENT_QUOTES, 'UTF-8', true);?>
</textarea>
                </li>
            </ul>
        </div>
        <div class="block layer">
            <h2>Рейтинг товара</h2>
            <ul>
                <li>
                    <label class=property>Рейтинг: </label>
                    <input class="okay_inp" type="text" name="rating" value="<?php echo $_smarty_tpl->tpl_vars['product']->value->rating;?>
"/>
                </li>
                <li>
                    <label class=property>Количество голосов: </label>
                    <input class="okay_inp" type="text" name="votes" value="<?php echo $_smarty_tpl->tpl_vars['product']->value->votes;?>
"/>
                </li>
            </ul>
        </div>

        <div class="block layer" <?php if (!$_smarty_tpl->tpl_vars['categories']->value) {?>style='display:none;'<?php }?>>
            <h2>Свойства товара  <a href="javascript:;" id="show_translit">Показать транслит</a>
                <div class="helper_wrap">
                    <a href="javascript:;" id="show_help_search" class="helper_link"></a>
                    <div class="right helper_block">
                    	<b>Транслит свойства</b>
                        <span>Используется для формирования URL после применения фильтра.</span>
                        <span>Гернерируется автоматически.</span>
                    </div>
                </div>
            </h2>


            <ul class="prop_ul">
                <?php
$_from = $_smarty_tpl->tpl_vars['features']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_feature_6_saved_item = isset($_smarty_tpl->tpl_vars['feature']) ? $_smarty_tpl->tpl_vars['feature'] : false;
$_smarty_tpl->tpl_vars['feature'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['feature']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['feature']->value) {
$_smarty_tpl->tpl_vars['feature']->_loop = true;
$__foreach_feature_6_saved_local_item = $_smarty_tpl->tpl_vars['feature'];
?>
                    <?php $_smarty_tpl->tpl_vars['feature_id'] = new Smarty_Variable($_smarty_tpl->tpl_vars['feature']->value->id, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'feature_id', 0);?>
                    <li feature_id="<?php echo $_smarty_tpl->tpl_vars['feature_id']->value;?>
">
                        <label class="property"><?php echo $_smarty_tpl->tpl_vars['feature']->value->name;?>
</label>
                        <input class="okay_inp option_value" type="text" name="options[<?php echo $_smarty_tpl->tpl_vars['feature_id']->value;?>
][value]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['options']->value[$_smarty_tpl->tpl_vars['feature_id']->value]->value, ENT_QUOTES, 'UTF-8', true);?>
"/>
                        <input class="okay_inp grey_translit" style="margin-left:175px;margin-top:2px;" type="text" name="options[<?php echo $_smarty_tpl->tpl_vars['feature_id']->value;?>
][translit]" readonly="" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['options']->value[$_smarty_tpl->tpl_vars['feature_id']->value]->translit, ENT_QUOTES, 'UTF-8', true);?>
"/>
                    </li>
                <?php
$_smarty_tpl->tpl_vars['feature'] = $__foreach_feature_6_saved_local_item;
}
if ($__foreach_feature_6_saved_item) {
$_smarty_tpl->tpl_vars['feature'] = $__foreach_feature_6_saved_item;
}
?>
            </ul>
            <ul class=new_features>
                <li id=new_feature>
                    <label class=property><input type=text class="okay_inp" name=new_features_names[]></label>
                    <input class="okay_inp" type="text" name=new_features_values[]/>
                </li>
            </ul>
            <span class="add"><i class="dash_link" id="add_new_feature">Добавить новое свойство</i></span>
            <input class="button_green button_save" type="submit" name="" value="Сохранить"/>
        </div>
    </div>
    <div id="column_right">
        <div class="block layer images">
            <h2>Изображения товара
                <div class="helper_wrap">
                    <a href="javascript:;" id="show_help_search" class="helper_link"></a>
                    <div class="right helper_block">
                        <span>Первое изображение считается основным и выводится в списке товаров</span>
                    </div>
                </div>
            </h2>
            <ul>
                <?php
$_from = $_smarty_tpl->tpl_vars['product_images']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_image_7_saved_item = isset($_smarty_tpl->tpl_vars['image']) ? $_smarty_tpl->tpl_vars['image'] : false;
$_smarty_tpl->tpl_vars['image'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['image']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['image']->value) {
$_smarty_tpl->tpl_vars['image']->_loop = true;
$__foreach_image_7_saved_local_item = $_smarty_tpl->tpl_vars['image'];
?>
                    <li>
                        <a href='#' class="delete"></a>
                        <img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['resize'][0][0]->resize_modifier($_smarty_tpl->tpl_vars['image']->value->filename,100,100);?>
" alt=""/>
                        <input type=hidden name='images[]' value='<?php echo $_smarty_tpl->tpl_vars['image']->value->id;?>
'>
                    </li>
                <?php
$_smarty_tpl->tpl_vars['image'] = $__foreach_image_7_saved_local_item;
}
if ($__foreach_image_7_saved_item) {
$_smarty_tpl->tpl_vars['image'] = $__foreach_image_7_saved_item;
}
?>
            </ul>
            <div id=dropZone>
                <div id=dropMessage>Перетащите файлы сюда</div>
                <input type="file" name="dropped_images[]" multiple class="dropInput">
            </div>
            <div id="add_image"></div>
            <span class=upload_image><i class="dash_link" id="upload_image">Добавить изображение</i></span> или
            <span class=add_image_url><i class="dash_link" id="add_image_url">загрузить из интернета</i></span>
            <h2>Промо-изображение
                <div class="helper_wrap">
                    <a href="javascript:;" id="show_help_search" class="helper_link"></a>
                    <div class="right helper_block" style="width: 168px;">
                    	<b>Промо-ярлык</b>
                        <span>Выводится поверх основного изображения товара</span>
                    </div>
                </div>
            </h2>
            <div id="special_img">
                <?php
$_from = $_smarty_tpl->tpl_vars['special_images']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_special_8_saved_item = isset($_smarty_tpl->tpl_vars['special']) ? $_smarty_tpl->tpl_vars['special'] : false;
$_smarty_tpl->tpl_vars['special'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['special']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['special']->value) {
$_smarty_tpl->tpl_vars['special']->_loop = true;
$__foreach_special_8_saved_local_item = $_smarty_tpl->tpl_vars['special'];
?>
                    <img title="<?php echo $_smarty_tpl->tpl_vars['special']->value->name;?>
" class="<?php if ($_smarty_tpl->tpl_vars['product']->value->special == $_smarty_tpl->tpl_vars['special']->value->filename) {?>selected<?php }?>" src="../<?php echo $_smarty_tpl->tpl_vars['config']->value->special_images_dir;
echo $_smarty_tpl->tpl_vars['special']->value->filename;?>
" alt="<?php echo $_smarty_tpl->tpl_vars['special']->value->filename;?>
"/>
                <?php
$_smarty_tpl->tpl_vars['special'] = $__foreach_special_8_saved_local_item;
}
if ($__foreach_special_8_saved_item) {
$_smarty_tpl->tpl_vars['special'] = $__foreach_special_8_saved_item;
}
?>
            </div>
            <div class="del_cont" style="margin-top:10px">
                <img class="del_spec" title="сброс специального изображения" src='design/images/cross-circle-frame.png'/>
                <a class="del_spec" href="#">удалить отметку</a>
            </div>
        </div>

        <div class="block layer">
            <h2>Рекомендуемые товары</h2>
            <div id=list class="sortable related_products">
                <?php
$_from = $_smarty_tpl->tpl_vars['related_products']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_related_product_9_saved_item = isset($_smarty_tpl->tpl_vars['related_product']) ? $_smarty_tpl->tpl_vars['related_product'] : false;
$_smarty_tpl->tpl_vars['related_product'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['related_product']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['related_product']->value) {
$_smarty_tpl->tpl_vars['related_product']->_loop = true;
$__foreach_related_product_9_saved_local_item = $_smarty_tpl->tpl_vars['related_product'];
?>
                    <div class="row">
                        <div class="move cell">
                            <div class="move_zone"></div>
                        </div>
                        <div class="image cell">
                            <input type=hidden name=related_products[] value='<?php echo $_smarty_tpl->tpl_vars['related_product']->value->id;?>
'>
                            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('id'=>$_smarty_tpl->tpl_vars['related_product']->value->id),$_smarty_tpl);?>
">
								<?php if ($_smarty_tpl->tpl_vars['related_product']->value->images[0]) {?>
                                <img class=product_icon src='<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['resize'][0][0]->resize_modifier($_smarty_tpl->tpl_vars['related_product']->value->images[0]->filename,35,35);?>
'>
								<?php } else { ?>
								<img class=product_icon src="../design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/images/no_image.png" width="22">
								<?php }?>
							</a>
                        </div>
                        <div class="name cell">
                            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('id'=>$_smarty_tpl->tpl_vars['related_product']->value->id),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['related_product']->value->name;?>
</a>
                        </div>
                        <div class="icons cell">
                            <a href='#' class="delete"></a>
                        </div>
                        <div class="clear"></div>
                    </div>
                <?php
$_smarty_tpl->tpl_vars['related_product'] = $__foreach_related_product_9_saved_local_item;
}
if ($__foreach_related_product_9_saved_item) {
$_smarty_tpl->tpl_vars['related_product'] = $__foreach_related_product_9_saved_item;
}
?>
                <div id="new_related_product" class="row" style='display:none;'>
                    <div class="move cell">
                        <div class="move_zone"></div>
                    </div>
                    <div class="image cell">
                        <input type=hidden name=related_products[] value=''>
                        <img class=product_icon src=''>
                    </div>
                    <div class="name cell">
                        <a class="related_product_name" href=""></a>
                    </div>
                    <div class="icons cell">
                        <a href='#' class="delete"></a>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <input type=text name=related id='related_products' class="input_autocomplete" placeholder='Выберите товар чтобы добавить его'>
        </div>
        <input class="button_green button_save" type="submit" name="" value="Сохранить"/>
    </div>

    <div class="block layer">
        <h2>Краткое описание</h2>
        <textarea name="annotation" id="annotation" class="editor_small"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value->annotation, ENT_QUOTES, 'UTF-8', true);?>
</textarea>
    </div>
    <div class="block">
        <h2>Полное описание</h2>
        <textarea name="body" class="editor_large"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value->body, ENT_QUOTES, 'UTF-8', true);?>
</textarea>
    </div>
    <input class="button_green button_save" type="submit" name="" value="Сохранить"/>

</form>


<?php }
/* smarty_template_function_category_select_1662557a47dc6656d31_42457616 */
if (!function_exists('smarty_template_function_category_select_1662557a47dc6656d31_42457616')) {
function smarty_template_function_category_select_1662557a47dc6656d31_42457616($_smarty_tpl,$params) {
$saved_tpl_vars = $_smarty_tpl->tpl_vars;
$params = array_merge(array('level'=>0), $params);
foreach ($params as $key => $value) {
$_smarty_tpl->tpl_vars[$key] = new Smarty_Variable($value);
}?>
                                <?php
$_from = $_smarty_tpl->tpl_vars['categories']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_category_2_saved_item = isset($_smarty_tpl->tpl_vars['category']) ? $_smarty_tpl->tpl_vars['category'] : false;
$_smarty_tpl->tpl_vars['category'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['category']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['category']->value) {
$_smarty_tpl->tpl_vars['category']->_loop = true;
$__foreach_category_2_saved_local_item = $_smarty_tpl->tpl_vars['category'];
?>
                                    <option value='<?php echo $_smarty_tpl->tpl_vars['category']->value->id;?>
' <?php if ($_smarty_tpl->tpl_vars['category']->value->id == $_smarty_tpl->tpl_vars['selected_id']->value) {?>selected<?php }?> category_name='<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['category']->value->name, ENT_QUOTES, 'UTF-8', true);?>
'><?php
$__section_sp_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_sp']) ? $_smarty_tpl->tpl_vars['__smarty_section_sp'] : false;
$__section_sp_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['level']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_sp_0_total = $__section_sp_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_sp'] = new Smarty_Variable(array());
if ($__section_sp_0_total != 0) {
for ($__section_sp_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_sp']->value['index'] = 0; $__section_sp_0_iteration <= $__section_sp_0_total; $__section_sp_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_sp']->value['index']++){
?>&nbsp;&nbsp;&nbsp;&nbsp;<?php
}
}
if ($__section_sp_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_sp'] = $__section_sp_0_saved;
}
echo htmlspecialchars($_smarty_tpl->tpl_vars['category']->value->name, ENT_QUOTES, 'UTF-8', true);?>
</option>
                                    <?php $_smarty_tpl->smarty->ext->_tplFunction->callTemplateFunction($_smarty_tpl, 'category_select', array('categories'=>$_smarty_tpl->tpl_vars['category']->value->subcategories,'selected_id'=>$_smarty_tpl->tpl_vars['selected_id']->value,'level'=>$_smarty_tpl->tpl_vars['level']->value+1), true);?>

                                <?php
$_smarty_tpl->tpl_vars['category'] = $__foreach_category_2_saved_local_item;
}
if ($__foreach_category_2_saved_item) {
$_smarty_tpl->tpl_vars['category'] = $__foreach_category_2_saved_item;
}
?>
                            <?php foreach (Smarty::$global_tpl_vars as $key => $value){
if (!isset($_smarty_tpl->tpl_vars[$key]) || $_smarty_tpl->tpl_vars[$key] === $value) $saved_tpl_vars[$key] = $value;
}
$_smarty_tpl->tpl_vars = $saved_tpl_vars;
}
}
/*/ smarty_template_function_category_select_1662557a47dc6656d31_42457616 */
}
