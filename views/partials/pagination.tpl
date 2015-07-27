				{if !isset($uri)}
				{assign var="uri" value=""}
				{/if}
				{if !isset($querystring)}
				{assign var="querystring" value=""}
				{/if}
				{if !isset($count_visible_pages)}
				{assign var="count_visible_pages" value="3"}
				{/if}

				{if $count_pages > 0}
				<nav>
					<ul class="pagination">
						{if $page > 1}
						<li><a href="{$uri}1{$querystring}" title="{t}First{/t}"><span class="glyphicon glyphicon-fast-backward"></span></a></li>
						<li><a href="{$uri}{$page - 1}{$querystring}" title="{t}Previous{/t}"><span class="glyphicon glyphicon-chevron-left"></span></a></li>
						{if $page > $count_visible_pages + 1}
						<li><a href="{$uri}1{$querystring}">1...</a></li>
						{/if}
						{/if}

						{for $i=max(1, $page - $count_visible_pages) to min($count_pages, $page + $count_visible_pages)}
						{if $i == $page}
						<li class="active"><a>{$i}</a></li>
						{else}
						<li><a href="{$uri}{$i}{$querystring}" title="{t}Page{/t} {$i}">{$i}</a></li>
						{/if}
						{/for}

						{if $page < $count_pages}
						{if $page < $count_pages - $count_visible_pages}
						<li><a href="{$uri}{$count_pages}{$querystring}">...{$count_pages}</a></li>
						{/if}
						<li><a href="{$uri}{$page + 1}{$querystring}" title="{t}Next{/t}"><span class="glyphicon glyphicon-chevron-right"></span></a></li>
						<li><a href="{$uri}{$count_pages}{$querystring}" title="{t}Last{/t}"><span class="glyphicon glyphicon-fast-forward"></span></a></li>
						{/if}
					</ul>
				</nav>
				{/if}