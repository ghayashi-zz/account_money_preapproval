<?php
require_once 'MercadoLivre/meli.php';
require_once 'Lib/User.php';

$meli = new Meli();

$params = array(
    "access_token" => $meli->getAccessToken()
);

echo "<br>";
print_r($params);

$preference = array( 
    "preapproval_id"=> $_REQUEST['preapproval_id'],
    "transaction_amount"=> 155.15,
    "currency_id"=> "BRL",
    "external_reference"=> "555",
    "type"=> "online" 
);


$preapproval = $meli->post('/authorized_payments', $preference, $params);

?>

Aguarde alguns instantes... <img src="assets/images/ajax-loader.gif">
