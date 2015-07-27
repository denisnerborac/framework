<?php
class User extends Model {

	protected $id;
	protected $fb_id;
	protected $firstname;
	protected $lastname;
	protected $email;
	protected $password;
	protected $status;
	protected $newsletter;
	protected $cgu;
	protected $register_date;

	private $session;

	public function __construct($data = array()) {
		parent::__construct($data);

		$this->session = Session::getInstance();
	}

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
	public function getPassword() {
		return $this->password;
	}
	public function getStatus() {
		return $this->status;
	}
	public function getNewsletter() {
		return $this->newsletter;
	}
	public function getCgu() {
		return $this->cgu;
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
		if (empty($firstname)) {
			throw new Exception('Vous devez renseigner votre prénom');
		}
		$this->firstname = $firstname;
	}
	public function setLastname($lastname) {
		if (empty($lastname)) {
			throw new Exception('Vous devez renseigner votre nom');
		}
		$this->lastname = $lastname;
	}
	public function setEmail($email) {
		if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
			throw new Exception('Vous devez renseigner un email valide');
		}
		$this->email = $email;
	}
	public function setPassword($password) {
		if (strlen($password) < 6) {
			throw new Exception('Vous devez fournir un mot de passe de 6 caractères minimum');
		}
		$this->password = $password;
	}
	public function setStatus($status) {
		$this->status = $status;
	}
	public function setNewsletter($newsletter) {
		$this->newsletter = $newsletter;
	}
	public function setCgu($cgu) {
		if (empty($cgu)) {
			throw new Exception('Vous devez accepter les CGU');
		}
		$this->cgu = $cgu;
	}
	public function setRegisterDate($register_date) {
		$this->register_date = $register_date;
	}

	public static function isLogged() {
		return Session::getInstance()->user_id;
	}

	public function checkRememberMe() {

		$remember_me = Authent::getRememberMe();

		if ($remember_me !== false) {

			$user_id = $remember_me;

			$user = self::get($user_id);

			if (!empty($user)) {

				$this->session->user_id = $user->id;
				$this->session->firstname = $user->firstname;

				return true;
			}
		}

		return false;
	}

	public function checkLogin($remember_me = false) {

		$result = Db::selectOne('SELECT * FROM user WHERE email = :email', array('email' => $this->email));


		if (!empty($result)) {

			$user = new User($result);

			$crypted_password = $user->password;

			if (password_verify($this->password, $crypted_password)) {

				if (!empty($remember_me)) {
					Authent::setRememberMe($user->id);
				}

				$this->session->user_id = $user->id;
				$this->session->firstname = $user->firstname;

				return true;
			}
		}
		return false;
	}

	public function checkAlreadyExists() {
		if (empty($this->email)) {
			return false;
		}
		$user = Db::select('SELECT * FROM user WHERE email = :email', array('email' => $this->email));
		if (!empty($user)) {
			return true;
		}
		return false;
	}

	public function register() {
		return Db::insert('INSERT INTO user (lastname, firstname, email, password, newsletter, cgu, register_date) VALUES (:lastname, :firstname, :email, :password, :newsletter, :cgu, NOW())', array(
					'lastname' => $this->lastname,
					'firstname' => $this->firstname,
					'email' => $this->email,
					'password' => $this->password,
					'newsletter' => $this->newsletter,
					'cgu' => $this->cgu
				));
	}


}