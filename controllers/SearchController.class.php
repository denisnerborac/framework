<?php

class SearchController extends BaseController {

	public function index() {
		return $this->results();
	}

	public function results() {

		$params = $this->getParams();

		$search_query = $this->request->get('q', '');
		$page = !empty($params[0]) ? (int) $params[0] : 1;

		$vars = array(
			'title' => 'Search',
			'description' => 'Description',
			'page' => $page,
			'count_pages' => 0,
			'posts' => array(),
			'count_total' => 0,
			'search_query' => $search_query
		);

		if (!empty($search_query)) {

			$pagination = new Pagination('SELECT * FROM posts WHERE title LIKE :search OR content LIKE :search ORDER BY date DESC', array(':search' => '%'.$search_query.'%'), 5, $page - 1);

			$vars = array_merge($vars, array(
				'page' => $page,
				'count_pages' => $pagination->getPagesCount(),
				'posts' => $pagination->getResults(),
				'count_total' => $pagination->getTotalCount()
			));
		}

		$this->render('search', $vars);
	}

}