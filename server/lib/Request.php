<?php
class Request extends Instance {

	private $var;

	public function __construct($method = 'get') {
		$method = strtolower($method);

		if($method == 'get') {
			$this->var = $_GET;
		} else {
			$this->var = $_POST;
		}
	}

	public function get($name = false) {
		$result = $this->var;

		if($name !== false) {
			$result = isset($this->var[$name]) ? $this->var[$name] : false;
		}

		return $result;
	}

}