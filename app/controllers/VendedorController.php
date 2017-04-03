<?php

class VendedorController implements IController {

    private $view;

    public function __construct() {
        $this->view = new View();
    }

    public function index() {
        
    }

    public function vendedores() {
        $config = Config::singleton();

        if (AppController::$login) {
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Persona.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "PersonaModel.php";

            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "TipoIdentificacion.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "TipoIdentificacionModel.php";

            $personaModel = new PersonaModel();
            $r = $personaModel->getVendedores();

            $tiModel = new TipoIdentificacionModel();
            $tipos = $tiModel->get();

            if (($r->status == 200 || $r->status == 201) & ($tipos->status == 200 || $tipos->status == 201)) {
                $vars["vendedores"] = $r->data;
                $vars["tipos"] = $tipos->data;
                $this->view->show("private/Vendedores.php", $vars);
            }
        } else {
            $this->view->show("public/home.php");
        }
    }

    public function vendedorPorId() {
        $config = Config::singleton();

        if (AppController::$login) {
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Persona.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "PersonaModel.php";

            $vendedor = new Persona();
            $vendedor->setPK_PSN_Id($_REQUEST["PK_PSN_Id"]);

            $personaModel = new PersonaModel();
            $r = $personaModel->getById($vendedor);
            
            if ($r->status == 200) {
                echo json_encode($r);
            }
        }
    }

    public function registrar() {
        $config = Config::singleton();

        if (AppController::$login) {
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Persona.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "PersonaModel.php";

            $vendedor = new Persona();
            $vendedor->setPSN_Id_Tipo_Identificacion($_POST["PSN_Id_Tipo_Identificacion"]);
            $vendedor->setPSN_Identificacion($_POST["PSN_Identificacion"]);
            $vendedor->setPSN_Nombre($_POST["PSN_Nombre"]);
            $vendedor->setPSN_Apellido($_POST["PSN_Apellido"]);
            $vendedor->setPSN_Telefono($_POST["PSN_Telefono"]);
            $vendedor->setPSN_Rol(Persona::$ROL_VENDEDOR);

            $personaModel = new PersonaModel();
            $r = $personaModel->insert($vendedor);

            header("location: ?controller=Vendedor&action=vendedores&msg={$r->msg}");
        }
    }

    public function editar() {
        if (AppController::$login) {
            $config = Config::singleton();
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Persona.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "PersonaModel.php";

            $vendedor = new Persona();
            $vendedor->setPK_PSN_Id($_POST["PK_PSN_Id_Editar"]);
            $vendedor->setPSN_Nombre($_POST["PSN_Nombre_Editar"]);
            $vendedor->setPSN_Apellido($_POST["PSN_Apellido_Editar"]);
            $vendedor->setPSN_Telefono($_POST["PSN_Telefono_Editar"]);

            $personaModel = new PersonaModel();
            $r = $personaModel->updateVendedor($vendedor);

            header("location: ?controller=Vendedor&action=vendedores&msg={$r->msg}");
        }
    }

    public function eliminar() {
        if (AppController::$login) {
            $config = Config::singleton();
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Persona.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "PersonaModel.php";

            $vendedor = new Persona();
            $vendedor->setPK_PSN_Id($_POST["PK_PSN_Id"]);

            $personaModel = new PersonaModel();
            $r = $personaModel->delete($vendedor);

            echo json_encode($r);
        }
    }
}