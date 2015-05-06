<?php

class DB{
    
    private $host = "localhost";
    private $user = "root";
    private $pass = "gabr1241992iel";
    private $db = "dafiti";
    private $conn;
    
    
    public function __construct() {
        
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