<?php
class Application {

	private $env;
	private static $vars;

	public function __construct($db, $router) {
		self::set('db', $db);
		self::set('router', $router);
		$this->initToken();
	}

	public function run($env) {
		$this->env = $env;
		self::initRouter();
	}

	public function initToken() {
		$request = new Request();
		$token = $request->get('token');

		if($token) {
			$expire = time() + 30 * 24 * 60 * 60;
			foreach($token as $key => $val) {
				$store = new Cookie($key, $expire);
				$cookieVal = unserialize($val);
				foreach($cookieVal as $ck => $cv) {
					$store->set($ck, $cv);
				}
			}
		}
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
		$config = self::getResultConfig();

		if(!$actionResult) {
			$status['result'] = false;
			$status['message'] = 'Error';
		}

		$json = json_encode(array(
			'config' => $config,
			'data' => $actionResult,
			'status' => $status
		));

		$request = new Request();
		if($request->get('callback')) {
			$json = $request->get('callback') . '(' . $json . ')';
		}

		echo $json;
	}

	private static function getResultConfig() {
		$result = array(
			'auth' => array('login' => false, 'systemLogin' => false),
			'token' => Cookie::getAllCookie()
		);

		$result['auth']['login'] = self::get('authentication')->isAuth();

		$systemAuth = self::get('authentication')->getInstance('systemAuthentication');
		$result['auth']['systemLogin'] = $systemAuth->isAuth();

		return $result;
	}

}