<?php

class ListController extends Zend_Controller_Action{

	public function indexAction(){
        $admin=new Zend_Session_Namespace('admin');
        if(isset($admin->name)){
            $this->view->admin=$admin->name;
            $products = new Application_Models_Products();
        	$this->view->products = $products->fetchAll();
        } else {
        	$this->_helper->redirector->gotoUrl('/');
        }
        
    }
    public function removeAction(){
    	$admin=new Zend_Session_Namespace('admin');
    	if(!isset($admin->name)){
    		$this->_helper->redirector->gotoUrl('/');
    	}
    }
    public function addAction(){
    	$admin=new Zend_Session_Namespace('admin');
    	if(!isset($admin->name)){
    		$this->_helper->redirector->gotoUrl('/');
    	}
    	$this->view->form = $form = new Application_Forms_Edit();
    }
}

?>