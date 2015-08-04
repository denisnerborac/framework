<?php
abstract class Model extends Core {

	protected $table;
	protected $id;

	public static function get($id) {
		return self::getById($id);
	}

	public static function getById($id) {
		$result = Db::selectOne('SELECT * FROM '.self::getDbTable().' WHERE id = :id', array('id' => $id));
		if (empty($result)) {
			return null;
		}
		$class = self::getClass();
		return new $class($result);
	}

	public static function getList($query = '', $vars = array()) {
		if (empty($query)) {
			$query = 'SELECT * FROM '.self::getDbTable();
		}
		return self::_getList(Db::select($query, $vars));
	}

	protected function insert() {

		$args = func_get_args();
		$vars = !empty($args[0]) ? $args[0] : array();
		$on_duplicate_key = (bool) !empty($args[1]) ? $args[1] : false;

		if (empty($vars)) {
			throw new Exception('Insert error - No '.self::getClass().' data to insert');
		}

		$sql = 'INSERT INTO '.self::getDbTable().' SET id = null';
		foreach($vars as $key => $value) {
			$sql .= ', '.$key.' = :'.$key;
		}
		if ($on_duplicate_key === true) {
			$sql .= ' ON DUPLICATE KEY UPDATE id = id';
			foreach($vars as $key => $value) {
				$sql .= ', '.$key.' = :'.$key;
			}
		}
		return Db::insert($sql, $vars);
	}

	protected function update() {

		if (empty($this->id)) {
			throw new Exception('Update error - Undefined '.self::getClass().' id');
		}

		$args = func_get_args();
		$vars = !empty($args[0]) ? $args[0] : array();

		if (empty($vars)) {
			throw new Exception('Update error - No '.self::getClass().' data to update');
		}

		$sql = 'UPDATE '.self::getDbTable().' SET id = :id';
		foreach($vars as $key => $value) {
			$sql .= ', '.$key.' = :'.$key;
		}
		$sql .= ' WHERE id = :id';

		if (!isset($vars['id'])) {
			$vars['id'] = $this->id;
		}

		return Db::update($sql, $vars);
	}

	protected function delete() {
		if (empty($this->id)) {
			throw new Exception('Delete error - Undefined '.self::getClass().' id');
		}
		return Db::delete('DELETE FROM '.self::getDbTable().' WHERE id = :id', array('id' => $this->id));
	}

	protected function getId() {
		return $this->id;
	}

	protected function _getFieldValue($key, $type, $request = null) {
		switch($type) {
			case 'insert':
			case 'create':
				return !is_null($request) && is_object($request) ? $request->post($key) : null;
			break;
			case 'update':
				return $this->$key;
			break;
		}
		return null;
	}

	private static function _getList($result) {
		$entity = self::getClass();
		$items = array();
		foreach($result as $item) {
			$items[] = new $entity($item);
		}
		return $items;
	}
}