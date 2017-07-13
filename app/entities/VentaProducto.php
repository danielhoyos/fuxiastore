<?php

class VentaProducto implements JsonSerializable {
    private $VEP_Id;
    private $PRO_Id;
    private $VEN_Id;
    
    function getVEP_Id() {
        return $this->VEP_Id;
    }

    function getPRO_Id() {
        return $this->PRO_Id;
    }

    function getVEN_Id() {
        return $this->VEN_Id;
    }

    function setVEP_Id($VEP_Id) {
        $this->VEP_Id = $VEP_Id;
    }

    function setPRO_Id($PRO_Id) {
        $this->PRO_Id = $PRO_Id;
    }

    function setVEN_Id($VEN_Id) {
        $this->VEN_Id = $VEN_Id;
    }

    public function jsonSerialize() {
        $vars = get_object_vars($this);
        return $vars;
    }

}