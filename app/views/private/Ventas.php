<?php
$config = Config::singleton();
$user = AppController::$login;
$user instanceof Usuario;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>.: Venta - Tienda de Ropa</title>
        <link rel="icon" type="image" href="<?php echo $config->get("rootHTTP"); ?>assets/icon.png"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/style.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/usuario.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/almacen.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>fonts/style.css"/>
        <script src="<?php echo $config->get("rootHTTP"); ?>js/lib/jquery.js"></script>
        <script src="<?php echo $config->get("rootHTTP"); ?>js/venta.js"></script>
    </head>
    <body class="admin">
        <?php require_once $config->get("rootFolder") . $config->get("viewsFolder") . "template/header.php"; ?>
        <div id="contenedor_principal">
            <center><br><h1 class="titulo1">VENTAS</h1><br></center>

            <div id="factura_venta">
                <form id="registrarVenta" action="?controller=Venta&action=registrar" method="POST">
                    <div id="cabecera_venta">
                        <div id="datos_factura">
                            <img id="logo_tienda" src="<?php echo $config->get("rootHTTP") . $config->get("assetsFolder") ?>icono_tienda.png"/>
                            <label id='nombre_tienda'>FUXIA</label>
                            <div id="numero_factura">
                                <label id="">FACTURA No. <?php
                                    if (isset($_SESSION['factura'])) {
                                        echo $_SESSION['factura'];
                                    }
                                    ?></label><br>
                                <input id="fecha_factura" type="dateme" name="VEN_Fecha_Venta" id="VEN_Fecha_Venta" value="<?php echo date("d/m/Y"); ?>" readonly/>
                            </div>
                        </div><br>

                        <table>
                            <tr>
                            <input type="hidden" name="PK_PSN_Id" id="PK_PSN_Id"/>
                            <td><label>Identificación</label></td>
                            <td><input type="text" id="PSN_Identificacion" name="PSN_Identificacion" class="inputDatos"/></td>
                            <td><label>Nombre</label></td>
                            <td><input type="text" name="PSN_Nombre" id="PSN_Nombre" class="inputDatos" /></td>
                            <td><label>Apellido</label></td>
                            <td><input type="text" name="PSN_Apellido" id="PSN_Apellido" class="inputDatos"/></td>
                            </tr>
                            <tr>
                                <td><label>Fecha de Nacimiento</label></td>
                                <td><input type="date" name="PSN_Fecha_Nacimiento" id="PSN_Fecha_Nacimiento"/></td>
                                <td><label>Teléfono</label></td>
                                <td><input type="tel" name="PSN_Telefono" id="PSN_Telefono"/></td>
                                <td><label>Vendedor</label></td>
                                <td>
                                    <select name="FK_VEN_Id" id="FK_VEN_Id">
                                        <?php
                                        foreach ($vendedores as $v) {
                                            $v instanceof Persona;
                                            echo "<option value='{$v->getPK_PSN_Id()}'>{$v->getPSN_Nombre()} {$v->getPSN_Apellido()}</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><br><label>Administrador:  </label></td>
                                <td><br><label><?php echo $user->PSN_Nombre . ' ' . $user->PSN_Apellido ?></label></td>
                                <td><label>Telefonos: </label></td>
                                <td><label>8380884 - 8380945</label></td>
                            </tr>
                        </table>
                    </div>

                    <table id="tabla_productos">
                        <thead>
                            <tr>
                                <th>CODIGO</th>
                                <th>NOMBRE</th>
                                <th>TALLA</th>
                                <th>SUBTOTAL</th>
                            </tr>
                        </thead>
                        <tbody id="productos">
                            <tr>
                                <td><input type="number" class="inputCorto codigo_producto"  name="codigo[]" id="codigo_producto1"/></td>
                                <td><input type="text" class="inputLargo" name="nombre[]" id="nombre_producto1" readonly/></td>
                                <td><input type="text" class="inputCorto" name="talla[]" id="talla_producto1" readonly/></td>
                                <td><input type="number"  class="inputMedio" name="subtotal[]" id="subtotal_producto1" class="subtotal" readonly/></td>
                            </tr>
                        </tbody>
                    </table>
                    <div id="compra">
                        <label>TOTAL: </label><input type="number" class="inputMedio" id="total_compra" name="total_compra" value="0" readonly/>
                    </div><br>
                </form>

                <button class="agregarProducto" id="agregarProducto">+</button>
                <button class="venderProducto">VENDER</button>
            </div>
            <p id="nota">NOTA: Si la casilla de CODIGO esta en rojo puede deberse a las siguientes 3 causas: <br><br>
                1. El Código ingresado NO esta registrado en el sistema.<br>
                2. El Código ingresado este registrado 2 veces en la Factura.<br>
                3. El Producto con el código ingresado no este disponible para la venta.<br> 
            </p>
        </div>
        <?php require_once $config->get("rootFolder") . $config->get("viewsFolder") . "template/footer.php"; ?>
    </body>
</html>

