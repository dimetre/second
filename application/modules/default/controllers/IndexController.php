<?php
class IndexController extends Zend_Controller_Action {
    public function indexAction() {
        if(isset($this->logged)){
            $this->view->logged=$this->logged;
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

        if($this->getRequest()->getParam('nume')!=null && $this->getRequest->getParam('password')!=null){
            if(!$form->isValid($this->getRequest()->getParams())){
                $this->view->message='empty fields';
            } else if($this->getRequest()->getParam('nume')==USER && $this->getRequest()->getParam('password')==PASSWORD){
                $this->logged=$this->getRequest()->getParam('nume');
                $this->view->message='empty fields';
                $this->_helper->redirector->gotoUrl('/');
            } else {
                 $this->view->message='Wrong login';
            }
        }
    }
}
?>