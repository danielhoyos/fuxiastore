<?php

class Marca{
    private $mar_id;
    private $mar_nombre;
    private $prov_id;
    
    function getMar_id() {
        return $this->mar_id;
    }

    function getMar_nombre() {
        return $this->mar_nombre;
    }

    function getProv_id() {
        return $this->prov_id;
    }

    function setMar_id($mar_id) {
        $this->mar_id = $mar_id;
    }

    function setMar_nombre($mar_nombre) {
        $this->mar_nombre = $mar_nombre;
    }

    function setProv_id($prov_id) {
        $this->prov_id = $prov_id;
    }


}