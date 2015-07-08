<?php

namespace Users\Form\Factory;


use Users\Form\Register;
use Users\InputFilter\User;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RegisterFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $sm) {
		$form = new Register;
		$form->setInputFilter(new User);

		return $form;
	}
}