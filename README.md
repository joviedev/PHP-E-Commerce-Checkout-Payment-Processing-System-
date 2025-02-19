# 🛒 PHP E-Commerce Checkout & Payment Processing System  

A **PHP-based online shopping and payment processing system** with support for **Google Pay, PayPal IPN, Westpac PayWay Net, and Stripe**, along with cart management.  

## 🚀 How to Run  

1. **Set up a PHP environment** (e.g., Apache with MySQL).  
2. **Configure payment settings** in `config.php` (including PayPal, Google Pay, Westpac PayWay Net, and Stripe).  
3. **Deploy the project** in a local server (e.g., XAMPP, MAMP).  
4. **Run `index.php`** to access the main shopping and checkout system.  

## ✨ Features  

- **Shopping Cart Management:** Add, update, and remove items in the cart (`cart.php`, `update_cart.php`).  
- **Checkout System:** Handles order placement and transactions (`checkout.php`).  
- **Google Pay Integration:** Implements Google Pay via `gpay.js`.  
- **PayPal IPN (Instant Payment Notification):** Manages real-time payment confirmation (`ipn.php`).  
- **Westpac PayWay Net Integration:** Processes payments via Westpac PayWay Net (`checkout.php`).  
- **Stripe Payment Gateway:** Handles transactions using Stripe API (`checkout.php`).  
- **Configuration Management:** Contains essential payment settings (`config.php`).  
- **Composer Dependency Management:** Uses `composer.lock` and `composer.phar` for managing PHP dependencies.  

## 🏗️ Tech Stack  

- **PHP** (Core backend logic)  
- **JavaScript** (Google Pay integration)  
- **MySQL** (Database support – assuming a database connection in `config.php`)  
- **PayPal API** (IPN for automated payment processing)  
- **Westpac PayWay Net API** (Processes secure transactions)  
- **Stripe API** (Handles online card payments)  

## 📂 Project Structure  
├── cart.php # Shopping cart functionality
├── checkout.php # Checkout process
├── update_cart.php # Update cart logic
├── gpay.js # Google Pay integration script
├── ipn.php # PayPal Instant Payment Notification
├── config.php # Configuration settings
├── composer.lock # PHP dependency lock file
├── composer.phar # Composer package manager
├── westpac_payway.php # Westpac PayWay Net integration
├── stripe_payment.php # Stripe payment processing
└── index.php # Main entry point
