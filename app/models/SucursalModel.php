<?php

class SucursalModel implements IModel {

    private $conexion;
    private $table = "TBL_Sucursal";
    private $nameEntity = "Sucursal";

    function __construct() {
        $this->conexion = SPDO::singleton();
    }

    public function delete($obj) {
        $retorno = new stdClass();
        try {
            $obj instanceof Sucursal;
            $sql = "DELETE FROM {$this->table} WHERE SUC_Id = ?";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->getSUC_Id());
            $query->execute();
            $retorno->status = 200;
            $retorno->msg = "Sucursal eliminada";
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
            $obj instanceof Sucursal;
            $sql = "SELECT * FROM {$this->table} WHERE SUC_Id = ?";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->getSUC_Id());
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
            $obj instanceof Sucursal;
            $sql = "INSERT INTO {$this->table} VALUES (null,?,?,?,?)";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->getSUC_Nit());
            $query->bindParam(2, $obj->getSUC_Nombre());
            $query->bindParam(3, $obj->getSUC_Direccion());
            $query->bindParam(4, $obj->getSUC_Telefono());
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
            $obj instanceof Sucursal;
            $sql = "UPDATE {$this->table} "
                    . "SET SUC_Nit=?, SUC_Nombre = ?, SUC_Direccion = ?, SUC_Telefono = ? "
                    . "WHERE SUC_Id = ?";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->getSUC_Nit());
            $query->bindParam(2, $obj->getSUC_Nombre());
            $query->bindParam(3, $obj->getSUC_Direccion());
            $query->bindParam(4, $obj->getSUC_Telefono());
            $query->bindParam(5, $obj->getSUC_Id());
            $query->execute();
            $retorno->data = $obj;
            $retorno->status = 200;
            $retorno->msg = "Sucursal Actualizada Exitosamente.";
        } catch (PDOException $e) {
            $retorno->msg = $e->getMessage();
            $retorno->status = 501;
        }
        return $retorno;
    }

}
