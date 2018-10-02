{capture name=tabs}

	<li class = "active">
		<a href = "index.php?module=ServiceAdmin">Антивирус</a>
	</li>
    {if in_array('dump', $manager->permissions)}
        <li>
            <a href = "index.php?module=ServiceDumper">База данных</a>
        </li>
    {/if}
{/capture}

{$meta_title = "Антивирус" scope=parent}

<div id="header">
	<h1>AntiShell</h1>

<a class="add" href = "index.php?module=ServiceAdmin">Сканировать</a>
<span class="helper_wrap">
 <a href="javascript:void(0)" id="show_help_search" class="helper_link"></a>
     <span class="right helper_block">
         <span>
          Начать новое сканирование
         </span>
     </span>
</span>

<a class="add" href = "index.php?module=ServiceAdmin&snap=y">Создать снимок</a>
<span class="helper_wrap">
 <a href="javascript:void(0)" id="show_help_search" class="helper_link"></a>
     <span class="right helper_block">
         <span>
          Снимок необходимо создавать после любых изменений разработчиком скриптов сайта.
         </span>
     </span>
</span>
</div>

{$scan_results}

<!-- Основная форма -->
<form method=post id=product enctype="multipart/form-data">
    <input type=hidden name="session_id" value="{$smarty.session.id}">
    <input type="hidden" name="lang_id" value="{$lang_id}" />
    {if $banners}
        <div id="product_categories">
		<select name="banner_id">
			{foreach $banners as $banner}
                <option value='{$banner->id}' {if $banners_image->banner_id == $banner->id}selected{/if}>{$banner->name}</option>
            {/foreach}
		</select>
	</div>
    {/if}

    <!-- Левая колонка -->
	<div id="column_left">
		<!-- Параметры страницы -->
		<div class="block layer">
			<h2>Настройки сканирования</h2>
			<ul>
				<li><label class=property>Адрес (URL)</label><input name="url" class="order_inp" type="text" value="{$banners_image->url|escape}" /></li>
				<li><label class=property>Alt изображения</label><input name="alt" class="order_inp" type="text" value="{$banners_image->alt|escape}" /></li>
				<li><label class=property>Title изображения</label><input name="title" class="order_inp" type="text" value="{$banners_image->title|escape}" /></li>
				<li><label class=property>Описание</label><textarea name="description" class="order_inp" >{$banners_image->description|escape}</textarea></li>
			</ul>
		</div>
        <!-- Параметры страницы (The End)-->
	</div>
    <!-- Левая колонка свойств (The End)-->

    <!-- Правая колонка свойств -->
	<div id="column_right">

	</div>
    <!-- Правая колонка свойств (The End)-->

    <!-- Описание категории (The End)-->
	<input class="button_green button_save" type="submit" name="" value="Сохранить" />

</form>
<!-- Основная форма (The End) -->
