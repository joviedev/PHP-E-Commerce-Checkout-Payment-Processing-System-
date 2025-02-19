<?php
require 'vendor/autoload.php';  // Include the Stripe PHP library
include 'config.php';

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);  // Use your secret key from config.php

header('Content-Type: application/json');

// Assume cart total is stored in session
$cart_total = $_SESSION['cart_total'];

try {
    $checkout_session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'aud',  // Change to your preferred currency
                'product_data' => [
                    'name' => 'Shopping Cart Purchase',
                ],
                'unit_amount' => $cart_total * 100,  // Stripe expects amounts in cents
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => 'http://localhost/code/success.php',  // Replace with your success URL
        'cancel_url' => 'http://localhost/code/index.php',    // Replace with your cancel URL
    ]);

    http_response_code(303); //telling the browser to redirect
    header("Location: " . $checkout_session->url); // sends the browser to the Stripe Checkout page using the URL from $checkout_session->url.
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]); // returns the error message in JSON format for debugging
}
