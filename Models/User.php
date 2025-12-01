<?php

class User {
    public $id;
    public $username;
    public $password;
    public $connectinon;

    public function __construct(){
        $this->connectinon = new mysqli('192.168.20.106', 'jc_database', 'jc', 'jc_company');
    }

    public function getAll(){
        $sql = "SELECT * FROM users";
        $result = $this->connectinon->query($sql);
        $users = [];
        while($row = $result->fetch_assoc()){
            $users[] = $row;
        }
        return $users;
    }

    public function getUserByUsername($username){
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $this->connectinon->query($sql);
        $user = $result->fetch_assoc();
        return $user;
    } 
        

    public function __destruct(){

        $this->connectinon->close();
    }
}