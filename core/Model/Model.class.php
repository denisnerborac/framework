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
		$class = get_called_class();
		return new $class($result);
	}

	public static function getList($query, $vars = array()) {
		return self::_getList(Db::select($query, $vars));
	}

	protected function getId() {
		return $this->id;
	}

	protected function _getFieldValue($key, $type, $request = null) {
		switch($type) {
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