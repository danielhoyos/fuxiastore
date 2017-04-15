<?php
$config = Config::singleton();
$user = AppController::$login;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>.: Contabilidad - <?php echo $config->get("nameApp"); ?></title>
        <link rel="icon" type="image" href="<?php echo $config->get("rootHTTP"); ?>assets/icon.png"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/style.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/usuario.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/almacen.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>fonts/style.css"/>
        <script src="<?php echo $config->get("rootHTTP"); ?>js/lib/jquery.js"></script>
        <script src="<?php echo $config->get("rootHTTP"); ?>js/contabilidad.js"></script>
    </head>
    <body class="admin">
        <?php
        require_once $config->get("rootFolder") . $config->get("viewsFolder") . "template/header.php";
        ?>
        <div id="contenedor_principal">
            <center><br><h1 class="titulo1">CONTABILIDAD</h1><br></center>
            <div id="aside">
                <div id="imagen_aside">
                    <img  src="<?php echo $config->get("rootHTTP") . $config->get("assetsFolder") . "ingresos_icon.png" ?>"/>
                </div>
                <div id="info">
                    <table class="tablaContabilidad">
                        <tr>
                            <td>COMPRA DE PRODUCTOS </td>
                            <td>$ <?php echo number_format($totalProductos); ?> </td>
                        </tr>
                        <tr>
                            <td>VENTAS TOTALES</td>
                            <td>$ <?php echo number_format($totalVentas); ?></td>
                        </tr>
                        <tr>
                            <td>VENTAS PRECIO NETO</td>
                            <td>$ <?php echo number_format($totalVentasCompra); ?></td>
                        </tr>
                        <tr>
                            <td>VENTAS GANANCIA</td>
                            <td>$ <?php echo number_format($totalVentasGanancia); ?></td>
                        </tr>
                    </table>
                </div>
                <center><button class="btn_notificaciones"><a href="?controller=Notificaciones">NOTIFICACIONES</a></button></center>
            </div>
            <div id="section">
                <input class="buscarVentaIdentificacion" type="number" placeholder="Numero de Identificación" name="venta_identificacion_buscar" id="venta_identificacion_buscar"/>
                <input class="buscarFacturaInicio" type="date" name="facturas_inicio_buscar" id="facturas_inicio_buscar"/>
                <input class="buscarFacturaFin" type="date" name="facturas_fin_buscar" id="facturas_fin_buscar"/>
                <div class="icon_buscar_factura"><span class="icon-search"></span></div>
                <center><h3 class="titulo1">FACTURAS</h3></center><br><br><br>
                <div class="tablaFacturas">
                    <?php
                    require_once $config->get("rootFolder") . $config->get("viewsFolder") . "private/PartialFacturas.php";
                    ?>
                </div>
            </div>
        </div>
        <div id="div_ver_factura" class="oculto">
            <div id="factura_venta" class="ver_factura_venta">
                <form id="registrarVenta" action="?controller=Venta&action=registrar" method="POST">
                    <div id="cabecera_venta">
                        <div id="datos_factura">
                            <img id="logo_tienda" src="<?php echo $config->get("rootHTTP") . $config->get("assetsFolder") ?>icono_tienda.png"/>
                            <label id='nombre_tienda'>FUXIA</label>
                            <div id="numero_factura">
                                <label>FACTURA No. </label><label id="num"></label><br>
                                <input id="fecha_factura" type="dateme" name="VEN_Fecha_Venta" readonly/>
                            </div>
                        </div>

                        <table>
                            <tr>
                            <input type="hidden" name="PK_PSN_Id" id="PK_PSN_Id"/>
                            <td><label>Identificación</label></td>
                            <td><input type="text" id="PSN_Identificacion" name="PSN_Identificacion" class="inputDatos" disabled/></td>
                            <td><label>Nombre</label></td>
                            <td><input type="text" name="PSN_Nombre" id="PSN_Nombre" class="inputDatos" disabled/></td>
                            <td><label>Apellido</label></td>
                            <td><input type="text" name="PSN_Apellido" id="PSN_Apellido" class="inputDatos" disabled/></td>
                            </tr>
                            <tr>
                                <td><label>Fecha de Nacimiento</label></td>
                                <td><input type="date" name="PSN_Fecha_Nacimiento" id="PSN_Fecha_Nacimiento" disabled/></td>
                                <td><label>Teléfono</label></td>
                                <td><input type="tel" name="PSN_Telefono" id="PSN_Telefono" disabled/></td>
                                <td><label>Vendedor</label></td>
                                <td>
                                    <select name="FK_VEN_Id" id="FK_VEN_Id" disabled>
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
                        <tbody id="productos_ventas">
                            <?php
                            require_once $config->get("rootFolder") . $config->get("viewsFolder") . "private/PartialProductosVenta.php";
                            ?>
                        </tbody>
                    </table>

                    <div id="compra">
                        <label>TOTAL: </label><input type="number" class="inputMedio" id="total_compra" name="total_compra"  readonly/>
                    </div><br>
                </form>
            </div>

            <center><button id="cerrar_factura">CERRAR</button></center>
        </div>
    </div>
    <?php require_once $config->get("rootFolder") . $config->get("viewsFolder") . "template/footer.php"; ?>
</body>
</html>
