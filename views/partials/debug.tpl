{if !empty($profiler)}
<div class="well">
	<ul>
		<li>Memory Usage = {$profiler->getMemoryUsage()}</li>
		<li>Memory Limit = {$profiler->getMemoryLimit()}</li>
		<li>Execution Time = {$profiler->getElapsedTime()}</li>
		<li>Execution Time Limit = {$profiler->getTimeLimit()}</li>
	</ul>
</div>
{/if}