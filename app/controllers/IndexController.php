<?php

class IndexController implements IController {

    private $view;

    public function __construct() {
        $this->view = new View();
    }

    public function home() {
        if (AppController::$login) {
            $this->view->show("private/IndexAdmin.php");
        } else {
            $this->view->show("public/home.php");
        }
    }

    public function index() {
        if (AppController::$login) {
            $this->view->show("private/IndexAdmin.php");
        } else {
            $this->view->show("public/home.php");
        }
    }

    public function perfil() {
        if (AppController::$login) {
            $config = Config::singleton();

            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "TipoIdentificacion.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "TipoIdentificacionModel.php";

            $tiModel = new TipoIdentificacionModel();
            $r = $tiModel->get();
            $vars["tiposIdentificacion"] = $r->data;

            $this->view->show("private/Perfil.php", $vars);
        } else {
            $this->view->show("public/home.php");
        }
    }

    public function formEditarPassword() {
        if(AppController::$login){
            $this->view->show("private/EditarPassword.php");
        }
    }
}