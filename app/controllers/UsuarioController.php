<?php

class UsuarioController implements IController {

    private $view;

    public function __construct() {
        $this->view = new View();
    }

    public function index() {
        
    }

    public function editarUsuario() {
        if (AppController::$login) {
            $login = AppController::$login;
            $config = Config::singleton();

            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Persona.php";
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Usuario.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "PersonaModel.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "UsuarioModel.php";

            $usuario = new Usuario();
            $usuario->setPK_PSN_Id($login->PK_PSN_Id);
            $usuario->setPSN_Id_Tipo_Identificacion($_POST["PSN_Id_Tipo_Identificacion"]);
            $usuario->setPSN_Identificacion($_POST["PSN_Identificacion"]);
            $usuario->setPSN_Nombre($_POST["PSN_Nombre"]);
            $usuario->setPSN_Apellido($_POST["PSN_Apellido"]);
            $usuario->setPSN_Fecha_Nacimiento($_POST["PSN_Fecha_Nacimiento"]);
            $usuario->setPSN_Telefono($_POST["PSN_Telefono"]);

            $usuario->setUSR_Id($login->USR_Id);
            $usuario->setUSR_Usuario($_POST["USR_Usuario"]);
            $usuario->setUSR_Fecha_Registro(date("F j, Y, g:i a"));

            $password = $login->USR_Password;

            $usuarioModel = new UsuarioModel();
            $r = $usuarioModel->update($usuario);

            if ($r->status == 200) {
                $_SESSION[AppController::$keySession] = json_encode($r->data);
                $user = $usuario->getUSR_Usuario();

                $usuario = new Usuario();
                $usuario->setUSR_Usuario($user);
                $usuario->setUSR_Password($password);

                $model = new UsuarioModel();
                $r = $model->validarAdministrador($usuario);

                $_SESSION[AppController::$keySession] = json_encode($r->data);
                header("location: ?action=perfil&msg=Usuario Editado Correctamente");
            }
        }
    }

    public function editarAvatar() {
        if (AppController::$login) {
            $login = AppController::$login;
            $config = Config::singleton();

            /*             * ********* SUBIENDO ARCHIVO ********* */
            $array_nombre = explode(".", $_FILES["USR_Avatar"]["name"]);
            $long = count($array_nombre);
            $ext = $array_nombre[$long - 1];
            $namephoto = $login->USR_Usuario . "." . $ext;
            $path = $config->get("rootFolder") . $config->get("assetsFolder") . "user/$namephoto";
            $fotoAntigua = $config->get("rootFolder") . $config->get("assetsFolder") . "user/" . $login->USR_Avatar;
            move_uploaded_file($_FILES["USR_Avatar"]["tmp_name"], $path);
            /*             * ********************************** */

            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Persona.php";
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Usuario.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "PersonaModel.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "UsuarioModel.php";

            $usuario = new Usuario();
            $usuario->setUSR_Id($login->USR_Id);
            $usuario->setUSR_Avatar($namephoto);

            $model = new UsuarioModel();
            $r = $model->updateFoto($usuario);

            if ($r->status == 200) {
                $_SESSION[AppController::$keySession] = json_encode($r->data);
                $user = $login->USR_Usuario;
                $password = $login->USR_Password;

                $usuario = new Usuario();
                $usuario->setUSR_Usuario($user);
                $usuario->setUSR_Password($password);

                $model = new UsuarioModel();
                $re = $model->validarAdministrador($usuario);
                $_SESSION[AppController::$keySession] = json_encode($re->data);

                header("location: ?action=perfil&msg=Avatar Editado Correctamente");
            }

            if ($path != $fotoAntigua) {
                unlink($fotoAntigua);
            }
        }
    }

    public function editarPortada() {
        if (AppController::$login) {
            $login = AppController::$login;
            $config = Config::singleton();

            /*             * ******** SUBIENDO ARCHIVO ********* */
            $array_nombre = explode(".", $_FILES["USR_Portada"]["name"]);
            $long = count($array_nombre);
            $ext = $array_nombre[$long - 1];
            $namephoto = $login->USR_Usuario . "." . $ext;
            $path = $config->get("rootFolder") . $config->get("assetsFolder") . "portada/$namephoto";
            $fotoAntigua = $config->get("rootFolder") . $config->get("assetsFolder") . "portada/" . $login->USR_Portada;
            move_uploaded_file($_FILES["USR_Portada"]["tmp_name"], $path);
            /*             * ********************************** */

            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Persona.php";
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Usuario.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "PersonaModel.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "UsuarioModel.php";

            $usuario = new Usuario();
            $usuario->setUSR_Id($login->USR_Id);
            $usuario->setUSR_Portada($namephoto);

            $model = new UsuarioModel();
            $r = $model->updatePortada($usuario);

            if ($r->status == 200) {
                $_SESSION[AppController::$keySession] = json_encode($r->data);
                $user = $login->USR_Usuario;
                $password = $login->USR_Password;

                $usuario = new Usuario();
                $usuario->setUSR_Usuario($user);
                $usuario->setUSR_Password($password);

                $model = new UsuarioModel();
                $re = $model->validarAdministrador($usuario);
                $_SESSION[AppController::$keySession] = json_encode($re->data);

                header("location: ?action=perfil&msg=Portada Editada Correctamente");
            }

            if ($path != $fotoAntigua) {
                unlink($fotoAntigua);
            }
        }
    }

    public function editarPassword() {
        $user = AppController::$login;
        $config = Config::singleton();

        require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Persona.php";
        require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Usuario.php";
        require_once $config->get("rootFolder") . $config->get("modelsFolder") . "PersonaModel.php";
        require_once $config->get("rootFolder") . $config->get("modelsFolder") . "UsuarioModel.php";
        /*         * ***** */
        $usuario = new Usuario();
        $usuario->setUSR_Id($user->USR_Id);
        $usuario->setUSR_Password($_POST["USR_Password"], true);
        $model = new UsuarioModel;
        $r = $model->consultarPassword($usuario);

        if ($r->status == 200) {
            $usuarioEditar = new Usuario();
            $usuarioEditar->setUSR_Id($user->USR_Id);
            $usuarioEditar->setUSR_Password($_POST["USR_PasswordConfirmar"], true);
            $modelo = new UsuarioModel;
            $re = $modelo->updatePassword($usuarioEditar);

            if ($re->status == 200) {
                $user = $user->USR_Usuario;
                $password = $_POST["USR_PasswordConfirmar"];

                $usuario = new Usuario();
                $usuario->setUSR_Usuario($user);
                $usuario->setUSR_Password($password, true);

                $model = new UsuarioModel();
                $r = $model->validarAdministrador($usuario);

                $_SESSION[AppController::$keySession] = json_encode($r->data);
                header("location: ?controller=Index&action=perfil&msg=Password Editado Correctamente");
            }
        } else {
            header("location: ?controller=Index&action=perfil&msg={$r->msg}}");
        }
    }

    public function personaByIdentificacion() {
        $config = Config::singleton();
        require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Persona.php";
        require_once $config->get("rootFolder") . $config->get("modelsFolder") . "PersonaModel.php";
        /*         * ***** */
        $persona = new Persona();
        $persona->setPSN_Identificacion($_POST["PSN_Identificacion"]);
        $model = new PersonaModel;
        $r = $model->personaByIdentificacion($persona);

        echo json_encode($r);
    }
}