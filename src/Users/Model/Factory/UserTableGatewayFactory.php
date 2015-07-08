<?php
/**
 * Created by PhpStorm.
 * User: hugo
 * Date: 08/07/2015
 * Time: 11:56
 */

namespace Users\src\Users\Model\Factory;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserTableGatewayFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $sm) {
		$dbAdapter = $sm->get('db-adapter');
		$resultSetPrototype = new \Zend\Db\ResultSet\ResultSet();
		$resultSetPrototype->setArrayObjectPrototype(new \Users\Model\User);
		return new TableGateway("user", $dbAdapter, null, $resultSetPrototype);
	}
}