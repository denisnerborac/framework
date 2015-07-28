<?php

class Post extends Model {

	protected $id;
	protected $author;
	protected $title;
	protected $content;
	protected $date;

	/* Getters */
	public function getId() {
		return $this->id;
	}
	public function getAuthor() {
		return $this->author;
	}
	public function getTitle() {
		return ucfirst($this->title);
	}
	public function getContent() {
		return nl2br(htmlspecialchars($this->content));
	}
	public function getDate($format = 'Y-m-d H:i:s') {
		return date($format, strtotime($this->date));
	}

	/* Setters */
	public function setId($id) {
		$this->id = $id;
	}
	public function setAuthor($author) {
		if (empty($author) || strlen($author) > 100) {
			throw new Exception(Lang::_('Author cannot be empty and must be 100 chars max'));
		}
		$this->author = $author;
	}
	public function setTitle($title) {
		if (empty($title) || strlen($title) > 255) {
			throw new Exception(Lang::_('Post title cannot be empty and must be 255 chars max'));
		}
		$this->title = $title;
	}
	public function setContent($content) {
		if (empty($content) || strlen($content) > 65536) {
			throw new Exception(Lang::_('Post content cannot be empty and must be 65536 chars max'));
		}
		$this->content = $content;
	}
	public function setDate($date) {
		if (strtotime($date) === false) {
			throw new Exception(Lang::_('Post date must be valid'));
		}
		$this->date = $date;
	}

	public function getForm($type, $action, $request, $isPost = false, $errors = array()) {

		$form = new Form('form-post-'.$type, 'form-post-'.$type, $action, 'POST', 'form-horizontal', $errors, $isPost);
		$form->addField('author', Lang::_('Author'), 'text', $this->_getfieldvalue('author', $type, $request), true, '', @$errors['author']);
		$form->addField('title', Lang::_('Title'), 'text', $this->_getfieldvalue('title', $type, $request), true, '', @$errors['title']);
		$form->addField('content', Lang::_('Content'), 'text', $this->_getfieldvalue('content', $type, $request), true, '', @$errors['content']);
		$form->addField('date', Lang::_('Date'), 'text', $this->_getfieldvalue('date', $type, $request), false, '', @$errors['date']);

		return $form;
	}

}