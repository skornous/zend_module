<?php

namespace Users\Controller;

use Users\Form\Login;
use Users\InputFilter\User;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController {

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
		$form->setValidationGroup(["email", "password"]);
		$form->setData($post);

		if ($form->isValid() === false){
			$view = new ViewModel([
				"error" => true,
				"connectForm" => $form
			]);
			$view->setTemplate("users/login/index");
			return $view;
		}
		$cleanData = $form->getData();
		return $this->redirect()->toRoute(null,[
			"controller" => "login",
			"action" => "confirm"
		]);
	}

	public function confirmAction() {
		return new ViewModel();
	}

}

