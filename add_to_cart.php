<?php
session_start();

// Define products (In reality, you'd fetch this from a database)
$products = [
    1 => ['name' => 'Bronton', 'price' => 3000, 'img' => 'bronton.jpg', 'id' => 1],
    2 => ['name' => 'E-BMX', 'price' => 2000, 'img' => 'dummyimg.jpg', 'id' => 2],
    3 => ['name' => 'F-65', 'price' => 700, 'img' => 'f65.jpg', 'id' => 3]
];

// Check if product_id is posted
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];	

    // Check if product exists
    if (isset($products[$product_id])) {
        $product = $products[$product_id];
		
        // Initialize cart session if not set
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // If the product is already in the cart, increment the quantity
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += 1;
        } else {
            // Add the new product to the cart
            $_SESSION['cart'][$product_id] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => 1,
				'img' => $product['img'],
				'id' => $product['id'],
            ];
        }

        // Redirect to cart page after adding
        header("Location: cart.php");
        exit();
    } else {
        // Handle invalid product ID
        echo "Invalid product.";
    }
} else {
    // Handle missing product ID
    echo "No product selected.";
}
?>
