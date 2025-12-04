<?php

class AuthController {

    public $username;
    public $user_id;

    public function login(): bool{
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        $userClass = new User();
        $result = $userClass->getUserByUsername($username);
        if ($result) {
            if(password_verify($password, $result[0]['password'])){
                $_SESSION['logged'] = true;
                $_SESSION['username'] = $result[0]['username'];
                $_SESSION['role'] = $result[0]['role'];
                header('Location: /dashboard');
                return true;
            }
        }

        $_SESSION['message'] = "Login error!";
        header('Location: /login');
        return false;
        
    }

    public function register($username, $password){
        return "Realize o registro!";
    }

    public function checkAuth(){
        echo 'ainda nao';
    }
}