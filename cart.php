<?php
/**
 * Rest API to handle cart product adding :-
 * test : http://localhost/pape/cart.php?product=T-shirt+Blouse+Pants+Shoes+Jacket 
 * test - Jacket : http://localhost/pape/cart.php?product=Jacket
 * 
*/
include 'class\Buy.php' ;
include 'class\Checkout_Proccess.php' ;
include 'class\ItemsDiscount_Proccess.php' ;
if(isset($_GET['product']) && !empty($_GET['product'])) {
    $product = $_GET["product"];
    $buyList = explode( ' ' , $product);
    //-JSON-//
    $json = file_get_contents('cart.json');
    $createCart = json_decode($json);
    //-----//
    // Div start-line
    echo "<div align='left' >";
    $preTotal = 0; // items-Total price
    $Totalshipping = 0; // items-Total shipping price
    $VAT = 0.14; // Value Added Tax 14%
    $netTotal = 0; // pretotal + VAT($pretotal)
    $index = 0; // items counter variable
    $discountsTotalValue = 0; 
    $topGroupCount = 0; 
    $jacketGroupCount = 0; 
    // Looping bought items in seperate div
    echo '</br>'.'~~~~~~~~~~~~  Cart  ~~~~~~~~~~~~~'.'</br>';
    foreach($buyList as $item) {
        // created object from Buy Class
        $buyCart = new Buy($item);
        $topGroupCount += $buyCart->topGroupCount;
        $jacketGroupCount += $buyCart->jacketGroupCount;
        //$buyCart->itemIndex += $index; // ?????????????? why doesnt work
        $buyProcces = new Checkout_Proccess();
        $preTotal += $buyProcces->pre_totalPrice($buyCart);
        $Totalshipping +=  $buyProcces->pre_totalShipping($buyCart);
        $itemDiscountProccess = new ItemsDiscount_Proccess($buyCart,$topGroupCount,$jacketGroupCount);
        $discountsTotalValue += $itemDiscountProccess->itemDiscountPrice;

        // loop item index
        $index += 1;
    }
    // setting up the final calculations VAT & netTotal then show client inovice
    $VAT = $VAT * $preTotal;
    $multipleProducts = false;
    // checking if items bought >= 2 items
    if($index >= 2) {
        // checking if the offer is available
        if($createCart->product->multipleProducts == true) {
            $multipleProducts = true;
        }
    }
    // Inovice-Div start-line
    echo "<div style='position:absolute;top: 44px;left: 145px; ' >";
    echo 'Subtotal : $'.$preTotal."</br>";
    echo 'Shipping : $'.$Totalshipping."</br>";
    echo 'VAT : $'.$VAT."</br>";
    //echo $topGroupCount." Tops  -  ".$jacketGroupCount." Jackets </br>"; // debugging
    if($discountsTotalValue > 0  || $multipleProducts == 1){
        /**(if no discounts then hide)
        * Discounts-Panel 
        */
        echo "Discounts : </br>";
        echo "<div style='padding-left: 20px;'> ";
        // (*) Items Offers (*)
        if($topGroupCount > 0){
            foreach($buyList as $item) {
                if($item == "Jacket" && $topGroupCount >= 2 && $jacketGroupCount >= 1) {
                    echo ($createCart->product->$item->discount*100)."% off ".$item.": -$".($createCart->product->$item->discount * $createCart->product->$item->price)."</br>";     
                    $topGroupCount -= 2; // took offer
                    $jacketGroupCount -= 1; // took offer
                }
                if($item == "Shoes") {
                    echo ($createCart->product->$item->discount*100)."% off ".$item.": -$".($createCart->product->$item->discount * $createCart->product->$item->price)."</br>";     
                }
            }
        }
        // (*) Seasonal Offers (*)
        if($multipleProducts == 1) {
            // Apply -10$ Dollars off shipping
            $offerValue = $createCart->product->multipleProducts->discount;
            $Totalshipping -= $offerValue;
            echo $offerValue."$ of shipping: -$".$offerValue."</br>";
        }
        // Discounts-div end-line
        echo "</div>";
    }
    $netTotal = $preTotal + $Totalshipping + $VAT;
    echo "Total : $".($netTotal - $discountsTotalValue);
    // Inovice-Div end-line
    echo "</div>";
    // Div end-line
    echo "</div>";
} else {
    writeIn('the shopping cart is empty');
}
// printing method
function writeIn($line_in) {
    echo "</br>".$line_in."</br>";
}
?>
