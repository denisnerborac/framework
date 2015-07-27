<?php

class PostController extends BaseController {

	public function view() {

		$params = $this->getParams();

		if (empty($params[0])) {
			throw new ActionControllerException('Undefined post id');
		}

		$post_id = (int) $params[0];

		$post = Post::get($post_id);

		$vars = array(
			'title' => 'Title',
			'description' => 'Description',
			'post' => $post
		);

		$this->render('post', $vars);
	}

	public function archives() {

		$params = $this->getParams();

		$date = !empty($params[0]) ? $params[0] : date('Y-m');
		$page = !empty($params[1]) ? (int) $params[1] : 1;

		$time = strtotime($date);
		$date_label = ucfirst(Lang::_(strtolower(date('F', $time)))).' '.date('Y', $time);

		$pagination = new Pagination('SELECT * FROM posts WHERE DATE_FORMAT(date, "%Y-%m") = :date ORDER BY date DESC', array(':date' => $date), 4, $page - 1);

		/*
		// Same with date split without mysql function DATE_FORMAT()
		$date_parts = explode('-', $date);
		$year = $date_parts[0];
		$month = $date_parts[1];

		$pagination = new Pagination('SELECT * FROM posts WHERE YEAR(date) = :year AND MONTH(date) = :month ORDER BY date DESC', array(':year' => $year, ':month' => $month), 4, $page - 1);
		*/

		$vars = array(
			'title' => 'Title',
			'description' => 'Description',
			'date' => $date,
			'date_label' => $date_label,
			'page' => $page,
			'count_pages' => $pagination->getPagesCount(),
			'count_total' => $pagination->getTotalCount(),
			'posts' => $pagination->getResults()
		);

		$this->render('archives', $vars);
	}

}