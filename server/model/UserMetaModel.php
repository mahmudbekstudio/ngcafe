<?php
class UserMetaModel extends Model {
	public $table = 'user_meta';
	private $checkCompany = '';

	public function __construct() {
		parent::__construct();
		$this->checkCompany = "`company_id`='" . Config::$web['companyId'] . "'";
	}

	public function getUniquePassword($pass) {
		$pass = addslashes(trim($pass));
		return $this->get(array(
			'where' => $this->checkCompany . " AND `meta_key`='unique_company_pass' AND `meta_value`='" . $pass . "'"
		), true);
	}

}