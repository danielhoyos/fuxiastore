<?php

class ProductoModel implements IModel {

    private $conexion;
    private $table = "TBL_Producto";
    private $nameEntity = "Producto";

    function __construct() {
        $this->conexion = SPDO::singleton();
    }

    public function delete($obj) {
        $retorno = new stdClass();
        try {
            $obj instanceof Producto;
            $sql = "DELETE FROM {$this->table} WHERE PRO_Id = ?";
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
            $sql = "SELECT * FROM {$this->table} ORDER BY PRO_Id DESC";
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
            $sql = "SELECT * FROM {$this->table} WHERE PRO_Id = ?";
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
            
            $sql = "SELECT * FROM {$this->table} WHERE PRO_Nombre LIKE '%{$buscar}%' OR PRO_Id LIKE '%{$buscar}%'";
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
            $sql = "SELECT * FROM {$this->table} where PRO_Estado = ? ORDER BY PRO_Id DESC";
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
                    . "SET PRO_Nombre=?, PRO_Talla=?, PRO_Precio_Compra=?, "
                    . "PRO_Precio_Venta=?, FK_CAT_Id=?, FK_SUC_Id=?, "
                    . "PRO_Estado=?, PRO_Fecha_Ingreso=?, FK_MAR_Id=? "
                    . "WHERE PRO_Id = ?";
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

            $sql = "UPDATE {$this->table} SET PRO_Estado = ? WHERE PRO_Id = ?";
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
            $sql = "SELECT * FROM {$this->table} ORDER BY PRO_Id DESC LIMIT {$i},{$f}";
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
