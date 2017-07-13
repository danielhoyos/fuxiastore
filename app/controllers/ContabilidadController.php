<?php

class ContabilidadController implements IController {

    private $view;

    public function __construct() {
        $this->view = new View();
    }

    public function index() {
        
    }

    public function contabilidad() {
        $config = Config::singleton();

        if (AppController::$login) {
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Contabilidad.php";
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Producto.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "ProductoModel.php";
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Venta.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "VentaModel.php";
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Persona.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "PersonaModel.php";
            
            $pag = !isset($_REQUEST["pag"]) ? 1 : $_REQUEST["pag"];
            
            $personaModel = new PersonaModel();
            $vendedores = $personaModel->getVendedores();

            $productoModel = new ProductoModel();
            $facturasModel = new VentaModel();

            $r = $productoModel->get();
            $f = $facturasModel->getFac($pag);

            $productos = $r->data;
            $totalProductos = 0;
            $totalVentas = 0;
            $totalVentasCompra = 0;

            foreach ($productos as $p) {
                $p instanceof Producto;
                $totalProductos += $p->getPRO_Precio_Compra();

                if ($p->getPRO_Estado() === "vendido") {
                    $totalVentasCompra += $p->getPRO_Precio_Compra();
                    $totalVentas += $p->getPRO_Precio_Venta();
                }
            }

            $totalVentasGanancia = $totalVentas - $totalVentasCompra;
            $cantFac = $facturasModel->getCantFac();
            
            $vars["totalProductos"] = $totalProductos;
            $vars["totalVentas"] = $totalVentas;
            $vars["totalVentasCompra"] = $totalVentasCompra;
            $vars["totalVentasGanancia"] = $totalVentasGanancia;
            $vars["facturas"] = $f->data;
            $vars["cantFac"] = $cantFac->data;
            $vars["vendedores"] = $vendedores->data;
            $this->view->show("private/Contabilidad.php", $vars);
        } else {
            $this->view->show("public/home.php");
        }
    }
}