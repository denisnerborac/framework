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

		$posts = Post::getList('SELECT * FROM post ORDER BY title ASC');

		$table = new Table('data-table', 'post', $posts, array('id', 'title', 'author', 'date'), ROOT_HTTP.'admin/post/edit', ROOT_HTTP.'admin/post/delete');

		$vars = array(
			'posts' => $posts,
			'table' => $table->render()
		);

		$this->render('admin/post', $vars);
	}

	public function post_insert() {
		return $this->post_edit();
	}
	public function post_update() {
		return $this->post_edit();
	}
	public function post_edit() {

		$id = $this->getParam(0, 0);
		$type = !empty($id) ? 'update' : 'insert';
		$action = ROOT_HTTP.'admin/post/'.$type.(!empty($id) ? '/'.$id : '');

		$isPost = $this->request->isPost();
		$errors = array();

		$post = new Post();
		if (!empty($id)) {
			$post = Post::get($id);
			if (empty($post)) {
				throw new Exception('Undefined post with id = ['.$id.']');
			}
		}

		$form = $post->getForm($type, $action, $this->request, $isPost, $errors = array());

		$vars['form'] = $form;

		$this->render('admin/post', $vars);
	}


	public function contact() {

		$contacts = Contact::getList('SELECT * FROM contact ORDER BY lastname, firstname');

		$table = new Table('data-table', 'contact', $contacts, array('id', 'firstname', 'lastname', 'message'), ROOT_HTTP.'admin/contact/edit', ROOT_HTTP.'admin/contact/delete');

		$vars = array(
			'contacts' => $contacts,
			'table' => $table->render()
		);

		$this->render('admin/contact', $vars);
	}

	public function contact_edit() {

		$id = $this->getParam(0, 0);
		$type = !empty($id) ? 'update' : 'insert';
		$action = ROOT_HTTP.'admin/contact/'.$type.(!empty($id) ? '/'.$id: '');

		$isPost = $this->request->isPost();
		$errors = array();

		$contact = new Contact();
		if (!empty($id)) {
			$contact = Contact::get($id);
			if (empty($contact)) {
				throw new Exception('Undefined contact with id = ['.$id.']');
			}
		}

		$form = $contact->getForm($type, $action, $this->request, $isPost, $errors);

		$vars['form'] = $form;

		$this->render('admin/contact', $vars);
	}

	public function contact_delete() {
		$this->render('admin/contact', array());
	}

	public function search() {

		$vars = array();

		$this->render('admin/search', $vars);
	}
}