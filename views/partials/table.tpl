<table class="table table-striped table-bordered table-hover" id="{$table->id}">
	<thead>
		<tr>
			{foreach $table->cols as $col}
			<th>{$col|ucfirst}</th>
			{/foreach}
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
	{$i = 0}
	{foreach $table->data as $data}
		<tr class="{if $i % 2 === 0}odd{else}even{/if}">
			{foreach $table->cols as $col}
			<td>{$data->$col}</td>
			{/foreach}
			<td class="center">
				<a href="{$table->edit_url}/{$data->id}"><i class="fa fa-pencil fa-fw"></i></a>
				<a href="{$table->delete_url}/{$data->id}"><i class="fa fa-trash fa-fw"></i></a>
			</td>
		</tr>
		{assign var=i value=$i + 1}
	{/foreach}
	</tbody>
</table>