<?php
class Checkout_Proccess {
    public $subtotal = 0; // 1st
    public $shipping = 0; // 2nd
    public $vat; // 3rd then apply the VAT
    function pre_totalPrice(Buy $cart_in){
        $this->subtotal = $cart_in->price;
        return $this->subtotal;
    }
    function pre_totalShipping(Buy $cart_in){
       $this->shipping = $cart_in->totalShipping;
       return $this->shipping ;
    }
}
?>