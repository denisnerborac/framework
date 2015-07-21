<?php
class RequestException extends CustomException {}

class Request {

	public $request = array();
	public $post = array();
	public $files = array();
	public $get = array();
	public $cookie = array();

	public function __construct() {
		$this->request = array_merge($this->request, $_REQUEST);
		$this->get = array_merge($this->get, $_GET);
		$this->post = array_merge($this->post, $_POST);
		$this->files = array_merge($this->files, $_FILES);
		$this->cookie = array_merge($this->cookie, $_COOKIE);
		//$this->setParams();
	}

	public function __set($key, $value) {
		$this->request[$key] = $value;
	}

	public function __get($key) {
		return isset($this->request[$key]) ? $this->request[$key] : null;
	}

	public function get($key, $default = '') {
		return !empty($this->get[$key]) ? $this->get[$key] : $default;
	}

	public function post($key, $default = '') {
		return !empty($this->post[$key]) ? $this->post[$key] : $default;
	}

	public function getRawData($var, $key) {
		switch(strtolower($var)) {
			case 'get':
				$array = $this->get;
			break;
			case 'post':
				$array = $this->post;
			break;
			case 'files':
				$array = $this->files;
			break;
			case 'cookie':
				$array = $this->cookie;
			break;
			default:
				$array = array();
			break;
		}
		if(isset($array[$key])) {
			return $array[$key];
		}
		return null;
	}

	public function isPost() {
		return $_SERVER['REQUEST_METHOD'] === 'POST';
	}

	public function isGet() {
		return $_SERVER['REQUEST_METHOD'] === 'GET';
	}

	public function isAjax() {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') ? true : false;
    }

    public function isSecure() {
        return (!empty($_SERVER['HTTPS'])) ? true : false;
    }
}