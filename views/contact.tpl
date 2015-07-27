{include file="partials/header.tpl"}

		<div class="blog-header">
			<h1 class="blog-title">{$title}</h1>
			<p class="lead blog-description">{$description}</p>
		</div>

		<div class="row">

			{if isset($form)}
			{$form}
			{/if}

			{if isset($redirectJS)}
			<div class="alert alert-success" role="alert">
			{t}Your message was sent succesfully, you will be redirected in 3 seconds...{/t}
			</div>
			{$redirectJS}
			{/if}

		</div><!-- /.row -->

{include file="partials/footer.tpl"}