<?php

class TestController extends BaseController {

	/*
	public function __construct($controller) {
		parent::__construct($controller);

		// Local stuff...
	}
	*/

	public function index() {

		$id = $this->controller->request->get('id', '');

		$vars = array(
			'id' => $id
		);

		$this->controller->response->render('test', $vars);
	}
}