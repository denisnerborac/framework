<!DOCTYPE html>
<html lang="{$lang}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="{$website_description}">
	<meta name="author" content="{$author}">

	<title>{$website_title} - {$title}</title>

	<link rel="stylesheet" href="{$CSS_ROOT}bootstrap.min.css">
	<link rel="stylesheet" href="{$CSS_ROOT}bootstrap-theme.min.css">
	<link rel="stylesheet" href="{$CSS_ROOT}styles.css">
</head>

<body>

	<div class="blog-masthead">
		<div class="container">
			<nav class="nav navbar-nav blog-nav">
				{foreach from=$pages item=page}
				<a class="blog-nav-item {if $page.url == $current_page || $page.url == $target || $page.url == "$target/$action"}active{/if}" href="{$HTTP_ROOT}{$page.url}">{$page.name}</a>
				{/foreach}
			</nav>

			<nav class="nav navbar-nav navbar-right blog-nav">
				<a href="{$HTTP_ROOT}../fr/{$current_page}{$querystring}" class="blog-nav-item{if $lang == 'fr'} active{/if}">FR</a>
				<a href="{$HTTP_ROOT}../en/{$current_page}{$querystring}" class="blog-nav-item{if $lang == 'en'} active{/if}">EN</a>
			</nav>
		</div>
	</div>

	<div class="container blog-content">