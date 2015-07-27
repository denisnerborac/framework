<?php

class Profiler {

	public $real_usage = false;
	public $mem_start = 0;
	public $mem_stop  = 0;
	public $memory_usage = null;
	public $timer;

	public function __construct($start = true, $real_usage = false) {

		$this->real_usage = $real_usage;

		if ($start) {
			$this->timer = new Timer();
			$this->start();
		}
	}

	public function start() {
		$this->mem_start = memory_get_usage($this->real_usage);
		$this->timer->start();
	}

	public function stop() {
		$this->mem_stop = memory_get_usage($this->real_usage);
		$this->timer->stop();
	}

	/* Time */
	public function getElapsedTime() {
		return $this->timer->elapsed();
	}

	public function getTimeLimit() {
		return ini_get('max_execution_time');
	}

	/* Memory */
	public function getMemoryUsage() {
		return Utils::getSize($this->mem_stop - $this->mem_start);
	}

	public function getMemoryPeakUsage() {
		return Utils::getSize(memory_get_peak_usage($this->real_usage));
	}

	public function getMemoryLimit() {
		return ini_get('memory_limit');
	}

	/* Summary */
	public function getSummary() {
		$response = new Response();
		return $response->render('partials/debug.tpl', array('profiler' => $this), true);
	}
}