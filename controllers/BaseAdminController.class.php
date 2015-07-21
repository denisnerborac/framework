<?php
abstract class BaseAdminController {

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
			'website_title' => 'Admin',
			'website_description' => 'Admin Description',
			'author' => 'Admin Author'
		);

		$vars['pages'] = array(
			'admin/index/' => array('Dashboard', 'fa-dashboard'),
            'admin/post/' => array('Posts', 'fa-file-text'),
            'admin/contact/' => array('Contacts', 'fa-envelope')
		);

		$this->controller->response->addVars($vars);
	}

}