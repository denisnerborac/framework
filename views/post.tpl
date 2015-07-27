{include file="partials/header.tpl"}

		<div class="blog-header">
			<h1 class="blog-title">{$title}</h1>
			<p class="lead blog-description">{$description}</p>
		</div>

		<div class="row">

			<div class="col-sm-8 blog-main">

				<a href="{if !empty($referer)}{$referer}{else}{$HTTP_ROOT}{/if}" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span> {t}Back to posts{/t}</a>
				<br><br>

				<div class="blog-post">
					<h2 class="blog-post-title">{$post->title}</h2>
					<p class="blog-post-meta">{$post->date} {t}by{/t} <a href="#">{$post->author}</a></p>

					<p>{$post->content|nl2br}</p>
				</div><!-- /.blog-post -->

			</div><!-- /.blog-main -->

			{include file="partials/sidebar.tpl"}

		</div><!-- /.row -->

{include file="partials/footer.tpl"}