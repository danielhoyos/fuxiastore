<?php

class ProductoController implements IController {

    private $view;

    public function __construct() {
        $this->view = new View();
    }

    public function index() {
        
    }

    public function productos() {
        $config = Config::singleton();

        if (AppController::$login) {
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Producto.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "ProductoModel.php";
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Categoria.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "CategoriaModel.php";
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Sucursal.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "SucursalModel.php";
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Marca.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "MarcaModel.php";

            $categoriaModel = new CategoriaModel();
            $categorias = $categoriaModel->get();

            $sucursalModel = new SucursalModel();
            $sucursales = $sucursalModel->get();

            $producto = new Producto();
            $productoModel = new ProductoModel();

            $marcaModel = new MarcaModel();
            $marcas = $marcaModel->get();
            $todos = false;

            if (!isset($_REQUEST["estado"]) || $_REQUEST["estado"] === "todos") {
                $todos = true;
            } else {
                if ($_REQUEST["estado"] === "disponibles") {
                    $producto->setPRO_Estado("disponible");
                } else if ($_REQUEST["estado"] === "nodisponibles") {
                    $producto->setPRO_Estado("no disponible");
                } else if ($_REQUEST["estado"] === "vendidos") {
                    $producto->setPRO_Estado("vendido");
                }
            }
            $pag = !isset($_REQUEST["pag"])?1:$_REQUEST["pag"];
            $productos = $todos?$productos = $productoModel->getProd($pag):$productoModel->getByEstado($producto, $pag);
            $cantProd = isset($_REQUEST["estado"])?$productoModel->getCantProd($producto->getPRO_Estado()):$productoModel->getCantProd();
            
            $vars["categorias"] = $categorias->data;
            $vars["sucursales"] = $sucursales->data;
            $vars["productos"] = $productos->data;
            $vars["marcas"] = $marcas->data;
            $vars["cantProd"] = $cantProd->data;
            $this->view->show("private/Productos.php", $vars);
        } else {
            $this->view->show("public/home.php");
        }
    }

    public function registrar() {
        $config = Config::singleton();

        if (AppController::$login) {
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Producto.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "ProductoModel.php";

            $producto = new Producto();
            $producto->setPRO_Nombre($_POST["PRO_Nombre"]);
            $producto->setPRO_Talla($_POST["PRO_Talla"]);
            $producto->setPRO_Precio_Compra($_POST["PRO_Precio_Compra"]);
            $producto->setPRO_Precio_Venta($_POST["PRO_Precio_Venta"]);
            $producto->setFK_CAT_Id($_POST["FK_CAT_Id"]);
            $producto->setFK_SUC_Id($_POST["FK_SUC_Id"]);
            $producto->setPRO_Estado("disponible");
            $producto->setPRO_Fecha_Ingreso(date("Y-m-d H:i:s"));
            $producto->setFK_MAR_Id($_POST["FK_MAR_Id"]);

            $productoModel = new ProductoModel();
            $r = $productoModel->insert($producto);

            header("location: ?controller=Producto&action=productos&msg={$r->msg}");
        }
    }

    public function productoPorId() {
        $config = Config::singleton();

        if (AppController::$login) {
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Producto.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "ProductoModel.php";

            $producto = new Producto();
            $producto->setPRO_Id($_REQUEST["PRO_Id"]);

            $productoModel = new ProductoModel();
            $r = $productoModel->getById($producto);

            if ($r->status == 200 || $r->status === 201) {
                echo json_encode($r);
            }
        }
    }

    public function editar() {
        $config = Config::singleton();

        if (AppController::$login) {
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Producto.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "ProductoModel.php";

            $producto = new Producto();
            $producto->setPRO_Id($_POST["PRO_Id_Editar"]);
            $producto->setPRO_Nombre($_POST["PRO_Nombre_Editar"]);
            $producto->setPRO_Talla($_POST["PRO_Talla_Editar"]);
            $producto->setPRO_Precio_Compra($_POST["PRO_Precio_Compra_Editar"]);
            $producto->setPRO_Precio_Venta($_POST["PRO_Precio_Venta_Editar"]);
            $producto->setFK_CAT_Id($_POST["FK_CAT_Id_Editar"]);
            $producto->setFK_SUC_Id($_POST["FK_SUC_Id_Editar"]);
            $producto->setPRO_Estado($_POST["PRO_Estado_Editar"]);
            $producto->setPRO_Fecha_Ingreso($_POST["PRO_Fecha_Ingreso"]);
            $producto->setFK_MAR_Id($_POST["FK_MAR_Id_Editar"]);

            $productoModel = new ProductoModel();
            $r = $productoModel->update($producto);

            header("location: ?controller=Producto&action=productos&msg={$r->msg}");
        }
    }

    public function eliminar() {
        if (AppController::$login) {
            $config = Config::singleton();
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Producto.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "ProductoModel.php";

            $producto = new Producto();
            $producto->setPRO_Id($_POST["PRO_Id"]);

            $productoModel = new ProductoModel();
            $r = $productoModel->delete($producto);

            echo json_encode($r);
        }
    }

    public function productoBuscar() {
        $config = Config::singleton();

        if (AppController::$login) {
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Producto.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "ProductoModel.php";
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Categoria.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "CategoriaModel.php";
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Sucursal.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "SucursalModel.php";
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Marca.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "MarcaModel.php";

            $categoriaModel = new CategoriaModel();
            $categorias = $categoriaModel->get();

            $sucursalModel = new SucursalModel();
            $sucursales = $sucursalModel->get();

            $marcaModel = new MarcaModel();
            $marcas = $marcaModel->get();

            $producto = new stdClass();
            $productoModel = new ProductoModel();

            $producto->productoBuscar = $_REQUEST["producto_buscar"];
            $r = $productoModel->getBuscar($producto);
            
            $vars["categorias"] = $categorias->data;
            $vars["sucursales"] = $sucursales->data;
            $vars["productos"] = $r->data;
            $vars["marcas"] = $marcas->data;

            $this->view->show("private/PartialProductos.php", $vars);
        } else {
            $this->view->show("public/home.php");
        }
    }
}