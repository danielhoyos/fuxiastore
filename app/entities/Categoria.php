<?php

class Categoria implements \JsonSerializable{
    private $CAT_Id;
    private $CAT_Nombre;

    function getCAT_Id() {
        return $this->CAT_Id;
    }

    function getCAT_Nombre() {
        return $this->CAT_Nombre;
    }

    function setCAT_Id($CAT_Id) {
        $this->CAT_Id = $CAT_Id;
    }

    function setCAT_Nombre($CAT_Nombre) {
        $this->CAT_Nombre = $CAT_Nombre;
    }

    public function jsonSerialize() {
        $vars = get_object_vars($this);
        return $vars;
    }
}

