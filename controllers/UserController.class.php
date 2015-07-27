<?php

class UserController extends BaseController {

	public function login() {

		$remember_me = Authent::getRememberMe();

		if ($remember_me !== false) {

			$user_id = $remember_me;

			$user = self::get($user_id);

			if (!empty($user)) {

				$this->session->user_id = $user->id;
				$this->session->firstname = $user->firstname;

				$this->response->redirect('index.php');
			}
		}

		$email = $this->request->post('email', '');
		$password = $this->request->post('password', '');
		$remember_me = $this->request->post('remember_me', '');

		$errors = array();
		$success = false;
		$isPost = $this->request->isPost();

		if ($isPost) {

			if (!empty($email) && !empty($password)) {

				$user = new User(Db::select('SELECT * FROM users WHERE email = :email', array('email' => $email)));

				if (!empty($user)) {

					$crypted_password = $user->pass;

					if (password_verify($password, $crypted_password)) {

						if (!empty($remember_me)) {
							Authent::setRememberMe($user->id);
						}

						$this->session->user_id = $user->id;
						$this->session->firstname = $user->firstname;

						$success = true;
					}
				}
			}

			$errors['authent'] = 'Identifiants incorrects';
		}

		$form = new Form('', 'form-login', ROOT_HTTP.'user/login', 'POST', 'form-horizontal', $errors, $isPost);
		$form->addField('email', Lang::_('Email'), 'email', $email, true, '', @$errors['authent']);
		$form->addField('password', Lang::_('Password'), 'password', $password, true, '', @$errors['authent']);

		$vars = array(
			'title' => 'Login',
			'form' => $form,
			'errors' => $errors,
			'success' => $success
		);

		return $this->render('login', $vars);
	}



}