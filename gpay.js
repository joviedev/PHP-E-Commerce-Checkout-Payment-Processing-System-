let paymentsClient = null;
const allowedCardNetworks = ["AMEX", "DISCOVER", "INTERAC", "JCB", "MASTERCARD", "VISA"];
const allowedCardAuthMethods = ["PAN_ONLY", "CRYPTOGRAM_3DS"];
const baseCardPaymentMethod = {
    type: 'CARD',
    parameters: {
        allowedAuthMethods: allowedCardAuthMethods,
        allowedCardNetworks: allowedCardNetworks
    }
};
 
 
const tokenizationSpecification = {
    type: 'PAYMENT_GATEWAY',
    parameters: {
        'gateway': 'example',
        'gatewayMerchantId': 'exampleGatewayMerchantId'
    }
};
const cardPaymentMethod = Object.assign(
    { tokenizationSpecification: tokenizationSpecification },
    baseCardPaymentMethod
);
 
 
function getGooglePaymentDataRequest() {
 
    const paymentDataRequest = {
        apiVersion: 2,
        apiVersionMinor: 0
    };
    paymentDataRequest.allowedPaymentMethods = [cardPaymentMethod];
    paymentDataRequest.transactionInfo = getGoogleTransactionInfo();
    paymentDataRequest.merchantInfo = {
        merchantName: 'Example Merchant'
    };
    paymentDataRequest.callbackIntents = ["PAYMENT_AUTHORIZATION"];
    return paymentDataRequest;
}
 
 
function getGoogleTransactionInfo(totalPrice) { 
 
    const displayItems = []

    const displayItem = {
        label: "Shopping Cart Purchase",
        type: "SUBTOTAL",
        price: `${totalPrice}`
    }
 
    displayItems.push(displayItem)
    
 
    return {
        totalPriceStatus: 'FINAL',
        totalPriceLabel: 'Total',
        totalPrice: `${totalPrice}`,
        currencyCode: 'AUD',
        countryCode: 'AU',
        displayItems: displayItems,
    }
}
 
function getGooglePaymentsClient() {
    if (paymentsClient === null) {
        paymentsClient = new google.payments.api.PaymentsClient({
            environment: 'TEST',
            paymentDataCallbacks: {
                onPaymentAuthorized: onPaymentAuthorized
            }
        });
    }
    return paymentsClient;
}
 
 
function onPaymentAuthorized(paymentData) {
    return new Promise(function (resolve, reject) {
        // handle the response
        console.log('onPaymentAuthorized')
        processPayment(paymentData)
            .then(function () {
                console.log('processPayment success')
                resolve({ transactionState: 'SUCCESS' });
            })
            .catch(function () {
                resolve({
                    transactionState: 'ERROR',
                    error: {
                        intent: 'PAYMENT_AUTHORIZATION',
                        message: 'Insufficient funds',
                        reason: 'PAYMENT_DATA_INVALID'
                    }
                });
            });
    });
}
 
function processPayment(paymentData) {
    console.log('doing processPayment...')
    return new Promise(function (resolve, reject) {
        setTimeout(function () {
            const paymentToken = paymentData.paymentMethodData.tokenizationData.token;
            resolve({});
        }, 3000);
    });
}