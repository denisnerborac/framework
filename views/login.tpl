{include file="partials/header.tpl"}

	<div class="blog-header">
		<h1 class="blog-title">{$title}</h1>
		<p class="lead blog-description">{$description}</p>
	</div>

	<div class="row">

		<div class="col-sm-8 blog-main">

			{if $success}
				<div class="alert alert-success" role="success">Authentification réussie</div>
				{Utils::redirectJS('index.php', 2)}
			{/if}

			{$form}

		</div>

	</div>

{include file="partials/footer.tpl"}