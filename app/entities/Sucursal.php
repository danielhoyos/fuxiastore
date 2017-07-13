<?php

class Sucursal implements JsonSerializable{
    private $SUC_Id;
    private $SUC_Nit;
    private $SUC_Nombre;
    private $SUC_Direccion;
    private $SUC_Telefono;
    
    function getSUC_Id() {
        return $this->SUC_Id;
    }
    
    function getSUC_Nit() {
        return $this->SUC_Nit;
    }

    
    function getSUC_Nombre() {
        return $this->SUC_Nombre;
    }

    function getSUC_Direccion() {
        return $this->SUC_Direccion;
    }

    function getSUC_Telefono() {
        return $this->SUC_Telefono;
    }

    function setSUC_Id($SUC_Id) {
        $this->SUC_Id = $SUC_Id;
    }
    
    function setSUC_Nit($SUC_Nit) {
        $this->SUC_Nit = $SUC_Nit;
    }
    
    function setSUC_Nombre($SUC_Nombre) {
        $this->SUC_Nombre = $SUC_Nombre;
    }

    function setSUC_Direccion($SUC_Direccion) {
        $this->SUC_Direccion = $SUC_Direccion;
    }

    function setSUC_Telefono($SUC_Telefono) {
        $this->SUC_Telefono = $SUC_Telefono;
    }

    public function jsonSerialize() {
        $vars = get_object_vars($this);
        return $vars;
    }

}

