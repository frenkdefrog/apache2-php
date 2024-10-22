<?php

class Controller{
    public function view($name){
        $baseurl = $this->getBaserUrl();
        $filename = "../app/views/".$name.".view.php";
        if (!file_exists($filename)){
            $filename = "../app/views/404.view.php";
        }
        require $filename;
    }

    private function getBaserUrl(){
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'];
        return $protocol.$host;
    }
}