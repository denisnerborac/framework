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
			'website_title' => '',
			'website_description' => '',
			'author' => ''
		);

		$vars['pages'] = array();

		$this->controller->response->addVars($vars);
	}

}