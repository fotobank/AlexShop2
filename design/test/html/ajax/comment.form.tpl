{*<form method="post" action="{$smarty.server.REQUEST_URI}" id="ajax-comment-form">
	<input type="hidden" name="comment" value="1">
	<label>Ваше имя* {if $error=='empty_name'}<span class="red-text">Введите Имя</span>{/if}</label>
	<input type="text" name="name" class="control full" value="{$comment->name}">
	<label>Ваш email* {if $error=='empty_email'}<span class="red-text">Введите E-mail</span>{/if}</label>
	<input type="email" name="email" class="control full" value="{$comment->email}">
	<label>Комментарий* {if $error=='empty_comment'}<span class="red-text">Введите текст коментария</span>{/if}</label>
	<textarea name="text" class="control full" rows="5">{$comment->text}</textarea>
	<div class="row">
		<div class="col-swga-6 col-smart-6"><img src="captcha/?PHPSESSID={$smarty.cookies.PHPSESSID}" class="captcha" alt="captcha"/></div>
		<div class="col-swga-6 col-smart-6">
			{if $error == 'captcha'}<label><span class="red-text">Капча введена неверно</span></label>{/if}
			<input type="text" name="captcha_code" class="control full" placeholder="Капча...">
			<input type="submit" name="" class="btn btn-blue full" value="Отправить">
		</div>
	</div>
</form>*}

{* Форма отправления комментария *}
    <form class = "form comment_form" action="{$smarty.server.REQUEST_URI}" id="ajax-comment-form" method = "post">
        <input type="hidden" name="comment" value="1">
        <div class = "h3 text-xs-center">
            <span data-language = "{$translate_id['product_write_comment']}">{$lang->product_write_comment}</span>
        </div>
         {* Вывод ошибок формы *}
        {if $error}
            <div class = "p-x-1 p-y-05 m-b-1 text-red">
                {if $error=='captcha'}
                    <span class="red-text" data-language = "{$translate_id['form_error_captcha']}">{$lang->form_error_captcha}</span>
                {elseif $error=='empty_name'}
                    <span class="red-text" data-language = "{$translate_id['form_enter_name']}">{$lang->form_enter_name}</span>
                {elseif $error=='empty_comment'}
                <span class="red-text" data-language = "{$translate_id['form_enter_comment']}">{$lang->form_enter_comment}</span>
                {/if}
            </div>
        {/if}

        <div class = "row m-b-0">
                 {* Имя комментария *}
                <div class = "col-lg-6 form-group">
                    <input class = "form-control" type = "text" name = "name"
                           value = "{$comment_name|escape}" data-format = ".+"
                           data-notice = "{$lang->form_enter_name}"
                           data-language = "{$translate_id['form_name']}"
                           placeholder = "{$lang->form_name}*"/>
                </div>
                <div class = "col-lg-6 form-group">
                    <input class = "form-control" type = "text" name = "email"
                           value = "{$comment_email|escape}"
                           data-language = "{$translate_id['form_email']}"
                           placeholder = "{$lang->form_email}"/>
                </div>

            </div>
             {* Текст комментария *}
            <div class = "form-group">
                <textarea class = "form-control" rows = "3" name = "text" data-format = ".+"
                          data-notice = "{$lang->form_enter_comment}"
                          data-language = "{$translate_id['form_enter_comment']}"
                          placeholder = "{$lang->form_enter_comment}*">{$comment_text}</textarea>
            </div>

        {if $settings->captcha_product}
            <div class = "col-xs-12 col-lg-7 form-inline m-b-1-md_down p-l-0">
                     {* Изображение капчи *}
                    <div class = "form-group">
                        <img class = "brad-3" src = "captcha/image.php?{math equation='rand(10,10000)'}"
                             alt = 'captcha'/>
                    </div>

                     {* Поле ввода капчи *}
                    <div class = "form-group">
                        <input class = "form-control" type = "text" name = "captcha_code" value = ""
                               data-format = "\d\d\d\d\d" data-notice = "{$lang->form_enter_captcha}"
                               data-language = "{$translate_id['form_enter_captcha']}"
                               placeholder = "{$lang->form_enter_captcha}*"/>
                    </div>
                </div>
        {/if}

        {* Кнопка отправки формы *}
                <div class = "text-xs-right">
                    <input class = "btn btn-warning" type = "submit" name = "comment"
                           data-language = "{$translate_id['form_send']}" value = "{$lang->form_send}"/>
                </div>
            </form>
