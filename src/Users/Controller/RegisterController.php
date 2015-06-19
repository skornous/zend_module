<?php

namespace Users\Controller;

use Users\Form\Register;
use Users\InputFilter\User;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RegisterController extends AbstractActionController
{

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
		$cleanData = $form->getData();
		return $this->redirect()->toRoute(null,[
			"controller" => "register",
			"action" => "confirm"
		]);
	}

	public function confirmAction() {
		return new ViewModel();
	}
}
