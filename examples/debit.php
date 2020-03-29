<?php

use PaymentGateway\Client\Client;
use PaymentGateway\Client\Data\Customer;
use PaymentGateway\Client\Transaction\Debit;
use PaymentGateway\Client\Transaction\Result;

require_once('../initClientAutoload.php');

//PajmentJS indicator
if(isset($_POST["transaction_token"])){
    $token = $_POST["transaction_token"];
}
// register card on file or not
if(isset($_POST["withRegister"])){
    $withRegister = $_POST["withRegister"]=== 'true'? true: false;
}
// use card on file
if(isset($_POST["CardOnFile"])){
    $CardOnFile = $_POST["CardOnFile"]=== 'true'? true: false;
}

$client = new Client('username', 'password', 'apiKey', 'sharedSecret', 'language');


$customer = new Customer();
$customer
    ->setFirstName('John')
    ->setLastName('Smith')
    ->setEmail('john@smith.com')
    ->setIpAddress('123.123.123.123');
//add further customer details if necessary

// define your transaction ID: e.g. 'myId-'.date('Y-m-d').'-'.uniqid()
$merchantTransactionId = 'D-Test-'.date('Y-m-d').'-'.uniqid(); // must be unique


$debit = new Debit();
$debit->setTransactionId($merchantTransactionId)
    ->setAmount(9.99)
    ->setCurrency('EUR')
    ->setCallbackUrl('https://YourDomain/PHPPaymentGateway/examples/Callback.php')
    ->setSuccessUrl('https://YourDomain/PHPPaymentGateway/examples/PaymentOK.php')
    ->setErrorUrl('https://YourDomain/PHPPaymentGateway/examples/PaymentNOK.php')
    ->setCancelUrl('https://YourDomain/PHPPaymentGateway/examples/PaymentCancel.php')
    ->setDescription('One pair of shoes')
    ->setWithRegister($withRegister)
    
    //->addExtraData('3dsecure', 'MANDATORY') 
    ->setCustomer($customer);
    
//if token acquired via payment.js
if (isset($token)) {
    $debit->setTransactionToken($token);
}

if (isset($CardOnFile) && $CardOnFile == true){
    $debit
        ->setTransactionIndicator('CARDONFILE')
        ->setReferenceTransactionId($_POST["RefTranId"]);
    
} else{
    $debit->setTransactionIndicator('SINGLE');
}

//for recurring transactions
//if ($isRecurringTransaction) {
//    $debit->setReferenceTransactionId($referenceIdFromFirstTransaction);
//}


$result = $client->debit($debit);

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