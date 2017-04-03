<?php

class ConfiguracionController implements IController {

    private $view;

    public function __construct() {
        $this->view = new View();
    }

    public function index() {
        
    }

    public function configuraciones() {
        $config = Config::singleton();

        if (AppController::$login) {
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Configuraciones.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "ConfiguracionesModel.php";

            $this->view->show("private/Configuracion.php");
        } else {
            $this->view->show("public/home.php");
        }
    }

}