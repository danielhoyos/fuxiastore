<?php
class AppController {

    public static $login;
    public static $keySession = "Administrador";

    public static function verificarLogin() {
        if (isset($_SESSION[self::$keySession])) {
            self::$login = json_decode($_SESSION[self::$keySession]);
        } else {
            self::$login = false;
        }
    }

    public static function main() {
        //Incluimos algunas clases:

        require_once 'app/class_/Config.php'; //de configuracion
        require_once 'config.php'; //Archivo con configuraciones.

        self::verificarLogin();
        require_once $config->get("rootFolder") . $config->get('modelsFolder') . "SPDO.php"; //PDO con singleton
        require_once $config->get("rootFolder") . $config->get('viewsFolder') . "View.php"; //Mini motor de plantillas
        require_once $config->get("rootFolder") . $config->get('controllersFolder') . "IController.php"; //Interface controlador
        require_once $config->get("rootFolder") . $config->get('modelsFolder') . "IModel.php"; //Interface modelo
        //Con el objetivo de no repetir nombre de clases, nuestros controladores
        //terminarán todos en Controller. Por ej, la clase controladora Items, será ItemsController
        //Formamos el nombre del Controlador o en su defecto, tomamos que es el IndexController
        if (!empty($_GET['controller'])) {
            $controllerName = $_GET['controller'] . 'Controller';
        } else {
            $controllerName = "IndexController";
        }
        //Lo mismo sucede con las acciones, si no hay acción, tomamos index como acción
        if (!empty($_GET['action'])) {
            $actionName = $_GET['action'];
        } else {
            $actionName = "home";
        }

        $controllerPath = $config->get("rootFolder") . $config->get('controllersFolder') . $controllerName . '.php';

        //Incluimos el fichero que contiene nuestra clase controladora solicitada
        if (is_file($controllerPath)) {
            require_once $controllerPath;
        } else {
            die("El controlador {$controllerName} no existe - 404 not found");
        }

        //Si no existe la clase que buscamos y su acción, mostramos un error 404
        if (is_callable(array($controllerName, $actionName)) == false) {
            trigger_error($controllerName . '->' . $actionName . '()  no existe', E_USER_NOTICE);
            return false;
        }
        //Si todo esta bien, creamos una instancia del controlador y llamamos a la acción
        $controller = new $controllerName();
        if ($controller instanceof IController) {
            $controller->$actionName();
        } else {
            die('El objeto no es una instancia de IController');
        }
    }
}
?>