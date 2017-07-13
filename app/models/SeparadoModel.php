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
            $sql = "DELETE FROM {$this->table} WHERE sep_id = ?";
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
                    . "ON {$this->table}.fk_pro_id = tbl_producto.pro_id INNER JOIN tbl_persona "
                    . "ON {$this->table}.fk_cli_id = tbl_persona.pk_psn_id ORDER BY {$this->table}.sep_id DESC";
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
    public function getSep($pag) {
        $retorno = new stdClass();
        $i = $pag == 1?0:($pag-1)*50;
        try {
            $sql = "SELECT * FROM {$this->table} INNER JOIN tbl_producto "
                    . "ON {$this->table}.fk_pro_id = tbl_producto.pro_id INNER JOIN tbl_persona "
                    . "ON {$this->table}.fk_cli_id = tbl_persona.pk_psn_id ORDER BY {$this->table}.sep_id DESC LIMIT {$i},50";
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
                    . "ON {$this->table}.fk_pro_id = tbl_producto.pro_id INNER JOIN tbl_persona "
                    . "ON {$this->table}.fk_cli_id = tbl_persona.pk_psn_id "
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
                    . "SET sep_estado=?, sep_valor=? WHERE sep_id = ?";
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
                    . "ON {$this->table}.fk_pro_id = tbl_producto.pro_id INNER JOIN tbl_persona "
                    . "ON {$this->table}.fk_cli_id = tbl_persona.pk_psn_id "
                    . "WHERE {$this->table}.sep_fecha BETWEEN ? and ? ORDER BY {$this->table}.sep_id DESC";
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
                    . "ON {$this->table}.fk_pro_id = tbl_producto.pro_id INNER JOIN tbl_persona "
                    . "ON {$this->table}.fk_cli_id = tbl_persona.pk_psn_id "
                    . "WHERE tbl_persona.psn_identificacion = ? ORDER BY {$this->table}.sep_id DESC";
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
    
    public function getCantSep() {
        $retorno = new stdClass();
        try {
            $sql = "SELECT COUNT(*) FROM {$this->table}";
            $query = $this->conexion->prepare($sql);
            $query->execute();
            $retorno->data = $query->fetchColumn();
            $retorno->status = 200;
            $retorno->msg = "{$this->nameEntity} encontrada";
        } catch (PDOException $e) {
            $retorno->msg = $e->getMessage();
            $retorno->status = 501;
        }
        return $retorno;
    }
}
