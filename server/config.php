<?php
class Config {
	public static $db = array(
		'host'=> 'localhost',
		'db' => 'tradeposter',
		'user' => 'root',
		'pass' => '',
		'prefix' => 'trade_',
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
		array('GET', '/login', 'user#login', 'login'),//TODO: change to POST
		array('GET|POST', '/logout', 'user#logout', 'logout'),
		array('GET', '/systemlogin', 'user#systemlogin', 'systemlogin'),//TODO: change to POST
		array('GET', '/config', 'default#config', 'config'),
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