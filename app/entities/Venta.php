<?php

class Venta implements JsonSerializable{
    private $VEN_Id;
    private $VEN_CLI_Id;
    private $VEN_VEND_Id;
    private $VEN_Fecha_Venta;
    private $VEN_Total;
    
    function getVEN_Id() {
        return $this->VEN_Id;
    }

    function getVEN_CLI_Id() {
        return $this->VEN_CLI_Id;
    }

    function getVEN_VEND_Id() {
        return $this->VEN_VEND_Id;
    }

    function getVEN_Fecha_Venta() {
        return $this->VEN_Fecha_Venta;
    }

    function getVEN_Total() {
        return $this->VEN_Total;
    }

    function setVEN_Id($VEN_Id) {
        $this->VEN_Id = $VEN_Id;
    }

    function setVEN_CLI_Id($VEN_CLI_Id) {
        $this->VEN_CLI_Id = $VEN_CLI_Id;
    }

    function setVEN_VEND_Id($VEN_VEND_Id) {
        $this->VEN_VEND_Id = $VEN_VEND_Id;
    }

    function setVEN_Fecha_Venta($VEN_Fecha_Venta) {
        $this->VEN_Fecha_Venta = $VEN_Fecha_Venta;
    }

    function setVEN_Total($VEN_Total) {
        $this->VEN_Total = $VEN_Total;
    }

    
    public function jsonSerialize() {
        $vars = get_object_vars($this);
        return $vars;
    }

}
