<?php
class Controller extends Instance {
	protected $access = array(
		/*array(
			'action' => array(), //list of actions to access
			'operation' => '=', //>, >=, <, <=, = (default =)
			'lavel' => '0' //user role (Guest) level (default 0)
		)*/
	);

	private $models = array();

	public function __construct() { }

	public function actionIndex() {
		return array();
	}

	public function runAction($actionName = false, $param = array()) {
		$actionName = (!$actionName || $actionName == '') ? 'index' : $actionName;
		$methodName = 'action' . ucfirst($actionName);

		if(!method_exists($this, $methodName) || !$this->checkAccess($actionName)) {
			$methodName = 'action404';
		}

		return call_user_func_array(array($this, $methodName), $param);
	}

	private function checkAccess($action) {
		$result = true;
		$access = $this->access;
		if(is_array($access) && ($accessCount = count($access)) > 0) {
			$level = Application::get('authentication')->getLevel();
			$config = Config::$level;

			for($i = 0; $i < $accessCount; $i++) {
				$access[$i]['lavel'] = isset($config[$access[$i]['lavel']]) ? $config[$access[$i]['lavel']] : $access[$i]['lavel'];

				if(in_array($action, $access[$i]['action']) ) {
					if($access[$i]['operation'] == '>') {
						$result = $level > $access[$i]['lavel'];
					} elseif($access[$i]['operation'] == '>=') {
						$result = $level >= $access[$i]['lavel'];
					} elseif($access[$i]['operation'] == '<') {
						$result = $level < $access[$i]['lavel'];
					} elseif($access[$i]['operation'] == '<=') {
						$result = $level <= $access[$i]['lavel'];
					} else {//$access[$i]['operation'] == '='
						$result = $level == $access[ $i ]['lavel'];
					}

					break;
				}
			}
		}
		return $result;
	}

	public function action404() {
		//header("HTTP/1.0 404 Not Found");
		return false;
	}

	public function getAccess() {
		return $this->access;
	}

	public function getModel($name) {
		if(!isset($this->models[$name])) {
			$modelClass = ucfirst(strtolower($name)) . 'Model';
			$this->models[$name] = new $modelClass();
		}

		return $this->models[$name];
	}
}