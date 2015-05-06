<?php

require_once 'MercadoLivre/meli.php';

$meli = new Meli();

echo $meli->getAccessToken();