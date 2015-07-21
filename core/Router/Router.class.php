<?php

class Router {

	private $_base;
	private $_routes = array();

	private function _prepareRoute($route) {
		if ($route == '/') {
			return $route;
		}
		return trim($route, '/');
	}

	public function __construct($base = null, $routes = array()) {

		$base = $base ?: '/';

		$this->_base = $this->_prepareRoute($base);

		if (!empty($routes)) {
			foreach($routes as $route => $params) {
				$this->add($route, $params);
			}
		}
	}

	public function add($route, $params = array()) {

		if (empty($route)) {
			throw new Exception('Undefined route');
		}

		$route = $this->_prepareRoute($this->_base.'/'.$route);

		$this->_routes['/^'.str_replace('/', '\/', $route).'$/'] = $params;

		return true;
	}

	public function dispatch(&$controller) {

		foreach ($this->_routes as $route => $params) {

			$path = $this->_prepareRoute(CURRENT_PATH);

			if (preg_match($route, $path, $_params)) {

				$controller->route = array_shift($_params);
				$controller->target = $params['target'];
				$controller->action = $params['action'];
				$controller->params = $_params;

				return true;
			}
		}

		return false;
	}
}