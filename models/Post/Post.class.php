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
		if (empty($date)) {
			return false;
		}
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
		$form->addField('date', Lang::_('Date'), 'date', $this->_getfieldvalue('date', $type, $request), false, '', @$errors['date']);

		return $form;
	}

	public function insert() {

		return Db::insert(
			'INSERT INTO post (author, title, content, date)
		 	 VALUES (:author, :title, :content, :date)',
			array(
				'author' => $this->author,
				'title' => $this->title,
				'content' => $this->content,
				'date' => $this->date ?: date('Y-m-d H:i:s')
			)
		);
	}

	public function update() {

		if (empty($this->id)) {
			throw new Exception('Update error - Undefined post id');
		}

		return Db::update(
			'UPDATE post SET author = :author, title = :title, content = :content, date = :date
		 	 WHERE id = :id',
			array(
				'author' => $this->author,
				'title' => $this->title,
				'content' => $this->content,
				'date' => $this->date ?: date('Y-m-d H:i:s'),
				'id' => (int) $this->id
			)
		);
	}

	public function delete() {

		if (empty($this->id)) {
			throw new Exception('Delete error - Undefined post id');
		}

		return Db::delete('DELETE FROM post WHERE id = :id', array('id' => $this->id));
	}

}