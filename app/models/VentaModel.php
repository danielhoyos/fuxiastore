<?php

class VentaModel implements IModel {

    private $conexion;
    private $table = "tbl_venta";
    private $nameEntity = "Venta";

    function __construct() {
        $this->conexion = SPDO::singleton();
    }

    public function delete($obj) {
        
    }

    public function get($obj = null) {
        $retorno = new stdClass();

        try {
            $obj instanceof Venta;
            $sql = "SELECT * FROM {$this->table} INNER JOIN tbl_persona "
                    . "ON {$this->table}.VEN_CLI_Id = tbl_persona.PK_PSN_Id ORDER BY {$this->table}.VEN_Id DESC";
            $query = $this->conexion->prepare($sql);
            $query->execute();
            $retorno->data = $query->fetchAll(PDO::FETCH_CLASS, $this->nameEntity);
            $retorno->status = 200;
            $retorno->msg = "Venta Encontrada Exitosamente";
        } catch (Exception $e) {
            $retorno->status = 501;
            $retorno->msg = $e->getMessage();
        }
        return $retorno;
    }

    public function getById($obj) {
        $retorno = new stdClass();

        try {
            $obj instanceof Venta;
            $sql = "SELECT * FROM {$this->table} INNER JOIN tbl_persona "
                    . "ON {$this->table}.VEN_CLI_Id = tbl_persona.PK_PSN_Id WHERE {$this->table}.VEN_Id = ?";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->getVEN_Id());
            $query->execute();

            $retorno->data = $query->fetchObject($this->nameEntity);
            $retorno->status = 200;
            $retorno->msg = "{$this->nameEntity} encontrada exitosamente";
            if (!$retorno->data instanceof $this->nameEntity) {
                $retorno->status = 201;
                $retorno->msg = "{$this->nameEntity} no encontrada";
            }
        } catch (Exception $e) {
            $retorno->status = 501;
            $retorno->msg = $e->getMessage();
        }

        return $retorno;
    }

    public function insert($obj) {
        $retorno = new stdClass();

        try {
            $obj instanceof Venta;
            $sql = "INSERT INTO {$this->table} VALUES(null,?,?,?,?)";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->getVEN_CLI_Id());
            $query->bindParam(2, $obj->getVEN_VEND_Id());
            $query->bindParam(3, $obj->getVEN_Fecha_Venta());
            $query->bindParam(4, $obj->getVEN_Total());
            $query->execute();
            $id = $this->conexion->lastInsertId();
            $retorno->data = $id;
            $retorno->status = 200;
            $retorno->msg = "Venta Registrada Exitosamente";
        } catch (Exception $e) {
            $retorno->status = 501;
            $retorno->msg = $e->getMessage();
        }
        return $retorno;
    }

    public function update($obj) {
        
    }

    public function facturasFecha($obj) {
        $retorno = new stdClass();

        try {
            $sql = "SELECT * FROM {$this->table} INNER JOIN tbl_persona "
                    . "ON {$this->table}.VEN_CLI_Id = tbl_persona.PK_PSN_Id WHERE {$this->table}.VEN_Fecha_Venta BETWEEN ? AND ? ORDER BY {$this->table}.VEN_Id DESC";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->fechaInicio);
            $query->bindParam(2, $obj->fechaFin);
            $query->execute();
            $retorno->data = $query->fetchAll(PDO::FETCH_CLASS, $this->nameEntity);
            $retorno->status = 200;
            $retorno->msg = "{$this->nameEntity} encontrada exitosamente";
        } catch (Exception $e) {
            $retorno->status = 501;
            $retorno->msg = $e->getMessage();
        }
        return $retorno;
    }
    
    public function facturasIdentificacion($obj) {
        $retorno = new stdClass();

        try {
            $sql = "SELECT * FROM {$this->table} INNER JOIN tbl_persona "
                    . "ON {$this->table}.VEN_CLI_Id = tbl_persona.PK_PSN_Id WHERE tbl_persona.PSN_Identificacion = ? ORDER BY {$this->table}.VEN_Id DESC";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->identificacion);
            $query->execute();
            $retorno->data = $query->fetchAll(PDO::FETCH_CLASS, $this->nameEntity);
            $retorno->status = 200;
            $retorno->msg = "{$this->nameEntity} encontrada exitosamente";
        } catch (Exception $e) {
            $retorno->status = 501;
            $retorno->msg = $e->getMessage();
        }
        return $retorno;
    }

}
