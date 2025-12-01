<?php
require_once 'autoload.php';


$route = $_SERVER['REQUEST_URI'];
$controller = new ViewController();

switch($route){
    case '/':
        $auth = new AuthController();
        if($auth->cehckAuth()){
            echo 'Você já está autenticado.';
            echo 'flag{cala_a_boca_corno}';
        }else{
            header('Location: /login');
        }
        break;

    case '/login':
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (isset($_POST['username']) && isset($_POST['password'])){
                $username = htmlspecialchars($_POST['username']);
                $password = htmlspecialchars($_POST['password']);
                $auth = new AuthController();
                $logged = $auth->login($username, $password);
                if($logged){
                    $controller->render('dashboard');
                }else{
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
        $auth = new AuthController();
        if($auth->cehckAuth()){
            $controller->render('dashboard');
        }else{
            header('Location: /login');
        }
        break;

    default:
        echo 'Página não encontrada!';
}