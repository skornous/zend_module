<?php

namespace Users\Form\Factory;


use Users\InputFilter\User;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LoginFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $sm) {
		$form = new \Users\Form\Login;
		$form->setInputFilter(new User);
		$form->setValidationGroup(["email", "password", "security"]);

		return $form;
	}
}