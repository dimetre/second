<?php
class CartController extends Zend_Controller_Action {
	public function indexAction(){
        $cart = new Zend_Session_Namespace('cart');
        if(!isset($cart->products)){
            $this->view->status = "empty cart";
        } else {
            $this->view->status = "";
            $products = new Application_Models_Products();
            $this->view->products = $prods = $products->fetchAll(array('id IN (?)'=>array_keys($cart->products)));
            $this->view->quantity = $quantity = $cart->products;
            $price = 0;
            foreach($prods as $prd){
                $price+=$prd->price*$quantity[$prd->id];
            }
            $this->view->price = $price;    
        }
    }
	public function emptycartAction(){
        $cart = new Zend_Session_Namespace('cart');
        unset($cart->products);
        $this->_helper->redirector->gotoUrl('/cart');
    }
    public function removefromcartAction(){
    	$cart = new Zend_Session_Namespace('cart');
    	$id = $this->getRequest()->getParam('id');
    	if($id != null){
    		if(isset($cart->products[$id])&&$cart->products[$id]>1){
    			$cart->products[$id]--;
    		} else if($cart->products[$id] == 1){
    			unset($cart->products[$id]);
    		}
    	}
    	if(count($cart->products) == 0){
    		unset($cart->products);
    	}
    	$this->_helper->redirector->gotoUrl('/cart');
    }
    public function checkoutAction(){
        $cart = new Zend_Session_Namespace('cart');
        if(isset($cart->products)){
            $message="Thank you! ";
            $products = new Application_Models_Products();
            $prods = $products ->fetchAll(array('id IN (?)'=>array_keys($cart->products)));
            $total = 0;

            foreach($prods as $product){
                $message .= " ".$product->title."  quantity: ".$cart->products[$product->id];
                $total += $cart->products[$product->id]*$product->price;
            }
            $message.=' Total price:'.$total;
            $headers="From:emailpentrutestareaplicatie@gmail.com";
            mail(EMAIL,"Testing",$message,$headers);
            unset($cart->products);
        } 
        $this->_helper->redirector->gotoUrl('/');
    }
}

?>