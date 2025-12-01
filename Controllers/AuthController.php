<?php

class AuthController {

    public $is_auth = false;
    public $username;
    public $user_id;

    public function login($username, $password){
        $userModel = new User();
        $user = $userModel->getUserByUsername($username);
        if($user){

            if($user['password'] === $password){
                $this->is_auth = true;
                $this->username = $user['username'];
                $this->user_id = $user['id'];
                return true;

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