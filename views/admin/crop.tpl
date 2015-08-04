{include file="admin/partials/header.tpl"}

<style type="text/css">
.jcrop-holder #preview-pane {
	display: block;
	position: absolute;
	z-index: 2000;
	top: 10px;
	right: -280px;
	padding: 6px;
	border: 1px rgba(0,0,0,.4) solid;
	background-color: white;

	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;

	-webkit-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
	-moz-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
	box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
}

#preview-pane .preview-container {
	width: {$thumb_width}px;
	height: {$thumb_height}px;
	overflow: hidden;
}

.clearfix {
	clear: both;
}

</style>


<div class="container">
	<div class="row">

				<form id="form-crop" name="form-crop" method="POST">

					<input type="hidden" id="x" name="x" />
					<input type="hidden" id="y" name="y" />
					<input type="hidden" id="w" name="w" />
					<input type="hidden" id="h" name="h" />

					<img src="{$IMG_ROOT}/image.jpg" id="target" alt="" />

					<div id="preview-pane">
						<div class="preview-container">
							<img src="{$IMG_ROOT}/image.jpg" class="jcrop-preview" alt="Preview" />
						</div>
					</div>

					<br />

					<input type="submit" value="Recadrer" class="btn btn-primary" />

				</form>

				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>

{include file="admin/partials/footer.tpl"}