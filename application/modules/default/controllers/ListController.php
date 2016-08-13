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
    		die;
    	}
    	// remove fom db and shit

    }
    public function addAction(){
    	$admin = new Zend_Session_Namespace('admin');
    	if(!isset($admin->name)){
    		$this->_helper->redirector->gotoUrl('/');
    		die;
    	}
    	$form = new Application_Forms_Edit();
    	if($this->getRequest()->getParam('id') !== null){
    		$id = $this->getRequest()->getParam('id');
    		$db = Zend_Db_Table::getDefaultAdapter();
    		$select = $db->select();
    		$select->from('products')->where('id = ?',$id);
    		$stm = $db->query($select);
            $result = $stm->fetchAll();
            $form->getElement('title')->setValue($result [0]['title']);
            $form->getElement('price')->setValue($result [0]['price']);
            $form->getElement('description')->setValue($result [0]['description']);
            $form->getElement('image')->setValue($result [0]['image']);
    	}
    	$this->view->form = $form;
    	if($this=>getRequest()->getParam('save')!==null && $this=>getRequest()->getParam('title')!==null){
    		
    	}
    }
}

?>