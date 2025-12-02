<?php
session_start();

require_once 'autoload.php';


$route = $_SERVER['REQUEST_URI'];
$controller = new ViewController();

switch($route){
    case '/':
        $auth = new AuthController();
        if($_SESSION['logged']){
            header('Location: /dashboard');
        }else{
            header('Location: /login');
        }
        break;

    case '/login':
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (isset($_POST['username']) && isset($_POST['password'])){
                $auth = new AuthController();
                $logged = $auth->login();
                if($logged === false){
                    $controller->render('login');
                }
            }

        }else{
            $controller->render('login');
        
        }
        break;
    
    case '/register':
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            echo 'Faça o cadastro!!!';
        }else{
            $controller = new ViewController();
            $controller->render('register');
        }
        break;

    case '/dashboard':
        if(!$_SESSION['logged']){
       header('Location: /login');
        die;
    }else{
        $controller->render('dashboard');
    }
        break;

    default:
        header('Location: /');
}