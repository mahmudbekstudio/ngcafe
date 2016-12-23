<?php
	class UserModel extends Model {
		public $table = 'user';
		private $defaultFields = 'id, email, role, firstname, lastname';
		private $checkCompany = '';

		public function __construct() {
			parent::__construct();
			$this->checkCompany = "`company_id`='" . Config::$web['companyId'] . "'";
		}

	public function getByHash($id, $hash) {
		return $this->get(array(
			'fields' => $this->defaultFields,
			'where' => $this->checkCompany . " AND `status`='1' AND `id`='" . $id . "' AND `hash_code`='" . $hash . "'"
		), true);
	}

	public function getByEmail($email, $fields = false) {
		if(!$fields) {
			$fields = $this->defaultFields;
		}

		return $this->get(array(
			'fields' => $fields,
			'where' => $this->checkCompany . " AND `status`='1' AND `email`='" . addslashes($email) . "'"
		), true);
	}

	public function getById($id) {
		return $this->get(array(
			'fields' => $this->defaultFields,
			'where' => $this->checkCompany . " AND `status`='1' AND `id`='" . $id . "'"
		), true);
	}

	public function getDefaultFields() {
		return $this->defaultFields;
	}

	public function updateHash($hash, $id) {
		$this->update(array('hash_code' => $hash), $this->checkCompany . " AND `id`='" . $id . "'");
	}
}