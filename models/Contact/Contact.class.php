<?php
class Contact extends Model {

	protected $id;
	protected $lastname;
	protected $firstname;
	protected $email;
	protected $message;
	protected $newsletter;
	protected $cgu;

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
			throw new Exception(Lang::_('You must provide a valid email'));
		}
		$this->email = $email;
	}
	public function setMessage($message) {
		if (empty($message)) {
			throw new Exception(Lang::_('You must fill your message'));
		}
		$this->message = strip_tags($message);
	}
	public function setNewsletter($newsletter) {
		$this->newsletter = $newsletter;
	}
	public function setCgu($cgu) {
		if (empty($cgu)) {
			throw new Exception(Lang::_('You have to accept the terms of service'));
		}
		$this->cgu = $cgu;
	}

	public function getForm($type, $action, $request, $isPost = false, $errors = array()) {

		$form = new Form($id = 'form-contact', $name = 'form-contact', $action, 'POST', 'form-horizontal', $isPost);
		$form->addField('lastname', Lang::_('Lastname'), 'text', $this->_getfieldvalue('lastname', $type, $request), true, '', @$errors['lastname']);
		$form->addField('firstname', Lang::_('Firstname'), 'text', $this->_getfieldvalue('firstname', $type, $request), true, '', @$errors['firstname']);
		$form->addField('email', Lang::_('Email'), 'email', $this->_getfieldvalue('email', $type, $request), true, '', @$errors['email']);
		$form->addField('message', Lang::_('Message'), 'textarea', $this->_getfieldvalue('message', $type, $request), true, '', @$errors['message']);
		$form->addField('newsletter', Lang::_('Subscribe to the newsletter'), 'checkbox', $this->_getfieldvalue('newsletter', $type, $request), false);
		$form->addField('cgu', Lang::_('Accept the terms of service'), 'checkbox', $this->_getfieldvalue('cgu', $type, $request), true, '', @$errors['cgu']);

		return $form->render();
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

	public function update() {

		if (empty($this->id)) {
			throw new Exception('Update error - Undefined contact id');
		}

		return Db::update(
			'UPDATE contact SET lastname = :lastname, firstname = :firstname, email = :email, newsletter = :newsletter, cgu = :cgu, message = :message, date = NOW()
		 	 WHERE id = :id',
			array(
				'lastname' => $this->lastname,
				'firstname' => $this->firstname,
				'email' => $this->email,
				'newsletter' => (int) $this->newsletter,
				'cgu' => (int) $this->cgu,
				'message' => $this->message,
				'id' => (int) $this->id
			)
		);
	}

	public function delete() {

		if (empty($this->id)) {
			throw new Exception('Delete error - Undefined contact id');
		}

		return Db::delete('DELETE FROM contact WHERE id = :id', array('id' => $this->id));
	}
}