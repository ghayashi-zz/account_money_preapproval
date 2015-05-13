<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require_once 'Lib/User.php';

$email = $_REQUEST['email'];

$user = new User(null, $email);
$balance = $user->get_balance();

//significa que não tem usuario, logo não busca nenhuma informação
if($balance['httpCode'] != 400){
    $me = $user->me();
    $balance['body']->user_info = $me['body'];    
}

echo json_encode($balance);