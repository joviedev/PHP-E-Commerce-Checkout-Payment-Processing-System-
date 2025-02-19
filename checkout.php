<?php
session_start();
include 'config.php';  // config.php includes PayPal and stripe credentials

// Generate a random reference number for Westpac Pay and store it in the session
if (!isset($_SESSION['reference_number'])) {
    $_SESSION['reference_number'] = rand(1000000000, 9999999999);  // Generate a random 10-digit number
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout Page</title>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
}

.checkout-container {
    display: flex;
    justify-content: space-between;
    width: 80%;
    max-width: 1200px;
    background: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.info-container, .payment-container {
    flex: 1;
    padding: 20px;
}

.info-container h2, .payment-container h2 {
    margin-bottom: 20px;
}

.info-container form {
    display: flex;
    flex-direction: column;
}

.info-container label {
    margin-bottom: 5px;
}

.info-container input[type="text"],
.info-container input[type="email"],
.info-container select {
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.payment-container form {
    display: flex;
    flex-direction: column;
}

.payment-container input[type="radio"],
.payment-container label {
    margin: 10px 0;
}

.payment-container button {
    padding: 10px 20px;
    background-color: #007AFF;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.payment-container button:hover {
    background-color: #007AAA;
}

.form-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

</style>
</head>
<body>
<div class="checkout-container">
    <div class="info-container">
        <h2>Billing address</h2>
        <form id="billing-form">
			<div class="form-row">
				<div>
					<label for="first-name">First Name</label>
					<input type="text" id="first-name" name="first_name">
				</div>
				<div>
					<label for="last-name">Last Name</label>
					<input type="text" id="last-name" name="last_name">
				</div>
			</div>

			<label for="address">Username</label>
            <input type="text" id="username" name="username">

            <label for="email">Email</label>
            <input type="email" id="email" name="email">

            <label for="address">Address</label>
            <input type="text" id="address" name="address">

		<div class="form-row">
			<div>
				<label for="country">Country</label>
				<select id="country" name="country">
					<option value="">Choose...</option>
				</select>
			</div>

			<div>
				<label for="state">State</label>
				<select id="state" name="state">
					<option value="">Choose...</option>
				</select>
			</div>

			<div>
				<label for="zip">ZIP</label>
				<input type="text" id="zip" name="zip">
			</div>
		</div>
        </form>
    </div>
    <div class="payment-container">
        <h2>Select A Payment Option</h2>
        <form id="paymentForm" method="post">
			<div>
				<input type="radio" id="paypal" name="payment" value="paypal" checked>
				<img src="assets/img/paypal.png" height="30">
			</div>
			
			<div>
				<input type="radio" id="google-pay" name="payment" value="google-pay">
				<img src="assets/img/gpay.png" height="30">
			</div>

            <input type="hidden" name="payment_token" id="payment_token">

			<div>
				<input type="radio" id="westpac-pay-net" name="payment" value="westpac-pay-net">
				<img src="assets/img/westpac.png" height="30">
			</div>

			<div>
				<input type="radio" id="stripe-pay" name="payment" value="stripe-pay">
				<img src="assets/img/stripe.png" height="30">
			</div>

			<!-- PayPal configuration fields -->
            <input type="hidden" name="business" value="<?php echo PAYPAL_ID; ?>">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="item_name" value="Shopping Cart Purchase">
            <input type="hidden" name="amount" value="<?php echo $_SESSION['cart_total']; ?>">
            <input type="hidden" name="currency_code" value="<?php echo PAYPAL_CURRENCY; ?>">

            <!-- Specify URLs -->
            <input type="hidden" name="return" value="<?php echo PAYPAL_RETURN_URL; ?>">
            <input type="hidden" name="cancel_return" value="<?php echo PAYPAL_CANCEL_URL; ?>">
            <input type="hidden" name="notify_url" value="<?php echo PAYPAL_NOTIFY_URL; ?>">

            <!-- Load Google Pay API -->
            <script async src="https://pay.google.com/gp/p/js/pay.js"></script>
            <script src="gpay.js"></script>
            <script>
                function setPaymentAction(event) {
                    event.preventDefault();  // Prevent default form submission

                    var selectedPayment = document.querySelector('input[name="payment"]:checked').value;

        // Set the action based on the selected payment method
        switch (selectedPayment) {
            case 'paypal':
                document.getElementById('paymentForm').action = '<?php echo PAYPAL_URL; ?>';
                document.getElementById('paymentForm').submit();
                break;

            case 'google-pay':
                let totalPrice = Number("<?php echo $_SESSION['cart_total'];?>");
                const paymentDataRequest = getGooglePaymentDataRequest();
                paymentDataRequest.transactionInfo = getGoogleTransactionInfo(totalPrice);
            
                const paymentsClient = getGooglePaymentsClient();
                paymentsClient.loadPaymentData(paymentDataRequest) //trigger pop up window
                    .then(function (paymentData) {
                        // if using gateway tokenization, pass this token without modification
                        console.log("loadPaymentData")
                        //redirect to success page
                        window.location.href = 'http://localhost/code/success.php';
            
                    })
                    .catch(function (err) {
                        // show error in developer console for debugging
                        console.error(err);
                    });   
                break;
                
            case 'westpac-pay-net':
                var paymentAmount = <?php echo $_SESSION['cart_total']; ?>;  // Or get from form inputs
                var paymentReference = '<?php echo $_SESSION['reference_number']; ?>';  // Use the generated reference number
                var receiptAddress = document.getElementById('email').value;

                document.getElementById('paymentForm').action = 'https://www.payway.com.au/MakePayment?BillerCode=190198&payment_amount=' + paymentAmount + '&receipt_address=' + receiptAddress + '&payment_reference=' + paymentReference;
                document.getElementById('paymentForm').submit();
                break;

            case 'stripe-pay':
                document.getElementById('paymentForm').action = 'http://localhost/code/stripe.php';  // Replace with actual Stripe URL
                document.getElementById('paymentForm').submit();
                break;
            default:
                alert("Please select a valid payment method.");
        }
    }
</script>

            <!-- Checkout Button -->
            <button type="submit" id="checkout-button" onclick="setPaymentAction(event)">Continue To Checkout</button>
        </form>
    </div>
</div>



</body>
</html>