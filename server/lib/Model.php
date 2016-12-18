<?php
class Model extends Instance {

	public $table = '';
	public $db;
	private $idName = 'id';

	public function __construct() {
		$this->db = Application::get('db');
	}

	public function get($params = array()) {
		return $this->db->select($this->table, $params);
	}

	public function delete($id, $operation = 'OR') {
		$this->db->delete($this->table, $this->createWhere($id, $operation));
	}

	private function createWhere($id, $operation = 'OR') {
		$where = '';
		if(is_array($id)) {
			foreach($id as $key => $val) {
				$where .= $where ? $operation : '';
				if(is_string($key)) {
					$where .= "`" . $key . "`='" . $val . "'";
				} else {
					$where .= "`" . $this->idName . "`='" . $val . "'";
				}
			}
		} elseif(is_int($id)) {
			$where = "`" . $this->idName . "`='" . $id . "'";
		} else {
			$where = $id;
		}

		return $where;
	}

	public function getId() {
		return $this->idName;
	}

	public function setId($idName) {
		$this->idName = $idName;
	}

	public function getItem($id) {
		$result = $this->get(array('where' => "`" . $this->idName . "`='" . $id . "'"));
		if(!empty($result)) {
			return $result[0];
		}
		return false;
	}

	public function update($fields, $where = '') {
		$this->db->update($this->table, $fields, $where);
	}

	public function insert($fields) {
		return $this->db->insert($this->table, $fields);
	}

}