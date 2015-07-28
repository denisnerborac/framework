<?php

global $routes;

$routes = array(

	#### Front ####

	'/' => array(
		'target' => DEFAULT_CONTROLLER_TARGET,
		'action' => DEFAULT_CONTROLLER_ACTION
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
	'login' => array(
		'target' => 'user',
		'action' => 'login'
	),
	'register' => array(
		'target' => 'user',
		'action' => 'register'
	),
	'logout' => array(
		'target' => 'user',
		'action' => 'logout'
	),


	##### Backoffice ####

	/* Contact */
	'admin/contact/create' => array(
		'target' => 'admin',
		'action' => 'contact_edit'
	),
	'admin/contact/update/([0-9\-]+)' => array(
		'target' => 'admin',
		'action' => 'contact_edit'
	),
	'admin/contact/edit/([0-9\-]+)' => array(
		'target' => 'admin',
		'action' => 'contact_edit'
	),
	'admin/contact/delete/([0-9\-]+)' => array(
		'target' => 'admin',
		'action' => 'contact_delete'
	),

	/* Post */
	'admin/post/create' => array(
		'target' => 'admin',
		'action' => 'post_create'
	),
	'admin/post/update/([0-9\-]+)' => array(
		'target' => 'admin',
		'action' => 'post_update'
	),
	'admin/post/edit/([0-9\-]+)' => array(
		'target' => 'admin',
		'action' => 'post_edit'
	),
	'admin/post/delete/([0-9\-]+)' => array(
		'target' => 'admin',
		'action' => 'post_delete'
	)
);