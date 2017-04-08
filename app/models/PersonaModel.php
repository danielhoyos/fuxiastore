<?php

class PersonaModel implements IModel {

    private $conexion;
    private $table = "tbl_persona";
    private $nameEntity = "Persona";

    public function __construct() {
        $this->conexion = SPDO::singleton();
    }

    public function delete($obj) {
        $retorno = new stdClass();
        try {
            $obj instanceof Persona;
            $sql = "DELETE FROM {$this->table} WHERE pk_psn_id = ?";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->getPK_PSN_Id());
            $query->execute();
            $retorno->status = 200;
            $retorno->msg = "Persona Eliminada";
        } catch (PDOException $e) {
            $retorno->msg = $e->getMessage();
            $retorno->status = 501;
        }
        return $retorno;
    }

    public function get($obj = null) {
        
    }

    public function getById($obj) {
        $retorno = new stdClass();
        try {
            $obj instanceof Persona;
            $sql = "SELECT * FROM {$this->table} WHERE pk_psn_id = ?";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->getPK_PSN_Id());
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
    public function personaByIdentificacion($obj) {
        $retorno = new stdClass();
        try {
            $obj instanceof Persona;
            $sql = "SELECT * FROM {$this->table} WHERE psn_identificacion = ?";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->getPSN_Identificacion());
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
            $obj instanceof Persona;
            $sql = "INSERT INTO {$this->table} VALUES (null,?,?,?,?,?,?,?)";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->getPSN_Id_Tipo_Identificacion());
            $query->bindParam(2, $obj->getPSN_Identificacion());
            $query->bindParam(3, $obj->getPSN_Nombre());
            $query->bindParam(4, $obj->getPSN_Apellido());
            $query->bindParam(5, $obj->getPSN_Fecha_Nacimiento());
            $query->bindParam(6, $obj->getPSN_Telefono());
            $query->bindParam(7, $obj->getPSN_Rol());
            $query->execute();
            $retorno->data = $this->conexion->lastInsertId();
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
            $obj instanceof Persona;

            $sql = "UPDATE {$this->table} SET "
                    . "psn_id_tipo_identificacion=?, "
                    . "psn_identificacion=?, "
                    . "psn_nombre=?, "
                    . "psn_apellido=?,"
                    . "psn_fecha_nacimiento=?,"
                    . "psn_telefono=? "
                    . "WHERE pk_psn_id=?";

            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->getPSN_Id_Tipo_Identificacion());
            $query->bindParam(2, $obj->getPSN_Identificacion());
            $query->bindParam(3, $obj->getPSN_Nombre());
            $query->bindParam(4, $obj->getPSN_Apellido());
            $query->bindParam(5, $obj->getPSN_Fecha_Nacimiento());
            $query->bindParam(6, $obj->getPSN_Telefono());
            $query->bindParam(7, $obj->getPK_PSN_Id());
            $query->execute();

            $retorno->data = $obj;
            $retorno->status = 200;
            $retorno->msg = "Persona Actualizada.";
        } catch (PDOException $e) {
            $retorno->msg = $e->getMessage();
            $retorno->status = 501;
        }
        return $retorno;
    }
    
    public function updateVendedor($obj) {
        $retorno = new stdClass();
        try {
            $obj instanceof Persona;

            $sql = "UPDATE {$this->table} SET "
                    . "psn_nombre=?, "
                    . "psn_apellido=?,"
                    . "psn_telefono=? "
                    . "WHERE pk_psn_id=?";

            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->getPSN_Nombre());
            $query->bindParam(2, $obj->getPSN_Apellido());
            $query->bindParam(3, $obj->getPSN_Telefono());
            $query->bindParam(4, $obj->getPK_PSN_Id());
            $query->execute();

            $retorno->data = $obj;
            $retorno->status = 200;
            $retorno->msg = "Vendedor Actualizado.";
        } catch (PDOException $e) {
            $retorno->msg = $e->getMessage();
            $retorno->status = 501;
        }
        return $retorno;
    }

    public function getVendedores() {
        $retorno = new stdClass();

        try {
            $sql = "SELECT * FROM {$this->table} WHERE psn_rol = 'vendedor'";
            $query = $this->conexion->prepare($sql);
            $query->execute();

            $retorno->data = $query->fetchAll(PDO::FETCH_CLASS, $this->nameEntity);
            $retorno->status = 200;
            $retorno->msg = "Consulta exitosa";
            if (count($retorno->data) === 0) {
                $retorno->status = 201;
                $retorno->msg = "No hay registros en la base de datos.";
            }
        } catch (PDOException $ex) {
            $retorno->msg = $ex->getMessage();
            $retorno->status = 501;
        }
        return $retorno;
        ;
    }
    
    public function getClientesCumpleanios() {
        $retorno = new stdClass();

        try {
            $sql = "SELECT * FROM {$this->table} WHERE psn_rol = 'cliente' and MONTH(psn_fecha_nacimiento) = MONTH(NOW())";
            $query = $this->conexion->prepare($sql);
            $query->execute();

            $retorno->data = $query->fetchAll(PDO::FETCH_CLASS, $this->nameEntity);
            $retorno->status = 200;
            $retorno->msg = "Consulta exitosa";
            if (count($retorno->data) === 0) {
                $retorno->status = 201;
                $retorno->msg = "No hay registros en la base de datos.";
            }
        } catch (PDOException $ex) {
            $retorno->msg = $ex->getMessage();
            $retorno->status = 501;
        }
        return $retorno;
        ;
    }

}
