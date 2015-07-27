<?php

class SessionException extends CustomException {}

class Session {

	protected $_name = 'PHP_SESSID';
	protected $_session_id = 0;
	protected $_session = array();

	private static $instance;

	public function __construct($name = null) {

		$this->_name = $name ?: $this->_name;

		session_name($this->_name);
		session_start();

		$this->_session_id = session_id();
		$this->_session = array_merge($this->_session, !empty($_SESSION) ? $_SESSION : array());
		$this->_clean();

		return true;
	}

	public static function getInstance($name = null) {
		if(!isset(self::$instance)) {
			self::$instance = new Session($name);
		}
		return self::$instance;
	}

	public function __set($key, $value) {
		$this->_session[$key] = $value;
		$this->_save();
	}

	public function __get($key)	{
		return isset($this->_session[$key]) ? $this->_session[$key] : null;
	}

	public function _unset($key) {
		if (isset($this->_session[$key])) {
			unset($this->_session[$key]);
			$this->_save();
		}
	}

	protected function _save() {
		try {
			if ($this->isActive()) {
				$_SESSION = $this->_session;
				return true;
			}
			//throw new SessionException('Session Save Error');
			return false;
		}
		catch (SessionException $e) {
			Logger::log($e);
		}
	}

	public function _destroy() {
		$this->_session = array();
		$this->_session_id = 0;
		$this->_save();

		if ($this->isActive()) {
			if (ini_get("session.use_cookies")) {
				$params = session_get_cookie_params();
				setcookie(session_name(), '', 1,
					$params["path"], $params["domain"],
					$params["secure"], $params["httponly"]
				);
			}

			session_destroy();
		}
	}

	protected function _clean() {
		if(get_magic_quotes_gpc()) {
			$this->_session = $this->_stripslashes($this->_session);
		}
	}

	protected function _stripslashes($value) {
	    if(is_array($value)) {
			return array_map(array($this,'_stripslashes'), $value);
		} else {
			return stripslashes($value);
		}
	}

    public function getName() {
    	return $this->_name;
    }

    public function isActive() {
        return empty($this->_session_id) ? false : true;
    }

	public function __toString() {
		return var_export($this, true);
	}
}