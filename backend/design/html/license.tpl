{capture name=tabs}
		<li class="active">
            <a href="index.php?module=LicenseAdmin">Лицензия</a>
        </li>
{/capture}

<!-- Основная форма -->
<form method=post id=product enctype="multipart/form-data">
<input type=hidden name="session_id" value="{$smarty.session.id}">
	<!-- Левая колонка свойств товара -->
	<div id="column_left">
 	
	<div class=block>
		{if $license->valid}	
		    <h2 style='color:green;'>Лицензия действительна {if $license->expiration != '*'}до {$license->expiration}{/if} для домен{$license->domains|count|plural:'а':'ов'} {foreach $license->domains as $d}{$d}{if !$d@last}, {/if}{/foreach}</h2>
		{else}
		    <h2 style='color:red;'>Лицензия недействительна</h2>
		{/if}
		<textarea name=license style='width:420px; height:100px;'>{$config->license|escape}</textarea>
		</div>
		<div class=block>	
		    <input class="button_green button_save" type="submit" name="" value="Сохранить" />
		    <a href='http://alexshop-sms.com/check?domain={$smarty.server.HTTP_HOST|escape}'>Проверить лицензию</a>
		</div>
	</div>

	<div id="column_right">
		<div class=block>
		<h2>Лицензионное соглашение</h2>

        <textarea style='width:420px; height:250px;'>
           1. Общие положения

        1.1. Настоящее Лицензионное соглашение (далее Соглашение) является публичной офертой и заключается между пользователем программного продукта "AlexShopCMS" (далее Пользователь) и обществом с ограниченной ответственностью "Шифтрезет" (далее Разработчик).
        1.2. Перед использованием Продукта внимательно ознакомьтесь с условиями данного Соглашения. В случае несогласия, Пользователь вправе отказаться от услуг, предоставляемых разработчиком и не использовать программный продукт AlexShopCMS.
        1.3. Продукт содержит компоненты, на которые не распространяется действие настоящего Соглашения. Эти компоненты предоставляются и распространяются свободно в соответствии с собственными лицензиями. Таковыми компонентами являются:

        - Визуальный редактор TinyMCE;
        - Файловый менеджер SMExplorer;
        - Менеджер изображений SMImage;
        - Редактор кода Codemirror;
        - Скрипт просмотра изображений EnlargeIt.
        </textarea>
		</div> 
	</div>
	<!-- Левая колонка свойств товара (The End)-->
</form>
<!-- Основная форма (The End) -->
