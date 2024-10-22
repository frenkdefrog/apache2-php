<?php

class Database{
    private $pdo;
    private $error;
    
    private function __construct(){
        $string = Config::get('database/driver').":host=".Config::get('database/hostname').";dbname=".Config::get('database/dbname');
        
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".CONFIG::get('database/charset'),
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false
        ];
        $pdo = new PDO($string, Config::get('database/username'), Config::get('database/userpassword'), $options);
        
        return $pdo;
    }

    public function query($query, $data=[]){
        $stm = $this->pdo->prepare($query);

        $check = $stm->execute($data);
        if (!$check) {
            return false;
        }
        
        return $stm->fetchAll();
    }
}
