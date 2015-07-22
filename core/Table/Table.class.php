<?php

class Table {

	public $id;
	public $entity;
	public $data;
	public $cols;

	public function __construct($id = '', $entity = '', $data = array(), $cols = array()) {

		$this->id = $id;
		$this->entity = $entity;
		$this->data = $data;
		$this->cols = $cols;
	}

	public function get() {
		$response = new Response();

		return $response->render('partials/table', array('this' => $this), $fetch = true);
	}

}