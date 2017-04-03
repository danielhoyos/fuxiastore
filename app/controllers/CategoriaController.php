<?php

class CategoriaController implements IController {

    private $view;

    public function __construct() {
        $this->view = new View();
    }

    public function index() {
        
    }

    public function categorias() {
        $config = Config::singleton();

        if (AppController::$login) {
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Categoria.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "CategoriaModel.php";

            $categoriaModel = new CategoriaModel();
            $r = $categoriaModel->get();

            if ($r->status == 200 || $r->status == 201) {
                $vars["categorias"] = $r->data;
                $this->view->show("private/Categorias.php", $vars);
            }
        } else {
            $this->view->show("public/home.php");
        }
    }
    
    public function registrar(){
        $config = Config::singleton();

        if (AppController::$login) {
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Categoria.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "CategoriaModel.php";

            $categoria = new Categoria();
            $categoria->setCAT_Nombre($_POST["CAT_Nombre"]);
            
            $categoriaModel = new CategoriaModel();
            $r = $categoriaModel->insert($categoria);
            
            header("location: ?controller=Categoria&action=categorias");
        }
    }
    
    public function categoriasPorId() {
        $config = Config::singleton();

        if (AppController::$login) {
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Categoria.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "CategoriaModel.php";

            $categoria = new Categoria();
            $categoria->setCAT_Id($_REQUEST["CAT_Id"]);

            $categoriaModel = new CategoriaModel();
            $r = $categoriaModel->getById($categoria);
            
            if ($r->status == 200) {
                echo json_encode($r);
            }
        }
    }
    
    public function editar() {
        $config = Config::singleton();
        
        if (AppController::$login) {
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Categoria.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "CategoriaModel.php";
            
            $categoria = new Categoria();
            $categoria->setCAT_Id($_POST["CAT_Id_Editar"]);
            $categoria->setCAT_Nombre($_POST["CAT_Nombre_Editar"]);
            
            $categoriaModel = new CategoriaModel();
            $r = $categoriaModel->update($categoria);

            header("location: ?controller=Categoria&action=categorias&msg={$r->msg}");
        }
    }
    
    public function eliminar(){
        $config = Config::singleton();
        
        if (AppController::$login) {
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Categoria.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "CategoriaModel.php";
            
            $categoria = new Categoria();
            $categoria->setCAT_Id($_POST["CAT_Id"]);
            
            $categoriaModel = new CategoriaModel();
            $r = $categoriaModel->delete($categoria);
            
            echo json_encode($r);
        }
    }
}
