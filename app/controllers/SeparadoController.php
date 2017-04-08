<?php

class SeparadoController implements IController {

    private $view;

    public function __construct() {
        $this->view = new View();
    }

    public function index() {
        
    }

    public function separados() {
        $config = Config::singleton();

        if (AppController::$login) {
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Separado.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "SeparadoModel.php";
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Persona.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "PersonaModel.php";

            $personaModel = new PersonaModel();
            $vendedores = $personaModel->getVendedores();

            $separadoModel = new SeparadoModel();
            $separados = $separadoModel->get();

            $vars["separados"] = $separados->data;
            $vars["vendedores"] = $vendedores->data;
            $this->view->show("private/Separados.php", $vars);
        } else {
            $this->view->show("public/home.php");
        }
    }

    public function registrar() {
        $config = Config::singleton();

        if (AppController::$login) {
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Separado.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "SeparadoModel.php";
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Persona.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "PersonaModel.php";
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Producto.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "ProductoModel.php";

            $personaModel = new PersonaModel();
            $vendedores = $personaModel->getVendedores();
            $separado = new Separado();
            $separadoModel = new SeparadoModel();

            if ($_POST["PK_PSN_Id"] === "") {
                $persona = new Persona();
                $persona->setPSN_Id_Tipo_Identificacion(1);
                $persona->setPSN_Identificacion($_POST["PSN_Identificacion"]);
                $persona->setPSN_Nombre($_POST["PSN_Nombre"]);
                $persona->setPSN_Apellido($_POST["PSN_Apellido"]);
                $persona->setPSN_Fecha_Nacimiento($_POST["PSN_Fecha_Nacimiento"]);
                $persona->setPSN_Telefono($_POST["PSN_Telefono"]);
                $persona->setPSN_Rol(Persona::$ROL_CLIENTE);

                $insertPersona = $personaModel->insert($persona);
                $separado->setFK_CLI_Id($insertPersona->data);
            } else {
                $separado->setFK_CLI_Id($_POST["PK_PSN_Id"]);
            }

            $separado->setFK_PRO_Id($_POST["codigo_producto"]);
            $separado->setSEP_Valor($_POST["SEP_Valor"]);
            $separado->setSEP_Estado(Separado::$ESTADO_SEPARADO);
            $separado->setSEP_Fecha(date("Y-m-d"));
            $separado->setFK_VEN_Id($_POST["FK_VEN_Id"]);

            $retorno_separado = $separadoModel->insert($separado);
            if ($retorno_separado->status === 200) {
                $producto = new Producto();
                $producto->setPRO_Estado("separado");
                $producto->setPRO_Id($separado->getFK_PRO_Id());

                $productoModel = new ProductoModel();
                $retorno_producto = $productoModel->updateEstado($producto);
            }

            require_once "{$config->get("rootFolder")}fpdf/fpdf.php";

            $pdf = new FPDF('P', 'mm', array(80, 105));
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
            $pdf->Cell(70, 3, "Separado", 0, 2, "L");

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
            
            $producto->setPRO_Id($_POST["codigo_producto"]);
            $p = $productoModel->getById($producto);
            $prod = $p->data;
            $prod instanceof Producto;

            $pdf->Cell(15, 3, "{$prod->getPRO_Id()}", 0, 0, "L");
            $pdf->Cell(36, 3, "{$prod->getPRO_Nombre()}", 0, 0, "L");
            $pdf->Cell(19, 3, "{$prod->getPRO_Precio_Venta()}", 0, 1, "R");
            
            $pdf->Cell(70, 3, "====================================", 0, 2, "C");
            $pdf->Cell(70, 3, "Abono: {$_POST["SEP_Valor"]}", 0, 1, "R");
            
            $saldo = ($prod->getPRO_Precio_Venta() - $_POST["SEP_Valor"]);
            
            $pdf->Cell(70, 3, "Saldo: {$saldo}", 0, 0, "R");
            $pdf->ln();
            $pdf->ln();
            $pdf->SetFont("Courier", "B", 9);
            $pdf->Cell(70, 3, "GRACIAS POR SU COMPRA", 0, 2, "C");
            $date = date("YmdHis");
            $pdf->Output("separados/separado-{$date}.pdf", "F");
            echo "<script language='javascript'>window.open('separados/separado-{$date}.pdf','_blank','');</script>";

            $separados = $separadoModel->get();
            $vars["separados"] = $separados->data;
            $vars["vendedores"] = $vendedores->data;
            $this->view->show("private/Separados.php", $vars);
        } else {
            $this->view->show("public/home.php");
        }
    }

    public function SeparadoPorId() {
        $config = Config::singleton();

        if (AppController::$login) {
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Separado.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "SeparadoModel.php";

            $separado = new Separado();
            $separado->setSEP_Id($_POST["SEP_Id"]);

            $separadoModel = new SeparadoModel();
            $retorno_reparado = $separadoModel->getById($separado);
            echo json_encode($retorno_reparado);
        } else {
            $this->view->show("public/home.php");
        }
    }

    public function abonar() {
        $config = Config::singleton();

        if (AppController::$login) {
            require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Separado.php";
            require_once $config->get("rootFolder") . $config->get("modelsFolder") . "SeparadoModel.php";

            $separado = new Separado();
            $separado->setSEP_Valor($_POST["valor_separado"] + $_POST["abonar_separado"]);
            $separado->setSEP_Id($_POST["SEP_Id_Buscar"]);

            if ($separado->getSEP_Valor() === (int) $_POST["valor_producto"]) {
                $separado->setSEP_Estado(Separado::$ESTADO_RETIRADO);
            } else {
                $separado->setSEP_Estado(Separado::$ESTADO_ABONADDO);
            }

            $separadoModel = new SeparadoModel();
            $retorno_separado = $separadoModel->update($separado);

            if ($retorno_separado->status == 200 && $separado->getSEP_Estado() == Separado::$ESTADO_RETIRADO) {
                require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Producto.php";
                require_once $config->get("rootFolder") . $config->get("modelsFolder") . "ProductoModel.php";

                $producto = new Producto();
                $producto->setPRO_Estado("vendido");
                $producto->setPRO_Id($_POST["codigo_producto"]);

                $productoModel = new ProductoModel();
                $productoModel->updateEstado($producto);
            }

            $this->separados();
        } else {
            $this->view->show("public/home.php");
        }
    }

    public function separadosFecha() {
        $config = Config::singleton();
        require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Separado.php";
        require_once $config->get("rootFolder") . $config->get("modelsFolder") . "SeparadoModel.php";
        require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Persona.php";
        require_once $config->get("rootFolder") . $config->get("modelsFolder") . "PersonaModel.php";
        require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Producto.php";
        require_once $config->get("rootFolder") . $config->get("modelsFolder") . "ProductoModel.php";

        $separado = new Separado();
        $separadoModel = new SeparadoModel();

        if ($_POST["Fecha_Inicio"] === "" || $_POST["Fecha_Fin"] === "") {
            $r = $separadoModel->get();
        } else {
            $separadosFecha = new stdClass();
            $separadosFecha->fechaInicio = $_POST["Fecha_Inicio"];
            $separadosFecha->fechaFin = $_POST["Fecha_Fin"];
            $r = $separadoModel->separadosFecha($separadosFecha);
        }

        if ($r->status == 200) {
            $personaModel = new PersonaModel();
            $vendedores = $personaModel->getVendedores();

            $vars["separados"] = $r->data;
            $vars["vendedores"] = $vendedores->data;
            $this->view->show("private/PartialSeparados.php", $vars);
        }
    }

    public function separadoIdentificacion() {
        $config = Config::singleton();
        require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Separado.php";
        require_once $config->get("rootFolder") . $config->get("modelsFolder") . "SeparadoModel.php";
        require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Persona.php";
        require_once $config->get("rootFolder") . $config->get("modelsFolder") . "PersonaModel.php";
        require_once $config->get("rootFolder") . $config->get("entitiesFolder") . "Producto.php";
        require_once $config->get("rootFolder") . $config->get("modelsFolder") . "ProductoModel.php";

        $separado = new stdClass();
        $separadoModel = new SeparadoModel();

        if ($_POST["SEP_Identificacion"] === "") {
            $r = $separadoModel->get();
        } else {
            $separado->identificacion = $_POST["SEP_Identificacion"];
            $r = $separadoModel->separadosIdentificacion($separado);
        }

        if ($r->status == 200) {
            $personaModel = new PersonaModel();
            $vendedores = $personaModel->getVendedores();

            $vars["separados"] = $r->data;
            $vars["vendedores"] = $vendedores->data;
            $this->view->show("private/PartialSeparados.php", $vars);
        }
    }
}
