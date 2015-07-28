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
		if ($isPost) {

			foreach($contact->getFields() as $key => $value) {
				try {
					$contact->$key = $this->request->post($key, '');
				} catch (Exception $e) {
					$errors[$key] = $e->getMessage();
				}
			}

			if (empty($errors)) {

				if ($result = $contact->insert()) {
					$vars['redirectJS'] = Utils::redirectJS(ROOT_HTTP, 3);
					$this->render('contact', $vars);
					return true;
				}
			}
		}

		$form = $contact->getForm($id = 'form-contact', $name = 'form-contact', $action = ROOT_HTTP.'contact/post', 'POST', 'form-horizontal', $errors, $isPost);

		$vars['form'] = $form;

		$this->render('contact', $vars);
	}

	public function post() {
		return $this->index();
	}

}