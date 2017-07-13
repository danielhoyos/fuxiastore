<?php

class ProveedorModel implements IModel {

    private $conexion;
    private $table = "tbl_proveedor";
    private $nameEntity = "Proveedor";

    function __construct() {
        $this->conexion = SPDO::singleton();
    }

    public function delete($obj) {
        $retorno = new stdClass();
        try {
            $obj instanceof Proveedor;
            $sql = "DELETE FROM {$this->table} WHERE prov_id = ?";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->getProv_id());
            $query->execute();
            $retorno->status = 200;
            $retorno->msg = "Proveedor eliminado";
        } catch (PDOException $e) {
            $retorno->msg = $e->getMessage();
            $retorno->status = 501;
        }
        return $retorno;
    }

    public function get($obj = null) {
        $retorno = new stdClass();
        try {
            $sql = "SELECT * from {$this->table}";
            $query = $this->conexion->prepare($sql);
            $query->execute();
            $retorno->data = $query->fetchAll(PDO::FETCH_CLASS, $this->nameEntity);
            $retorno->status = 200;
            $retorno->msg = "Consulta exitosa";
            if (count($retorno->data) === 0) {
                $retorno->status = 201;
                $retorno->msg = "No hay registros en la base de datos.";
            }
        } catch (PDOException $e) {
            $retorno->msg = $e->getMessage();
            $retorno->status = 501;
        }
        return $retorno;
    }

    public function getById($obj) {
        $retorno = new stdClass();
        try {
            $obj instanceof Proveedor;
            $sql = "SELECT * FROM {$this->table} WHERE pro_id = ?";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->getProv_id());
            $query->execute();
            $retorno->data = $query->fetchObject($this->nameEntity);
            $retorno->status = 200;
            $retorno->msg = "{$this->nameEntity} encontrada";
            if (!$retorno->data instanceof $this->nameEntity) {
                $retorno->status = 201;
                $retorno->msg = "{$this->nameEntity} no encontrado";
            }
        } catch (PDOException $e) {
            $retorno->msg = $e->getMessage();
            $retorno->status = 501;
        }
        return $retorno;
    }

    public function insert($obj) {
        $retorno = new stdClass();

        try {
            $obj instanceof Proveedor;
            $sql = "INSERT INTO {$this->table} VALUES (null,?)";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->getProv_nombre());
            $query->execute();
            $id = $this->conexion->lastInsertId();
            $obj->setSUC_Id($id);
            $retorno->data = $obj;
            $retorno->status = 200;
            $retorno->msg = "Registro insertado.";
        } catch (PDOException $e) {
            $retorno->msg = $e->getMessage();
            $retorno->status = 501;
        }

        return $retorno;
    }

    public function update($obj) {
        $retorno = new stdClass();
        try {
            $obj instanceof Proveedor;
            $sql = "UPDATE {$this->table} "
                    . "SET prov_nombre=? WHERE prov_id = ?";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->getProv_nombre());
            $query->bindParam(2, $obj->getProv_id());
            $query->execute();
            $retorno->data = $obj;
            $retorno->status = 200;
            $retorno->msg = "Proveedor Actualizado Exitosamente.";
        } catch (PDOException $e) {
            $retorno->msg = $e->getMessage();
            $retorno->status = 501;
        }
        return $retorno;
    }

}
