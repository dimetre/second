<?php
class IndexController extends Zend_Controller_Action {

    public function indexAction() {
        $admin=new Zend_Session_Namespace('admin');
        if(isset($admin->name)){
            $this->view->admin=$admin->name;
        }
        $products = new Application_Models_Products();
        $this->view->products = $products->fetchAll();
    }
    
    public function adaugaAction() {
        $this->view->form = $form = new Application_Forms_Editare();

        if($this->getRequest()->getParam('nume') !== null) {
            if (!$form->isValid($this->getRequest()->getParams())) {
                $this->view->mesaj = 'Incorect';
            } else {
                $contacte = new Application_Models_Contacte();
                $contact = $contacte->createRow();
                $contact->nume = $this->getRequest()->getParam('nume');
                $contact->data_nasterii = $this->getRequest()->getParam('data_nasterii');
                $contact->detalii = $this->getRequest()->getParam('detalii');
                $contact->save();
                
                $this->_helper->redirector->gotoUrl('/');
            }
        }
    }

    public function loginAction(){
        $this->view->form = $form = new Application_Forms_Login();
        if($this->getRequest()->getParam('id')!==null){
            if($this->getRequest()->getParam('id')==USER && $this->getRequest()->getParam('password')==PASSWORD){
                $admin=new Zend_Session_Namespace('admin');
                $admin->name=$this->getRequest()->getParam('id');
                $this->view->message='empty fields';
                $this->_helper->redirector->gotoUrl('/');
            } else {
                 $this->view->message='Wrong login';
            }
        } 
    }
    public function logoutAction(){
        $admin = new Zend_Session_Namespace('admin');
        unset($admin->name);
        $this->_helper->redirector->gotoUrl('/');
    }
    public function addtocartAction(){
        if($this->getRequest()->getParam('id')!=null){
            $id=$this->getRequest()->getParam('id');
            $cart = new Zend_Session_Namespace('cart');
            if(!isset($cart->products)){
                $cart->products=array();           
            }
            if(isset($cart->products[$id])){
                $cart->products[$id]++;
            } else {
                $cart->products[$id]=1;
            }
            $this->_helper->redirector->gotoUrl('/');
        }
    } 
}
?>