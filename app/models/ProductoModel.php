<?php

class ProductoModel implements IModel {

    private $conexion;
    private $table = "tbl_producto";
    private $nameEntity = "Producto";

    function __construct() {
        $this->conexion = SPDO::singleton();
    }

    public function delete($obj) {
        $retorno = new stdClass();
        try {
            $obj instanceof Producto;
            $sql = "DELETE FROM {$this->table} WHERE pro_id = ?";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->getPRO_Id());
            $query->execute();
            $retorno->status = 200;
            $retorno->msg = "Producto eliminado";
        } catch (PDOException $e) {
            $retorno->msg = $e->getMessage();
            $retorno->status = 501;
        }
        return $retorno;
    }

    public function get($obj = null) {
        $retorno = new stdClass();
        try {
            $sql = "SELECT * FROM {$this->table} ORDER BY pro_id DESC";
            $query = $this->conexion->prepare($sql);
            $query->execute();
            $retorno->data = $query->fetchAll(PDO::FETCH_CLASS, $this->nameEntity);
            $retorno->status = 200;
            $retorno->msg = "Consulta exitosa";
            if (count($retorno->data) === 0) {
                $retorno->status = 201;
                $retorno->msg = "No hay registros en la base de datos.";
            }
        } catch (PDOException $e) {
            $retorno->msg = $e->getMessage();
            $retorno->status = 501;
        }
        return $retorno;
    }

    public function getById($obj) {
        $retorno = new stdClass();
        try {
            $obj instanceof Producto;
            $sql = "SELECT * FROM {$this->table} WHERE pro_id = ?";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->getPRO_Id());
            $query->execute();
            $retorno->data = $query->fetchObject($this->nameEntity);
            $retorno->status = 200;
            $retorno->msg = "{$this->nameEntity} encontrada";
            if (!$retorno->data instanceof $this->nameEntity) {
                $retorno->status = 201;
                $retorno->msg = "{$this->nameEntity} no encontrado";
            }
        } catch (PDOException $e) {
            $retorno->msg = $e->getMessage();
            $retorno->status = 501;
        }
        return $retorno;
    }

    public function getBuscar($obj) {
        $retorno = new stdClass();
        try {
            $buscar = trim($obj->productoBuscar);
            
            $sql = "SELECT * FROM {$this->table} WHERE pro_nombre LIKE '%{$buscar}%' OR pro_id LIKE '%{$buscar}%'";
            $query = $this->conexion->prepare($sql);
            $query->execute();
            $retorno->data = $query->fetchAll(PDO::FETCH_CLASS, $this->nameEntity);
            $retorno->status = 200;
            $retorno->msg = "{$this->nameEntity} encontrada";
        } catch (PDOException $e) {
            $retorno->msg = $e->getMessage();
            $retorno->status = 501;
        }
        return $retorno;
    }

    public function getByEstado($obj) {
        $retorno = new stdClass();
        try {
            $obj instanceof Producto;
            $sql = "SELECT * FROM {$this->table} where pro_estado = ? ORDER BY pro_id DESC";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->getPRO_Estado());
            $query->execute();
            $retorno->data = $query->fetchAll(PDO::FETCH_CLASS, $this->nameEntity);
            $retorno->status = 200;
            $retorno->msg = "Consulta exitosa";
            if (count($retorno->data) === 0) {
                $retorno->status = 201;
                $retorno->msg = "No hay registros en la base de datos.";
            }
        } catch (PDOException $e) {
            $retorno->msg = $e->getMessage();
            $retorno->status = 501;
        }
        return $retorno;
    }

    public function insert($obj) {
        $retorno = new stdClass();

        try {
            $obj instanceof Producto;
            $sql = "INSERT INTO {$this->table} VALUES (null,?,?,?,?,?,?,?,?,?)";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->getPRO_Nombre());
            $query->bindParam(2, $obj->getPRO_Talla());
            $query->bindParam(3, $obj->getPRO_Precio_Compra());
            $query->bindParam(4, $obj->getPRO_Precio_Venta());
            $query->bindParam(5, $obj->getFK_CAT_Id());
            $query->bindParam(6, $obj->getFK_SUC_Id());
            $query->bindParam(7, $obj->getPRO_Estado());
            $query->bindParam(8, $obj->getPRO_Fecha_Ingreso());
            $query->bindParam(9, $obj->getFK_MAR_Id());
            $query->execute();
            $id = $this->conexion->lastInsertId();
            $obj->setPRO_Id($id);
            $retorno->data = $obj;
            $retorno->status = 200;
            $retorno->msg = "Registro insertado.";
        } catch (PDOException $e) {
            $retorno->msg = $e->getMessage();
            $retorno->status = 501;
        }

        return $retorno;
    }

    public function update($obj) {
        $retorno = new stdClass();
        try {
            $obj instanceof Producto;
            $sql = "UPDATE {$this->table} "
                    . "SET pro_nombre=?, pro_talla=?, pro_precio_compra=?, "
                    . "pro_precio_venta=?, fk_cat_id=?, fk_suc_id=?, "
                    . "pro_estado=?, pro_fecha_ingreso=?, fk_mar_id=? "
                    . "WHERE pro_id = ?";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->getPRO_Nombre());
            $query->bindParam(2, $obj->getPRO_Talla());
            $query->bindParam(3, $obj->getPRO_Precio_Compra());
            $query->bindParam(4, $obj->getPRO_Precio_Venta());
            $query->bindParam(5, $obj->getFK_CAT_Id());
            $query->bindParam(6, $obj->getFK_SUC_Id());
            $query->bindParam(7, $obj->getPRO_Estado());
            $query->bindParam(8, $obj->getPRO_Fecha_Ingreso());
            $query->bindParam(9, $obj->getFK_MAR_Id());
            $query->bindParam(10, $obj->getPRO_Id());
            $query->execute();
            $retorno->data = $obj;
            $retorno->status = 200;
            $retorno->msg = "Producto Actualizado Exitosamente.";
        } catch (PDOException $e) {
            $retorno->msg = $e->getMessage();
            $retorno->status = 501;
        }
        return $retorno;
    }

    public function updateEstado($obj) {
        $retorno = new stdClass();

        try {
            $obj instanceof Producto;

            $sql = "UPDATE {$this->table} SET pro_estado = ? WHERE pro_id = ?";
            $query = $this->conexion->prepare($sql);
            $query->bindParam(1, $obj->getPRO_Estado());
            $query->bindParam(2, $obj->getPRO_Id());
            $query->execute();
            $id = $this->conexion->lastInsertId();
            $retorno->data = $id;
            $retorno->status = 200;
            $retorno->msg = "Estado Actualizado Correctamente";
        } catch (Exception $e) {
            $retorno->status = 501;
            $retorno->msg = $e->getMessage();
        }

        return $retorno;
    }
    
    public function getProd($pag){
        $retorno = new stdClass();
        try {
            if($pag == 1){
                $i = 0;
                $f = 20 * $pag;
            }else{
                $f = 20 * $pag;
                $i = $f - 20;
            }
            $sql = "SELECT * FROM {$this->table} ORDER BY pro_id DESC LIMIT {$i},{$f}";
            $query = $this->conexion->prepare($sql);
            $query->execute();
            $retorno->data = $query->fetchAll(PDO::FETCH_CLASS, $this->nameEntity);
            $retorno->status = 200;
            $retorno->msg = "Consulta exitosa";
            if (count($retorno->data) === 0) {
                $retorno->status = 201;
                $retorno->msg = "No hay registros en la base de datos.";
            }
        } catch (PDOException $e) {
            $retorno->msg = $e->getMessage();
            $retorno->status = 501;
        }
        return $retorno;
    }
    public function getCantProd() {
        $retorno = new stdClass();
        try {
            $sql = "SELECT * FROM {$this->table}";
            $query = $this->conexion->prepare($sql);
            $query->execute();
            $retorno->data = $query->rowCount();
            $retorno->status = 200;
            $retorno->msg = "{$this->nameEntity} encontrada";
        } catch (PDOException $e) {
            $retorno->msg = $e->getMessage();
            $retorno->status = 501;
        }
        return $retorno;
    }
}
