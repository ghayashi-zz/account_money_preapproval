<?php
require_once 'MercadoLivre/meli.php';
require_once 'Lib/User.php';

$meli = new Meli();

$params = array(
    "access_token" => $meli->getAccessToken()
);


$preference = array(
    "payer_email" => $_REQUEST['email'],
    "back_url" => "https://account-money-preapproval.herokuapp.com/charge_preapproval.php",
    "external_reference" => "ORDER-12345",
    "reason" => "Pagamento com Dinheiro em Conta",
    "status" => "authorized",
    "account_money" => true
);

$preapproval = $meli->post('/preapproval', $preference, $params);



$preference = array(
    "preapproval_id" => $preapproval['body']->id,
    "transaction_amount"=> $_REQUEST['amount'],
    "currency_id"=> "BRL",
    "external_reference"=> date("Y-m-d h:i:s"),
    "type"=> "online"
);

$authorize = $meli->post('/authorized_payments', $preference, $params);


echo json_encode($authorize['body']);
