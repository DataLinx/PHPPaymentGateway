<?php

use PaymentGateway\Client\Client;
use PaymentGateway\Client\StatusApi\StatusRequestData;

require_once('../initClientAutoload.php');

$client = new Client('username', 'password', 'apiKey', 'sharedSecret');

$statusRequestData = new StatusRequestData();

$transactionUuid = $_POST["RefTranId"]; // the gatewayReferenceId you get by Result->getReferenceId();
//$merchantTransactionId = 'your_transaction_id';

// use either the UUID or your merchantTransactionId but not both
$statusRequestData->setTransactionUuid($transactionUuid);
//$statusRequestData->setMerchantTransactionId($merchantTransactionId);

$statusResult = $client->sendStatusRequest($statusRequestData);

var_dump($statusResult);

die();