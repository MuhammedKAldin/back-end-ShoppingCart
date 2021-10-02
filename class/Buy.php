<?php

class Buy {
    public $itemType;
    public $itemDiscountActivated; // check if that discount is activated or seasonal discount then it might be disabled
    public $itemDiscountRate; // discounts 10% or etc..
    public $itemDiscountPrice; // price after applying discount
    public $itemId;  // ####
    public $category; // ####
    public $topGroupCount; // ####
    public $jacketGroupCount; // ####
    public $quantity; // ####
    public $price;
    public $region;
    public $weight;
    public $regionRate;
    public $totalShipping;
    function __construct($item_in){
        $this->itemType = $item_in;
        $this->printName(); // displaying item's name on screen
        $this->getCategory($this->itemType);
        $this->getPrice($this->itemType);
        $this->getRegion($this->itemType);
        $this->getWeight($this->itemType);
        $this->getShipping(); // calculated by weight & region rate
        $this->checkDiscountExisting($item_in);
    }
    function printName(){
        echo "→ ".$this->itemType."</br>";
    }
    function getCategory($category_of){
        // get input id
        $json = file_get_contents('cart.json');
        $createCart = json_decode($json);
        $this->category = $createCart->product->$category_of->category;
        if($this->category == "tops") { $this->topGroupCount += 1; }
        if($this->category == "jackets") { $this->jacketGroupCount += 1; }
        return $this->category;
        echo "</br>";
    }
    function getPrice($price_of){
        // get input price
        $json = file_get_contents('cart.json');
        $createCart = json_decode($json);
        return $this->price = $createCart->product->$price_of->price;
        echo "</br>";
    }
    function getRegion($region_of){
        // get input region
        $json = file_get_contents('cart.json');
        $createCart = json_decode($json);
        $this->region = $createCart->product->$region_of->region;
        $this->getRegionPrice($this->region);
        return $this->region;
        echo "</br>";
    }
    function getRegionPrice($currentRegion){
        // get input region shipping rate
        $json = file_get_contents('cart.json');
        $createCart = json_decode($json);
        return $this->regionRate = $createCart->region->$currentRegion;
        echo "</br>";
    }
    function getWeight($weight_of){
        // get input weight
        $json = file_get_contents('cart.json');
        $createCart = json_decode($json);
        // kilogram to gram unit-conversion 
        return $this->weight = $createCart->product->$weight_of->weight * 1000; 
        echo "</br>";
    }
    function getShipping(){
        // region rates per 100 grams
        return $this->totalShipping = $this->weight / 100 * $this->regionRate; 
    }
    function checkDiscountExisting($discount_of){
        $json = file_get_contents('cart.json');
        $createCart = json_decode($json);
        $this->itemDiscountActivated = $createCart->product->$discount_of->discountExist; 
        // check if the current discount offer is activated
        if($this->itemDiscountActivated == 1) {
            $this->itemDiscountRate = $createCart->product->$discount_of->discount; 
            $this->itemDiscountPrice = ($this->itemDiscountRate * $this->price);
            return $this->itemDiscountPrice;
        }
    }
}

?>
