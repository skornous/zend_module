<?php

namespace Users\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class UserTable {

	protected $tableGateway;

	function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}

	function getUser($id) {
		$id = (int) $id;
		$select = new Select($this->tableGateway->getTable());
		$select->columns(['id', 'name', 'email'])->where(['id' => $id]);
		$rowSet = $this->tableGateway->selectWith($select);
		$row = $rowSet->current();

		if(!$row) {
			throw new \Exception("could not find row " . $id);
		}

		return $row;
	}

	function saveUser(User $user) {
		$data = [
			"name" => $user->getName(),
			"email" => $user->getEmail(),
		];
		$id = (int) $user->getId();

		if($id === 0) {
			$data['password'] = $user->getPassword();
			$this->tableGateway->insert($data);
		} else {
			if ($this->getUser($id)) {
				$this->tableGateway->update($data, ["id" => $id]);
			} else {
				throw new \Exception("User ID does not exists");
			}
		}
	}

	function fetchAll() {
		$rowSet = $this->tableGateway->select();
		return $rowSet;
	}

	function getUserByEmail($email) {
		$rowSet = $this->tableGateway->select(array("email" => $email));
		$row = $rowSet->current();

		if(!$row) {
			throw new \Exception("could not find row $email");
		}

		return $row;
	}

	function deleteUser($id) {
		$id = (int) $id;
		$this->tableGateway->delete(array("id" => $id));
	}

}