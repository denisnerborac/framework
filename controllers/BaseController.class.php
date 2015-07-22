<?php
abstract class BaseController {

	protected $controller;

	public function __construct($controller) {

		$this->controller = $controller;

		$vars = array(
			'HTTP_ROOT' => ROOT_HTTP.$controller->lang->getUserLang().'/',
			'CSS_ROOT' => CSS_HTTP,
			'JS_ROOT' => JS_HTTP,
			'IMG_ROOT' => IMG_HTTP,
			'referer' => REFERER,
			'uri' => $controller->getUri(),
			'querystring' => $controller->getQueryString(),
			'current_page' => $controller->route,
			'target' => $controller->target,
			'action' => $controller->action,
			'lang' => $controller->lang->getUserLang(),
			'website_title' => 'Website Title',
			'website_description' => 'Website Description',
			'author' => 'Website Author'
		);

		$vars['pages'] = array(
			array('url' => 'home', 'name' => Lang::_('Home')),
			array('url' => 'post/archives', 'name' => Lang::_('Archives')),
			array('url' => 'search', 'name' => Lang::_('Search')),
			array('url' => 'contact', 'name' => Lang::_('Contact')),
		);

		$archives_dates = array();
		for($i = 0; $i < 12; $i++) {
			$time = strtotime('-'.$i.' month');
			$month_value = date('Y-m', $time);
			$month_label = ucfirst(Lang::_(strtolower(date('F', $time))));
			$year = date('Y', $time);
			$archives_dates[$month_value] = $month_label.' '.$year;
		}

		$vars['archives_dates'] = $archives_dates;

		$this->controller->response->addVars($vars);
	}

	public function getParams() {
		return $this->controller->getParams();
	}

	public function getParam($param, $default = null) {
		return $this->controller->getParam($param, $default);
	}

	public function view($template, $vars = array()) {
		return $this->render($template, $vars);
	}

	public function render($template, $vars = array()) {
		return $this->controller->response->render($template, $vars);
	}
}