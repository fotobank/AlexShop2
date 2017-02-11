{capture name=tabs}
    <li class = "active">
        <a href = "index.php?module=SettingsAdmin">Настройки</a>
    </li>
    {if in_array('currency', $manager->permissions)}
        <li>
            <a href = "index.php?module=CurrencyAdmin">Валюты</a>
        </li>
    {/if}
    {if in_array('delivery', $manager->permissions)}
        <li>
            <a href = "index.php?module=DeliveriesAdmin">Доставка</a>
        </li>
    {/if}
    {if in_array('payment', $manager->permissions)}
        <li>
            <a href = "index.php?module=PaymentMethodsAdmin">Оплата</a>
        </li>
    {/if}
    {if in_array('managers', $manager->permissions)}
        <li>
            <a href = "index.php?module=ManagersAdmin">Менеджеры</a>
        </li>
    {/if}
    {if in_array('languages', $manager->permissions)}
        <li>
            <a href = "index.php?module=LanguagesAdmin">Языки</a>
        </li>
    {/if}
    {if in_array('languages', $manager->permissions)}
        <li>
            <a href = "index.php?module=TranslationsAdmin">Переводы</a>
        </li>
    {/if}
{/capture}

{$meta_title = "Настройки" scope=parent}

{if $message_success}
    <div class = "message message_success">
        <span class = "text">{if $message_success == 'saved'}Настройки сохранены{/if}</span>
        {if $smarty.get.return}
            <a class = "button" href = "{$smarty.get.return}">Вернуться</a>
        {/if}
    </div>
{/if}

{if $message_error}
    <div class = "message message_error">
        <span class = "text">
            {if $message_error == 'watermark_is_not_writable'}
                Установите права на запись для файла {$config->watermark_file}
            {/if}
        </span>
        <a class = "button" href = "">Вернуться</a>
    </div>
{/if}

<div class = "tabs-section tabs-vertical">
<form method = post id = product enctype = "multipart/form-data">
    <input type = hidden name = "session_id" value = "{$smarty.session.id}">
    <ul class = "tabs-caption">
		<li class = "active">Сайт</li>
		<li>Админка</li>
		<li>Оповещения</li>
		<li>Капча</li>
		<li>Формат цены</li>
		<li>Каталог</li>
		<li>1C</li>
		<li>Изображения товаров</li>
		<li>Экспорт в яндекс</li>
		<li>Google аналитика</li>
		<li>Яндекс метрика</li>
	</ul>
    <div class = "tabs-content active">
         <div class = "center-h1">
        <h1>Основные настройки сайта</h1>
         </div>
        <div class = "split-0"></div>
        <ul class = "align-field">
            <li><label for = "site_name" class = "property">Имя сайта</label>
                <input id = "site_name" name = "site_name" class = "order_inp" type = "text"
                       value = "{$settings->site_name|escape}"/></li>
            <li><label for = "company_name" class = "property">Имя компании</label>
                <input id = "company_name" name = "company_name" class = "order_inp" type = "text"
                       value = "{$settings->company_name|escape}"/></li>
            <li><label for = "phone1" class = "property">телефон 1</label>
                <input id = "phone1" name = "phone1" class = "order_inp" type = "text"
                       value = "{$settings->phone1}"/></li>
            <li><label for = "phone2" class = "property">телефон 2</label>
                <input id = "phone2" name = "phone2" class = "order_inp" type = "text"
                       value = "{$settings->phone2}"/></li>
            <li><label for = "phone3" class = "property">телефон 3</label>
                <input id = "phone3" name = "phone3" class = "order_inp" type = "text"
                       value = "{$settings->phone3}"/></li>
            <li><label for = "date_format" class = "property">Формат даты</label>
                <input id = "date_format" name = "date_format" class = "order_inp" type = "text"
                       value = "{$settings->date_format|escape}"/></li>
            <li><label for = "admin_email" class = "property">Email для восстановления пароля</label>
                <input id = "admin_email" name = "admin_email" class = "order_inp" type = "text"
                       value = "{$settings->admin_email|escape}"/></li>
            <li>
                <label for = "site_work" class = "property">Выключение сайта</label>
                <select id = "site_work" name = "site_work">
                    <option value = "on" {if $settings->site_work == "on"}selected{/if}>Включен</option>
                    <option value = "off" {if $settings->site_work == "off"}selected{/if}>Выключен</option>
                </select>
            </li>
            <li>
                <label for = "site_annotation" class = "property">Техническое сообщение</label>
                <textarea id = "site_annotation" name = "site_annotation"
                          class = "order_inp">{$settings->site_annotation|escape}</textarea>
            </li>
        </ul>
    </div>
    <div class = "tabs-content active">
         <div class = "center-h1">
        <h1>Настройки админки</h1>
         </div>
        <div class = "split-0"></div>
        <ul class = "align-field">
            <li>
                <label for = "admin_table" class = "property">Метод отображения таблиц
                    <div class="helper_wrap">
                        <a href="javascript:void(0)" id="show_help_search" class="helper_link"></a>
                        <div class="right helper_block">
                        <span>
                            Выбор шаблона для работы с таблицами.
                            Не все таблицы поддерживают ajax, поэтому они будут работать
                            в основном шаблоне не зависимо от выбора.
                        </span>
                        </div>
                    </div>
                  </label>
                <select id = "admin_table" name = "admin_table">
                    <option value = "old_table" {if $settings->admin_table == "old_table"}selected{/if}>основной</option>
                    <option value = "jq_grig" {if $settings->admin_table == "jq_grig"}selected{/if}>ajax-jQGrid</option>
                    <option value = "js_grig" {if $settings->admin_table == "js_grig"}selected{/if}>ajax-jSGrid</option>
                </select>
            </li>
        </ul>
    </div>
    <div class = "tabs-content">
         <div class = "center-h1">
        <h1>Оповещения</h1>
         </div>
        <div class = "split-0"></div>
        <ul class = "align-field width-max-field">
            <li><label for = "order_email" class = "property">Оповещение о заказах</label>
                <input id = "order_email" name = "order_email" class = "order_inp" type = "text"
                       value = "{$settings->order_email|escape}"/></li>
            <li><label for = "comment_email" class = "property">Оповещение о комментариях</label>
                <input id = "comment_email" name = "comment_email" class = "order_inp" type = "text"
                       value = "{$settings->comment_email|escape}"/></li>
            <li><label for = "notify_from_email" class = "property">Обратный адрес оповещений</label>
                <input id = "notify_from_email" name = "notify_from_email" class = "order_inp" type = "text"
                       value = "{$settings->notify_from_email|escape}"/></li>
            <li><label for = "notify_from_name" class = "property">Имя отправителя письма</label>
                <input id = "notify_from_name" name = "notify_from_name" class = "order_inp" type = "text"
                       value = "{$settings->notify_from_name|escape}"/></li>
        </ul>
    </div>
     <div class = "tabs-content">
          <div class = "center-h1">
        <h1>Капча вкл./выкл.</h1>
          </div>
         <div class = "split-0"></div>
        <ul>
            <li><label class = "property" for = "captcha_product">В товаре</label>
                <input id = "captcha_product"
                       name = "captcha_product"
                       class = "order_inp"
                       type = "checkbox" value = "1"
                       {if $settings->captcha_product}checked = ""{/if} />
            </li>
            <li><label class = "property" for = "captcha_post">В статье блога</label>
                <input id = "captcha_post"
                       name = "captcha_post"
                       class = "order_inp"
                       type = "checkbox" value = "1"
                       {if $settings->captcha_post}checked = ""{/if} /></li>
            <li><label class = "property" for = "captcha_cart">В корзине</label>
                <input id = "captcha_cart"
                       name = "captcha_cart"
                       class = "order_inp"
                       type = "checkbox" value = "1"
                       {if $settings->captcha_cart}checked = ""{/if} /></li>
            <li><label class = "property" for = "captcha_register">В форме регистрации</label>
                <input
                        id = "captcha_register" name = "captcha_register" class = "order_inp" type = "checkbox"
                        value = "1" {if $settings->captcha_register}checked = ""{/if} /></li>
            <li><label class = "property" for = "captcha_feedback">В форме обратной связи</label>
                <input
                        id = "captcha_feedback" name = "captcha_feedback" class = "order_inp" type = "checkbox"
                        value = "1" {if $settings->captcha_feedback}checked = ""{/if} /></li>
        </ul>
    </div>

     <div class = "tabs-content">
          <div class = "center-h1">
        <h1>Формат цены</h1>
          </div>
          <div class = "split-0"></div>
        <ul class = "align-field width-max-field">
            <li><label for = "decimals_point" class = "property">Разделитель копеек</label>
                <select id = "decimals_point" name = "decimals_point" class = "order_inp">
                    <option value = '.'
                            {if $settings->decimals_point == '.'}selected{/if}>точка: 12.45 {$currency->sign|escape}</option>
                    <option value = ','
                            {if $settings->decimals_point == ','}selected{/if}>запятая: 12,45 {$currency->sign|escape}</option>
                </select>
            </li>
            <li><label for = "thousands_separator" class = "property">Разделитель тысяч</label>
                <select id = "thousands_separator" name = "thousands_separator" class = "order_inp">
                    <option value = ''
                            {if $settings->thousands_separator == ''}selected{/if}>без разделителя: 1245678 {$currency->sign|escape}</option>
                    <option value = ' '
                            {if $settings->thousands_separator == ' '}selected{/if}>пробел: 1 245 678 {$currency->sign|escape}</option>
                    <option value = ','
                            {if $settings->thousands_separator == ','}selected{/if}>запятая: 1,245,678 {$currency->sign|escape}</option>
                </select>
            </li>
        </ul>
    </div>
     <div class = "tabs-content">
         <div class = "center-h1">
            <h1>Настройки каталога</h1>
         </div>
         <ul class = "align-field width-middle-field">
            <li><label for = "products_num" class = "property">Товаров на странице сайта</label>
                <input id = "products_num" name = "products_num" class = "order_inp" type = "text"
                       value = "{$settings->products_num|escape}"/></li>
            <li><label for = "max_order_amount" class = "property">Максимум товаров в заказе</label>
                <input id = "max_order_amount" name = "max_order_amount" class = "order_inp" type = "text"
                       value = "{$settings->max_order_amount|escape}"/></li>
            <li><label for = "units" class = "property">Единицы измерения товаров</label>
                <input id = "units" name = "units" class = "order_inp" type = "text"
                       value = "{$settings->units|escape}"/></li>
            <li><label for = "comparison_count"
                       class = "property">Максимальное количество товаров в папке сравнения</label>
                <input id = "comparison_count" name = "comparison_count" class = "order_inp" type = "text"
                       value = "{$settings->comparison_count|escape}"/></li>
            <li><label for = "posts_num" class = "property">Статей на странице блога</label>
                <input id = "posts_num" name = "posts_num" class = "order_inp" type = "text"
                       value = "{$settings->posts_num|escape}"/></li>
            <li>
                <label for = "is_preorder" class = "property">Если нет в наличии
                    <div class = "helper_wrap">
                        <a href = "javascript:void(0)" id = "show_help_search" class = "helper_link"></a>
                        <div class = "right helper_block">
                        <span>
                            Выберите что происходит с товарами которых нет на складе.
                            Или они доступны под заказ, или отображаются что их нет в наличии
                        </span>
                        </div>
                    </div>
                </label>
                <select id = "is_preorder" name = "is_preorder">
                    <option value = "0" {if $settings->is_preorder == 0} selected = ""{/if}>Нет на складе</option>
                    <option value = "1" {if $settings->is_preorder == 1} selected = ""{/if}>Предзаказ</option>
                </select>
            </li>
        </ul>
    </div>
     <div class = "tabs-content">
         <div class = "center-h1">
            <h1>Настройки 1C</h1>
         </div>
         <div class = "split-0"></div>
        <ul class = "align-field width-middle-field">
            <li><label for = "login_1c" class = "property">Логин</label>
                <input id = "login_1c" name = "login_1c" class = "order_inp" type = "text"
                       value = "{$login_1c|escape}"/></li>
            <li><label for = "pass_1c" class = "property">Пароль</label>
                <input id = "pass_1c" name = "pass_1c" class = "order_inp" type = "text" value = ""/></li>
        </ul>
    </div>
     <div class = "tabs-content">
         <div class = "center-h1">
        <h1>Изображения товаров</h1>
         </div>
        <ul class = "align-field set-field-watermark">
            <li><label for = "watermark_offset_x" class = "property">Горизонтальное положение водяного знака</label>
                <input id = "watermark_offset_x" name = "watermark_offset_x" class = "order_inp" type = "text"
                       value = "{$settings->watermark_offset_x|escape}"/> %</li>
            <li><label for = "watermark_offset_y" class = "property">Вертикальное положение водяного знака</label>
                <input id = "watermark_offset_y" name = "watermark_offset_y" class = "order_inp" type = "text"
                       value = "{$settings->watermark_offset_y|escape}"/> %</li>
            <li><label for = "watermark_transparency" class = "property">Прозрачность знака (больше &mdash;
                                                                       прозрачней)</label>
                <input id = "watermark_transparency" name = "watermark_transparency" class = "order_inp" type = "text"
                       value = "{$settings->watermark_transparency|escape}"/> %</li>
            <li><label for = "images_sharpen" class = "property">Резкость изображений (рекомендуется 20%)</label>
                <input id = "images_sharpen" name = "images_sharpen" class = "order_inp" type = "text"
                       value = "{$settings->images_sharpen|escape}"/> %</li>
            <li><label class = "property">Водяной знак</label>
            <input name = "watermark_file" class = "order_inp" type = "file"/>
            </li>
        </ul>
         <img style = 'display:block; border:1px solid #d0d0d0; margin:10px 0 10px 0;'
              src = "{$config->root_url}/{$config->watermark_file}?{math equation='rand(10,10000)'}">
    </div>
     <div class = "tabs-content">
         <div class = "center-h1">
        <h1>Настройки экспорта в яндекс</h1>
            <div class = "helper_wrap">
                <a class = "top_help" id = "show_help_search" href = "https://www.youtube.com/watch?v=9eO8CsSvfqg"
                   target = "_blank"></a>
                <div class = "right helper_block topvisor_help">
                    <p>Видеоинструкция по данному функционалу</p>
                </div>
            </div>
         </div>
        <ul class = "yandex_list align-field">
            <li>
                <label class = "property" for = "yandex_export_not_in_stock">Экспортировать со статусом "под заказ" товары, отсутствующие на складе</label>
                <input id = "yandex_export_not_in_stock" name = "yandex_export_not_in_stock" class = "order_inp"
                       type = "checkbox" {if $settings->yandex_export_not_in_stock}checked = ""{/if} />
            </li>
            <li>
                <label class = "property"
                       for = "yandex_available_for_retail_store">Можно купить в розничном магазине</label>
                <input id = "yandex_available_for_retail_store" name = "yandex_available_for_retail_store"
                       class = "order_inp" type = "checkbox"
                       {if $settings->yandex_available_for_retail_store}checked = ""{/if} />
            </li>
            <li>
                <label class = "property" for = "yandex_available_for_reservation">Можно зарезервировать выбранный товар и забрать его самостоятельно.</label>
                <input id = "yandex_available_for_reservation" name = "yandex_available_for_reservation"
                       class = "order_inp" type = "checkbox"
                       {if $settings->yandex_available_for_reservation}checked = ""{/if} />
            </li>
            <li>
                <label for = "yandex_short_description" class = "property">Выводить в ЯндексМаркет краткое или полное описание товара(0-краткое, 1-полное)</label>
                <input id = "yandex_short_description" name = "yandex_short_description" class = "order_inp"
                       type = "checkbox" {if $settings->yandex_short_description}checked = ""{/if} />
            </li>
            <li>
                <label class = "property"
                       for = "yandex_has_manufacturer_warranty">У товаров есть гарантия производителя</label>
                <input id = "yandex_has_manufacturer_warranty" name = "yandex_has_manufacturer_warranty"
                       class = "order_inp" type = "checkbox"
                       {if $settings->yandex_has_manufacturer_warranty}checked = ""{/if} />
            </li>
            <li>
                <label class = "property" for = "yandex_has_seller_warranty">У товаров есть гарантия продавца</label>
                <input id = "yandex_has_seller_warranty" name = "yandex_has_seller_warranty" class = "order_inp"
                       type = "checkbox" {if $settings->yandex_has_seller_warranty}checked = ""{/if} />
            </li>
            <li>
                <label class = "property" for = "yandex_sales_notes">sales_notes
                    <div class = "helper_wrap">
                        <a href = "javascript:void(0)" id = "show_help_search" class = "helper_link"></a>
                        <div class = "right helper_bottom helper_block" style = "width: 546px;">
                                <b>Используйте элемент sales_notes для указания следующей информации:</b>
                                    <ol style = "list-style-type: decimal">
                                        <li>минимальная сумма заказа (указание элемента обязательно);</li>
                                        <li>минимальная партия товара (указание элемента обязательно);</li>
                                        <li>необходимость предоплаты (указание элемента обязательно);</li>
                                        <li>варианты оплаты (указание элемента необязательно);</li>
                                        <li>условия акции (указание элемента необязательно).</li>
                                    </ol>
                                    Допустимая длина текста в элементе — 50 символов.
                        </div>
                    </div>
                </label>
                <input id = "yandex_sales_notes" name = "yandex_sales_notes" class = "order_inp" type = "text"
                       value = "{$settings->yandex_sales_notes}"/>
            </li>
        </ul>
    </div>
     <div class = "tabs-content">
         <div class = "center-h1">
        <h1>Настройка Google аналитики</h1>
            <div class = "helper_wrap">
                <a href = "javascript:" id = "show_help_search" class = "helper_link"></a>
                <div class = "right helper_bottom helper_block" style = "width: 446px;">
                    <span>
                        <b>Google Analytics ID</b> - прописывается ID счетчика, в формате (UA-xxxxxxxx-x)
                        <b>Google Webmaster</b> - прописывается только содержимое атрибута content (786f3d0f736b732c)
                        <br>пример: <br>meta name='google-site-verification' content='<i style = "font-weight: bold">786f3d0f736b732c</i>'
                    </span>
                </div>
            </div>
            </div>
        <ul>
            <li>
                <label for = "g_analytics" class = "property">Google Analytics ID</label>
                <input id = "g_analytics" type = "text" name = "g_analytics" value = "{$settings->g_analytics}"
                       class = "order_inp">
            </li>
            <li>
                <label for = "g_webmaster" class = "property">Google Webmaster</label>
                <input id = "g_webmaster" type = "text" name = "g_webmaster" value = "{$settings->g_webmaster}"
                       class = "order_inp">
            </li>
        </ul>
    </div>
     <div class = "tabs-content">
           <div class = "center-h1">
        <h1>Яндекс метрика</h1>
            <div class = "helper_wrap">
                <a href = "javascript:void(0)" id = "show_help_search" class = "helper_link"></a>
                <div class = "right helper_bottom helper_block" style = "width: 446px;">
                    <span>
                        <b>Yandex метрика</b> - прописывается числовой код метрики (ID)
                        <b>Yandex вебмастер</b> - прописывается только содержимое атрибута content (786f3d0f736b732c)
                        <br>пример: <br>meta name='yandex-verification' content='<i style = "font-weight: bold">786f3d0f736b732c</i>'

                    </span>
                </div>
            </div>
            <div class = "helper_wrap">
                <a class = "top_help" id = "show_help_search" href = "https://www.youtube.com/watch?v=8IVMhLKSMKA"
                   target = "_blank"></a>
                <div class = "right helper_block topvisor_help">
                    <p>Видеоинструкция по данному функционалу</p>
                </div>
            </div>
     </div>
        <ul>
            <li>
                <label for = "yandex_metrika_app_id" class = "property">ID приложения</label>
                <input id = "yandex_metrika_app_id" name = "yandex_metrika_app_id" class = "order_inp" type = "text"
                       value = "{$settings->yandex_metrika_app_id|escape}"/>
            </li>
            <li>
                <label for = "yandex_metrika_token" class = "property">Токен</label>
                <input id = "yandex_metrika_token" name = "yandex_metrika_token" class = "order_inp" type = "text"
                       value = "{$settings->yandex_metrika_token|escape}"/>
            </li>
            <li>
                <label for = "yandex_metrika_counter_id" class = "property">ID счётчика</label>
                <input id = "yandex_metrika_counter_id" name = "yandex_metrika_counter_id" class = "order_inp"
                       type = "text" value = "{$settings->yandex_metrika_counter_id|escape}"/>
            </li>
            <li>
                <label for = "y_webmaster" class = "property">Yandex вебмастер</label>
                <input id = "y_webmaster" type = "text" name = "y_webmaster" value = "{$settings->y_webmaster}"
                       class = "order_inp">
            </li>
        </ul>
        <div>
            <h4 class = "fn-helper">Инструкция по настройке поключения Я.Метрики &#8659;</h4>
            <div class = "ya_metrica_helper" style = "display: none;">
                <p>Подключение статистики яндекс метрики к административной части AlexShopCMS</p>
                <ul>
                    <li>
                        Шаг 1. Необходимо зайти на ссылку <a target = "_blank" href = "https://oauth.yandex.ru">https://oauth.yandex.ru</a>
                    </li>
                    <li>
                        Шаг 2. Нажать кнопку «Зарегистрировать приложение»
                    </li>

                    <li>
                        Шаг 3. Ввести следующие данные:<br>
                        <b>Название:</b> YandexMetrikaAPI<br>
                        <b>Описание:</b> Приложение для доступа к API метрики с AlexShopCMS<br>
                        <b>Иконка:</b> Пусто<br>
                        <b>Ссылка на сайт приложения:</b> Пусто<br>
                        <b>Права:</b> Выбираем пункт Яндекс.Метрика и отмечаем галочкой
                        Получение статистики, чтение параметров своих и доверенных счётчиков<br>
                        <b>Callback URL:</b> https://oauth.yandex.ru/verification_code
                    </li>
                    <li>
                        Шаг 4. Нажимаем «Сохранить»
                    </li>
                    <li>
                        Шаг 5. На открывшейся странице копируем ID приложения и сохраняем его в настройках Яндекс
                        Метрики в административной части
                    </li>
                    <li>
                        Шаг 6. Авторизуемся на Яндексе под учетной записью пользователя, от имени которого будет
                        работать приложение
                    </li>
                    <li>
                        Шаг 7. Переходим по URL:
                        <a target = "_blank"
                           href = "https://oauth.yandex.ru/authorize?response_type=token&client_id=<идентификатор приложения>">https://oauth.yandex.ru/authorize?response_type=token&client_id=идентификатор приложения
                        </a>
                         ,где   <b>идентификатор приложения</b> - ранее полученный ID
                        <br>
                        <i><b>
                            Пример:
                            https://oauth.yandex.ru/authorize?response_type=token&client_id=
                            a4e35e82346a4264abdaa54aff04a143
                        </b></i>
                    </li>
                    <li>
                        Шаг 8. Приложение запросит разрешение на доступ, которое нужно предоставить, нажав «Разрешить»
                    </li>
                    <li>
                        Шаг 9 . Сохранить полученный токен в настройки Яндекс Метрики, в административную часть на
                        сайте.
                    </li>
                </ul>
            </div>
        </div>
</div>
    <input class = "button_green button_save" type = "submit" name = "save" value = "Сохранить"/>
</form>
 </div>
<script>
    //табы
    (function ($) {
        $(function () {
            $('ul.tabs-caption').delegate('li:not(.current)', 'click', function () {
                $(this).addClass('current').siblings().removeClass('current')
                    .parents('div.tabs-section').find('div.box').hide().eq($(this).index()).fadeIn(150);
            })

        })
    })(jQuery);

    (function ($) {
        $(function () {

            $('ul.tabs-caption').each(function (i) {
                var storage = localStorage.getItem('tab' + i);
                if (storage) {
                    $(this).find('li').removeClass('active').eq(storage).addClass('active')
                        .closest('div.tabs-section').find('div.tabs-content').removeClass('active').eq(storage).addClass('active');
                }
            });

            $('ul.tabs-caption').on('click', 'li:not(.active)', function () {
                $(this)
                    .addClass('active').siblings().removeClass('active')
                    .closest('div.tabs-section').find('div.tabs-content').removeClass('active').eq($(this).index()).addClass('active');
                var ulIndex = $('ul.tabs-caption').index($(this).parents('ul.tabs-caption'));
                localStorage.removeItem('tab' + ulIndex);
                localStorage.setItem('tab' + ulIndex, $(this).index());
            });

        });
    })(jQuery);

    $(window).on('load', function () {
        $('.fn-helper').on('click', function () {
            $(this).next().slideToggle(500);
        });
    })
</script>
