<?php

class Cache {

	private $path;
	public $type;
	public $expire;

	public function __construct($type = 'default', $path = CACHE_PATH) {
		$this->type = $type;
		$this->path = $path;
	}

	private function _getPath($file) {
		return $this->path.'/'.$this->type.'/'.$file;
	}

	public function read($key) {

		$cache = $this->_getPath($key);

		if (!file_exists($cache) ||
			filemtime($cache) > $this->expire) {
			return false;
		}

		return file_get_contents($cache);
	}

	public function write($key, $value) {
		$cache = $this->_getPath($key);
		return file_put_contents($cache, $value);
	}

}