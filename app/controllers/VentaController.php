<?php

class VentaController implements IController {

    private $view;

    public function __construct() {
        $this->view = new View();
    }

    public function index() {
        
    }

    public function ventas($abrir = null) {
        $config = Config::singleton();

        if (AppController::$login) {
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Venta.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "VentaModel.php";
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Persona.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "PersonaModel.php";
            $personaModel = new PersonaModel();
            $vendedores = $personaModel->getVendedores();

            if ($abrir !== null) {
                echo $abrir;
            }

            $vars["vendedores"] = $vendedores->data;
            $this->view->show("private/Ventas.php", $vars);
        } else {
            $this->view->show("public/home.php");
        }
    }

    public function registrar() {
        $config = Config::singleton();

        if (AppController::$login) {
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Venta.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "VentaModel.php";
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Persona.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "PersonaModel.php";

            $venta = new Venta();

            if ($_POST["PK_PSN_Id"] === "") {
                $persona = new Persona();
                $persona->setPSN_Id_Tipo_Identificacion(1);
                $persona->setPSN_Identificacion($_POST["PSN_Identificacion"]);
                $persona->setPSN_Nombre($_POST["PSN_Nombre"]);
                $persona->setPSN_Apellido($_POST["PSN_Apellido"]);
                $persona->setPSN_Fecha_Nacimiento($_POST["PSN_Fecha_Nacimiento"]);
                $persona->setPSN_Telefono($_POST["PSN_Telefono"]);
                $persona->setPSN_Rol(Persona::$ROL_CLIENTE);

                $personaModel = new PersonaModel();
                $insertPersona = $personaModel->insert($persona);
                $venta->setVEN_CLI_Id($insertPersona->data);
            } else {
                $venta->setVEN_CLI_Id($_POST["PK_PSN_Id"]);
            }

            $venta->setVEN_VEND_Id($_POST["FK_VEN_Id"]);
            $venta->setVEN_Fecha_Venta(date("Y-m-d H:i:s"));
            $venta->setVEN_Total($_POST["total_compra"]);

            $ventaModel = new VentaModel();
            $r = $ventaModel->insert($venta);
            $_SESSION["factura"] = ($r->data) + 1;
            $contador = 0;

            if ($r->status == 200) {
                require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Producto.php";
                require_once $config->get("rootFolder") . $config->get("modelsFolder") . "ProductoModel.php";
                require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "VentaProducto.php";
                require_once $config->get("rootFolder") . $config->get("modelsFolder") . "VentaProductoModel.php";

                $producto = new Producto();
                $productoModel = new ProductoModel();
                $ventaProducto = new VentaProducto();
                $ventaProductoModel = new VentaProductoModel();
                $codigos = $_POST["codigo"];

                for ($i = 0; $i < count($codigos); $i++) {
                    if ($codigos[$i] !== "") {
                        $producto->setPRO_Id($codigos[$i]);
                        $producto->setPRO_Estado("vendido");
                        $s = $productoModel->updateEstado($producto);

                        if ($s->status === 200) {
                            $ventaProducto->setPRO_Id($codigos[$i]);
                            $ventaProducto->setVEN_Id($r->data);
                            $v = $ventaProductoModel->insert($ventaProducto);
                        }
                    }
                }
            }
            require_once "{$config->get("rootFolder")}fpdf/fpdf.php";

            $alto = 102 + (count($codigos) * 3);

            $pdf = new FPDF('P', 'mm', array(80, $alto));
            $pdf->AddPage();
            $pdf->SetMargins(5, 0, 5);
            $pdf->SetFont("Courier", "B", 16);
            $pdf->Cell(60, 5, "FUXIA STORE", 0, 2, "C");
            $pdf->SetFont("Courier", "B", 9);
            $pdf->Cell(60, 3, "Nit. 1114812792-4", 0, 2, "C");
            $pdf->Cell(60, 3, "C.Co Anarkos Plaza Local 52", 0, 2, "C");
            $pdf->Cell(60, 3, "REGIMEN SIMPLIFICADO", 0, 2, "C");
            $pdf->Ln();
            $pdf->Cell(70, 3, "====================================", 0, 2, "C");
            $pdf->Cell(53.3, 3, "Fecha: " . date('Y-m-d'), 0, 0, "L");
            $pdf->Cell(10, 3, date('H:i:s'), 0, 1, "L");
            $pdf->Cell(70, 3, "====================================", 0, 2, "C");
            $pdf->Ln();
            $pdf->Cell(70, 3, "FACTURA No: {$r->data}", 0, 2, "L");
            
            $vendedor = new Persona();
            $vendedor->setPK_PSN_Id($_POST["FK_VEN_Id"]);

            $personaModel = new PersonaModel();
            $datos_vendedor = $personaModel->getById($vendedor);
            $ven = $datos_vendedor->data;
            $ven instanceof Persona;
            
            $pdf->Cell(70, 3, "Vendedor(a): {$ven->getPSN_Nombre()} {$ven->getPSN_Apellido()}", 0, 2, "L");
            $pdf->Ln();
            $pdf->Cell(70, 3, "C.C: {$_POST["PSN_Identificacion"]}", 0, 2, "L");
            $pdf->Cell(70, 3, "Nombre: {$_POST["PSN_Nombre"]} {$_POST["PSN_Apellido"]}", 0, 2, "L");
            $pdf->Ln();
            $pdf->Cell(70, 3, "====================================", 0, 2, "C");
            $pdf->Cell(15, 3, "COD", 0, 0, "L");
            $pdf->Cell(36, 3, "DETALLE", 0, 0, "L");
            $pdf->Cell(19, 3, "VALOR", 0, 1, "L");
            $pdf->Cell(70, 3, "====================================", 0, 2, "C");
            $valorPagar = 0;
            for ($i = 0; $i < count($codigos); $i++) {
                if ($codigos[$i] !== "") {
                    $producto->setPRO_Id($codigos[$i]);
                    $p = $productoModel->getById($producto);
                    $prod = $p->data;
                    $prod instanceof Producto;

                    $pdf->Cell(15, 3, "{$prod->getPRO_Id()}", 0, 0, "L");
                    $pdf->Cell(36, 3, "{$prod->getPRO_Nombre()}", 0, 0, "L");
                    $pdf->Cell(19, 3, "{$prod->getPRO_Precio_Venta()}", 0, 1, "R");

                    $valorPagar += $prod->getPRO_Precio_Venta();
                }
            }
            $pdf->Cell(70, 3, "====================================", 0, 2, "C");
            $pdf->Cell(70, 3, "Valor a Pagar: $ {$valorPagar}", 0, 0, "R");
            $pdf->ln();
            $pdf->ln();
            $pdf->ln();
            $pdf->SetFont("Courier", "B", 11);
            $pdf->SetFont("Courier", "B", 9);
            $pdf->Cell(70, 3, "GRACIAS POR SU COMPRA", 0, 2, "C");
            $pdf->Output("facturas/factura-no-{$r->data}.pdf", "F");
            $abrir = "<script language='javascript'>window.open('facturas/factura-no-{$r->data}.pdf','_blank','');</script>";

            $this->ventas($abrir);
        } else {
            $this->view->show("public/home.php");
        }
    }

    public function ventasById() {
        $config = Config::singleton();
        require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Venta.php";
        require_once $config->get("rootFolder") . $config->get("modelsFolder") . "VentaModel.php";

        $venta = new Venta();
        $venta->setVEN_Id($_POST["VEN_Id"]);

        $ventaModel = new VentaModel();
        $r = $ventaModel->getById($venta);

        print json_encode($r);
    }

    public function productosVenta() {
        $config = Config::singleton();
        require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "VentaProducto.php";
        require_once $config->get("rootFolder") . $config->get("modelsFolder") . "VentaProductoModel.php";

        $ventaProducto = new VentaProducto();
        $ventaProductoModel = new VentaProductoModel();

        $ventaProducto->setVEN_Id($_POST["VEN_Id"]);
        $r = $ventaProductoModel->productosVenta($ventaProducto);

        if ($r->status == 200) {
            $vars["productos"] = $r->data;
            $this->view->show("private/PartialProductosVenta.php", $vars);
        }
    }

    public function facturasFecha() {
        $config = Config::singleton();
        require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Venta.php";
        require_once $config->get("rootFolder") . $config->get("modelsFolder") . "VentaModel.php";
        require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Persona.php";
        require_once $config->get("rootFolder") . $config->get("modelsFolder") . "PersonaModel.php";

        $personaModel = new PersonaModel();
        $vendedores = $personaModel->getVendedores();

        $vars["vendedores"] = $vendedores->data;

        $venta = new Venta();
        $ventaModel = new VentaModel();

        if ($_POST["Fecha_Inicio"] === "" || $_POST["Fecha_Fin"] === "") {
            $r = $ventaModel->get();
        } else {
            $ventasFecha = new stdClass();
            $ventasFecha->fechaInicio = $_POST["Fecha_Inicio"];
            $ventasFecha->fechaFin = $_POST["Fecha_Fin"];
            $r = $ventaModel->facturasFecha($ventasFecha);
        }

        if ($r->status == 200) {
            $vars["facturas"] = $r->data;
            $vars["vendedores"] = $vendedores->data;
            $this->view->show("private/PartialFacturas.php", $vars);
        }
    }

    public function facturasIdentificacion() {
        $config = Config::singleton();
        require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Venta.php";
        require_once $config->get("rootFolder") . $config->get("modelsFolder") . "VentaModel.php";
        require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Persona.php";
        require_once $config->get("rootFolder") . $config->get("modelsFolder") . "PersonaModel.php";

        $personaModel = new PersonaModel();
        $vendedores = $personaModel->getVendedores();

        $vars["vendedores"] = $vendedores->data;

        $venta = new Venta();
        $ventaModel = new VentaModel();

        if ($_POST["VEN_Identificacion"] === "") {
            $r = $ventaModel->get();
        } else {
            $ventas = new stdClass();
            $ventas->identificacion = $_POST["VEN_Identificacion"];
            $r = $ventaModel->facturasIdentificacion($ventas);
        }

        if ($r->status == 200) {
            $vars["facturas"] = $r->data;
            $vars["vendedores"] = $vendedores->data;
            $this->view->show("private/PartialFacturas.php", $vars);
        }
    }

}
