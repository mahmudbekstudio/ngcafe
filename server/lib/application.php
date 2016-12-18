<?php
class Application {

	private $env;
	private static $vars;

	public function __construct($db, $router) {
		self::set('db', $db);
		self::set('router', $router);
	}

	public function run($env) {
		$this->env = $env;
		self::initRouter();
	}

	public static function set($var, $val) {
		self::$vars[$var] = $val;
	}

	public static function get($var) {
		if(!isset(self::$vars[$var])) {
			self::set($var, new $var());
		}

		return self::$vars[$var];
	}

	private static function initRouter() {
		$match = self::get( 'router' )->match();
		if($match !== false) {
			if(is_callable( $match['target'] )) {
				call_user_func($match['target'], $match['params']);
			} else {
				$targetArr = explode('#', $match['target']);
				$className = ucfirst($targetArr[0]) . 'Controller';
				$targetArr[1] = isset($targetArr[1]) ? trim($targetArr[1]) : false;

				if(!class_exists($className)) {
					die('Class "' . $className . '" is not exist');
				}

				$controllerInstance = new $className();
				$result = $controllerInstance->runAction($targetArr[1], $match['params']);
				self::sendResult($result);
			}
		} else {
			header("HTTP/1.0 404 Not Found");
		}
	}

	private static function sendResult($actionResult) {
		$status = array('result' => true, 'message' => '');
		$config = array();

		if(!$actionResult) {
			$status['result'] = false;
			$status['message'] = 'Error';
		}

		echo json_encode(array(
			'config' => $config,
			'data' => $actionResult,
			'status' => $status
		));
	}


}