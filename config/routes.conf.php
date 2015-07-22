<?php

global $routes;

$routes = array(
	/* Front */
	'/' => array(
		'target' => 'home',
		'action' => 'index'
	),
	'post/([0-9]+)' => array(
		'target' => 'post',
		'action' => 'view'
	),
	'post/archives/([0-9\-]+)/([0-9]+)' => array(
		'target' => 'post',
		'action' => 'archives'
	),
	'search' => array(
		'target' => 'search',
		'action' => 'results'
	),

	/* Backoffice */
	'admin/contact/edit/([0-9\-]+)' => array(
		'target' => 'admin',
		'action' => 'contact_edit'
	),
	'admin/contact/delete/([0-9\-]+)' => array(
		'target' => 'admin',
		'action' => 'contact_delete'
	)
);