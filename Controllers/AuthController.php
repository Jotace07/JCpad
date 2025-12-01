<?php

class AuthController {

    public $is_auth = false;
    public $username;
    public $user_id;

    public function login($username, $password){

        $userClass = new User();
        $result = $userClass->getUserByUsername($username);
        if ($result) {
            if(password_verify($password, $result[0]['password'])){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function register($username, $password){
        return "Realize o registro!";
    }

    public function cehckAuth(){
        return $this->is_auth;
    }
    }