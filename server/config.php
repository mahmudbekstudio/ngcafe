<?php
class Config {
	public static $db = array(
		'host'=> 'localhost',
		'db' => 'student',
		'user' => 'root',
		'pass' => '',
		'prefix' => 'std_',
		'charset' => 'utf8',
		'collate' => '',
	);

	public static $web = array(
		'companyId' => 1,
		'appName' => 'Trade Poster',
		'adminEmail' => 'mahmudbekstudio@mail.ru',
		//'theme' => '',
	);

	public static $routes = array(
		array('GET', '/goodslist', 'goods#list', 'goodslist'),
		array('POST', '/login', 'user#login', 'login'),
	);

	public static $level = array(
		'guest' => 0,
		'user' => 1,
		'author' => 2,
		'editor' => 3,
		'admin' => 4,
		'superadmin' => 5
	);

	public static $env = 'dev';
}