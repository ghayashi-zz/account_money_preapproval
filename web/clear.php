<?php
require_once "Lib/Db.php";

$db = new DB();
$resultado = $db->query("TRUNCATE TABLE users");
if($resultado){
    echo "ok";
}else{
    echo "error";
}