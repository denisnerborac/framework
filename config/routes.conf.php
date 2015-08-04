<?php

global $routes;

$routes = array(

	#### Front ####

	'[/]?([0-9]*)' => array(
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
	'admin/contact/([a-zA-Z-_]+)/?([0-9]*)' => array(
		'target' => 'admin',
		'action' => 'contact_action'
	),

	/* Post */
	'admin/post/([a-zA-Z-_]+)/?([0-9]*)' => array(
		'target' => 'admin',
		'action' => 'post_action'
	)
);