<?php

class Post extends Model {

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
		return $this->title;
	}
	public function getContent() {
		return $this->content;
	}
	public function getDate() {
		return $this->date;
	}

	/* Setters */
	public function setId($id) {
		$this->id = $id;
	}
	public function setAuthor($author) {
		$this->author = $author;
	}
	public function setTitle($title) {
		$this->title = $title;
	}
	public function setContent($content) {
		$this->content = $content;
	}
	public function setDate($date) {
		$this->date = $date;
	}
}