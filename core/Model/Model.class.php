<?php
abstract class Model {

	protected $table;
	protected $id;

	public function __construct($data = array()) {

		$this->table = self::getDbTable();

		foreach($data as $key => $value) {
			$method = $this->_setter($key);
			if (method_exists($this, $method)) {
				$this->$method($value);
			}
		}
	}

	public function __get($key)	{
		$method = $this->_getter($key);
		if (!method_exists($this, $method)) {
            throw new Exception('Undefined getter ['.$method.'] for class '.get_class($this));
			return NULL;
        }
		return $this->$method();
	}

	public function __set($key, $value)	{
		$method = $this->_setter($key);
		if (!method_exists($this, $method)) {
			throw new Exception('Undefined setter ['.$method.'] for class '.get_class($this));
			return false;
		}
		$this->$method($value);
		return true;
	}

	public static function get($id) {
		return self::getById($id);
	}

	public static function getById($id) {
		$result = Db::selectOne('SELECT * FROM '.self::getDbTable().' WHERE id = :id', array('id' => $id));
		$class = get_called_class();
		return new $class($result);
	}

	protected static function getDbTable() {
		return strtolower(get_called_class());
	}

	protected function getId() {
		return $this->id;
	}

	protected function getVars() {
		return get_object_vars($this);
	}

	protected function getDbFields() {
		$vars = $this->getVars();
		unset($vars['table']);

		$fields = array();
		foreach($vars as $key => $var) {
			if (!is_array($var) && !is_object($var)) {
				$fields[$key] = $var;
			}
		}
		return $fields;
	}

	private function _setter($key) {
		return 'set'.Utils::camelCase($key);
	}

	private function _getter($key) {
		return 'get'.Utils::camelCase($key);
	}
}