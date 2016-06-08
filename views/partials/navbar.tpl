	<div class="blog-masthead">
		<div class="container">
			<nav class="navbar navbar-default blog-nav">
				<div class="container-fluid">

					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
							<span class="sr-only">Navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="{$HTTP_ROOT}" title="{$website_title}" data-active="#home">Blog</a>
					</div>

					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav blog-nav">
						{foreach $pages as $page_url => $page}
							{assign var=isCurrentPage value=$page_url == $current_page || $page_url == $target || $page_url == "$target/$action"}
							{if !is_array($page)}
							<li class="{if $isCurrentPage}active{/if}"><a id="{Utils::cleanString($page_url)}" class="blog-nav-item" href="{$HTTP_ROOT}{$page_url}">{$page}</a></li>
							{else}
							<li class="dropdown{if $isCurrentPage} active{/if}">
								<a href="{$page_url}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{$page[0]} <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									{foreach $page[1] as $subpage_url => $subpage}
									<li><a href="{$HTTP_ROOT}{$subpage_url}">{$subpage}</a></li>
									<!--<li role="separator" class="divider"></li>-->
									{/foreach}
								</ul>
							</li>
							{/if}
						{/foreach}

						{if !empty($user) && User::isLogged()}
							{t}Logged as{/t} {$user->firstname}
							<li{if $current_page == 'user/logout/'} class="active"{/if}><a href="{$HTTP_ROOT}logout" class="blog-nav-item">{t}Logout{/t}</a></li>
						{else}
							<li{if $current_page == 'user/login/'} class="active"{/if}><a href="{$HTTP_ROOT}login" class="blog-nav-item">{t}Login{/t}</a></li>
							<li{if $current_page == 'user/register/'} class="active"{/if}><a href="{$HTTP_ROOT}register" class="blog-nav-item">{t}Register{/t}</a></li>
						{/if}
						</ul>

						<form action="{$HTTP_ROOT}search" class="navbar-form navbar-left blog-nav" role="search" method="GET">
							<div class="input-group">
								<input type="text" name="q" class="form-control" placeholder="{t}Search{/t}...">
								<span class="input-group-btn">
									<button class="btn btn-default" type="submit" data-active="#search"><i class="fa fa-search"></i></button>
								</span>
							</div><!-- /input-group -->
						</form>

						<ul class="nav navbar-nav navbar-right blog-nav">
							<li{if $lang == 'fr'}  class="active"{/if}><a href="{$HTTP_ROOT}../fr/{$current_page}{$querystring}" class="blog-nav-item">FR</a></li>
							<li role="separator" class="divider"></li>
							<li{if $lang == 'en'} class="active"{/if}><a href="{$HTTP_ROOT}../en/{$current_page}{$querystring}" class="blog-nav-item">EN</a></li>
						</ul>
					</div><!-- /.navbar-collapse -->
				</div><!-- /.container-fluid -->
			</nav>
		</div>
	</div>