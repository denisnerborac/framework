{include file="partials/header.tpl"}

		<div class="blog-header">
			<h1 class="blog-title">{$title}</h1>
			<p class="lead blog-description">{$description}</p>
		</div>

		<div class="row">

			<div class="col-sm-8 blog-main">

				<!--<h1>{t count=$count_total|@count 1=$count_total|@count plural="%1 posts"}One post{/t}</h1>-->
				<h1>{if $count_total == 0}{t}No post{/t}{else}{$count_total} {if $count_total > 1}{t}posts{/t}{else}{t}post{/t}{/if}{/if}</h1>

				<hr>

				{include file="partials/post-list-item.tpl"}

				{include file="partials/pagination.tpl"}

			</div><!-- /.blog-main -->

			{include file="partials/sidebar.tpl"}

		</div><!-- /.row -->

{include file="partials/footer.tpl"}
