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
				$errors['authent'] = true;
			}
		}

		$form = $user->getLoginForm($isPost, $errors);

		$vars = array(
			'title' => Lang::_('Login'),
			'isPost' => $isPost,
			'form' => $form,
			'errors' => $errors,
			'success' => $success
		);

		$fb_active = API_Facebook::isActive();
		if ($fb_active) {
			$vars['fb_login_url'] = API_Facebook::getLoginUrl(ROOT_HTTP.'register');
		}

		return $this->render('authent', $vars);
	}

	public function register() {

		try {

			$errors = array();
			$success = false;
			$isPost = $this->request->isPost();

			$user = new User();

			try {

				$fb_active = API_Facebook::isActive();

				if ($fb_active) {

					$fb_user = $user->getFacebookUser(ROOT_HTTP.'register');

					if (!empty($fb_user)) {
						$this->response->redirect(ROOT_HTTP);
					}
				}
			} catch (Exception $e) {
				$errors['authent'] = $e->getMessage();
			}

			$confirm_email = $this->request->post('confirm_email', '');
			$confirm_password = $this->request->post('confirm_password', '');

			if ($isPost) {
				foreach($user->getFields() as $key => $value) {
					try {
						$user->$key = $this->request->post($key, '');
					} catch (Exception $e) {
						$errors[$key] = $e->getMessage();
					}
				}

				if (empty($confirm_email) || strcmp($user->email, $confirm_email) !== 0) {
					$errors['confirm_email'] = Lang::_('You must confirm your email');
				}
				if (empty($confirm_password) || strcmp($user->password, $confirm_password) !== 0) {
					$errors['confirm_password'] = Lang::_('You must confirm your password');
				}

				if (empty($errors)) {

					$user_already_exists = $user->checkAlreadyExists();
					if ($user_already_exists === true) {
						$errors['email'] = Lang::_('Email already in use');
					} else {

						$user->password = password_hash($user->password, PASSWORD_BCRYPT);

						$user_id = $user->register();

						if (!empty($user_id)) {
							$success = $this->login();
						} else {
							$errors['authent'] = Lang::_('Register failed');
						}
					}
				}
			}

			$form = $user->getRegisterForm($isPost, $errors);

			$vars = array(
				'title' => Lang::_('Register'),
				'isPost' => $isPost,
				'form' => $form,
				'errors' => $errors,
				'success' => $success
			);

		} catch (Exception $e) {
			$vars['debug'] = $e->getMessage();
		}

		return $this->render('authent', $vars);
	}

	public function logout() {

		$success = Authent::logout();

		$vars = array(
			'title' => Lang::_('Logout'),
			'isPost' => true,
			'success' => $success
		);

		return $this->render('authent', $vars);
	}

}