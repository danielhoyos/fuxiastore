<?php

class Persona implements JsonSerializable {

    private $PK_PSN_Id;
    private $PSN_Id_Tipo_Identificacion;
    private $PSN_Identificacion;
    private $PSN_Nombre;
    private $PSN_Apellido;
    private $PSN_Fecha_Nacimiento;
    private $PSN_Telefono;
    private $PSN_Rol;
    
    public static $ROL_ADMINISTRADOR = "administrador";
    public static $ROL_VENDEDOR = "vendedor";
    public static $ROL_CLIENTE = "cliente";
    
    function getPSN_Rol() {
        return $this->PSN_Rol;
    }

    function setPSN_Rol($PSN_Rol) {
        $this->PSN_Rol = $PSN_Rol;
    }
    
    function getPK_PSN_Id() {
        return $this->PK_PSN_Id;
    }

    function getPSN_Id_Tipo_Identificacion() {
        return $this->PSN_Id_Tipo_Identificacion;
    }

    function getPSN_Identificacion() {
        return $this->PSN_Identificacion;
    }

    function getPSN_Nombre() {
        return $this->PSN_Nombre;
    }

    function getPSN_Apellido() {
        return $this->PSN_Apellido;
    }

    function getPSN_Fecha_Nacimiento() {
        return $this->PSN_Fecha_Nacimiento;
    }

    function getPSN_Telefono() {
        return $this->PSN_Telefono;
    }

    function setPK_PSN_Id($PK_PSN_Id) {
        $this->PK_PSN_Id = $PK_PSN_Id;
    }

    function setPSN_Id_Tipo_Identificacion($PSN_Id_Tipo_Identificacion) {
        $this->PSN_Id_Tipo_Identificacion = $PSN_Id_Tipo_Identificacion;
    }

    function setPSN_Identificacion($PSN_Identificacion) {
        $this->PSN_Identificacion = $PSN_Identificacion;
    }

    function setPSN_Nombre($PSN_Nombre) {
        $this->PSN_Nombre = $PSN_Nombre;
    }

    function setPSN_Apellido($PSN_Apellido) {
        $this->PSN_Apellido = $PSN_Apellido;
    }

    function setPSN_Fecha_Nacimiento($PSN_Fecha_Nacimiento) {
        $this->PSN_Fecha_Nacimiento = $PSN_Fecha_Nacimiento;
    }

    function setPSN_Telefono($PSN_Telefono) {
        $this->PSN_Telefono = $PSN_Telefono;
    }

    public function jsonSerialize() {
        $vars = get_object_vars($this);
        return $vars;
    }

}
