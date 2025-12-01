<?php

class User {
    
    private $db;
    public $id;
    public $username;
    public $password;
    public $connectinon;

    public function __construct(){
        $this->db = Database::connect();
    }

    public function getAll(){
        $sql = "SELECT * FROM users";
        $users = $this->db->query($sql)->fetchAll();
        return $users;
    }

    public function getUserByUsername($username){
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetchAll();
        return $user;
    }

        
    public function __destruct(){

        
    }
}