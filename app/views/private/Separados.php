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
        <script src="<?php echo $config->get("rootHTTP"); ?>js/separado.js"></script>
    </head>
    <body class="admin">
        <?php require_once $config->get("rootFolder") . $config->get("viewsFolder") . "template/header.php"; ?>
        <div id="contenedor_principal">
            <center><br><h1 class="titulo1">SEPARADOS</h1><br></center>

            <div id="separados">
                <form id="registrarSeparado" action="?controller=Separado&action=registrar" method="POST">
                    <h4>Datos del Cliente</h4><br>
                    <table>
                        <tr>
                        <input type="hidden" name="PK_PSN_Id" id="PK_PSN_Id"/>
                        <td><label>Identificación</label></td>
                        <td><input type="text" id="PSN_Identificacion" name="PSN_Identificacion"/></td>
                        <td><label>Nombre</label></td>
                        <td><input type="text" name="PSN_Nombre" id="PSN_Nombre"/></td>
                        <td><label>Apellido</label></td>
                        <td><input type="text" name="PSN_Apellido" id="PSN_Apellido"/></td>
                        </tr>
                        <tr>
                            <td><label>Fecha de Nacimiento</label></td>
                            <td><input type="date" name="PSN_Fecha_Nacimiento" id="PSN_Fecha_Nacimiento"/></td>
                            <td><label>Teléfono</label></td>
                            <td><input type="tel" name="PSN_Telefono" id="PSN_Telefono"/></td>
                        </tr>
                    </table>

                    <br><br><h4>Datos del Producto</h4><br>
                    <table>
                        <tr>
                            <td><label>Codigo</label></td>
                            <td><input type="text" class="inputCorto" name="codigo_producto" id="codigo_producto"/></td>
                            <td><label>Nombre</label></td>
                            <td><input type="text" name="nombre_producto" id="nombre_producto" disabled/></td>
                            <td><label>Talla</label></td>
                            <td><input type="text" class="inputCorto" name="talla_producto" id="talla_producto"/></td>
                            <td><label>Total</label></td>
                            <td><input type="number" class="inputCorto"  name="valor_producto" id="valor_producto"/></td>
                        </tr>
                        <tr>
                            <td><label>Abono</label></td>
                            <td><input type="text" class="inputCorto" name="SEP_Valor" id="SEP_Valor"/></td>
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
                    </table>

                </form>
                <button class="separarProducto">SEPARAR</button>
            </div>
            <br><br><br>
            <input class="buscarSeparadoIdentificacion" type="number" placeholder="Numero de Identificación" name="separado_identificacion_buscar" id="separado_identificacion_buscar"/>
            <input class="buscarSeparadoInicio" type="date" name="separado_inicio_buscar" id="separado_inicio_buscar"/>
            <input class="buscarSeparadoFin" type="date" name="separado_fin_buscar" id="separado_fin_buscar"/>
            <div class="icon_buscar_separado"><span class="icon-search"></span></div>
            <div id="tabla_separados">
                <?php
                require_once "{$config->get("rootFolder")}{$config->get("viewsFolder")}private/PartialSeparados.php";
                ?>
            </div>
        </div>
        <?php require_once $config->get("rootFolder") . $config->get("viewsFolder") . "template/footer.php"; ?>
    </body>
</html>

