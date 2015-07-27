<?php

class Form {

	public $name;
	public $id;
	public $action;
	public $hidden_fields = array();
	public $fields = array();
	public $class = '';

	public function __construct($name = '', $id = '', $action = '', $method = 'POST', $class = '', $isSubmit = false) {
		$this->name 	= $name;
		$this->id 		= $id;
		$this->action 	= $action;
		$this->method 	= $method;
		$this->class 	= $class;
		$this->isSubmit	= $isSubmit;
	}

	public function getVars() {
		return get_object_vars($this);
	}

	public function addField() {
		$args = func_get_args();
		$field = new ReflectionClass('Field');
		$this->fields[] = $field->newInstanceArgs($args);
	}

	public function render() {

		$vars = $this->getVars();

		$response = new Response();

		return $response->render('partials/form.tpl', $vars, $fetch = true);
	}

	public function __toString() {
		return $this->render();
	}

}