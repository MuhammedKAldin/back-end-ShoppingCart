<?php
// test : http://localhost/pape/cart.php?product=T-shirt+Blouse+Pants+Shoes+Jacket
// test - Jacket : http://localhost/pape/cart.php?product=Jacket

$json = file_get_contents('cart.json');
$createCart = json_decode($json);
//================================//
$product = $_GET["product"];
$buyList = explode( ' ' , $product);

class BUY {
    public $itemType;
    public $itemPrice;
    public $itemRegion;
    public $itemWeight;
    // shoes 0.10 offer
    public $shoesExist = false;
    // jacket half offer
    public $shirtExist = false;
    public $blouseExist = false;
    public $jacketExist = false;
    // 10 dollars off shiiping 
    // 2 > products total shipping price
    public $shippingDiscountOffer = false;

    public function searchForDiscount($usedItem)
    {
        return $createCart->discount->$usedItem ;
    }
}

// Div start-line
echo "<div align='left' >";
echo '</br>'.'~~~~~~~~~~~~  Cart  ~~~~~~~~~~~~~'.'</br>';

// created Object from BUY Class to store values inside
$buyCart = new BUY();
// calulations data
$Subtotal = 0;
$Shipping = 0;
$VAT = 0.14; // applied before discounts
$discountsApplied = 0;
$Total = 0;
// group calculations
$shoeGroup = 0; // gathering all shoeses and combining thier discounts
$topsGroup = 0;
$jacketsGroup = 0;

$index = 0;
echo "<label>Added products:-</label></br>";
foreach ($buyList as $itemType)
{
    //searching through the JSON 
    $buyCart->itemType = $itemType;
    $buyCart->itemPrice = $createCart->product->$itemType->price;
    $buyCart->itemRegion = $createCart->product->$itemType->region;
    $buyCart->itemWeight = 1000 * $createCart->product->$itemType->weight;

    //calculate inovice
    $Subtotal += $buyCart->itemPrice;
    //local variable to store current region
    $getItemRegion = $buyCart->itemRegion;
    // calculate item region
    $Shipping += $buyCart->itemWeight / 100 * $createCart->region->$getItemRegion;

    if($itemType == "Shoes" ){$buyCart->shoesExist = true;}
    if($itemType == "T-shirt" ){ $topsGroup += 1;}
    if($itemType == "Blouse"  ){ $topsGroup += 1;}
    if($itemType == "Jacket" ){ $jacketsGroup += 1;}
    if($index >= 1){ $buyCart->shippingDiscountOffer = true;}

    // incrementing the current item index
    $index += 1;
    // print item
    echo $index.' - '.$buyCart->itemType;
    echo "</br>";
}
echo '~~~~~~~~~~~~~~~~~~~~~~~~~~~~~'.'</br>';  
echo 'Subtotal : $'.$Subtotal."</br>";
echo 'Shipping : $'.$Shipping."</br>";
echo 'VAT : $'.$Subtotal*$VAT."</br>";
if($discountsApplied != 0)
{
    // if no discounts available then hide
    echo "Discounts : </br>";
}
echo "<div style='padding-left: 20px;'> ";

foreach($buyList as $value)
{
    if($createCart->product->$value->discountExist == true)
    {
        if($buyCart->shoesExist == true && $value == "Shoes" ) {
        /// shoes-discount
        /// incase there is multiple selection of shoeses, calculate thier discount and apply them once
        $shoeGroup += 1;
        }
        // jacket-discount
        // checking if the T-shirt , Blouse and Jacket Existing
        if($value == "Jacket")
        {
            if($topsGroup >= 2 && $jacketsGroup >= 1)
            {
                $discountsApplied  +=($createCart->product->$value->discount * $createCart->product->$value->price);
                echo ($createCart->product->$value->discount*100)."% off jacket: -$".($createCart->product->$value->discount * $createCart->product->$value->price)."</br>";     
                $topsGroup -= 2;
                $jacketsGroup -= 1;

            }
        }

    }

}

if($shoeGroup > 0)
{
    $discountsApplied  +=($createCart->product->Shoes->discount * $createCart->product->Shoes->price);
    echo ($createCart->product->Shoes->discount*100*$shoeGroup)."% off shoes: -$".($createCart->product->Shoes->discount * $createCart->product->Shoes->price)*$shoeGroup."</br>";
}


if($buyCart->shippingDiscountOffer == true)
{
    // two or more items in cart discount
    $Shipping -= $createCart->product->multipleProducts->discount; 
    echo ($createCart->product->multipleProducts->discount)."$ of shipping: -$".$createCart->product->multipleProducts->discount."</br>";

}

echo "</div>";
$totalApplied_VAT = $Subtotal*$VAT;
$Total = ($Subtotal + $totalApplied_VAT + $Shipping);
echo 'Total : $'.($Total-$discountsApplied)."</br>";

// Div end-line
echo "</div>";


?>