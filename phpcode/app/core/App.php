<?php

class App{
    private $controller= 'Home';
    private $method = 'index';
    private $params = [];

    private function splitURL(){
        $URL = $_GET['url'] ?? ''; //itt még meg lehet szabni, hogy mi legyen az alapértelmezett landing page
        $URL = trim($URL, '/');
        $URL = filter_var($URL, FILTER_SANITIZE_URL);
        return explode("/", $URL);
    }
    
    public function loadController(){
        $URL = $this->splitURL();
        
        //Controller az URL első eleméből, hogy ha van
        if(!empty($URL[0])) {
            $filename = "../app/controllers/".ucfirst($URL[0]).".php";
        
            if (file_exists($filename)) {
                $this->controller = ucfirst($URL[0]);
                unset($URL[0]); //Eltávolítjuk a controllert a tömbből
                $URL = array_values($URL);
            } else {
                $filename = "../app/controllers/_404.php";
                $this->controller = "_404";
            }
        } else {
            //az alapértelmezett controller használata
            $filename = "../app/controllers/".$this->controller.".php";
        }

        require $filename;  
        $controller = new $this->controller;

        //metódus beállítása az URL második eleméből, hogy ha van.
        if (isset($URL[0])) {
            if (method_exists($controller, $URL[0])) {
                $this->method = $URL[0];
                unset($URL[0]);
                $URL=array_values($URL);
            }
        }
        //a megmaradt elemek paraméterek lesznek
        $this->params = $URL ? array_values($URL) : [];

        //a controller metódusának meghívása paraméterekkel
        call_user_func_array([$controller,$this->method], $this->params);
    }
}

