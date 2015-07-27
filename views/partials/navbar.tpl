	<div class="blog-masthead">
		<div class="container">
			<nav class="nav navbar-nav blog-nav">
				{foreach from=$pages item=page}
				<a class="blog-nav-item {if $page.url == $current_page || $page.url == $target || $page.url == "$target/$action"}active{/if}" href="{$HTTP_ROOT}{$page.url}">{$page.name}</a>
				{/foreach}
			</nav>

			<nav class="nav navbar-nav navbar-right blog-nav">
				{if !empty($user) && User::isLogged()}
					{t}Logged as{/t} {$user->firstname}
					<a href="{$HTTP_ROOT}logout" class="blog-nav-item{if $current_page == 'user/logout/'} active{/if}">{t}Logout{/t}</a>&nbsp;|&nbsp;
				{else}
					<a href="{$HTTP_ROOT}login" class="blog-nav-item{if $current_page == 'user/login/'} active{/if}">{t}Login{/t}</a>
					<a href="{$HTTP_ROOT}register" class="blog-nav-item{if $current_page == 'user/register/'} active{/if}">{t}Register{/t}</a>&nbsp;|&nbsp;
				{/if}

				<a href="{$HTTP_ROOT}../fr/{$current_page}{$querystring}" class="blog-nav-item{if $lang == 'fr'} active{/if}">FR</a>
				<a href="{$HTTP_ROOT}../en/{$current_page}{$querystring}" class="blog-nav-item{if $lang == 'en'} active{/if}">EN</a>
			</nav>
		</div>
	</div>