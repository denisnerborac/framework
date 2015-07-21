<?php

abstract class Controller {

	public $lang;
	public $target;
	public $action;
	public $params;

	public $uri;
	public $route;
	public $querystring;

	public $request;
	public $response;
	public $redirected;

	public function __construct(Request $request, Response $response) {
		$this->request = $request;
		$this->response = $response;
		$this->redirected = false;
		$this->setParams();
	}

	protected function setParams() {

		global $routes;

		$do = $this->request->get('do', '');

		unset($this->request->get['do']);
		unset($this->request->request['do']);

		if (!empty($do) &&
		   (preg_match('/^(?P<lang>[a-zA-Z]{2})\/(?P<target>[a-zA-Z0-9]+)\/(?P<action>[a-zA-Z0-9]+)\/?(?P<params>.*?)?\/?$/', $do, $matches) ||
			preg_match('/^(?P<lang>[a-zA-Z]{2})\/(?P<target>[a-zA-Z0-9]+)\/?(?P<params>.*?)?\/?$/', $do, $matches) ||
			preg_match('/^(?P<target>[a-zA-Z0-9]{3,})\/(?P<action>[a-zA-Z0-9]+)\/?(?P<params>.*?)?\/?$/', $do, $matches) ||
			preg_match('/^(?P<target>[a-zA-Z0-9]{3,})\/?(?P<params>.*?)?\/?$/', $do, $matches) ||
			preg_match('/^(?P<lang>[a-zA-Z]{2})\/?$/', $do, $matches))) {}


		$lang = !empty($matches['lang']) ? $matches['lang'] : '';
		$this->target = !empty($matches['target']) ? $matches['target'] : 'home';
		$this->action = !empty($matches['action']) ? $matches['action'] : 'index';
		$this->params = !empty($matches['params']) ? explode('/', $matches['params']) : array();

		/*
		echo 'LANG >> '.$lang.'<br>';
		echo 'TARGET >> '.print_r($this->target, true).'<br>';
		echo 'ACTION >> '.print_r($this->action, true).'<br>';
		echo 'PARAMS >> '.print_r($this->params, true).'<br>';
		*/

		$router = new Router($lang, $routes);
		$router->dispatch($this);

		//$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
		//$root_path = trim(ROOT_DIR.'/'.(!empty($lang) ? $lang : ''), '/');
		$this->route = $this->target.'/'.$this->action.'/'.implode('/', $this->params);
		$this->uri = ROOT_HTTP.$this->target.'/'.$this->action.'/';

		if (empty($lang)) {
			$lang = Lang::getDefaultLang();
		}
		$this->lang = new Lang($lang);

		$this->querystring = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
		$this->querystring = (!empty($this->querystring) ? '?' : '').$this->querystring;

		if(get_magic_quotes_gpc()) {
			$this->request = Utils::stripslashes($this->request);
			$this->post = Utils::stripslashes($this->post);
			$this->get = Utils::stripslashes($this->get);
		}
	}

	public function getParam($param, $default = null) {
		return !empty($this->params[$param]) ? $this->params[$param] : $default;
	}

	public function getParams() {
		return $this->params;
	}

	public function getUri() {
		return $this->uri;
	}

	public function getQueryString() {
		return $this->querystring;
	}

	public function getRequest() {
		return $this->request;
	}

	public function redirect($url) {
		if ($this->redirected == true) {
			throw new Exception('Already redirected');
		}
		$this->response->redirect($url);
		$this->redirected = true;
	}

	public function __get($param) {
		return $this->response->getVar($param);
	}

	public function __set($name, $param)	{
		$this->response->addVar($name, $param);
	}
}