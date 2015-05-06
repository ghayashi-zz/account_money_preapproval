<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require_once 'Lib/User.php';

$email = $_REQUEST['email'];

$user = new User(null, $email);
$balance = $user->get_balance();

echo json_encode($balance);