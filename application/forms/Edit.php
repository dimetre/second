<?php
class Application_Forms_Edit extends Zend_Form{
	
	public function init(){
		$validator = new Zend_Validate_NotEmpty();
        $validator->setMessage('Nu poate fi gol');

       	$titlu = new Zend_Form_Element_Text('title');
       	$titlu ->setLabel('Title:')
       		->addValidator($validator);

       	$price = new Zend_Form_Element_Text('price');
       	$price ->setLabel('Price:');

       	$description = new Zend_Form_Element_Textarea('description');
       	$description ->setLabel('Description:');

       	$image = new Zend_Form_Element_Text('image');
       	$image ->setLabel('Image:');

       	$save = new Zend_Form_Element_Submit('save');
       	$save ->setLabel('Save');

       	$this->addElements(array($titlu,$price,$description,$image,$save));
	}
}

?>