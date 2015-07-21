			<div class="col-sm-3 col-sm-offset-1 blog-sidebar">
				<div class="sidebar-module sidebar-module-inset well">
					<h4>About</h4>
					<p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
				</div>

				{if isset($archives_dates)}
				<div class="sidebar-module">
					<h4>Archives</h4>
					<ol class="list-unstyled">
						{foreach from=$archives_dates key=date item=date_label}
						<li><a href="{$HTTP_ROOT}post/archives/{$date}">{$date_label}</a></li>
						{/foreach}
					</ol>
				</div>
				{/if}

			</div><!-- /.blog-sidebar -->