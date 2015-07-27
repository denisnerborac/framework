<?php
class User extends Model {

	private $id;
	private $fb_id;
	private $firstname;
	private $lastname;
	private $email;
	private $pass;
	private $status;
	private $newsletter;
	private $register_date;

	public function getId() {
		return $this->id;
	}
	public function getFbId() {
		return $this->fb_id;
	}
	public function getFirstname() {
		return $this->firstname;
	}
	public function getLastname() {
		return $this->lastname;
	}
	public function getEmail() {
		return $this->email;
	}
	public function getStatus() {
		return $this->status;
	}
	public function getNewsletter() {
		return $this->newsletter;
	}
	public function getRegisterDate() {
		return $this->register_date;
	}

	public function setId($id) {
		$this->id = $id;
	}
	public function setFbId($fb_id) {
		$this->fb_id = $fb_id;
	}
	public function setFirstname($firstname) {
		$this->firstname = $firstname;
	}
	public function setLastname($lastname) {
		$this->lastname = $lastname;
	}
	public function setEmail($email) {
		$this->email = $email;
	}
	public function setStatus($status) {
		$this->status = $status;
	}
	public function setNewsletter($newsletter) {
		$this->newsletter = $newsletter;
	}
	public function setRegisterDate($register_date) {
		$this->register_date = $register_date;
	}

}