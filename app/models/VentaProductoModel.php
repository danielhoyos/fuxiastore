<?php

class VentaProductoModel implements IModel {

    private $conexion;
    private $table = "tbl_venta_producto";
    private $nameEntity = "VentaProducto";

    function __construct() {
        $this->conexion = SPDO::singleton();
    }

    public function delete($obj) {
        
    }

    public function get($obj = null) {
        
    }

    public function getById($obj) {
        
    }

    public function insert($obj) {
        $retorno = new stdClass();

        try {
            $obj instanceof VentaProducto;

            $sql = "INSERT INTO {$this->table} VALUES(null,?,?)";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->getPRO_Id());
            $query->bindParam(2, $obj->getVEN_Id());
            $query->execute();

            $retorno->status = 200;
            $retorno->msg = "Insertado Correctamente";
        } catch (Exception $e) {
            $retorno->status = 501;
            $retorno->msg = $e->getMessage();
        }
        
        return $retorno;
    }

    public function update($obj) {
        
    }
    
    public function productosVenta($obj){
        $retorno = new stdClass();
        
        try{
            $obj instanceof VentaProducto;
            
            $sql = "SELECT * FROM {$this->table} INNER JOIN tbl_producto ON {$this->table} .pro_id = tbl_producto.pro_id WHERE ven_id = ?";
            $query = $this->conexion->prepare($sql);
            $query->bindParam (1, $obj->getVEN_Id());
            $query->execute();
            
            $retorno->data = $query->fetchAll(PDO::FETCH_CLASS, $this->nameEntity);
            $retorno->status = 200;
            $retorno->msg = "Productos Encontrados";
        } catch (Exception $e) {
            $retorno->status = 501;
            $retorno->msg = $e->getMessage();
        }
        
        return $retorno;
    }

}
