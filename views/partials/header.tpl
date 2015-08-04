{if empty($isAjax)}
<!DOCTYPE html>
<html lang="{$lang}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="{$website_description}">
	<meta name="author" content="{$author}">

	<title>{$website_title} - {$title}</title>

	<link rel="stylesheet" href="{$CSS_ROOT}{if !empty($current_theme)}themes/{$current_theme}/{/if}bootstrap.min.css">
	{if empty($current_theme)}
	<link rel="stylesheet" href="{$CSS_ROOT}bootstrap-theme.min.css">
	<link rel="stylesheet" href="{$CSS_ROOT}styles.css">
	{/if}
	<link rel="stylesheet" href="{$CSS_ROOT}font-awesome.min.css">
	<link rel="stylesheet" href="{$CSS_ROOT}reset.css">

</head>

<body>

	{include file="partials/navbar.tpl"}

	<div id="main-container" class="container blog-content">
{/if}