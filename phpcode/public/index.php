<?php
session_start();

require "../app/core/init.php";

try{
    $app = new App;
    $app->loadController();
} catch (\Exception $e){
    echo $e->getMessage();
}
// phpinfo();