<?php

class ListController extends Zend_Controller_Action{

    public function init(){
        $admin=new Zend_Session_Namespace('admin');
        if(!isset($admin->name)){
            $this->_helper->redirector->gotoUrl('/');
            die;
        }
    }
	public function indexAction(){
        $admin=new Zend_Session_Namespace('admin');
        $this->view->admin=$admin->name;
        $products = new Application_Models_Products();
    	$this->view->products = $products->fetchAll(); 
    }

    public function removeAction(){
    	$admin=new Zend_Session_Namespace('admin');
    	if($this->getRequest()->getParam('id')!==null){
            $products = new Application_Models_Products();
            $product = $products->fetchRow(array('id = ?'=>$this->getRequest()->getParam('id')));
            if($product){
                if($product->image){
                    unlink("uploads/".$product->id.$product->image);
                }
                $product->delete();
            }
    	}
    	$this->_helper->redirector->gotoUrl('/list');
    	

    }
    public function addAction(){
        $uploadpath='C:/xampp/htdocs/second/uploads/';
        $products = new Application_Models_Products();
    	$form = new Application_Forms_Edit();
    	if($this->getRequest()->getParam('id') !== null){
            $row = $products->fetchRow(array('id = ?' => $this->getRequest()->getParam('id')))->toArray();
            //$row['note'] = $row['image'];
            $row['note']="<img src='http://second.local.com/uploads/".$row['id'].$row['image']."' style='width : 150px;hieght :100px;'>";
            $form->populate($row);
    	} 
    	$this->view->form = $form;

    	if($this->getRequest()->getParam('save')!==null && $this->getRequest()->getParam('title')!==''){

    		if(!$this->getRequest()->getParam('id')){
                $product = $products->createRow();
    		} else {
    			$product = $products->fetchRow(array('id = ?' => $this->getRequest()->getParam('id')));
        	}
            
            $product->title = $this->getRequest()->getParam('title');
            $product->price = $this->getRequest()->getParam('price');
            $product->description = $this->getRequest()->getParam('description');
            $element = $form ->getElement('image');
            $fileName = basename($element->getFileName());
            if ($fileName){
                if ($fileName !== $product->image && $product->image) {
                    unlink($uploadpath.$product->id.$product->image);
                }
                $product->image = $fileName;
            }
            $product->save();

            if($fileName){
                $element->addFilter('Rename', array('target' => $element->getDestination() . '/' .  $product->id.$fileName));
                $element ->receive();
                //rename($uploadpath.$name,);
            }

    		$this->_helper->redirector->gotoUrl('/list');
    	}	
    }
}

?>