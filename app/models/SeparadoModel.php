<?php

class SeparadoModel implements IModel {

    private $conexion;
    private $table = "tbl_separado";
    private $nameEntity = "Separado";

    function __construct() {
        $this->conexion = SPDO::singleton();
    }

    public function delete($obj) {
        $retorno = new stdClass();
        try {
            $obj instanceof Separado;
            $sql = "DELETE FROM {$this->table} WHERE SEP_Id = ?";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->getSEP_Id());
            $query->execute();
            $retorno->status = 200;
            $retorno->msg = "Separado eliminado";
        } catch (PDOException $e) {
            $retorno->msg = $e->getMessage();
            $retorno->status = 501;
        }
        return $retorno;
    }

    public function get($obj = null) {
        $retorno = new stdClass();
        try {
            $sql = "SELECT * FROM {$this->table} INNER JOIN tbl_producto "
                    . "ON {$this->table}.FK_PRO_Id = tbl_producto.PRO_Id INNER JOIN tbl_persona "
                    . "ON {$this->table}.FK_CLI_Id = tbl_persona.PK_PSN_Id ORDER BY {$this->table}.SEP_Id DESC";
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
            $obj instanceof Separado;
            $sql = "SELECT * FROM {$this->table} INNER JOIN tbl_producto "
                    . "ON {$this->table}.FK_PRO_Id = tbl_producto.PRO_Id INNER JOIN tbl_persona "
                    . "ON {$this->table}.FK_CLI_Id = tbl_persona.PK_PSN_Id "
                    . "WHERE {$this->table}.SEP_Id=?";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->getSEP_Id());
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
            $obj instanceof Separado;
            $sql = "INSERT INTO {$this->table} VALUES (null,?,?,?,?,?,?)";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->getFK_PRO_Id());
            $query->bindParam(2, $obj->getSEP_Valor());
            $query->bindParam(3, $obj->getSEP_Fecha());
            $query->bindParam(4, $obj->getSEP_Estado());
            $query->bindParam(5, $obj->getFK_VEN_Id());
            $query->bindParam(6, $obj->getFK_CLI_Id());
            $query->execute();
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
            $obj instanceof Separado;
            $sql = "UPDATE {$this->table} "
                    . "SET SEP_Estado=?, SEP_Valor=? WHERE SEP_Id = ?";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->getSEP_Estado());
            $query->bindParam(2, $obj->getSEP_Valor());
            $query->bindParam(3, $obj->getSEP_Id());
            $query->execute();
            $retorno->status = 200;
            $retorno->msg = "Separado Actualizado Exitosamente.";
        } catch (PDOException $e) {
            $retorno->msg = $e->getMessage();
            $retorno->status = 501;
        }
        return $retorno;
    }
    
    public function separadosFecha($obj) {
        $retorno = new stdClass();

        try {
            $sql = "SELECT * FROM {$this->table} INNER JOIN tbl_producto "
                    . "ON {$this->table}.FK_PRO_Id = tbl_producto.PRO_Id INNER JOIN tbl_persona "
                    . "ON {$this->table}.FK_CLI_Id = tbl_persona.PK_PSN_Id "
                    . "WHERE {$this->table}.SEP_Fecha BETWEEN ? and ? ORDER BY {$this->table}.SEP_Id DESC";
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
    
    public function separadosIdentificacion($obj) {
        $retorno = new stdClass();

        try {
            $sql = "SELECT * FROM {$this->table} INNER JOIN tbl_producto "
                    . "ON {$this->table}.FK_PRO_Id = tbl_producto.PRO_Id INNER JOIN tbl_persona "
                    . "ON {$this->table}.FK_CLI_Id = tbl_persona.PK_PSN_Id "
                    . "WHERE tbl_persona.PSN_Identificacion = ? ORDER BY {$this->table}.SEP_Id DESC";
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
