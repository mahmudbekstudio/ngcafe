<?php
class UserController extends Controller {

	protected $access = array(
		array(
			'action' => array('systemlogin'), //list of actions to access
			'operation' => '=', //>, >=, <, <=, = (default =)
			'lavel' => 'guest' //user role (Guest) level (default 0)
		)
	);

	public function actionlogin() {
		$request = new Request('post');

		return $request->get('email');
	}

}