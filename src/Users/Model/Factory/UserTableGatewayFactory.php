<?php

namespace Users\Model\Factory;


use Users\Model\User;
use Zend\Db\ResultSet\ResultSet;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserTableGatewayFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $sm) {
		$dbAdapter = $sm->get('db-adapter');
		$resultSetPrototype = new ResultSet;
		$resultSetPrototype->setArrayObjectPrototype(new User);
		return new TableGateway("user", $dbAdapter, null, $resultSetPrototype);
	}
}