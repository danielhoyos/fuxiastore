<?php

class UsuarioModel implements IModel {

    private $conexion;
    private $table = "tbl_usuario";
    private $nameEntity = "Usuario";

    public function __construct() {
        $this->conexion = SPDO::singleton();
    }

    public function delete($obj) {
        
    }

    public function get($obj = null) {
        
    }

    public function getById($obj) {
        
    }

    public function insert($obj) {
        
    }

    public function update($obj) {
        $retorno = new stdClass();
        try {
            $personaModel = new PersonaModel();
            $r = $personaModel->update($obj);
            if ($r->status == 200) {
                $obj instanceof Usuario;

                $sql = "UPDATE {$this->table} SET "
                        . "usr_usuario=?, usr_fecha_modificacion=? "
                        . "WHERE usr_id=?";

                $query = $this->conexion->prepare($sql);

                $query->bindParam(1, $obj->getUSR_Usuario());
                $query->bindParam(2, $obj->getUSR_Fecha_Modificacion());
                $query->bindParam(3, $obj->getUSR_Id());
                $query->execute();
                $retorno->data = $obj;
                $retorno->status = 200;
                $retorno->msg = "Usuario actualizado.";
            } else {
                $retorno = $r;
            }
        } catch (PDOException $e) {
            $retorno->msg = $e->getMessage();
            $retorno->status = 501;
        }
        return $retorno;
    }
    
    public function updateFoto(Usuario $usuario) {
        $retorno = new stdClass();
        try {

            $sql = "UPDATE {$this->table} SET usr_avatar=? WHERE usr_id=?";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $usuario->getUSR_Avatar());
            $query->bindParam(2, $usuario->getUSR_Id());
            $query->execute();
            $retorno->data = $query->fetchObject($this->nameEntity);
            $retorno->status = 200;
            $retorno->msg = "Foto de Perfil Actualizada Correctamente";
        } catch (PDOException $e) {
            $retorno->msg = $e->getMessage();
            $retorno->status = 501;
        }
        return $retorno;
    }
    public function updatePortada(Usuario $usuario) {
        $retorno = new stdClass();
        try {

            $sql = "UPDATE {$this->table} SET usr_portada=? WHERE usr_id=?";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $usuario->getUSR_Portada());
            $query->bindParam(2, $usuario->getUSR_Id());
            $query->execute();
            $retorno->data = $query->fetchObject($this->nameEntity);
            $retorno->status = 200;
            $retorno->msg = "Foto de Portada Actualizada Correctamente";
        } catch (PDOException $e) {
            $retorno->msg = $e->getMessage();
            $retorno->status = 501;
        }
        return $retorno;
    }

    public function consultarPassword(Usuario $usuario) {
        $retorno = new stdClass();
        try {
            $sql = "SELECT * FROM {$this->table} WHERE usr_id = ? and usr_password = ?";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $usuario->getUSR_Id());
            $query->bindParam(2, $usuario->getUSR_Password());
            $query->execute();

            $retorno->data = $query->fetchObject($this->nameEntity);

            if (!$retorno->data instanceof $this->nameEntity) {
                $retorno->status = 201;
                $retorno->msg = "{$this->nameEntity} no encontrado";
            } else {
                $retorno->msg = "{$this->nameEntity} encontrado";
                $retorno->status = 200;
            }
        } catch (PDOException $e) {
            $retorno->msg = $e->getMessage();
            $retorno->status = 501;
        }
        return $retorno;
    }
    
    public function updatePassword(Usuario $usuario) {
        $retorno = new stdClass();
        try {

            $sql = "UPDATE {$this->table} SET usr_password=? WHERE {$this->table}.usr_id=?";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $usuario->getUSR_Password());
            $query->bindParam(2, $usuario->getUSR_Id());
            $query->execute();
            $retorno->data = $query->fetchObject($this->nameEntity);
            $retorno->msg = "Password Editado Correctamente";
            $retorno->status = 200;
        } catch (PDOException $e) {
            $retorno->msg = $e->getMessage();
            $retorno->status = 501;
        }
        return $retorno;
    }
    
    public function validarAdministrador(Usuario $usuario) {
        $retorno = new stdClass();
        try {
            $sql = "SELECT * FROM {$this->table} INNER JOIN tbl_persona "
                    . "on {$this->table}.usr_id_persona = tbl_persona.pk_psn_id WHERE usr_usuario=? and usr_password=?";

            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $usuario->getUSR_Usuario());
            $query->bindParam(2, $usuario->getUSR_Password());
            $query->execute();
            
            $retorno->data = $query->fetchObject($this->nameEntity);
            $retorno->status = 200;
            
            if (!$retorno->data instanceof $this->nameEntity) {
                $retorno->status = 201;
                $retorno->msg = "{$this->nameEntity} no encontrado";
            } else {
                $retorno->msg = "!!!Bienvenido...¡¡¡";
            }
        } catch (PDOException $e) {
            $retorno->status = 501;
            $retorno->msg = $e->getMessage();
        }
        return $retorno;
    }

}
