<?php
class Application_Forms_Login extends Zend_Form{
	public function init(){
		$validator = new Zend_Validate_NotEmpty();
	    $validator->setMessage('Nu poate fi gol');

	    $ID = new Zend_Form_Element_Text('id');
	    $ID->setLabel('Id')
	        ->setRequired(true)
	        ->addValidator($validator);

	    $Password = new Zend_Form_Element_Password('password');
	    $Password->setLabel('Parola')
	        ->setRequired(true)
	        ->addValidator($validator);

	    $buton = new Zend_Form_Element_Submit('submit');
        $buton->setLabel('Login');

	    $this->AddElements(array($ID,$Password,$buton));
	}
            
}

?>