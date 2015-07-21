<?php

class Pagination {

	public $count_items = 10;
	public $count_pages = 0;
	public $count_total = 0;
	public $results = array();

	public function __construct($query = null, $vars = array(), $count_items = 10, $page = 0) {
		if (empty($query)) {
			throw new Exception('Undefined query for pagination');
		}

		$this->page = $page;
		$this->count_items = $count_items;
		$this->_exec($query, $vars);
	}

	private function _exec($query, $vars) {

		$this->count_total = Db::count($query, $vars);
		$this->count_pages = ceil($this->count_total / $this->count_items);

		$query .= ' LIMIT :start, :count_items';
		$vars['start'] = $this->page * $this->count_items;
		$vars['count_items'] = $this->count_items;

		$this->results = Db::select($query, $vars);

		return true;
	}

	public function getResults() {
		return $this->results;
	}

	public function getPagesCount() {
		return $this->count_pages;
	}

	public function getTotalCount() {
		return $this->count_total;
	}

}