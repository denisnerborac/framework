{if !empty($profiler)}
<div class="alert alert-info" role="info">
	<ul>
		<li>Memory Usage = {$profiler->getMemoryUsage()}</li>
		<li>Memory Limit = {$profiler->getMemoryLimit()}</li>
		<li>Execution Time = {$profiler->getElapsedTime()}</li>
		<li>Execution Time Limit = {$profiler->getTimeLimit()}</li>
	</ul>
</div>
{/if}

{if !empty($debug)}
<div class="alert alert-warning" role="warning">
{$debug}
</div>
{/if}