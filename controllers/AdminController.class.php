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

		$this->render('admin/index', $vars);
	}

	public function post() {

		$posts = Post::getList('SELECT * FROM posts ORDER BY title ASC');

		$vars = array('posts' => $posts);

		$this->render('admin/post', $vars);
	}

	public function contact() {

		$id = $this->getParam(0, 0);

		$isPost = $this->controller->request->isPost();
		$errors = array();

		$contact = new Contact();
		if (!empty($id)) {
			$contact = Contact::get($id);
			if (empty($contact)) {
				throw new Exception('Undefined contact with id = ['.$id.']');
			}
		}

		// $id, $name, $action, $method, $class, $errors, $isPost
		$form = $contact->getForm('form-contact-admin', 'form-contact-admin', ROOT_HTTP.'admin/contact', 'POST', 'form-horizontal', $errors, $isPost);

		$vars['form'] = $form;

		$this->render('admin/contact', $vars);
	}

	public function search() {

		$vars = array();

		$this->render('admin/search', $vars);
	}
}