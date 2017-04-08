<?php

class SucursalController implements IController {

    private $view;

    public function __construct() {
        $this->view = new View();
    }

    public function index() {
        
    }

    public function sucursales() {
        $config = Config::singleton();

        if (AppController::$login) {
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Sucursal.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "SucursalModel.php";

            $sucursalModel = new SucursalModel();
            $r = $sucursalModel->get();

            if ($r->status == 200 || $r->status == 201) {
                $vars["sucursales"] = $r->data;
                $this->view->show("private/Sucursales.php", $vars);
            }
        } else {
            $this->view->show("public/home.php");
        }
    }

    public function sucursalesPorId() {
        $config = Config::singleton();

        if (AppController::$login) {
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Sucursal.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "SucursalModel.php";

            $sucursal = new Sucursal();
            $sucursal->setSUC_Id($_REQUEST["SUC_Id"]);

            $sucursalModel = new SucursalModel();
            $r = $sucursalModel->getById($sucursal);
            
            if ($r->status == 200) {
                echo json_encode($r);
            }
        }
    }

    public function registrar() {
        $config = Config::singleton();

        if (AppController::$login) {
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Sucursal.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "SucursalModel.php";

            $sucursal = new Sucursal();
            $sucursal->setSUC_Nit($_POST["SUC_Nit"]);
            $sucursal->setSUC_Nombre($_POST["SUC_Nombre"]);
            $sucursal->setSUC_Direccion($_POST["SUC_Direccion"]);
            $sucursal->setSUC_Telefono($_POST["SUC_Telefono"]);

            $sucursalModel = new SucursalModel();
            $r = $sucursalModel->insert($sucursal);

            header("location: ?controller=Sucursal&action=sucursales&msg={$r->msg}");
        }
    }

    public function editar() {
        if (AppController::$login) {
            $config = Config::singleton();
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Sucursal.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "SucursalModel.php";
            
            $sucursal = new Sucursal();
            $sucursal->setSUC_Id($_POST["SUC_Id_Editar"]);
            $sucursal->setSUC_Nit($_POST["SUC_Nit_Editar"]);
            $sucursal->setSUC_Nombre($_POST["SUC_Nombre_Editar"]);
            $sucursal->setSUC_Direccion($_POST["SUC_Direccion_Editar"]);
            $sucursal->setSUC_Telefono($_POST["SUC_Telefono_Editar"]);
            
            $sucursalModel = new SucursalModel();
            $r = $sucursalModel->update($sucursal);

            header("location: ?controller=Sucursal&action=sucursales&msg={$r->msg}");
        }
    }
    
    public function eliminar(){
        if (AppController::$login) {
            $config = Config::singleton();
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Sucursal.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "SucursalModel.php";
            
            $sucursal = new Sucursal();
            $sucursal->setSUC_Id($_POST["SUC_Id"]);
            
            $sucursalModel = new SucursalModel();
            $r = $sucursalModel->delete($sucursal);
            
            echo json_encode($r);
        }
    }
}