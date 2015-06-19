<?php

namespace Users\Model;

class User {
	private $id;
	private $name;
	private $email;
	private $password;

	public function exchangeArray($data) {
		$this->id = (isset($data["id"])) ? $data["id"] : null;
		$this->name = (isset($data["name"])) ? $data["name"] : null;
		$this->email = (isset($data["email"])) ? $data["email"] : null;
		$this->password = (isset($data["password"])) ? $this->setPassword($data["password"]) : null;
	}

	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param mixed $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @param mixed $email
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * @return mixed
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @param mixed $password
	 */
	public function setPassword($password) {
		$this->password = sha1($password);
	}



}