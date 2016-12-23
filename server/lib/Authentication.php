<?php
class Authentication extends Instance {

	private $store;
	private $level = 0;
	private $params = array();
	private $hashSplitter = ';hash::';
	private $userModel = false;
	private $instanceList = array();

	public function __construct($space = 'auth', $expire = false) {
		if(!$expire) {
			$expire = time() + 30 * 24 * 60 * 60;
		}

		$this->userModel = new UserModel();

		$this->store = new Cookie($space, $expire);
		$this->init();
	}

	public function getInstance($space = 'auth', $expire = false) {
		if(!isset($this->instanceList[$space])) {
			$this->instanceList[$space] = new self($space, $expire);
		}

		return $this->instanceList[$space];
	}

	private function init() {
		if($this->store->check('hash')) {
			$hash = $this->store->get('hash');
			$id = $this->getIdFromHash($hash);

			$user = $this->userModel->getByHash($id, $hash);

			$this->reset($user['role'], $user);
		}
	}

	public function isAuth() {
		return count($this->getParams()) > 0;
	}

	public function authenticate($email, $pass) {
		$user = $this->userModel->getByEmail($email, '*');

		if(!$this->checkPassword($pass, $user)) {
			$user = array();
		} else {
			$fields = explode(',', $this->userModel->defaultFields);
			$newUser = array();

			foreach($fields as $val) {
				$val = trim($val);
				$newUser[$val] = $user[$val];
			}
			$user = $newUser;
		}

		if(!empty($user)) {
			$this->reset($user['role'], $user);

			$hash = $this->generateHash($user);
			$this->store->set('hash', $hash);
			$this->userModel->updateHash($hash, $user['id']);
		}

		return $user;
	}

	public function systemAuthenticate($pass) {
		$result = array();

		if(Application::get('authentication')->isAuth()) {
			$userMetaModel = new UserMetaModel();
			$userMeta = $userMetaModel->getUniquePassword($pass);

			if(isset($userMeta['user_id'])) {
				$params = Application::get('authentication')->getParams();

				if($params['id'] == $userMeta['user_id']) {
					$user = $params;
					$hash = Application::get('authentication')->getHash();
				} else {
					$user = $this->userModel->getById($userMeta['user_id']);
					$hash = $this->generateHash($user);
				}

				$this->reset($user['role'], $user);
				$this->store->set('hash', $hash);
				$this->userModel->updateHash($hash, $user['id']);

				$result = $user;
			}
		}

		return $result;
	}

	public function logout() {
		$result = array();
		if($this->store->check('hash')) {
			$hash = $this->store->get('hash');
			$id = $this->getIdFromHash($hash);

			$this->userModel->updateHash('', $id);

			$this->reset();
		}

		return $result;
	}

	private function reset($level = 0, $params = array()) {
		$this->level = $level;
		$this->params = $params;
	}

	public function getLevel() {
		return $this->level;
	}

	public function getParams() {
		return $this->params;
	}

	public function checkPassword($pass, $user) {
		$password = md5($user['id'] . $user['company_id'] . $pass . $user['registered']);

		return $user['pass'] === $password;
	}

	public function generateHash($user) {
		return $user['id'] . $this->hashSplitter . md5($user['id'] . Config::$web['companyId'] . time() . $_SERVER['REMOTE_ADDR']);
	}

	public function getIdFromHash($hash) {
		$hashArr = explode($this->hashSplitter, $hash);

		return $hashArr[0];
	}

	public function getHash() {
		return $this->store->get('hash');
	}

}