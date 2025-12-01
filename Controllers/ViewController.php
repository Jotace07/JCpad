<?php

class ViewController{
    
    public function render($view){
        require_once './Views/' . $view . '.php';
    }
}