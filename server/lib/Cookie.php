<?php
class Cookie extends Instance {

	private $space;
	private $default = array();
	private static $sapceList = array();

	public function __construct($space = 'cookie', $expire = 0, $path = '/', $domain = '', $secure = false, $httponly = false) {
		$this->space = $space;
		$this->default['expire'] = $expire;
		$this->default['path'] = $path;
		$this->default['domain'] = $domain;
		$this->default['secure'] = $secure;
		$this->default['httponly'] = $httponly;

		self::$sapceList[] = $space;
	}

	public static function getAllCookie() {
		$cookie = $_COOKIE;
		$result = array();

		foreach($cookie as $key => $val) {
			if(in_array($key, self::$sapceList)) {
				$result[$key] = $val;
			}
		}

		return $result;
	}

	private function issetCookie() {
		return isset($_COOKIE[$this->space]);
	}

	private function getCookie() {
		if(!$this->issetCookie()) {
			$this->setCookie();
		}

		return unserialize($_COOKIE[$this->space]);
	}

	private function setCookie($val = array()) {
		$val = serialize($val);
		if(!$this->issetCookie()) {
			setcookie(
				$this->space,
				$val,
				$this->default['expire'],
				$this->default['path'],
				$this->default['domain'],
				$this->default['secure'],
				$this->default['httponly']
			);
		}

		$_COOKIE[$this->space] = $val;
	}

	public function check($key) {
		$cookie = $this->getCookie();
		return isset($cookie[$key]);
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
		$cookie = $this->getCookie();
		$cookie[$key] = $val;
		$this->setCookie($cookie);
	}

	public function get($key) {
		$cookie = $this->getCookie();
		return $cookie[$key];
	}

	public function getAll() {
		return $this->getCookie();
	}

}