<?php
$config = Config::singleton();
$user = AppController::$login;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>.: Vendedores - <?php echo $config->get("nameApp"); ?></title>
        <link rel="icon" type="image" href="<?php echo $config->get("rootHTTP"); ?>assets/icon.png"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/style.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/usuario.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/almacen.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>fonts/style.css"/>
        <script src="<?php echo $config->get("rootHTTP"); ?>js/lib/jquery.js"></script>
        <script src="<?php echo $config->get("rootHTTP"); ?>js/vendedor.js"></script>
    </head>
    <body class="admin">
        <?php require_once $config->get("rootFolder") . $config->get("viewsFolder") . "template/header.php"; ?>
        <div id="contenedor_principal">
            <center><br><h1 class="titulo1">VENDEDORES</h1><br></center>
            <div title="AGREGAR VENDEDOR (A)" class="agregar" id="agregar_vendedor">+</div>

            <?php
            foreach ($vendedores as $v) {
                $v instanceof Persona;
                $nombre = $v->getPSN_Nombre() . " " . $v->getPSN_Apellido();
                $nombre_corto = substr($nombre, 0, 14);

                echo "<div class='item_menu'>"
                . "<div id='imagen_item'>"
                . "<img src='{$config->get('rootHTTP')}assets/icon_vendedor.png?>'/>"
                . "</div>"
                . "<center><label>Iden.</label>"
                . "<label>{$v->getPSN_Identificacion()}</label></center>"
                . "<center><label>Nom.</label>"
                . "<label>{$nombre_corto}</label></center>"
                . "<button class='botton_ver' id='{$v->getPK_PSN_Id()}'>VER</button>"
                . "</div>";
            }
            ?>
        </div>

        <!-- FORMULARIO REGISTRAR VENDEDOR -->
        <div id="div_agregar_vendedor" class="oculto">
            <div class="div_datos vendedor">
                <form id="form_agregar_vendedor" action="?controller=Vendedor&action=registrar" method="POST">
                    <h3>AGREGAR VENDEDOR</h3>
                    <div id='imagen_item'>
                        <img src='<?php $config->get('rootHTTP') ?>assets/icon_vendedor.png'/>
                    </div>
                    <table>
                        <tr>
                            <td><label>Tipo de Identificación: </label></td>
                            <td>
                                <select name="PSN_Id_Tipo_Identificacion" id="PSN_Id_Tipo_Identificacion" >
                                    <?php
                                    foreach ($tipos as $ti) {
                                        $ti instanceof TipoIdentificacion;
                                        echo "<option value='{$ti->getTI_id()}'>{$ti->getTI_nombre()}</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label>Identificación:</label></td>
                            <td><input type="text" name="PSN_Identificacion" id="PSN_Identificacion"/></td>
                        </tr>
                        <tr>
                            <td><label>Nombre (s):</label></td>
                            <td><input type="text" name="PSN_Nombre" id="PSN_Nombre"/></td>
                        </tr>
                        <tr>
                            <td><label>Apellido (s):</label></td>
                            <td><input type="text" name="PSN_Apellido" id="PSN_Apellido"/></td>
                        </tr>
                        <tr>
                            <td><label>Teléfono (s):</label></td>
                            <td><input type="text" name="PSN_Telefono" id="PSN_Telefono" /></td>
                        </tr>
                    </table>
                </form>
                <div id="botones_guardar">
                    <button id="botton_guardar">Guardar</button>
                    <button class="x">x</button>
                </div>
            </div>
        </div>
        <!-- FIN FORMULARIO REGISTRAR VENDEDOR -->

        <!-- FORMULARIO EDITAR VENDEDOR -->
        <div id="div_editar_vendedor" class="oculto">
            <div class="div_datos vendedor">

                <form id="form_editar_vendedor" action="?controller=Vendedor&action=editar" method="POST">
                    <h3>VENDEDOR</h3>
                    <div id='imagen_item'>
                        <img src='<?php $config->get('rootHTTP') ?>assets/icon_vendedor.png'/>
                    </div>
                    <input type="hidden" name="PK_PSN_Id_Editar" id="PK_PSN_Id_Editar"/>
                    <table>
                        <tr>
                            <td><label>Tipo de Identificación: </label></td>
                            <td>
                                <select name="PSN_Id_Tipo_Identificacion_Editar" id="PSN_Id_Tipo_Identificion_Editar" disabled>
                                    <?php
                                    foreach ($tipos as $ti) {
                                        $ti instanceof TipoIdentificacion;
                                        echo "<option value='{$ti->getTI_id()}'>{$ti->getTI_nombre()}</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label>Identificación:</label></td>
                            <td><input type="text" name="PSN_Identificacion_Editar" id="PSN_Identificacion_Editar" disabled/></td>
                        </tr>
                        <tr>
                            <td><label>Nombre (s):</label></td>
                            <td><input type="text" name="PSN_Nombre_Editar" id="PSN_Nombre_Editar" disabled/></td>
                        </tr>
                        <tr>
                            <td><label>Apellido (s):</label></td>
                            <td><input type="text" name="PSN_Apellido_Editar" id="PSN_Apellido_Editar" disabled/></td>
                        </tr>
                        <tr>
                            <td><label>Teléfono (s):</label></td>
                            <td><input type="text" name="PSN_Telefono_Editar" id="PSN_Telefono_Editar" disabled/></td>
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
        <!-- FIN FORMULARIO EDITAR VENDEDOR -->
        
        <?php require_once $config->get("rootFolder") . $config->get("viewsFolder") . "template/footer.php"; ?>
    </body>
</html>


