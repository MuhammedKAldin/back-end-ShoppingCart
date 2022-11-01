# Back-end-shoppingCart
challenge in PHP backend


<strong>Usage is via Simple Rest API :</strong>

• Start ``Xampp`` Server.

• Open via `` localhost/cart.php?product= ``.

•  Example 1 `` localhost/cart.php?product=T-shirt+Blouse+Pants+Shoes+Jacket ``.

•  Example 2 `` localhost/cart.php?product=Shoes ``.

-------------------------------------------------------
# coding challenge guidelines.
## Challenge Description

***Write a program that can price a cart of products from different countries, accept multiple products, combine offers, and display a total detailed invoice in USD as well.***

**Available catalog products** and their respective price in USD (regardless of the shipping country):

| Item type | Item price | Shipped from | Weight |
| -------- | -------- | -------- |  -------- | 
| T-shirt | **$30.99** | **US** | **0.2kg** |
| Blouse | **$10.99** | **UK** | **0.3kg** |
| Pants | **$64.99** | **UK** | **0.9kg** |
| Sweatpants | **$84.99** | **CN** | **1.1kg** |
| Jacket | **$199.99** | **US** | **2.2kg** |
| Shoes | **$79.99** | **CN** | **1.3kg** |

  
#### Products Info
The Following table used as the a complete reference for this challenge (NOT HARDCODED CALCULATED VALUES) 
|Item type|Country|Item price|Weight|Rate |Shipping|VAT|
| -------- | -------- | -------- | -------- | -------- | -------- |-------- |
|T-shirt |US|$30.99|0.2|$2|$4|$4.3386|
|Blouse |UK|$10.99|0.3|$3|$9|$1.5386|
|Pants|UK|$64.99|0.9|$3|$27|$9.0986|
|Sweatpants|CN|$84.99|1.1|$2|$22|$11.8986|
|Jacket|US|$199.99|2.2|$2|$44|$27.9986|
|Shoes|CN|$79.99|1.3|$2|$26|$11.1986|

Each country has a shipping rate per 100 grams 

**Shipping rates**:
**Hint**: [see below, how to calculate each item shipping fees](#q-i-got-confused-on-how-to-calculate-an-item-price-and-its-shipping-and-vat)
| Country | Rate  | 
| -------- | -------- |
| US | $2 |
| UK | $3 |
| CN | $2 |

The program can handle some special offers, which affect the pricing.

**Available offers**:

* **Shoes** are on 10% off.
* Buy any **two** tops (t-shirt or blouse) and get any jacket **half** its price.
* Buy any **two** items or *more* and get a **maximum** of $10 off shipping fees.



**There is a 14% VAT (before discounts) applied to all products, whatever the shipping country is.**

The program **accepts** a list of products, **outputs** the detailed **invoice** of the subtotal (sum of items prices), shipping fees, VAT, and discounts if applicable.


**e.g.**

Adding the following products:

```
T-shirt
Blouse
Pants
Shoes
Jacket
```

Outputs the following invoice:

```
Subtotal: $386.95
Shipping: $110
VAT: $54.173
Discounts:
	10% off shoes: -$7.999
	50% off jacket: -$99.995
	$10 of shipping: -$10
Total: $433.129
```

Another, e.g., If none of the offers are eligible by adding one product:

```
Jacket
```

Outputs the following invoice:

```
Subtotal: $199.99
Shipping: $44
VAT: $27.9986
Total: $271.9886
```

