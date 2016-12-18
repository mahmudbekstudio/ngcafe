<?php
/**
 * Abstract class Instance
 * main template for other classes
 */

abstract class Instance {

	/**
	 * get object
	 * if not exist then create
	 */
	public function getInstance() {
		throw new Exception('This is abstract class "Instance"');
	}

	/**
	 * Magic function getter
	 *
	 * @param string $var_name  Name of variable got get value
	 * @return mixed            Return variable value, if not exist then return NULL
	 */
	public function __get($var_name) {
		$method_name = 'get' . $var_name;
		if (method_exists($this, $method_name)) {
			return $this->$method_name();
		}
		return NULL;
	}

	/**
	 * Magic function setter
	 *
	 */
	public function __set($var_name, $var_val) {
		$method_name = 'set' . $var_name;
		if (method_exists($this, $method_name)) {
			$this->$method_name($var_val);
		} else {
			throw new Exception('In class "' . __CLASS__ . '" preoperty "' . $var_name . '" not found or you cannot access');
		}
	}

	public function __isset($var_name) {
		$method_name = 'get' . $var_name;
		return method_exists($this, $method_name);
	}

	public function __unset($var_name) {
		$this->__set($var_name, NULL);
	}

	public function __toString() {
		return __CLASS__;
	}

	public function getClassName($inLowerCase = false) {
		$class = get_called_class();
		$className = substr($class, strrpos($class, '\\') + 1, strlen($class));
		if($inLowerCase) {
			$className = strtolower($className);
		}
		return $className;
	}

}