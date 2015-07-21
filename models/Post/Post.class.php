<?php

class Post extends Model {

	private $author;
	private $title;
	private $content;
	private $date;

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