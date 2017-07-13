<?php

class Proveedor{
    private $prov_id;
    private $prov_nombre;
    
    public function getProv_id() {
        return $this->prov_id;
    }

    public function getProv_nombre() {
        return $this->prov_nombre;
    }

    public function setProv_id($prov_id) {
        $this->prov_id = $prov_id;
    }

    public function setProv_nombre($prov_nombre) {
        $this->prov_nombre = $prov_nombre;
    }

}

