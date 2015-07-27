{include file="partials/header.tpl"}

	<div class="blog-header">
		<h1 class="blog-title">{$title}</h1>
		<p class="lead blog-description">{$description}</p>
	</div>

	<div class="row">

		<div class="col-sm-8 blog-main">

			{if !empty($isPost)}
				{if !empty($success)}
					<div class="alert alert-success" role="success">{t}{$title} success{/t}</div>
					{Utils::redirectJS($HTTP_ROOT, 1)}
				{/if}

				{if !empty($errors)}
				<div class="alert alert-danger" role="danger">{t}{$title} failed{/t}</div>
				{/if}
			{/if}

			{if isset($form) && empty($success)}
				{$form}
			{/if}

		</div>

	</div>

{include file="partials/footer.tpl"}