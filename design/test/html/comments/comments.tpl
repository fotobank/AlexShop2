<div class="col-lg-7">
{* Рекурсивная функция вывода дерева комментариев *}
{function name=comments_tree}
	{if $comments}
		<ul class="fa-ul comments">
		{foreach $comments as $comment}
			{* Показываем только одобренные *}
			{if $comment->approved}
				<li class="comment {if $comment->admin}admin{/if}">
					<div class="head">

                <span class="name"><i class="fa fa-user"></i><span>{$comment->name|escape}</span></span>
                <span class="date"><i class="fa fa-calendar"></i><time>{$comment->date|date}, {$comment->date|time}</time></span>

					</div>
					<div class="text">{$comment->text|escape|nl2br}</div>
					<div class="foot">
						<a data-form="#comment-answer-{$comment->id}" href="ajax/comment.form.php?parent={$comment->id}&type={$comment->type}&object_id={$comment->object_id}"
                           class="dotted comment-answer">/ <em>ответить</em>  / </a>
						<span class="comment-rate">
                            <small>полезен отзыв?</small>
							<a href="ajax/comment.rate.php?id={$comment->id}&rate=up" class="rate-comment true"><i class="fa fa-thumbs-o-up"></i> (<span id="star-five">{$comment->rate_up}</span>)</a>
							<a href="ajax/comment.rate.php?id={$comment->id}&rate=down" class="rate-comment false"><i class="fa fa-thumbs-o-down"></i> (<span>{$comment->rate_down}</span>)</a>
						</span>
					</div>
					<ul class="ul comments" id="comment-answer-{$comment->id}"></ul>
					{comments_tree comments=$comment->children}
					{$child=1}
				</li>
			{/if}
		{/foreach}
		</ul>
	{/if}
{/function}
    {$comments|@debug_print_var}
{comments_tree comments=$comments}
{if !$comments}<ul class="ul comments"><small>Пока что комментариев нет. Будьте первыми!</small></ul>{/if}
</div>