<?php

class AdminController extends BaseAdminController {

	/*
	public function __construct($controller) {
		parent::__construct($controller);

		// Local stuff...
	}
	*/

	public function index() {

		$vars = array();

		$this->controller->response->render('admin/index', $vars);
	}

	public function post() {

		$query = Db::select('SELECT * FROM posts ORDER BY title ASC');

		$posts = array();
		foreach($query as $_post) {
			$posts[] = new Post($_post);
		}

		$vars = array('posts' => $posts);

		$this->controller->response->render('admin/post', $vars);
	}

	public function contact() {

		$contact = Contact::get(1);

		$form = $contact->getForm();

		$vars['form'] = $form;

		$this->controller->response->render('admin/contact', $vars);
	}

	public function search() {

		$vars = array();

		$this->controller->response->render('admin/search', $vars);
	}
}