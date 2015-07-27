<?php

class Timer {

	private $_start     = 0;
	private $_stop      = 0;
	private $_elapsed   = null;

	public function __construct($start = true) {
		if ($start) {
			$this->start();
		}
	}

	public function start($reset = false) {
		if ($reset) {
			$this->_reset();
		}
		$this->_start = $this->_getTime();
		return $this->_start;
	}

	public function stop() {
		$this->_stop    = $this->_getTime();
		$this->_elapsed = $this->_getElapsedTime();
		return $this->_stop;
	}

	public function elapsed() {
		if (is_null($this->_elapsed))
			$this->stop();
		return $this->_elapsed;
	}

	private function _reset() {
		$this->_start   = 0;
		$this->_stop    = 0;
		$this->_elapsed = null;
	}

	private function _getTime() {
		return microtime();
	}

	private function _getElapsedTime() {
		return $this->_stop - $this->_start;
	}
}