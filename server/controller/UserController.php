<?php
class UserController extends Controller {

	protected $access = array(
		array(
			'action' => array('login'), //list of actions to access
			'operation' => '=', //>, >=, <, <=, = (default =)
			'lavel' => 'guest' //user role (Guest) level (default 0)
		)
	);

	public function actionLogin() {
		$request = new Request('get');//TODO: change to post

		$result = Application::get('authentication')->authenticate($request->get('email'), $request->get('pass'));

		return $result;
	}

	public function actionLogout() {
		return Application::get('authentication')->logout();
	}

	public function actionSystemlogin() {
		$request = new Request('get');//TODO: change to post
		$auth = Application::get('authentication')->getInstance('systemAuthentication');
		$auth->systemAuthenticate($request->get('pass'));
		return array();
	}

}