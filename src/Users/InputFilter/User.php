<?php

namespace Users\InputFilter;

use Zend\InputFilter\InputFilter;

class User extends InputFilter {

	function __construct() {
		// filtres et validateurs pour le nom
		$this->add([
			"name" => "name",
			"filters" => [
				["name" => "StringTrim"],
				["name" => "StripTags"],
			],
			"validators" => [
				[
					"name" => "StringLength",
					"options" => [
						"min" => 1,
						"max" => 100
					],
				],
			],
		]);

		// filtrage et validation pour l'email
		$this->add([
			"name" => "email",
			"filters" => [
				["name" => "StringTrim"],
				["name" => "StripTags"],
			],
			"validators" => [
				["name" => "EmailAddress"],
			],
		]);

		// filtrage et validation pour le password
		$this->add([
			"name" => "password",
			"validators" => [
				[
					"name" => "StringLength",
					"options" => [
						"min" => 8,
					],
				],
			],
		]);

		// filtrage et validation pour le password_confirm
		$this->add([
			"name" => "password_confirm",
			"validators" => [
				[
					"name" => "Identical",
					"options" => [
						"token" => "password",
					],
				],
			],
		]);
	}
}