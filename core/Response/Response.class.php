<?php
class Response
{
	public $vars = array();
	private $headers = array();

	public function addVar($key, $value) {
		$this->vars[$key] = $value;
	}

	public function addVars($_vars) {
		$this->vars = array_merge($this->vars, $_vars);
	}

	public function getVar($key) {
		return $this->vars[$key];
	}

	public function getVars() {
		return $this->vars;
	}

	public function render($template, $_vars = array(), $fetch = false) {

		$view = new View($template);

		$this->addVars($_vars);

		foreach($this->vars as $key => $var) {
			$view->assign($key, $var);
		}

		if ($fetch === true) {
			return $view->fetch($view->getTemplate());
		}
		$view->display($view->getTemplate());

		return true;
	}

	public function redirect($url, $permanent = false) {
		if ($permanent) {
			$this->headers['Status'] = '301 Moved Permanently';
		} else {
			$this->headers['Status'] = '302 Found';
		}
		$this->headers['Location'] = $url;

		foreach ($this->headers as $key => $value) {
			header($key. ':' . $value);
		}
		exit();
	}
}