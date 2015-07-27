{include file="partials/header.tpl"}

		<div class="blog-header">
			<h1 class="blog-title">{t}Search{/t}</h1>
			<p class="lead blog-description">...</p>
		</div>

		<div class="row">

			<div class="col-sm-8 blog-main">

				<form action="{$HTTP_ROOT}search/results" method="GET">
					<div class="input-group">
						<input name="q" type="text" class="form-control" placeholder="{t}Search{/t}..." value="{$search_query}">
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit">
								<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
							</button>
						</span>
					</div>
				</form>

				{if !empty($search_query)}

				<hr>

				<h1>{if $count_total == 0}{t}No result{/t}{else}{$count_total} {if $count_total > 1}{t}results{/t}{else}{t}result{/t}{/if}{/if} {t}for the search{/t} "{$search_query}"</h1>

				<hr>

				{include file="partials/post-list-item.tpl"}

				{include file="partials/pagination.tpl" querystring="?q={$search_query}"}

				{/if}

			</div><!-- /.blog-main -->

			{include file="partials/sidebar.tpl"}

		</div><!-- /.row -->

{include file="partials/footer.tpl"}