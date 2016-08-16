<?php
class CartController extends Zend_Controller_Action {
	public function indexAction(){
        $cart = new Zend_Session_Namespace('cart');
        if(!isset($cart->products)){
            $this->view->status = "empty cart";
        } else {
            $this->view->status = "";
 			$db=Zend_Db_Table::getDefaultAdapter();
            $select = $db->select()->from('products')->where('id IN (?)',array_keys($cart->products));
            $stm = $db->query($select);
            $result=$stm->fetchAll();
            foreach($result as $row){
            	$toRet[$row['id']]=$row;
            }
            $price = 0 ;
            foreach($toRet as $row){
                $price += $row['price']*$cart->products[$row['id']];
            }
            $this->view->price=$price;
            $this->view->infos = $toRet;
            $this->view->keys = array_keys($cart->products);
            $this->view->products = $cart->products;
        }
    }
	public function emptycartAction(){
        $cart = new Zend_Session_Namespace('cart');
        $price = new Zend_Session_Namespace('price');
        unset($cart->products);
        unset($price->value);
        print_r($cart);
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
            $db=Zend_Db_Table::getDefaultAdapter();
            $select = $db->select()->from('products')->where('id IN (?)',array_keys($cart->products));
            $stm = $db->query($select);
            $result=$stm->fetchAll();
            foreach($result as $row){
                $toRet[$row['id']]=$row;
            }
            $total = 0;
            foreach(array_keys($cart->products)as $key){
                $message .= "  ".$toRet[$key]['title']." quantity:".$cart->products[$key];
                $total += $cart->products[$key]*$toRet[$key]['price'];
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