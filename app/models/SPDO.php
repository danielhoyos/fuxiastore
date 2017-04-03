<?php

class SPDO extends PDO {

    private static $instance = null;
    
    private function SPDO() {
        $config = Config::singleton();
        try {
            parent::__construct('mysql:host=' . $config->get('dbhost') . ';dbname=' . $config->get('dbname'), $config->get('dbuser'), $config->get('dbpass'));
            $this->exec("SET CHARACTER SET utf8");
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
            die();
        }
    }

    public static function singleton() {
        if (!isset(self::$instance)) {
            $miclase = __CLASS__;
            self::$instance = new $miclase();
        }
        return self::$instance;
    }
    
    public function __clone() {
        trigger_error('La clonación no es permitida!.', E_USER_ERROR);
    }

}
?>