<?php
	session_start();

	if (isset($_POST['remove'])) {
		foreach ($_POST['productIds'] as $productId) {
			echo $productId;
			if (isset($_SESSION['cart'][$productId])) {
				unset($_SESSION['cart'][$productId]);
			}
		}
	} else {
		$product_ids = isset($_POST['product_ids']) ? $_POST['product_ids'] : [];
	    $quantities = isset($_POST['quantities']) ? $_POST['quantities'] : [];
		foreach ($product_ids as $index => $product_id) {
            $quantity = $quantities[$index];
			$_SESSION['cart'][$product_id]['quantity'] = $quantity;
		}		
	}

    // Redirect to cart page after update
    header("Location: cart.php");
	exit();
?>