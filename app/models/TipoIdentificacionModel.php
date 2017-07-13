<?php

class TipoIdentificacionModel implements IModel{
    
    private $conexion;
    private $table = "tbl_tipo_identificacion";
    private $nameEntity = "TipoIdentificacion";
    
    public function __construct() {
        $this->conexion = SPDO::singleton();
    }

    public function delete($obj) {
        
    }

    public function get($obj = null) {
        $retorno = new stdClass();
        
        try {
            $sql = "SELECT * FROM {$this->table}";
            $query = $this->conexion->prepare($sql);
            $query->execute();
            $retorno->data = $query->fetchAll(PDO::FETCH_CLASS, $this->nameEntity);
            $retorno->status = 200;
            $retorno->msg = "Consulta Exitosa";
            
            if (count($retorno->data) === 0) {
                $retorno->status = 201;
                $retorno->msg = "No hay registros en la base de datos.";
            }
        } catch (PDOException $e) {
            $retorno->status = 501;
            $retorno->msg = $e->getMessage();
        }
        
        return $retorno;
    }

    public function getById($obj) {
        
    }

    public function insert($obj) {
        
    }

    public function update($obj) {
        
    }

}