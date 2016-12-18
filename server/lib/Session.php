<?php
class Session extends Instance {

	private $space;

	public function __construct($space = 'session') {
		if(is_array($space)) {
			extract($space);
		}

		self::start();
		$this->space = $space . session_id();
	}

	public function start() {
		if (!session_id()) {
			session_start();
		}
	}

	public function check($key) {
		return isset($_SESSION[$this->space][$key]);
	}

	public function remove($key) {
		if ($this->check($key)) {
			unset($_SESSION[$this->space][$key]);
		}
	}

	public function destroy() {
		$_SESSION[$this->space] = array();
	}

	public function set($key, $val) {
		$_SESSION[$this->space][$key] = $val;
	}

	public function get($key) {
		return $_SESSION[$this->space][$key];
	}

	public function getAll() {
		return $_SESSION[$this->space];
	}

}