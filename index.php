<?php
require_once 'autoload.php';


$route = $_SERVER['REQUEST_URI'];

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
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $request = file_get_contents('php://input');
            $data_obj = json_decode($request);
            $auth = new AuthController();
            $result = $auth->login($data_obj->username, $data_obj->password);
            if($result){
                echo 'Login realizado com sucesso!';

            }else{
                echo 'Login ou senha inválido!';
            }

        }else{
            $controller = new ViewController();
            $controller->render('login');
        
        }
        break;
    
    case '/register':
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            echo 'Faça o cadastro!!!';
        }else{
            $controller = new ViewController();
            $controller->render('register');
        }
        break;

    case '/dashboard':
        $auth = new AuthController();
        if($auth->cehckAuth()){
            $controller = new ViewController();
            $controller->render('dashboard');
        }else{
            header('Location: /login');
        }
        break;

    default:
        echo 'Página não encontrada!';
}