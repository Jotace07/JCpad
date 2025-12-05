<?php
session_start();

require_once 'autoload.php';


$route = $_SERVER['REQUEST_URI'];
$controller = new ViewController();
$crud = new CrudController();

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
            }
        
        }else{
            $controller->render('login');
        
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
    
    case '/crud':
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['noteTitle']) && isset($_POST['noteContent']) && isset($_POST['saveNote'])){
                $crud->saveNotes();
            }

            if(isset($_POST['oldTitle']) && isset($_POST['oldContent']) && isset($_POST['newTitle']) && isset($_POST['newNote']) && isset($_POST['editNote'])){
                $crud->updateNotes();
            }
            
            if(isset($_POST['getNotes'])){
                $crud->getNotes();
            }

            if(isset($_POST['noteTitle']) && isset($_POST['deleteNotes'])){
                $crud->deleteNotes();
            }  
        }

        break;

        case '/admin':
            if($_SESSION['logged'] && $_SESSION['role'] === 'admin'){
                $controller->render('admin');
                die;
            }
            header('Location: /login');
            break;

    default:
        header('Location: /');
}