<?php

class ContactController extends BaseController {

	public function index() {

		$vars = array(
			'title' => 'Contact',
			'description' => '...'
		);

		$isPost = $this->controller->request->isPost();

		$contact = new Contact();

		$errors = array();
		if ($isPost) {

			foreach($contact->getFields() as $key => $value) {
				try {
					$contact->$key = $this->controller->request->post($key, '');
				} catch (Exception $e) {
					$errors[$key] = $e->getMessage();
				}
			}

			if (empty($errors)) {

				if ($result = $contact->insert()) {
					$vars['redirectJS'] = Utils::redirectJS(ROOT_HTTP, 3);
					$this->controller->response->render('contact', $vars);
					return false;
				}
			}
		}

		$form = $contact->getForm($errors, $isPost);

		$vars['form'] = $form;

		$this->controller->response->render('contact', $vars);
	}

	public function post() {
		return $this->index();
	}

}