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
    	$db=Zend_Db_Table::getDefaultAdapter();
    	if(!isset($admin->name)){
    		$this->_helper->redirector->gotoUrl('/');
    		die;
    	}
    	if($this->getRequest()->getParam('id')!==null){
    		$db->query('DELETE FROM products WHERE id = ?',$this->getRequest()->getParam('id'));
    	}
    	$this->_helper->redirector->gotoUrl('/list');
    	// image

    }
    public function addAction(){
    	$admin = new Zend_Session_Namespace('admin');
    	$db = Zend_Db_Table::getDefaultAdapter();
    	if(!isset($admin->name)){
    		$this->_helper->redirector->gotoUrl('/');
    		die;
    	}
    	$form = new Application_Forms_Edit();
    	if($this->getRequest()->getParam('id') !== null){
    		$id = $this->getRequest()->getParam('id');
    		$select = $db->select();
    		$select->from('products')->where('id = ?',$id);
    		$stm = $db->query($select);
            $result = $stm->fetchAll();
            $form->getElement('title')->setValue($result [0]['title']);
            $form->getElement('price')->setValue($result [0]['price']);
            $form->getElement('description')->setValue($result [0]['description']);
            $form->getElement('image')->setValue($result [0]['image']);
            $lastid = $result[0]['id'];
    	} 
    	$this->view->form = $form;
    	if($this->getRequest()->getParam('save')!==null && $this->getRequest()->getParam('title')!==''){
    		if(!isset($lastid)){
    			$db->query('INSERT INTO products() VALUES()');
    			$lastid = $db->lastInsertId();
            	echo 'last id is '.$lastid;
    		}
    		$data = array( 'title'=>$this->getRequest()->getParam('title'),
							'price'=>$this->getRequest()->getParam('price'),
							'description'=>$this->getRequest()->getParam('description'),
							'image'=>$this->getRequest()->getParam('image'));
    		$db->update('products',$data,'id ='.$lastid);
    		$this->_helper->redirector->gotoUrl('/list');
    	}
    	//image
    	
    }
}

?>