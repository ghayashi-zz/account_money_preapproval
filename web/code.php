<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require_once 'MercadoLivre/meli.php';
require_once 'Lib/User.php';

$retorno = array();
$meli = new Meli();

$r = $meli->authorize($_GET['code'], 'https://account-money-preapproval.herokuapp.com/code.php/code.php');

if($r['httpCode'] == 200){
    $token = $r['body'];
    $params = array('access_token' => $token->access_token);
    $user = $meli->get('/users/me', $params);
    $user = $user['body'];

    //salva usuario    
    $user = new User($user->id, $user->email, $token->refresh_token);
    
    if(!$user->save() == false){
        $retorno = array(
            "status" => true
        );
    }else{
        $retorno = array(
            "status" => false
        );        
    }
    
}else{
    $retorno = array(
        "status" => false
    );
}

//echo json_encode($retorno);
?>

<br/>

Usuário autorizado. <br/>
Por favor, feche o modal!


