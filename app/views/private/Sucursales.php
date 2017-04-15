<?php
$config = Config::singleton();
$user = AppController::$login;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>.: Sucursales - <?php echo $config->get("nameApp"); ?></title>
        <link rel="icon" type="image" href="<?php echo $config->get("rootHTTP"); ?>assets/icon.png"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/style.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/usuario.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/almacen.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>fonts/style.css"/>
        <script src="<?php echo $config->get("rootHTTP"); ?>js/lib/jquery.js"></script>
        <script src="<?php echo $config->get("rootHTTP"); ?>js/sucursal.js"></script>
    </head>
    <body class="admin">
        <?php require_once $config->get("rootFolder") . $config->get("viewsFolder") . "template/header.php"; ?>
        <div id="contenedor_principal">
            <center><br><h1 class="titulo1">SUCURSALES</h1><br></center>
            <div title="AGREGAR NUEVA SUCURSAL" class="agregar" id="agregar_sucursal">+</div>

            <?php
            foreach ($sucursales as $s) {
                $s instanceof Sucursal;
                $nit_corto = substr($s->getSUC_Nit(), 0, 13);
                $nombre_corto = substr($s->getSUC_Nombre(), 0, 16);

                echo "<div class='item_menu'>"
                . "<div id='imagen_item'>"
                . "<img src='{$config->get('rootHTTP')}assets/icon_sucursal.png?>'/>"
                . "</div>"
                . "<table>"
                . "<tr>"
                . "<td><label>Nit.</label></td>"
                . "<td><label>{$nit_corto}</label></td>"
                . "</tr>"
                . "<tr>"
                . "<td><label>Nom.</label></td>"
                . "<td><label>{$nombre_corto}</label></td>"
                . "</tr>"
                . "</table>"
                . "<button class='botton_ver' id='{$s->getSUC_Id()}'>VER</button>"
                . "</div>";
            }
            ?>
            <!-- onclick={$c}location.href = '?controller=Sucursal&action=formEditar&id={$s->getSUC_Id()}'{$c} -->
        </div>
        
        <!-- FORMULARIO REGISTRAR SUCURSAL -->
        <div id="div_agregar_sucursal" class="oculto">
            <div class="div_datos sucursal">
                <form id="form_agregar_sucursal" action="?controller=Sucursal&action=registrar" method="POST">
                    <h3>AGREGAR SUCURSAL</h3>
                    <div id='imagen_item'>
                        <img src='<?php $config->get('rootHTTP') ?>assets/icon_sucursal.png'/>
                    </div>
                    <table>
                        <tr>
                            <td><label>NIT: </label></td>
                            <td><input type="text" name="SUC_Nit" id="SUC_Nit"/></td>
                        </tr>
                        <tr>
                            <td><label>Nombre: </label></td>
                            <td><input type="text" name="SUC_Nombre" id="SUC_Nombre"/></td>
                        </tr>
                        <tr>
                            <td><label>Dirección: </label></td>
                            <td><input type="text" name="SUC_Direccion" id="SUC_Direccion"/></td>
                        </tr>
                        <tr>
                            <td><label>Teléfono: </label></td>
                            <td><input type="text" name="SUC_Telefono" id="SUC_Telefono"/></td>
                        </tr>
                    </table>
                </form>
                <div id="botones_guardar">
                    <button id="botton_guardar">Guardar</button>
                    <button class="x">x</button>
                </div>
            </div>
        </div>
        <!-- FIN FORMULARIO REGISTRAR SUCURSAL -->

        <!-- FORMULARIO EDITAR SUCURSAL -->
        <div id="div_editar_sucursal" class="oculto">
            <div class="div_datos sucursal">

                <form id="form_editar_sucursal" action="?controller=Sucursal&action=editar" method="POST">
                    <h3>SUCURSAL</h3>
                    <div id='imagen_item'>
                        <img src='<?php $config->get('rootHTTP') ?>assets/icon_sucursal.png'/>
                    </div>
                    
                    <input type="hidden" name="SUC_Id" id="SUC_Id_Editar"/>
                    <table id="datos_sucursal">
                        <tr>
                            <td><label>NIT: </label></td>
                            <td><input type="text" name="SUC_Nit" id="SUC_Nit_Editar"disabled/></td>
                        </tr>
                        <tr>
                            <td><label>Nombre: </label></td>
                            <td><input type="text" name="SUC_Nombre" id="SUC_Nombre_Editar" disabled/></td>
                        </tr>
                        <tr>
                            <td><label>Dirección: </label></td>
                            <td><input type="text" name="SUC_Direccion" id="SUC_Direccion_Editar" disabled/></td>
                        </tr>
                        <tr>
                            <td><label>Teléfono: </label></td>
                            <td><input type="text" name="SUC_Telefono" id="SUC_Telefono_Editar" disabled/></td>
                        </tr>
                    </table>
                </form>
                <div id="botones_guardar">
                    <button id="botton_editar">Editar</button>
                    <button id="botton_guardar_edicion" class="oculto">Guardar</button>
                    <button id="botton_eliminar" class="oculto">Eliminar</button>
                    <button class="x">x</button>
                </div>
            </div>
        </div>
        <!-- FIN FORMULARIO EDITAR SUCURSAL -->
        
        <?php require_once $config->get("rootFolder") . $config->get("viewsFolder") . "template/footer.php"; ?>
    </body>
</html>


