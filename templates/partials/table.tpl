<table class="table table-striped table-bordered table-hover" id="{$this->id}">
    <thead>
        <tr>
            {foreach $this->cols as $col}
            <th>{$col|ucfirst}</th>
            {/foreach}
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    {$i = 0}
    {foreach $this->data as $data}
		<tr class="{if $i % 2 === 0}odd{else}even{/if}">
            {foreach $this->cols as $col}
            <td>{$data->$col}</td>
            {/foreach}
            <td class="center">
          		<a href=""><i class="fa fa-pencil fa-fw"></i></a>
          		<a href=""><i class="fa fa-trash fa-fw"></i></a>
            </td>
        </tr>
        {assign var=i value=$i + 1}
    {/foreach}
    </tbody>
</table>