<?php

class NotificacionesController implements IController {

    private $view;

    public function __construct() {
        $this->view = new View();
    }

    public function index() {
        
    }

    public function home() {
        $config = Config::singleton();

        if (AppController::$login) {
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Notificaciones.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "NotificacionesModel.php";
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Producto.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "ProductoModel.php";
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Categoria.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "CategoriaModel.php";
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Sucursal.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "SucursalModel.php";
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Marca.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "MarcaModel.php";
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Persona.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "PersonaModel.php";
            
            $personaModel = new PersonaModel();
            $personas = $personaModel->getClientesCumpleanios();

            $categoriaModel = new CategoriaModel();
            $categorias = $categoriaModel->get();

            $sucursalModel = new SucursalModel();
            $sucursales = $sucursalModel->get();

            $productoModel = new ProductoModel();
            $productos = $productoModel->get();
            
            $marcaModel = new MarcaModel();
            $marcas = $marcaModel->get();
            
            $vars["categorias"] = $categorias->data;
            $vars["sucursales"] = $sucursales->data;
            $vars["productos"] = $productos->data;
            $vars["marcas"] = $marcas->data;
            $vars["clientes"] = $personas->data;
            $this->view->show("private/Notificaciones.php", $vars);
        } else {
            $this->view->show("public/home.php");
        }
    }
}