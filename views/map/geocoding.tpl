{include file="partials/header.tpl"}

<form>
	<input type="text" size="50" name="address" value="{$address}">
	<input type="submit" value="OK">
</form>

{Utils::debug($result)}

{include file="partials/footer.tpl"}