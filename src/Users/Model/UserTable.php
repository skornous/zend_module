<?php
/**
 * Created by PhpStorm.
 * User: hugo
 * Date: 19/06/2015
 * Time: 17:24
 */

namespace Users\Model;

use Zend\Db\TableGateway;

class UserTable {

	protected $tableGateway;

	function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}

	function getUser($id) {
		$id = (int) $id;
		$rowSet = $this->tableGateway->select(array("id" => $id));
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
			"password" => $user->getPassword(),
		];

		$id = (int) $user->getId();
		if($id === 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getUser($id)) {
				$this->tableGateway->update($data, array("id" => $id));
			} else {
				throw new \Exception("User ID does not exists");
			}
		}
	}

}