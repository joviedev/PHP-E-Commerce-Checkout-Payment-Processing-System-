<?php
//global variable configuration
/*
* PayPal configuration
*/
// PayPal configuration
define('PAYPAL_ID', 's3710021@student.rmit.edu.au'); //seller email
define('PAYPAL_SANDBOX', TRUE); //TRUE or FALSE
//redirect page
define('PAYPAL_RETURN_URL', 'http://localhost/code/success.php'); 
define('PAYPAL_CANCEL_URL', 'http://localhost/code/cancel.php'); 
define('PAYPAL_NOTIFY_URL', 'http://127.0.0.1/ipn.php');
//define currency
define('PAYPAL_CURRENCY', 'AUD');

// Change not required
define('PAYPAL_URL', (PAYPAL_SANDBOX == true)? "https://www.sandbox.paypal.com/cgi-bin/webscr": "https://www.paypal.com/cgi-bin/webscr");

/* 
*my stripe configuration
*/
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_51Q4y5CJ04A5SZ1Ep86S1EdoB5kngjaVPjtyhGBoDvfhJqivQ9w1pCdLiHXPstMgRcv6ri72KnABt4Xlwt2OiJs9B007lJJNvGjy');
define('STRIPE_SECRET_KEY', 'sk_test_51Q4y5CJ04A5SZ1EpECtod8GfxoZgGqHAv9FiDT2PE3qSUthbCl8nYI8T7p2HmF320crS5dd1uOyiwPU1f46wuV93009CuGygdw');
?>
