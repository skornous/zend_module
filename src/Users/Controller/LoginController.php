<?php

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController {

    public function indexAction() {
	    $form = $this->getServiceLocator()->get('login-form');
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

		$form = $this->getServiceLocator()->get('login-form');
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
		$authService = $this->getServiceLocator()->get('auth-service');
		$result = $authService
			->getAdapter()
			->setIdentity($cleanData["email"])
			->setCredential($cleanData["password"])
			->authenticate();

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
			"user_email" => $this->getServiceLocator()->get('auth-service')->getStorage()->read()
		]);
	}
}

