<?php

class AdminController extends BaseAdminController {

	/*
	public function __construct($controller) {
		parent::__construct($controller);

		// Local stuff...
	}
	*/

	public function index() {

		$vars = array();

		$this->render('admin/index', $vars);
	}

	public function post() {
		return $this->base_list('post', array('id', 'title', 'author', 'date'));
	}

	public function post_action() {
		return $this->base_action('post');
	}

	public function contact() {
		return $this->base_list('contact', array('id', 'firstname', 'lastname', 'message'), 'lastname, firstname');
	}

	public function contact_action() {
		return $this->base_action('contact');
	}

	public function search() {

		$vars = array();

		$this->render('admin/search', $vars);
	}

	public function crop() {

		$thumb_width = 200;
		$thumb_height = 200;

		if ($this->request->isPost()) {

			$jpeg_quality = 90;

			$src = IMG_PATH.'image.jpg';

			$img_r = imagecreatefromjpeg($src);
			$dst_r = ImageCreateTrueColor($thumb_width, $thumb_height);

			imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
			$thumb_width,$thumb_height,$_POST['w'],$_POST['h']);

			header('Content-type: image/jpeg');
			imagejpeg($dst_r, null, $jpeg_quality);

			return true;
		}

		$vars = array(
			'thumb_width' => $thumb_width,
			'thumb_height' => $thumb_height
		);

		$this->render('admin/crop', $vars);
	}
}