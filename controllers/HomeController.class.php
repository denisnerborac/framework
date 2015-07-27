<?php

class HomeController extends BaseController {

	public function index() {

		$page = (int) $this->getParam(0, 1);

		$pagination = new Pagination('SELECT * FROM posts ORDER BY date DESC', array(), 4, $page - 1);

		$vars = array(
			'title' => 'Blog',
			'description' => 'Description',
			'page' => $page,
			'count_pages' => $pagination->getPagesCount(),
			'posts' => $pagination->getResults(),
			'count_total' => $pagination->getTotalCount()
		);

		$this->render('index', $vars);
	}

}