<?php
class Authentication extends Instance {

	private $store;
	private $level = 0;
	private $params = array();

	public function __construct() {
		$this->store = new Cookie('auth', time() + 30 * 24 * 60 * 60);
		$this->init();
	}

	private function init() {
		$db = Application::get('db');
	}

	public function getLevel() {
		return $this->level;
	}

	public function getParams() {
		return $this->params;
	}

}