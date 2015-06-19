<?php

namespace Users\Controller;

use Users\Form\Login;
use Users\InputFilter\User;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter;

class LoginController extends AbstractActionController {

	protected $authService;

    public function indexAction() {
	    $form = new Login("connect");
	    return new ViewModel(['connectForm' => $form]);
    }

	public function processAction() {
		if($this->request->isPost() === false) {
			return $this->redirect()->toRoute(null, [
				"controller" => "login",
				"action" => "index"
			]);
		}
		$post = $this->request->getPost();
		$form = new Login;
		$form->setInputFilter(new User);
		$form->setValidationGroup(["email", "password", "security"]);
		$form->setData($post);

		if ($form->isValid() === false){
			$view = new ViewModel([
				"error" => true,
				"connectForm" => $form
			]);
			$view->setTemplate("users/login/index");
			return $view;
		}
		// from here the form is considered as valid
		$cleanData = $form->getData();
		$this->getAuthService()->getAdapter()
			->setIdentity($cleanData["email"])
			->setCredential($cleanData["password"]);
		$result = $this->getAuthService()->authenticate();

		if($result->isValid()) {
			$this->getAuthService()->getStorage()->write($cleanData["email"]);
			return $this->redirect()->toRoute(null,[
				"controller" => "login",
				"action" => "confirm"
			]);
		}

		$view = new ViewModel([
			"error" => true,
			"connectForm" => $form
		]);
		$view->setTemplate("users/login/index");
		return $view;
	}

	public function confirmAction() {
		return new ViewModel([
			"user_email" => $this->getAuthService()->getStorage()->read()
		]);
	}

	public function getAuthService() {
		if ($this->authService === null) {
			$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
			$dbTableAuthAdapter = new CredentialTreatmentAdapter($dbAdapter, "user", "email", "password", 'SHA1(?)');
			$authService = new AuthenticationService();
			$authService->setAdapter($dbTableAuthAdapter);
			$this->authService = $authService;
		}

		return $this->authService;
	}
}

