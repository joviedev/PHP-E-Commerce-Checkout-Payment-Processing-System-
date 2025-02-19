<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Shopping Cart</title>
	<style>
        .cart-container {
            width: 80%;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
        }
        .cart-header, .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .cart-header {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .cart-item {
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
        .cart-item img {
            max-width: 100px;
        }
        .cart-item p {
            margin: 0;
        }
        .cart-item .description {
            flex: 2;
            padding: 0 10px;
        }
        .cart-item .price, .cart-item .qty, .cart-item .total {
            flex: 1;
            text-align: center;
        }
        .cart-item .qty input {
            width: 50px;
            text-align: center;
        }
        .update-btn, .remove-btn {
            background-color: black;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
	  .right-margin {
		float: right;
		margin-bottom: 20px;
	  }
	  .image-container {
		width: 80%;
		display: flex;
		justify-content: space-between;
	}
    </style>
</head>
<body>
<div class="cart-container">
    <h1>Your Shopping Cart</h1>
	
	<div class="cart-header">
        <div>Remove</div>
        <div>Image</div>
        <div class="description">Product Description</div>
        <div class="price">Price</div>
        <div class="qty">Qty</div>
        <div class="total">Total</div>
    </div>
	<form action="update_cart.php" method="post">
    <?php if (!empty($_SESSION['cart'])): ?>
            <?php 
            $cart_total = 0;
            foreach ($_SESSION['cart'] as $product_id => $product): 
                $product_total = $product['price'] * $product['quantity'];
                $cart_total += $product_total;
            ?>

	<div class="cart-item">
        <div><input type="checkbox" name="productIds[]" value="<?php echo $product['id']; ?>"></div>
        <div><img src="assets/img/<?php echo $product['img']; ?>" alt="<?php echo $product['name']; ?>"></div>
        <div class="description">
            <p><strong><?php echo $product['name']; ?></strong></p>
            <p>Availability: <span style="color:green;">Online</span> <span style="color:blue;">Immediate Pick-up</span></p>
        </div>
        <div class="price">$<?php echo $product['price']; ?></div>
        <div class="qty"><input name="quantities[]" type="number" value="<?php echo $product['quantity']; ?>"></div>		
		<input type="hidden" name="product_ids[]" value="<?php echo $product['id']; ?>">
        <div class="total">$<?php echo $product_total; ?></div>
    </div>

            <?php endforeach; ?>

        <!-- Store total amount in session -->
        <?php $_SESSION['cart_total'] = $cart_total; ?>

	    <button class="update-btn" name="update_qty" value="1">UPDATE QTY</button>
	    <button class="remove-btn" name="remove" value="1">REMOVE</button>
	</form>
</div>
<div style="width: 80%; margin: 0 auto;">
	<h1>Select Payment Option</h1>
	<div class="image-container">
		<img src="assets/img/paypal.png" height="30">
		<img src="assets/img/gpay.png" height="30">
		<img src="assets/img/westpac.png" height="30">
		<img src="assets/img/stripe.png" height="30">
	</div>
	<!-- Link to Proceed to Checkout -->
	<div><a href="checkout.php" class="right-margin"><img src="assets/img/checkout.png" alt="Proceed to Checkout"></a></div>
</div>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</body>
</html>

