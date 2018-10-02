{* Страница отдельной записи блога *}

{* Канонический адрес страницы *}
{$canonical="/blog/{$post->url}" scope=parent}

<article class="post">

                        <div class="post-inner">
                            <h3 class="post-title" data-post="{$post->id}">{$post->name|escape}</h3>
                            <ul class="post-meta">
                                <li><i class="fa fa-calendar"></i><a href="">{$post->date|date}</a>
                                </li>
                                <li><i class="fa fa-comments"></i><a href="{url}#comments">{$comments|count} {$comments|count|plural:'комментарий':'комментариев':'комментария'}</a>
                                </li>
                            </ul>
                            <div class="gap gap-mini"></div>
<!-- Тело поста /-->
{$post->text}
                        </div>
                    </article>


<!-- Соседние записи /-->
<div id="back_forward">
	{if $prev_post}
		←&nbsp;<a class="prev_page_link" href="blog/{$prev_post->url}">{$prev_post->name}</a>
	{/if}
	{if $next_post}
		<a class="next_page_link" href="blog/{$next_post->url}">{$next_post->name}</a>&nbsp;→
	{/if}
</div>
                    <div class="gap gap-small"></div>
<!-- Комментарии -->
<div id="comments">

	<h2>Комментарии</h2>
	
	{if $comments}
	<!-- Список с комментариями -->
	<ul class="comments-list">
		{foreach $comments as $comment}
		<a name="comment_{$comment->id}"></a>
		<li>
		<article class="comment">
                                <div class="comment-inner"><span class="comment-author-name">{$comment->name|escape}</span>
                                    <p class="comment-content">{$comment->text|escape|nl2br}</p>
                                    <span class="comment-time">{$comment->date|date}, {$comment->date|time}{if !$comment->approved} - <b>ожидает модерации</b>{/if}</span>
                                </div>
                            </article>
		</li>
		{/foreach}
	</ul>
	<!-- Список с комментариями (The End)-->
	{else}
	<p>
		Пока нет комментариев
	</p>
	{/if}
	
	<!--Форма отправления комментария-->
		<h2>Написать комментарий</h2>
<form method="post" action="">
		{if $error}
		<div class="message_error">
			{if $error=='captcha'}
			Неверно введена капча
			{elseif $error=='empty_name'}
			Введите имя
			{elseif $error=='empty_comment'}
			Введите комментарий
			{/if}
		</div>
		{/if}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Имя</label>
                                    <input  type="text" id="comment_name"  placeholder="Введите ваше имя" name="name" value="{$comment_name|escape}" data-format=".+" data-notice="Введите имя" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label> </label>
                                   <div class="captcha"><img src="captcha/image.php?{math equation='rand(10,10000)'}"/></div>
                                </div>
                            </div>
                             <div class="col-md-2">
                                <div class="form-group">
                                    <label> </label>
                                    <input class="form-control" id="comment_captcha" type="text" name="captcha_code" placeholder="Число" value="" data-format="\d\d\d\d" data-notice="Введите капчу"/>
                                </div>
                            </div>                           
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Комментарий</label>
                                    <textarea class="form-control" id="comment_text"  placeholder="Ваш комментарий" name="text" data-format=".+" data-notice="Введите комментарий">{$comment_text}</textarea>
                                </div>
                            </div>
                        </div>
                        <input type="submit" name="comment" value="Отправить" class="btn btn-primary">
                    </form>
	<!--Форма отправления комментария (The End)-->
	
</div>
<!-- Комментарии (The End) -->