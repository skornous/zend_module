<?php

namespace Users\Controller;

use Users\Form\Register;
use Users\InputFilter\User;
use Users\Model\UserTable;
use Users\Model\User as UserModel;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\ResultSet\ResultSet;

class RegisterController extends AbstractActionController {

    public function indexAction() {
	    $form = new Register("formulaire");
        return new ViewModel(['registerForm' => $form]);
    }

	public function processAction() {
		if($this->request->isPost() === false) {
			return $this->redirect()->toRoute(null, [
				"controller" => "register",
				"action" => "index"
			]);
		}
		$post = $this->request->getPost();
		$form = new Register;
		$form->setInputFilter(new User);
		$form->setData($post);

		if ($form->isValid() === false){
			$view = new ViewModel([
				"error" => true,
				"registerForm" => $form
			]);
			$view->setTemplate("users/register/index");
			return $view;
		}
		$cleanData = $form->getData(); // "data" is now clean
		$this->createUser($cleanData); // saving user with clean data
		return $this->redirect()->toRoute(null,[ //redirect to confirm
			"controller" => "register",
			"action" => "confirm"
		]);
	}

	public function confirmAction() {
		return new ViewModel();
	}

	protected function createUser(array $data) {
		$sm = $this->getServiceLocator();
		$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		$resultSetPrototype = new ResultSet();
		$resultSetPrototype->setArrayObjectPrototype(new UserModel);
		$tableGateway = new TableGateway("user", $dbAdapter, null, $resultSetPrototype);

		$user = new UserModel();
		$user->exchangeArray($data);
		$userTable = new UserTable($tableGateway);
		$userTable->saveUser($user);

		return true;
	}
}

