<?php

class Table {

	public $id;
	public $entity;
	public $data;
	public $cols;
	public $edit_url;
	public $delete_url;

	public function __construct($id = '', $entity = '', $data = array(), $cols = array(), $edit_url = '', $delete_url = '') {

		$this->id = $id;
		$this->entity = $entity;
		$this->data = $data;
		$this->cols = $cols;
		$this->edit_url = $edit_url;
		$this->delete_url = $delete_url;
	}

	public function render() {
		$response = new Response();
		return $response->render('partials/table', array('table' => $this), $fetch = true);
	}

}