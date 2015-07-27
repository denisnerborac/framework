<?php

class UserController extends BaseController {

	public function login() {

		$user = new User();

		$remember_me = $user->checkRememberMe();
		if ($remember_me === true) {
			$this->response->redirect(ROOT_HTTP);
		}

		$errors = array();
		$success = false;
		$isPost = $this->request->isPost();

		$remember_me = $this->request->post('remember_me', '');

		if ($isPost) {

			foreach($this->request->post as $key => $value) {
				try {
					if (property_exists($user, $key)) {
						$user->$key = $this->request->post($key, '');
					}
				} catch (Exception $e) {
					$errors[$key] = $e->getMessage();
				}
			}

			if (empty($errors)) {
				$success = $user->checkLogin($remember_me);
			}

			if ($success === false) {
				$errors['authent'] = 'Identifiants incorrects';
			}
		}

		$form = new Form('', 'form-login', ROOT_HTTP.'user/login', 'POST', 'form-horizontal', $errors, $isPost);
		$form->addField('email', Lang::_('Email'), 'email', $user->email, true, '', @$errors['authent']);
		$form->addField('password', Lang::_('Password'), 'password', $user->password, true, '', @$errors['authent']);

		$vars = array(
			'title' => 'Login',
			'isPost' => $isPost,
			'form' => $form,
			'errors' => $errors,
			'success' => $success
		);

		return $this->render('authent', $vars);
	}

	public function register() {

		$user = new User();

		$errors = array();
		$success = false;
		$isPost = $this->request->isPost();

		$confirm_email = $this->request->post('confirm_email', '');
		$confirm_password = $this->request->post('confirm_password', '');

		if ($isPost) {
			foreach($user->getDbFields() as $key => $value) {
				try {
					$user->$key = $this->request->post($key, '');
				} catch (Exception $e) {
					$errors[$key] = $e->getMessage();
				}
			}

			if (empty($confirm_email) || strcmp($user->email, $confirm_email) !== 0) {
				$errors['confirm_email'] = 'Vous devez confirmer votre email';
			}
			if (empty($confirm_password) || strcmp($user->password, $confirm_password) !== 0) {
				$errors['confirm_password'] = 'Vous devez confirmer votre mot de passe';
			}

			if (empty($errors)) {

				$user_already_exists = $user->checkAlreadyExists();
				if ($user_already_exists === true) {
					$errors['email'] = "L'email est déjà pris";
				} else {

					$user->password = password_hash($user->password, PASSWORD_BCRYPT);

					$user_id = $user->register();

					if (!empty($user_id)) {

						$this->session->user_id = $user_id;
						$this->session->firstname = $firstname;

						$success = true;
					} else {
						$errors['register'] = 'Register failed';
					}
				}
			}
		}

		$form = new Form('', 'form-register', ROOT_HTTP.'user/register', 'POST', 'form-horizontal', $errors, $isPost);
		$form->addField('firstname', Lang::_('Firstname'), 'text', $user->firstname, true, '', @$errors['firstname']);
		$form->addField('lastname', Lang::_('Lastname'), 'text', $user->lastname, true, '', @$errors['lastname']);
		$form->addField('email', Lang::_('Email'), 'email', $user->email, true, '', @$errors['email']);
		$form->addField('confirm_email', Lang::_('Confirm email'), 'email', $confirm_email, true, '', @$errors['confirm_email']);
		$form->addField('password', Lang::_('Password'), 'password', '', true, '', @$errors['password']);
		$form->addField('confirm_password', Lang::_('Confirm password'), 'password', $confirm_password, true, '', @$errors['confirm_password']);
		$form->addField('newsletter', Lang::_('Newsletter'), 'checkbox', $user->newsletter, false, '');
		$form->addField('cgu', Lang::_('Accept the CGU'), 'checkbox', $user->cgu, true, '', @$errors['cgu']);

		$vars = array(
			'title' => 'Register',
			'isPost' => $isPost,
			'form' => $form,
			'errors' => $errors,
			'success' => $success
		);

		return $this->render('authent', $vars);
	}

	public function logout() {

		$success = Authent::logout();

		$vars = array(
			'title' => 'Logout',
			'isPost' => true,
			'success' => $success
		);

		return $this->render('authent', $vars);
	}

}