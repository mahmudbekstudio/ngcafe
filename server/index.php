<?php
header('Access-Control-Allow-Origin: http://localhost:3000');//TODO: remove this line
if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
	$_POST = json_decode(file_get_contents('php://input'), true);

define('PATHROOT', dirname(__FILE__));
define('BASEURL', substr($_SERVER['PHP_SELF'], 0, strlen($_SERVER['PHP_SELF']) - 10));

function __autoload($className) {
	$pathList = array('lib', 'controller', 'model');

	foreach($pathList as $path) {
		$file = PATHROOT . '/' . $path . '/' . $className . '.php';

		if(file_exists($file)) {
			require_once $file;
			return true;
		}
	}

	return false;
}

require_once PATHROOT . '/config.php';

$db = new Database(
	Config::$db['host'],
	Config::$db['user'],
	Config::$db['pass'],
	Config::$db['db'],
	Config::$db['prefix'],
	Config::$db['charset'],
	Config::$db['collate']
);
$router = new AltoRouter(Config::$routes, BASEURL);

$app = new Application($db, $router);
$app->run(Config::$env);