<?php

class AuthController implements IController{
    
    public function index() {
        
    }
    
    public function validarAdministrador() {
        $config = Config::singleton();
        require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Persona.php";
        require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Usuario.php";
        require_once $config->get("rootFolder") . $config->get("modelsFolder") . "UsuarioModel.php";

        $usuario = new Usuario();
        $usuario->setUSR_Usuario($_POST["USR_Usuario"]);
        $usuario->setUSR_Password($_POST["USR_Password"],true);

        $model = new UsuarioModel();
        $r = $model->validarAdministrador($usuario);

        if ($r->status == 200) {
            $_SESSION[AppController::$keySession] = json_encode($r->data);
            header("location: ?action=index&msg={$r->msg}&status={$r->status}");
        } else {
            header("location: ?action=home&msg={$r->msg}&status={$r->status}");
        }
    }

    public function cerrarSesion() {
        session_destroy();
        $salto = "\r\n";
        $msg = "Sesión cerrada correctamente...<br>Gracias por Visitarnos!";
        $status = 200;
        header("location: ?msg={$msg}&status={$status}");
    }

}
