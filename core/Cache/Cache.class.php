<?php

class Cache {

	private $path;
	private $file;
	private $type;
	private $expire;

	public function __construct($file, $type = 'data', $expire = 0) {

		if (empty($file)) {
			throw new Exception('Cache error - Undefined cache file');
		}

		$this->file = strpos($file, '.cache') === false ? $file.'.cache' : $file;
		$this->type = $type;
		$this->expire = $expire;
	}

	public function read() {

		$cache = $this->_getPath();

		if (!file_exists($cache) ||	filemtime($cache) < self::_getTime() - $this->expire) {
			return false;
		}
		return unserialize(file_get_contents($cache));
	}

	public function write($value) {
		$cache = $this->_getPath();
		return file_put_contents($cache, serialize($value));
	}

	private static function _getTime() {
		return time();
	}

	private function _getPath() {
		return CACHE_PATH.$this->type.'/'.$this->file;
	}
}