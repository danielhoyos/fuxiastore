<?php

     class VentaModel implements IModel {

         private $conexion;
         private $table = "tbl_venta";
         private $nameEntity = "Venta";

         function __construct() {
             $this->conexion = SPDO::singleton();
         }

         public function delete($obj) {
             
         }

         public function get($obj = null) {
             $retorno = new stdClass();

             try {
                 $obj instanceof Venta;
                 $sql = "SELECT * FROM {$this->table} INNER JOIN tbl_persona "
                  . "ON {$this->table}.ven_cli_id = tbl_persona.pk_psn_Id ORDER BY {$this->table}.ven_id DESC";
                 $query = $this->conexion->prepare($sql);
                 $query->execute();
                 $retorno->data = $query->fetchAll(PDO::FETCH_CLASS, $this->nameEntity);
                 $retorno->status = 200;
                 $retorno->msg = "Venta Encontrada Exitosamente";
             } catch (Exception $e) {
                 $retorno->status = 501;
                 $retorno->msg = $e->getMessage();
             }
             return $retorno;
         }

         public function getFac($pag) {
             $retorno = new stdClass();

             try {
                 $i = $pag == 1 ? 0 : ($pag - 1) * 50;
                 $sql = "SELECT * FROM {$this->table} INNER JOIN tbl_persona "
                  . "ON {$this->table}.ven_cli_id = tbl_persona.pk_psn_Id ORDER BY {$this->table}.ven_id DESC LIMIT {$i},50";
                 $query = $this->conexion->prepare($sql);
                 $query->execute();
                 $retorno->data = $query->fetchAll(PDO::FETCH_CLASS, $this->nameEntity);
                 $retorno->status = 200;
                 $retorno->msg = "Venta Encontrada Exitosamente";
             } catch (Exception $e) {
                 $retorno->status = 501;
                 $retorno->msg = $e->getMessage();
             }
             return $retorno;
         }

         public function getById($obj) {
             $retorno = new stdClass();

             try {
                 $obj instanceof Venta;
                 $sql = "SELECT * FROM {$this->table} INNER JOIN tbl_persona "
                  . "ON {$this->table}.ven_cli_id = tbl_persona.pk_psn_Id WHERE {$this->table}.ven_id = ?";
                 $query = $this->conexion->prepare($sql);
                 $query->bindParam(1, $obj->getVEN_Id());
                 $query->execute();

                 $retorno->data = $query->fetchObject($this->nameEntity);
                 $retorno->status = 200;
                 $retorno->msg = "{$this->nameEntity} encontrada exitosamente";
                 if (!$retorno->data instanceof $this->nameEntity) {
                     $retorno->status = 201;
                     $retorno->msg = "{$this->nameEntity} no encontrada";
                 }
             } catch (Exception $e) {
                 $retorno->status = 501;
                 $retorno->msg = $e->getMessage();
             }

             return $retorno;
         }

         public function insert($obj) {
             $retorno = new stdClass();

             try {
                 $obj instanceof Venta;
                 $sql = "INSERT INTO {$this->table} VALUES(null,?,?,?,?)";
                 $query = $this->conexion->prepare($sql);
                 $query->bindParam(1, $obj->getVEN_CLI_Id());
                 $query->bindParam(2, $obj->getVEN_VEND_Id());
                 $query->bindParam(3, $obj->getVEN_Fecha_Venta());
                 $query->bindParam(4, $obj->getVEN_Total());
                 $query->execute();
                 $id = $this->conexion->lastInsertId();
                 $retorno->data = $id;
                 $retorno->status = 200;
                 $retorno->msg = "Venta Registrada Exitosamente";
             } catch (Exception $e) {
                 $retorno->status = 501;
                 $retorno->msg = $e->getMessage();
             }
             return $retorno;
         }

         public function update($obj) {
             
         }

         public function facturasFecha($obj) {
             $retorno = new stdClass();

             try {
                 $sql = "SELECT * FROM {$this->table} INNER JOIN tbl_persona "
                  . "ON {$this->table}.ven_cli_id = tbl_persona.pk_psn_id WHERE {$this->table}.ven_fecha_venta BETWEEN ? AND ? ORDER BY {$this->table}.ven_id DESC";
                 $query = $this->conexion->prepare($sql);
                 $query->bindParam(1, $obj->fechaInicio);
                 $query->bindParam(2, $obj->fechaFin);
                 $query->execute();
                 $retorno->data = $query->fetchAll(PDO::FETCH_CLASS, $this->nameEntity);
                 $retorno->status = 200;
                 $retorno->msg = "{$this->nameEntity} encontrada exitosamente";
             } catch (Exception $e) {
                 $retorno->status = 501;
                 $retorno->msg = $e->getMessage();
             }
             return $retorno;
         }

         public function facturasIdentificacion($obj) {
             $retorno = new stdClass();

             try {
                 $sql = "SELECT * FROM {$this->table} INNER JOIN tbl_persona "
                  . "ON {$this->table}.ven_cli_id = tbl_persona.pk_psn_id WHERE tbl_persona.psn_identificacion = ? ORDER BY {$this->table}.ven_id DESC";
                 $query = $this->conexion->prepare($sql);
                 $query->bindParam(1, $obj->identificacion);
                 $query->execute();
                 $retorno->data = $query->fetchAll(PDO::FETCH_CLASS, $this->nameEntity);
                 $retorno->status = 200;
                 $retorno->msg = "{$this->nameEntity} encontrada exitosamente";
             } catch (Exception $e) {
                 $retorno->status = 501;
                 $retorno->msg = $e->getMessage();
             }
             return $retorno;
         }

         public function getCantFac() {
             $retorno = new stdClass();
             try {
                 $sql = "SELECT COUNT(*) FROM {$this->table}";
                 $query = $this->conexion->prepare($sql);
                 $query->execute();
                 $retorno->data = $query->fetchColumn();
                 $retorno->status = 200;
                 $retorno->msg = "{$this->nameEntity} encontrada";
             } catch (PDOException $e) {
                 $retorno->msg = $e->getMessage();
                 $retorno->status = 501;
             }
             return $retorno;
         }

     }