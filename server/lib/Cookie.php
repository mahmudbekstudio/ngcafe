<?php
class Cookie extends Instance {

	private $space;
	private $default = array();

	public function __construct($space = 'cookie', $expire = 0, $path = '/', $domain = '', $secure = false, $httponly = false) {
		$this->space = $space . session_id();
		$this->default['expire'] = $expire;
		$this->default['path'] = $path;
		$this->default['domain'] = $domain;
		$this->default['secure'] = $secure;
		$this->default['httponly'] = $httponly;
	}

	public function check($key) {
		return isset($_COOKIE[$this->space][$key]);
	}

	public function remove($key) {
		if ($this->check($key)) {
			$this->set($key, null);
		}
	}

	public function destroy() {
		$list = $this->getAll();
		foreach($list as $key => $val) {
			$this->remove($key);
		}
	}

	public function set($key, $val) {
		setcookie(
			$this->space . '[' . $key . ']',
			(string)$val,
			$this->default['expire'],
			$this->default['path'],
			$this->default['domain'],
			$this->default['secure'],
			$this->default['httponly']
		);
	}

	public function get($key) {
		return $_COOKIE[$this->space][$key];
	}

	public function getAll() {
		return $_COOKIE[$this->space];
	}

}