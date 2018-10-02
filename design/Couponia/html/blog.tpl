{* Список записей блога *}

{* Канонический адрес страницы *}
{$canonical="/blog" scope=parent}

<!-- Заголовок /-->
<h1>{$page->name}</h1>

{include file='pagination.tpl'}

<!-- Статьи /-->

	{foreach $posts as $post}
<article class="post">
                        <header class="post-header">

                        </header>
                        <div class="post-inner">
                            <h4 class="post-title"><a data-post="{$post->id}" href="blog/{$post->url}">{$post->name|escape}</a></h4>
                            <ul class="post-meta">
                                <li><i class="fa fa-calendar"></i><a href="blog/{$post->url}">{$post->date|date}</a>
                                </li>
                            </ul>
                            <p class="post-desciption">{$post->annotation}</p>
                            <a class="btn btn-small btn-primary" href="blog/{$post->url}">Читать далее</a>
                        </div>
                    </article>	
	{/foreach}

<!-- Статьи #End /-->    

{include file='pagination.tpl'}
          