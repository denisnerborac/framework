				{if !empty($posts)}
				{foreach from=$posts item=post}
				<div class="blog-post">
					<h2 class="blog-post-title"><a href="{$HTTP_ROOT}post/view/{$post.id}">{$post.title}</a></h2>
					<p class="blog-post-meta">{$post.date|date_format:"%d-%m-%Y %H:%M:%S"} {t}by{/t} <a href="#">{$post.author}</a></p>

					<blockquote>
						{Utils::cutString($post.content, 100, ' [...]')|nl2br}
						{if strlen($post.content) > 100}
						<br><a href="{$HTTP_ROOT}post/view/{$post.id}">{t}Read more{/t}</a>
						{/if}
					</blockquote>
				</div><!-- /.blog-post -->
				{/foreach}
				{/if}