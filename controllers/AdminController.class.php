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
		return $this->base_list('post', array('id', 'title', 'author', 'date'));
	}

	public function post_action() {
		return $this->base_action('post');
	}

	public function contact() {
		return $this->base_list('contact', array('id', 'firstname', 'lastname', 'message'), 'lastname, firstname');
	}

	public function contact_action() {
		return $this->base_action('contact');
	}

	public function search() {

		$vars = array();

		$this->render('admin/search', $vars);
	}
}