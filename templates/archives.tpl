{include file="partials/header.tpl"}

		<div class="blog-header">
			<h1 class="blog-title">{t}Archives{/t}</h1>
			<p class="lead blog-description">...</p>
		</div>

		<div class="row">

			<div class="col-sm-8 blog-main">

				<hr>

				<h1>{if $count_total == 0}{t}No post{/t}{else}{$count_total} {if $count_total > 1}{t}posts{/t}{else}{t}post{/t}{/if}{/if} {t}in{/t} {$date_label}</h1>

				<hr>

				{include file="partials/post-list-item.tpl"}

				{include file="partials/pagination.tpl" uri="{$uri}{$date}/"}

			</div><!-- /.blog-main -->

			{include file="partials/sidebar.tpl"}

		</div><!-- /.row -->

{include file="partials/footer.tpl"}