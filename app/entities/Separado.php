<?php

class Separado implements \JsonSerializable{

    private $SEP_Id;
    private $FK_PRO_Id;
    private $SEP_Valor;
    private $SEP_Estado;
    private $SEP_Fecha;
    private $FK_VEN_Id;
    private $FK_CLI_Id;
    public static $ESTADO_SEPARADO = "separado";
    public static $ESTADO_ABONADDO = "abonado";
    public static $ESTADO_RETIRADO = "retirado";
    
    function getSEP_Fecha() {
        return $this->SEP_Fecha;
    }

    function setSEP_Fecha($SEP_Fecha) {
        $this->SEP_Fecha = $SEP_Fecha;
    }

    function getSEP_Valor() {
        return $this->SEP_Valor;
    }

    static function getESTADO_SEPARADO() {
        return self::$ESTADO_SEPARADO;
    }

    static function getESTADO_ABONADDO() {
        return self::$ESTADO_ABONADDO;
    }

    static function getESTADO_RETIRADO() {
        return self::$ESTADO_RETIRADO;
    }

    function setSEP_Valor($SEP_Valor) {
        $this->SEP_Valor = $SEP_Valor;
    }

    function getSEP_Id() {
        return $this->SEP_Id;
    }

    function getFK_PRO_Id() {
        return $this->FK_PRO_Id;
    }

    function getSEP_Estado() {
        return $this->SEP_Estado;
    }

    function setSEP_Id($SEP_Id) {
        $this->SEP_Id = $SEP_Id;
    }

    function setFK_PRO_Id($FK_PRO_Id) {
        $this->FK_PRO_Id = $FK_PRO_Id;
    }

    function setSEP_Estado($SEP_Estado) {
        $this->SEP_Estado = $SEP_Estado;
    }
    
    function getFK_VEN_Id() {
        return $this->FK_VEN_Id;
    }

    function getFK_CLI_Id() {
        return $this->FK_CLI_Id;
    }

    function setFK_VEN_Id($FK_VEN_Id) {
        $this->FK_VEN_Id = $FK_VEN_Id;
    }

    function setFK_CLI_Id($FK_CLI_Id) {
        $this->FK_CLI_Id = $FK_CLI_Id;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

}
