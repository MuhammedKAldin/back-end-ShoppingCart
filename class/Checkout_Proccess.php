<?php
class ItemsDiscount_Proccess {
    // get itemID or Category and check if it has discount 
    public $itemCategory;
    // collects total discounts value
    public $itemDiscountPrice;
    public $tops = 0; // tops counter
    public $jackets = 0; // jackets counter

    function __construct(Buy $cart_in ,int $tops ,int $jackets){
        $this->itemCategory = $cart_in->category;
        $this->tops = $tops;
        $this->jackets = $jackets;
        if($this->itemCategory == "footwear"){
            $this->footwearDiscount($cart_in);
        } else if($this->itemCategory == "jackets" && $tops >= 2 && $jackets >= 1){
            // apply the discount 
            $this->jacketsDiscount($cart_in);
        }   
    }
    function footwearDiscount($cart_in){
        $this->itemDiscountPrice = $cart_in->itemDiscountPrice;
        return $this->itemDiscountPrice;
    }
    function jacketsDiscount($cart_in){
        $this->itemDiscountPrice = $cart_in->itemDiscountPrice;
        return $this->itemDiscountPrice;
    }
}
?>