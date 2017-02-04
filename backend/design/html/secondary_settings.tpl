{capture name=tabs_setting}
    {if in_array('currency', $manager->permissions)}
        <li class="active">
            <a href="index.php?module=SecondarySettingsAdmin">Заглушка</a>
        </li>
    {/if}
{/capture}

{$meta_title = "Дополнительные настройки" scope=parent}

{if $message_success}
    <div class="message message_success">
        <span class="text">{if $message_success == 'saved'}Настройки сохранены{/if}</span>
        {if $smarty.get.return}
            <a class="button" href="{$smarty.get.return}">Вернуться</a>
        {/if}
    </div>
{/if}

{if $message_error}
    <div class="message message_error">
        <span class="text">
            {if $message_error == 'watermark_is_not_writable'}
                Установите права на запись для файла {$config->watermark_file}
            {/if}
        </span>
        <a class="button" href="">Вернуться</a>
    </div>
{/if}

<form method=post id="product" enctype="multipart/form-data">
    <input type=hidden name="session_id" value="{$smarty.session.id}">
    <div class="align-field width-max-field content">
        <div class = "center-h1">
         <h1>Настройки страницы - заглушки</h1>
        </div>
        <div class = "split-0"></div>
        <ul>
            <li><label class=property>Имя сайта</label>
                <input name="site_name" class="order_inp" type="text" value="{$settings->site_name|escape}" /></li>
            <li><label class=property>Имя компании</label>
                <input name="company_name" class="order_inp" type="text" value="{$settings->company_name|escape}" /></li>
            <li><label class=property>телефон 1</label>
                <input name="phone1" class="order_inp" type="text" value="{$settings->phone1}" /></li>
            <li><label class=property>Формат даты</label>
                <input name="date_format" class="order_inp" type="text" value="{$settings->date_format|escape}" /></li>
            <li><label class=property>Email для восстановления пароля</label>
                <input name="admin_email" class="order_inp" type="text" value="{$settings->admin_email|escape}" /></li>
            <li>
                <label class=property>Выключение сайта</label>
                <select name="site_work">
                    <option value="on" {if $settings->site_work == "on"}selected{/if}>Включен</option>
                    <option value="off" {if $settings->site_work == "off"}selected{/if}>Выключен</option>
                </select>
            </li>
            <li>
                <label class=property>Техническое сообщение</label>
                <textarea name="site_annotation" class="order_inp">{$settings->site_annotation|escape}</textarea>
            </li>
        </ul>
    </div>

    <input class="button_green button_save" type="submit" name="save" value="Сохранить" />
</form>


<div class = 'subscriberls'>
		<div class = "header">
			<a href = "../">
			<img src = "../<?php echo $conf['logo_file']; ?>" width = "<?php echo $conf['logo_width']; ?>"
                 height = "<?php echo $conf['logo_height']; ?>" alt = "<?php echo $conf['logo_alt_text']; ?>"
                 class = "img-rounded"/>
			</a>
		</div>
		<p class = "pull-right"><p><?php echo $lang['admin_settings_intro']; ?></p>
		<div class = "subtable"></div>
		<div class = "subform">
			<form method = "post" action = "index.php?admin=update">
				<h4><?php echo $lang['admin_title']; ?></h4>
                <?php
                EditTxt('title_h1', $language, $conf, $mysql);
                ?>
                <h4><?php echo $lang['admin_seo_title']; ?></h4>
                <?php
                EditTxt('seo_title', $language, $conf, $mysql);
                ?>
                <h4><?php echo $lang['admin_seo_description']; ?></h4>
                <?php
                EditTxt('seo_description', $language, $conf, $mysql);
                ?>
                <h4><?php echo $lang['admin_countdown']; ?></h4>
				<label for = "countdown_activated"><?php echo $lang['admin_countdown_activated']; ?> : </label>
				<input type = "checkbox" name = "countdown_activated" value = "countdown_activated"
                       id = "countdown_activated" <?php if ($conf['countdown_activated']) echo 'checked'; ?>>
				<br/>
				<label for = "countdown_year"><?php echo $lang['year']; ?> : </label>
				<select name = "countdown_year" id = "countdown_year">
<?php
$now_year = date('Y');
for ($i = ($now_year - 2); $i < ($now_year + 3); $i++){
    ?>
                    <option
                            value = "<?php echo $i; ?>" <?php if ($i == $conf['countdown_year']) echo 'selected'; ?>><?php echo $i; ?></option>
                    <?php
}
?>
				</select>
				&nbsp;&nbsp;
				<label for = "countdown_month"><?php echo $lang['month']; ?> : </label>
				<select name = "countdown_month" id = "countdown_month"><?php
                    for ($i = 1; $i < 13; $i++){
                        ?>
                    <option
                            value = "<?php echo $i; ?>" <?php if ($i == $conf['countdown_month']) echo 'selected'; ?>><?php echo $i; ?></option>
                    <?php
                    }
                    ?>
				</select>
				&nbsp;&nbsp;
				<label for = "countdown_day"><?php echo $lang['day']; ?> : </label>
				<select name = "countdown_day" id = "countdown_day">
					<?php
                    for ($i = 1; $i < 32; $i++){
                        echo '<option value="' . $i . '" ';
                        if ($i == $conf['countdown_day']) echo 'selected';
                        echo '>' . $i . '</option>
                               ';
                    }
                    ?></select>
				<br/>
				<label for = "countdown_hour"><?php echo $lang['hours']; ?> : </label>
				<select name = "countdown_hour" id = "countdown_hour">
					<?php
                    for ($i = 0; $i < 24; $i++){
                        echo '<option value="' . $i . '" ';
                        if ($i == $conf['countdown_hour']) echo 'selected';
                        echo '>' . $i . '</option>
                               ';
                    }
                    ?></select>
				&nbsp;&nbsp;
				<label for = "countdown_min"><?php echo $lang['minutes']; ?> : </label>
				<select name = "countdown_min" id = "countdown_min">
					<?php
                    for ($i = 0; $i < 60; $i++){
                        echo '<option value="' . $i . '" ';
                        if ($i == $conf['countdown_min']) echo 'selected';
                        echo '>' . $i . '</option>
                               ';
                    }
                    ?></select>
				&nbsp;&nbsp;
				<label for = "countdown_sec"><?php echo $lang['seconds']; ?> : </label>
				<select name = "countdown_sec" id = "countdown_sec">
					<?php
                    for ($i = 0; $i < 60; $i++){
                        echo '<option value="' . $i . '" ';
                        if ($i == $conf['countdown_sec']) echo 'selected';
                        echo '>' . $i . '</option>
                               ';
                    }
                    ?></select>
				<br/>
                <?php
                EditTxt('content_homepage_1st_paragraph', $language, $conf, $mysql);
                ?> <h4 class = ""><?php echo $lang['admin_progress_bar']; ?></h4>
				<label for = "progressbar_activated"><?php echo $lang['admin_progress_bar_activated']; ?> : </label>
				<input type = "checkbox" name = "progressbar_activated" value = "progressbar_activated"
                       id = "progressbar_activated" <?php if ($conf['progressbar_activated']) echo 'checked'; ?>>
				<br/>
				<label for = "progressbar_percent"><?php echo $lang['percentage']; ?> : </label>
				<select name = "progressbar_percent" id = "progressbar_percent">
					<?php
                    for ($i = 0; $i < 101; $i++){
                        echo '<option value="' . $i . '" ';
                        if ($i == $conf['progressbar_percent']) echo 'selected';
                        echo '>' . $i . '</option>
                               ';
                    }
                    ?></select>
				<br/>
                <?php
                EditTxt('content_homepage_progess_bar', $language, $conf, $mysql);
                ?>
                <h4 class = ""><?php echo $lang['newsletter']; ?></h4>
				<label for = "newsletter_activated"><?php echo $lang['admin_newsletter_activated']; ?> : </label>
				<input type = "checkbox" name = "newsletter_activated" value = "newsletter_activated"
                       id = "newsletter_activated" <?php if ($conf['newsletter_activated']) echo 'checked'; ?>>
				<br/>
                <?php
                EditTxt('content_homepage_newsletter', $language, $conf, $mysql);
                ?>
                <h4 class = ""><?php echo $lang['admin_map']; ?></h4>
				<label for = "map_activated"><?php echo $lang['admin_map_activated']; ?> : </label>
				<input type = "checkbox" name = "map_activated" value = "map_activated"
                       id = "map_activated" <?php if ($conf['map_activated']) echo 'checked'; ?>>
				<br/>
				<label for = "lattitude"><?php echo $lang['lattitude']; ?> : </label>
				<input type = "text" id = "lattitude" name = "lattitude" value = "<?php echo $conf['map_latitude'] ?>">
				<br/>
				<label for = "longitude"><?php echo $lang['longitude']; ?> : </label>
				<input type = "text" id = "longitude" name = "longitude" value = "<?php echo $conf['map_longitude'] ?>">
				<br/>
				<label for = "map_title"><?php echo $lang['map_info_window_title']; ?> : </label>
				<input type = "text" id = "map_title" name = "map_title"
                       value = "<?php echo $conf['map_infowindow_title'] ?>">
				<br/>
				<label for = "map_address"><?php echo $lang['address_in_map_and_contact']; ?> : </label>
				<input type = "text" id = "map_address" name = "map_address"
                       value = "<?php echo $conf['map_infowindow_address'] ?>">
				<h4><?php echo $lang['admin_contact']; ?></h4>
				<label for = "contact_activated"><?php echo $lang['admin_contact_activated']; ?> : </label>
				<input type = "checkbox" name = "contact_activated" value = "contact_activated"
                       id = "contact_activated" <?php if ($conf['contact_activated']) echo 'checked'; ?>>
				<br/>
				<label for = "contact_phone"><?php echo $lang['admin_phone_fax']; ?> : </label>
				<input type = "text" id = "contact_phone" name = "contact_phone"
                       value = "<?php echo $conf['phone_fax'] ?>">
				<br/>
				<label for = "contact_email"><?php echo $lang['email']; ?> : </label>
				<input type = "text" id = "contact_email" name = "contact_email"
                       value = "<?php echo $conf['email_address'] ?>">
				<br/>
				<label for = "contact_email_name"><?php echo $lang['admin_email_name']; ?> : </label>
				<input type = "text" id = "contact_email_name" name = "contact_email_name"
                       value = "<?php echo $conf['email_from_name'] ?>">
				<h4><?php echo $lang['admin_about']; ?></h4>
				<label for = "about_activated"><?php echo $lang['about_activated']; ?> : </label>
				<input type = "checkbox" name = "about_activated" value = "about_activated"
                       id = "about_activated" <?php if ($conf['about_activated']) echo 'checked'; ?>>
				<br/>
				<label for = "about_title"><?php echo $lang['admin_about_title']; ?> : </label>
				<br/>
                <?php
                EditTxt('about_title', $language, $conf, $mysql);
                ?>
                <br/>
				<label for = "about_txt"><?php echo $lang['admin_about_content']; ?> : </label>
				<br/>
                <?php
                if ($conf['multilingual']){
                    foreach ($language as $key => $value){
                        ?><label for = "about_txt_<?php echo $key; ?>"><img
                            src = "../images/languages/<?php echo $key; ?>.png" width = "16" height = "11"/></label> <?php
                        ?><textarea rows = "0" cols = "80" name = "about_txt_<?php echo $key; ?>"
                                    id = "about_txt_<?php echo $key; ?>" ><?php aboutTxt($key, $conf, $mysql); ?></textarea>
                        <br/><?php
                    }
                } else {
                    ?><label for = "about_txt_<?php echo $conf['current_language']; ?>"><img
                            src = "../images/languages/<?php echo htmlspecialchars_decode($conf['current_language']); ?>.png"
                            width = "16" height = "11"/></label> <?php
                    ?><textarea rows = "0" cols = "80" name = "about_txt_<?php echo $conf['current_language']; ?>"
                                id = "about_txt_<?php echo $conf['current_language']; ?>"><?php aboutTxt($conf['current_language'], $conf, $mysql); ?></textarea>
                    <br/><?php
                } ?>
                <br/>
				<input class = "btn btn-primary btn-sm" name = "button" type = "submit"
                       value = "<?php echo $lang['update']; ?>"/>
			</form>
			<p>&nbsp;</p>
		</div>
	</div>