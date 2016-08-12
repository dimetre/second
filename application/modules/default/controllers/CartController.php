<?php
class CartController extends Zend_Controller_Action {
	public function indexAction(){
        $cart = new Zend_Session_Namespace('cart');
        if(!isset($cart->products)){
            $this->view->status="empty cart";
        } else {
            $this->view->status="";
            $this->view->keys=array_keys($cart->products);
            $this->view->products=$cart->products;
        }
    }
	public function emptycartAction(){
        $cart = new Zend_Session_Namespace('cart');
        unset($cart->products);
        print_r($cart);
        $this->_helper->redirector->gotoUrl('/cart');
    }
}

?>