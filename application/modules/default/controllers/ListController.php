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
    		$select = $db->select();
    		$select->from('products')->where('id = ?',$this->getRequest()->getParam('id'));
    		$result = $db->query($select)->fetchAll();
    		if($result[0]['image']){
    			unlink("uploads/".$result[0]['id'].$result[0]['image']);
    		}
    		$db->query('DELETE FROM products WHERE id = ?',$this->getRequest()->getParam('id'));
    	}
    	$this->_helper->redirector->gotoUrl('/list');
    	

    }
    public function addAction(){
        $uploadpath='C:/xampp/htdocs/second/uploads/';
    	$admin = new Zend_Session_Namespace('admin');
    	$db = Zend_Db_Table::getDefaultAdapter();
    	$adapter = new Zend_File_Transfer_Adapter_Http();
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
            $form->getElement('note')->setValue($result [0]['image']);
            $lastid = $result[0]['id'];
    	} 
    	$this->view->form = $form;
    	if($this->getRequest()->getParam('save')!==null && $this->getRequest()->getParam('title')!==''){
    		if(!isset($lastid)){
    			$db->query('INSERT INTO products() VALUES()');
    			$lastid = $db->lastInsertId();
    		}
    		if(!isset($result)){
    			$select = $db->select();
    			$select->from('products')->where('id = ?',$lastid);
    			$stm = $db->query($select);
            	$result = $stm->fetchAll();
        	}
            
            if($form ->getElement('image')->getValue()){
                $name = $form ->getElement('image')->getValue();
                $element = $form ->getElement('image');
                if($name!== $result[0]['image']){
                    if($result[0]['image']!==""){
                        unlink($uploadpath.$lastid.$result[0]['image']);
                    }
                    $element ->receive();
                    rename($uploadpath.$name,$uploadpath.$lastid.$name);
                }
            } else {
                $name = $result[0]['image'];
            }

    		$data = array( 'title'=>$this->getRequest()->getParam('title'),
							'price'=>$this->getRequest()->getParam('price'),
							'description'=>$this->getRequest()->getParam('description'),
							'image'=>$name);
    		$db->update('products',$data,'id ='.$lastid);
    		$this->_helper->redirector->gotoUrl('/list');
    	}
    	//image
    	
    }
}

?>