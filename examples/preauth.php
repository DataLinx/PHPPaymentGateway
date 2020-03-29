<?php

use PaymentGateway\Client\Client;
use PaymentGateway\Client\Data\Customer;
use PaymentGateway\Client\Transaction\Preauthorize;
use PaymentGateway\Client\Transaction\Result;

require_once('../initClientAutoload.php');

if(isset($_POST["transaction_token"])){
    $token = $_POST["transaction_token"];
}
$client = new Client('username', 'password', 'apiKey', 'sharedSecret', 'language');




//$client = new \PaymentGateway\Client\Client($username, $password, $apiKey, $sharedSecret);

$preauth = new Preauthorize();

// define your transaction ID: e.g. 'myId-'.date('Y-m-d').'-'.uniqid()
$merchantTransactionId = 'P-Test-'.date('Y-m-d').'-'.uniqid(); // must be unique

$preauth
 ->setTransactionId($merchantTransactionId)
 ->setAmount(4.99)
 ->setCurrency('EUR')
 ->setDescription('Transaction Description')
 ->setCallbackUrl('https://YourDomain/PHPPaymentGateway/examples/Callback.php')
 ->setSuccessUrl('https://YourDomain/PHPPaymentGateway/examples/PaymentOK.php')
 ->setErrorUrl('https://YourDomain/PHPPaymentGateway/examples/PaymentNOK.php')
 ->setCancelUrl('https://YourDomain/PHPPaymentGateway/examples/PaymentCancel.php')
 ->setDescription('One pair of shoes')
 ->setTransactionIndicator('SINGLE');

$customer = new Customer();
$customer
 ->setFirstName('John')
 ->setLastName('Smith')
 ->setIdentification('1111')
 ->setBillingCountry('AT')
 ->setEmail('some.person@some.domain')
 ->setIpAddress('123.123.123.123');

$preauth->setCustomer($customer);



//if token acquired via payment.js
if (isset($token)) {
    $debit->setTransactionToken($token);
}


$result = $client->preauthorize($preauth);

$gatewayReferenceId = $result->getReferenceId(); //store it in your database

if ($result->getReturnType() == Result::RETURN_TYPE_ERROR) {
    //error handling Sample
    $error = $result->getFirstError();
    $outError = array();
    $outError ["message"] = $error->getMessage();
    $outError ["code"] = $error->getCode();
    $outError ["adapterCode"] = $error->getAdapterCode();
    $outError ["adapterMessage"] = $error->getAdapterMessage();
    header("Location: https://YourDomain/PHPPaymentGateway/examples/PaymentNOK.php?" . http_build_query($outError));
    die;
} elseif ($result->getReturnType() == Result::RETURN_TYPE_REDIRECT) { 
    //redirect the user
    header('Location: '.$result->getRedirectUrl());
    die;
} elseif ($result->getReturnType() == Result::RETURN_TYPE_PENDING) {
    //payment is pending, wait for callback to complete

    //setCartToPending();

} elseif ($result->getReturnType() == Result::RETURN_TYPE_FINISHED) {
    //payment is finished, update your cart/payment transaction
    
    header("Location: https://YourDomain/PHPPaymentGateway/examples/PaymentOK.php?" . http_build_query($result->toArray()));
    die;
    //finishCart();
}      