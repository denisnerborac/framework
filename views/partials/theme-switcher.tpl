	<form id="form-theme-select" method="GET">
	  <div class="form-group">
		<select id="theme-select" name="theme" class="form-control" onchange="$('#form-theme-select').submit();">
			<option value="">Theme</option>
			{foreach $themes as $theme_path}
			<option value="{$theme_path|basename}"{if basename($theme_path) == $current_theme} selected="selected"{/if}>{$theme_path|basename}</option>
			{/foreach}
		</select>
	  </div>
	</form>