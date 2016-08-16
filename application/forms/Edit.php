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

       	$image = new Zend_Form_Element_File('image');
       	$image ->setLabel('Image:');
       	$image ->setDestination('C:/xampp/htdocs/second/uploads');

       	$note = new Zend_Form_Element_Note('note');
       	$note ->setLabel('Current Image:');

       	$save = new Zend_Form_Element_Submit('save');
       	$save ->setLabel('Save');

       	$this->addElements(array($titlu,$price,$description,$image,$note,$save));
	}
}

?>