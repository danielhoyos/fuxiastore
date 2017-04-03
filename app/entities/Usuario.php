<?php

class Usuario extends Persona implements JsonSerializable {

    private $USR_Id;
    private $USR_Usuario;
    private $USR_Password;
    private $USR_Fecha_Modificacion;
    private $USR_Avatar;
    private $USR_Portada;

    function getUSR_Id() {
        return $this->USR_Id;
    }

    function getUSR_Usuario() {
        return $this->USR_Usuario;
    }

    function getUSR_Password() {
        return $this->USR_Password;
    }

    function getUSR_Fecha_Modificacion() {
        return $this->USR_Fecha_Modificacion;
    }

    function getUSR_Avatar() {
        return $this->USR_Avatar;
    }

    function getUSR_Portada() {
        return $this->USR_Portada;
    }

    function setUSR_Id($USR_Id) {
        $this->USR_Id = $USR_Id;
    }

    function setUSR_Usuario($USR_Usuario) {
        $this->USR_Usuario = $USR_Usuario;
    }

    function setUSR_Password($USR_Password, $codificar = false) {
        if($codificar){
           $USR_Password = md5($USR_Password); 
        }
        $this->USR_Password = $USR_Password;
    }

    function setUSR_Fecha_Registro($USR_Fecha_Modificacion) {
        $this->USR_Fecha_Modificacion = $USR_Fecha_Modificacion;
    }

    function setUSR_Avatar($USR_Avatar) {
        $this->USR_Avatar = $USR_Avatar;
    }

    function setUSR_Portada($USR_Portada) {
        $this->USR_Portada = $USR_Portada;
    }

    
    public function jsonSerialize() {
        $vars = get_object_vars($this);
        return $vars;
    }

}
