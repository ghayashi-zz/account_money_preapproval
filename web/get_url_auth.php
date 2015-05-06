<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require_once 'MercadoLivre/meli.php';

$meli = new Meli();
$redirectUrl = $meli->getAuthUrl('http://matsuoka.im/dafiti/code.php');

echo json_encode(array("url" => $redirectUrl));