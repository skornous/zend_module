<?php

namespace Users\Form;
use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Captcha\Dumb;


class Register extends Form{
	/**
	 * @param null $name
	 */
	public function __construct($name=null) {
		parent::__construct("Register");

		$this->setAttribute('method', 'post');
		$this->setAttribute('enctype', 'multipart/form-data');

		// champ nom
		$name = new Element\Text("name");
		$name->setLabel("Nom");
//		$name->setAttribute("required", "required");
//		$name->setOptions(
//			[
//				"label_attributes" => [
//					"class" => "form-group"
//				]
//			]
//		);
		$this->add($name);

		// champ email
		$this->add([
			'name' => 'email',
			'attributes' => [
				'type' => 'email',
				'required' => 'required',
			],
			'options' => [
				'label' => 'Email'
			]
		]);

		// champ password
		$password = new Element\Password("password");
		$password->setLabel("Mot de passe");
		$password->setAttribute("required", "required");
		$this->add($password);

		// champ password_confirm
		$confirm = new Element\Password("password_confirm");
		$confirm->setLabel("Confirmation");
		$confirm->setAttribute("required", "required");
		$this->add($confirm);

		// token CSRF
		$csrf = new Element\Csrf("security");
		$this->add($csrf);

		// Captcha
		$captchaText = new Dumb;
		$captchaText->setLabel("Veuillez recopiez ces mots");

		$captcha = new Element\Captcha("captcha");
		$captcha->setCaptcha($captchaText);
		$captcha->setLabel("Vérifiez que vous êtes humain");
		$this->add($captcha);

		// bouton validation
		$validate = new Element\Submit("Valider");
		$validate->setLabel("Valider");
		$validate->setValue("Valider");
		$this->add($validate);

	}
}