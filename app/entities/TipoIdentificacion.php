<?php

class TipoIdentificacion{
    
    private $TI_id;
    private $TI_nombre;
    
    function getTI_id() {
        return $this->TI_id;
    }

    function getTI_nombre() {
        return $this->TI_nombre;
    }

    function setTI_id($TI_id) {
        $this->TI_id = $TI_id;
    }

    function setTI_nombre($TI_nombre) {
        $this->TI_nombre = $TI_nombre;
    }
}
