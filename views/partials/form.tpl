		<form id="{$id}" name="{$name}" class="{$class}" action="{$action}" method="{$method}" novalidate>

			{section name=id loop=$hidden_fields}
				<input type="{$hidden_fields[id]->type}" name="{$hidden_fields[id]->name}" value="{$hidden_fields[id]->value}" />
			{/section}

			{section name=key loop=$fields}

				<div class="form-group{if !empty($isSubmit)}{if !empty($fields[key]->error)} has-error{else} has-success{/if}{/if}">

					{if $fields[key]->type == 'text' ||
						$fields[key]->type == 'email' ||
						$fields[key]->type == 'date' ||
						$fields[key]->type == 'password'}
					<label for="{$fields[key]->name}" class="col-sm-2 control-label">{$fields[key]->label}</label>
					<div class="col-sm-10">
						<input type="{$fields[key]->type}" class="form-control{if $fields[key]->required} required{/if}{$fields[key]->class}" id="{$fields[key]->name}" name="{$fields[key]->name}" {if isset($fields[key]->maxlength) && $fields[key]->maxlength > 0} maxlength="{$fields[key]->maxlength}"{/if} placeholder="{$fields[key]->label}" value="{$fields[key]->value}">
					</div>
					{/if}

					{if $fields[key]->type == 'checkbox'}
					<div class="col-sm-offset-2 col-sm-10">
						<div class="checkbox">
							<label>
								<input type="{$fields[key]->type}" class="{if $fields[key]->required} required{/if}{$fields[key]->class}" id="{$fields[key]->name}" name="{$fields[key]->name}" {if isset($fields[key]->maxlength) && $fields[key]->maxlength > 0} maxlength="{$fields[key]->maxlength}"{/if} value="1"{if $fields[key]->value == '1'} checked="checked"{/if}> {$fields[key]->label}
							</label>
						</div>
					</div>
					{/if}

					{if $fields[key]->type == 'select'}
					<label for="{$fields[key]->name}" class="col-sm-2 control-label">{$fields[key]->label}</label>
					<div class="col-sm-10">
						<select id="{$fields[key]->name}" name="{$fields[key]->name}" class="form-control{if $fields[key]->required} required{/if}{$fields[key]->class}">
							<option value="">...</option>
							{section name=index loop=$fields[key]->multi_values}
							<option value="{$fields[key]->multi_values[index]['id']}"{if $fields[key]->value == $fields[key]->multi_values[index]['id']} selected="selected"{/if}>{$fields[key]->multi_values[index]['name']}</option>
							{/section}
						</select>
					</div>
					{/if}

					{if $fields[key]->type == 'textarea'}
					<label for="{$fields[key]->name}" class="col-sm-2 control-label">{$fields[key]->label}</label>
					<div class="col-sm-10">
						<textarea id="{$fields[key]->name}" name="{$fields[key]->name}" class="form-control{if $fields[key]->required} required{/if}{$fields[key]->class}" placeholder="{$fields[key]->label}" col="10" rows="3">{$fields[key]->value}</textarea>
					</div>
					{/if}

					{if $fields[key]->type == 'file'}
					<label for="{$fields[key]->name}" class="col-sm-2 control-label">{$fields[key]->label}</label>
					<div class="col-sm-10">
				    	<input type="file" id="{$fields[key]->name}" name="{$fields[key]->name}" class="{$fields[key]->class}">
				    </div>
					{/if}

					{if !empty($isSubmit) && !empty($fields[key]->error) && $fields[key]->error !== true}
					<label class="col-sm-2"></label>
					<div class="col-sm-10 error" role="alert">
						<span class="glyphicon glyphicon-warning-sign"></span> {$fields[key]->error}
					</div>
					{/if}

				</div>

			{/section}

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-default">{t}Send{/t}</button>
				</div>
			</div>

		</form>