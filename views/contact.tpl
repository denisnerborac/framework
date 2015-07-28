{include file="partials/header.tpl"}

		<div class="blog-header">
			<h1 class="blog-title">{$title}</h1>
			<p class="lead blog-description">{$description}</p>
		</div>

		<div class="row">

			{if !empty($errors)}
			<div class="alert alert-danger" role="danger">{t}Please fix the following errors{/t}</div>
			{/if}

			{if !empty($isPost) && !empty($success)}
				<div class="alert alert-success" role="success">{t}Your message was sent succesfully, you will be redirected in 3 seconds...{/t}</div>
				{Utils::redirectJS($HTTP_ROOT, 3)}
			{/if}

			{if isset($form) && empty($success)}
				{$form}
			{/if}

		</div><!-- /.row -->

{include file="partials/footer.tpl"}