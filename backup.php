<?php
        require_once 'app/class_/Config.php'; //de configuracion
        require_once 'config.php'; //Archivo con configuraciones.
	require_once "{$config->get('modelsFolder')}SPDO.php";
	
	$dataBase = new BackupDataBase();
	$retornoTables = $dataBase->backupTables();
	$dataTables = $retornoTables->data;
	$sqlData = "";
	
	if(is_array($dataTables)){
		for($i=0;$i < count($dataTables);$i++){
			$tablas[] = $dataTables[$i][0]; 
		}
		for($j=0;$j < count($tablas);$j++){
			$retornoData = $dataBase->backupData($tablas[$j]);
			$dataTable = $retornoData->data;
			$sqlData.= "INSERT INTO {$tablas[$j]} VALUES \r\n";
			for($k=0;$k < count($dataTable);$k++){
				$data = $dataTable[$k];
				$sqlData.= "(";
				for($l=0;$l < (count($data)/2);$l++){
					$sqlData.= '"'.$data[$l].'"';
					if($l < ((count($data)/2)-1)){
						$sqlData.= ',';
					}
				}
				if($k < (count($dataTable)-1)){
					$sqlData.= "),\n";
				}else{
					$sqlData.=");\n\n";
				}
			}
		}
	}else{
		echo "Error: {$dataTables->msg}";
	}
        
    $dataBase->saveFile($sqlData);
	
	class BackupDataBase{
		var $conexion;
		function __construct(){
			$this->conexion = SPDO::singleton();
		}
		function backupTables(){
			$tables = new stdClass();
			
			try{
				$sql="SHOW TABLES";
				$query = $this->conexion->prepare($sql);
				$query->execute();
				$tables->data = $query->fetchAll();
			}catch (PDOException $e) {
				$tables->msg = $e->getMessage();;
			}
			return $tables;
		}
		
		function backupData($table){
			$datos = new stdClass();
			
			try{
				$sql="SELECT * FROM {$table}";
				$query = $this->conexion->prepare($sql);
				$query->execute();
				$datos->data = $query->fetchAll();
			}catch (PDOException $e) {
				$datos->msg = $e->getMessage();;
			}
			return $datos;
		}
		
		function saveFile($sql, $outputDir = '.'){
			if (!$sql) 
				return false;
			try{
				$handle = fopen($outputDir.'/backupFuxiaStore.sql','w+');
				fwrite($handle, $sql);
				fclose($handle);
			}
			catch (Exception $e)
			{
				var_dump($e->getMessage());
				return false;
			}
			return true;
		}
	}
?>

