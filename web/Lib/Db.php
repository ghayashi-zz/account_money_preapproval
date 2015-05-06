<?php

class DB{
    
    private $host = "localhost";
    private $user = "root";
    private $pass = "root";
    private $db = "account_money_preapproval";
    private $conn;
    
    
    public function __construct() {
        
        //caso exista variaveis do servidor, usa elas
        $this->host = isset($_REQUEST['HOST_DB']) ? $_REQUEST['HOST_DB'] : $this->host;
        $this->user = isset($_REQUEST['USER_DB']) ? $_REQUEST['USER_DB'] : $this->user;
        $this->pass = isset($_REQUEST['PASS_DB']) ? $_REQUEST['PASS_DB'] : $this->pass;
        $this->db = isset($_REQUEST['NAME_DB']) ? $_REQUEST['NAME_DB'] : $this->db;
        
        print_r($this);exit;
        //efetua connecao e seleciona db
        $this->conn = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
        
        
        if(!$this->conn){
            throw new Exception('Erro ao conectar no banco de dados. ' . mysqli_error($this->conn));
        }
    }
    
    
    public function query($query){
        return mysqli_query($this->conn, $query);
    }
    
}