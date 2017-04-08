<?php
	$backupDatabase = new Backup_Database();
	$retorno = $backupDatabase->backupTables();
	print_r($retorno);
	
	class Backup_Database{
		function __construct() {
			$this->conexion = SPDO::singleton();
		}
		
		function backupTables(){
			$retorno = new stdClass();
        try {
            $sql = "SHOW TABLES";
            $query = $this->conexion->prepare($sql);
            $query->execute();
			$retorno->data = $query->array();
        } catch (PDOException $e) {
            $retorno->msg = $e->getMessage();;
        }
        return $retorno;
		}
	}
        ?>