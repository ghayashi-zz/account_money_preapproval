<?php

require_once "Db.php";
require_once './MercadoLivre/meli.php';

class User{
    
    
    public $user_id;
    public $email;
    public $refresh_token;
    private $db;
    
    public function __construct($user_id = null, $email = null, $refresh_token = null) {
        $this->user_id = $user_id;
        $this->email = $email;
        $this->refresh_token = $refresh_token;
        $this->db = new DB();
    }
    
    public function all(){
        $r = $this->db->query("SELECT * FROM users");
        $users = array();
        while($user = $r->fetch_array(MYSQLI_ASSOC)){
            $users[] = $user;
        }
        
        return $users;
    }
    
    public function save(){
        
        $r = "";
        
        if(!$this->select()){
            //caso n‹o exista cria o usuario
            $r = $this->db->query("INSERT INTO users (user_id, email, refresh_token)  VALUES ('$this->user_id', '$this->email', '$this->refresh_token')");
        }else{
            $r = $this->db->query("UPDATE users SET email = '$this->email', refresh_token = '$this->refresh_token' WHERE user_id = '$this->user_id'");
        }
        
        if($r){
            return $this;
        }else{
            return false;
        }
        
    }
    
    public function select(){
        $query = "";
        
        if($this->user_id != null){
            $query = "user_id = '$this->user_id'";
        }
        
        if($this->email != null){
            $separator = "";
            
            if($query != ""){
                $separator = " OR ";
            }
            
            $query .= $separator . " email= '$this->email'";
        }
        
        if($query == ""){
            return false;
        }
        
        $r = $this->db->query("SELECT * FROM users WHERE " . $query . " LIMIT 1");
        if($r->num_rows > 0){
            
            $user = $r->fetch_array(MYSQLI_ASSOC);
            $this->user_id = $user['user_id'];
            $this->email = $user['email'];
            $this->refresh_token = $user['refresh_token'];
            
            return $this;
        }else{
            return false;
        }
    }
    
    public function get_access_token(){
        
        $meli = new Meli(null, $this->refresh_token);
        $r = $meli->refreshAccessToken();
        
        if($r['httpCode'] == 200){
            $token = $r['body'];
            $this->refresh_token = $token->refresh_token;
            $this->save();
            
            return $token->access_token;
        }
    }
    
    public function get_balance(){
        
        if(!$this->select() == false){
            $access_token = $this->get_access_token();
            $params = array('access_token' => $access_token);
            
            $meli = new Meli();
            $balance = $meli->get("/users/$this->user_id/mercadopago_account/balance", $params);
            //$balance = $balance['body'];
            return $balance;
        }else{
            return array("httpCode" => 400);
        }
    }
    
    public function me(){
        if(!$this->select() == false){
            $access_token = $this->get_access_token();
            $params = array('access_token' => $access_token);
            
            $meli = new Meli();
            $me = $meli->get("/users/me", $params);

            return $me;
        }else{
            return array("httpCode" => 400);
        }
        
    }
    
    
}