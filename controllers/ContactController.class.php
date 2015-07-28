<?php

class ContactController extends BaseController {

	public function index() {

		$vars = array(
			'title' => 'Contact',
			'description' => '...'
		);

		$isPost = $this->request->isPost();

		$contact = new Contact();

		$errors = array();
		$success = false;
		if ($isPost) {

			foreach($contact->getFields() as $key => $value) {
				try {
					$contact->$key = $this->request->post($key, '');
				} catch (Exception $e) {
					$errors[$key] = $e->getMessage();
				}
			}

			if (empty($errors)) {
				$success = $result = $contact->insert();
			}
		}

		$form = $contact->getForm(ROOT_HTTP.$this->lang->getUserLang().'/contact/post', $isPost, $errors);

		$vars['form'] = $form;
		$vars['isPost'] = $isPost;
		$vars['errors'] = $errors;
		$vars['success'] = $success;

		$this->render('contact', $vars);
	}

	public function post() {
		return $this->index();
	}

}