<?php

class Producto implements \JsonSerializable {

    private $PRO_Id;
    private $PRO_Nombre;
    private $PRO_Talla;
    private $PRO_Precio_Compra;
    private $PRO_Precio_Venta;
    private $FK_CAT_Id;
    private $FK_SUC_Id;
    private $PRO_Estado;
    private $FK_MAR_Id;
    private $PRO_Fecha_Ingreso;
    
    function getFK_MAR_Id() {
        return $this->FK_MAR_Id;
    }

    function setFK_MAR_Id($FK_MAR_Id) {
        $this->FK_MAR_Id = $FK_MAR_Id;
    }
    
    function getPRO_Fecha_Ingreso() {
        return $this->PRO_Fecha_Ingreso;
    }

    function setPRO_Fecha_Ingreso($PRO_Fecha_Ingreso) {
        $this->PRO_Fecha_Ingreso = $PRO_Fecha_Ingreso;
    }

    function getPRO_Talla() {
        return $this->PRO_Talla;
    }

    function setPRO_Talla($PRO_Talla) {
        $this->PRO_Talla = $PRO_Talla;
    }

    function getPRO_Id() {
        return $this->PRO_Id;
    }

    function getPRO_Nombre() {
        return $this->PRO_Nombre;
    }

    function getPRO_Precio_Compra() {
        return $this->PRO_Precio_Compra;
    }

    function getPRO_Precio_Venta() {
        return $this->PRO_Precio_Venta;
    }

    function getFK_CAT_Id() {
        return $this->FK_CAT_Id;
    }

    function getFK_SUC_Id() {
        return $this->FK_SUC_Id;
    }

    function setPRO_Id($PRO_Id) {
        $this->PRO_Id = $PRO_Id;
    }

    function setPRO_Nombre($PRO_Nombre) {
        $this->PRO_Nombre = $PRO_Nombre;
    }

    function setPRO_Precio_Compra($PRO_Precio_Compra) {
        $this->PRO_Precio_Compra = $PRO_Precio_Compra;
    }

    function setPRO_Precio_Venta($PRO_Precio_Venta) {
        $this->PRO_Precio_Venta = $PRO_Precio_Venta;
    }

    function setFK_CAT_Id($FK_CAT_Id) {
        $this->FK_CAT_Id = $FK_CAT_Id;
    }

    function setFK_SUC_Id($FK_SUC_Id) {
        $this->FK_SUC_Id = $FK_SUC_Id;
    }

    function getPRO_Estado() {
        return $this->PRO_Estado;
    }

    function setPRO_Estado($PRO_Estado) {
        $this->PRO_Estado = $PRO_Estado;
    }

    public function jsonSerialize() {
        $vars = get_object_vars($this);
        return $vars;
    }

}
