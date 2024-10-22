<?php

class Config {
    private static $jsonconfigFile = __DIR__.'/../appconfig.json';
    private static $configCache = null; //statikus változó a konfiguráció gyorsítótárazására
    private static $lastModifiedTime = 0; //Fájl módosulásának ideje

    public static function get($variable=null) {
        if ($variable === null) {
            throw new \Exception('Configuration variable is not set');
        }
        
        //többszintű elérés támogatása (pl: database/host)
        $variable = explode('/', $variable);
        $config = self::getConfigArray();

        foreach($variable as $bit){
            if (isset($config[$bit])) {
                $config = $config[$bit]; //Navigálás a konfigurációs fájlban
            } else {
                throw new \Exception("Configuration key '$bit' not found");
            }
        }
        return $config;
    }

    public static function getConfigArray(){
        $currentModifiedTime = filemtime(self::$jsonconfigFile); //fájl utolsó módosítának ideje
       
        // ha a cache elérhető és nem változott a fájl
        if (self::$configCache !== null && self::$lastModifiedTime === $currentModifiedTime ) {
            return self::$configCache;
        }
        
        if (!file_exists(self::$jsonconfigFile)) {
            throw  new \Exception("The appconfig.json file cannot be found");
        }

        $jsonConfig = file_get_contents(self::$jsonconfigFile);
        $configArray = json_decode($jsonConfig, true);
            
        if (json_last_error() !== JSON_ERROR_NONE) {
            return new \Exception ("Error reading configuration file: ". json_last_error_msg());
        }
        
        //konfiguráció gyorsítótárazása a teljesítmény növelése érdekében
        self::$configCache = $configArray;
        self::$lastModifiedTime = $currentModifiedTime; //módosítási idő mentése
        
        return self::$configCache;
    }
}