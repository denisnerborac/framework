<?php
class Contact extends Model {

	protected $id;
	protected $lastname;
	protected $firstname;
	protected $email;
	protected $message;
	protected $newsletter;
	protected $cgu;

	public function getForm($id = '', $name = '', $action = '', $method = 'POST', $class = 'form-horizontal', $errors = array(), $isPost = false) {

		$form = new Form($id, $name, $action, $method, $class, $isPost);
		$form->addField('lastname', Lang::_('Lastname'), 'text', $this->lastname, true, '', @$errors['lastname']);
		$form->addField('firstname', Lang::_('Firstname'), 'text', $this->firstname, true, '', @$errors['firstname']);
		$form->addField('email', Lang::_('Email'), 'email', $this->email, true, '', @$errors['email']);
		$form->addField('message', Lang::_('Message'), 'textarea', $this->message, true, '', @$errors['message']);
		$form->addField('newsletter', Lang::_('Subscribe to the newsletter'), 'checkbox', $this->newsletter, false);
		$form->addField('cgu', Lang::_('Accept the CGU'), 'checkbox', $this->cgu, true, '', @$errors['cgu']);

		return $form->render();
	}

	/* Getters */
	public function getId() {
		return $this->id;
	}
	public function getLastname() {
		return $this->lastname;
	}
	public function getFirstname() {
		return $this->firstname;
	}
	public function getEmail() {
		return $this->email;
	}
	public function getMessage() {
		return $this->message;
	}
	public function getNewsletter() {
		return $this->newsletter;
	}
	public function getCgu() {
		return $this->cgu;
	}

	/* Setters */
	public function setId($id) {
		$this->id = $id;
	}
	public function setLastname($lastname) {
		if (empty($lastname)) {
			throw new Exception(Lang::_('You must fill your lastname'));
		}
		$this->lastname = $lastname;
	}
	public function setFirstname($firstname) {
		if (empty($firstname)) {
			throw new Exception(Lang::_('You must fill your firstname'));
		}
		$this->firstname = $firstname;
	}
	public function setEmail($email) {
		if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
			throw new Exception(Lang::_('You must fill a valid email'));
		}
		$this->email = $email;
	}
	public function setMessage($message) {
		if (empty($message)) {
			throw new Exception(Lang::_('You must fill the message'));
		}
		$this->message = strip_tags($message);
	}
	public function setNewsletter($newsletter) {
		$this->newsletter = $newsletter;
	}
	public function setCgu($cgu) {
		if (empty($cgu)) {
			throw new Exception(Lang::_('You have to accept the ToS'));
		}
		$this->cgu = $cgu;
	}

	public function insert() {

		return Db::insert(
			'INSERT INTO contact (lastname, firstname, email, newsletter, cgu, message, date)
		 	 VALUES (:lastname, :firstname, :email, :newsletter, :cgu, :message, NOW())',
			array(
				'lastname' => $this->lastname,
				'firstname' => $this->firstname,
				'email' => $this->email,
				'newsletter' => (int) $this->newsletter,
				'cgu' => (int) $this->cgu,
				'message' => $this->message
			)
		);
	}
}