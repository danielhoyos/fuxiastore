<?php
$config = Config::singleton();
$user = AppController::$login;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>.: Categorias - <?php echo $config->get("nameApp"); ?></title>
        <link rel="icon" type="image" href="<?php echo $config->get("rootHTTP"); ?>assets/icon.png"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/style.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/usuario.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/almacen.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>fonts/style.css"/>
        <script src="<?php echo $config->get("rootHTTP"); ?>js/lib/jquery.js"></script>
        <script src="<?php echo $config->get("rootHTTP"); ?>js/categorias.js"></script>
    </head>
    <body class="admin">
        <?php require_once $config->get("rootFolder") . $config->get("viewsFolder") . "template/header.php"; ?>
        <div id="contenedor_principal">
            <center><br><h1 class="titulo1">CATEGORIAS DE ROPA</h1><br></center>
            <div title="AGREGAR NUEVA CATEGORIA" class="agregar" id="agregar_categoria">+</div>
             <?php
            foreach ($categorias as $c) {
                $c instanceof Categoria;
                $nombre_corto = substr($c->getCAT_Nombre(), 0, 8);
                
                echo "<div class='item_menu'>"
                . "<div id='imagen_item'>"
                . "<img src='{$config->get('rootHTTP')}assets/icon_categorias.png?>'/>"
                . "</div>"
                . "<table>"
                . "<tr>"
                . "<td><label>Cod: </label></td>"
                . "<td><label>{$c->getCAT_Id()}</label></td>"
                . "</tr>"
                . "<tr>"
                . "<td><label>Categoria: </label></td>"
                . "<td><label>{$nombre_corto}</label></td>"
                . "</tr>"
                . "</table>"
                . "<button class='botton_ver' id='{$c->getCAT_Id()}'>VER</button>"
                . "</div>";
            }
            ?>
        </div>
        
        <!-- FORMULARIO REGISTRAR CATEGORIA -->
        <div id="div_agregar_categoria" class="oculto">
            <div class="div_datos sucursal">
                <form id="form_agregar_categoria" action="?controller=Categoria&action=registrar" method="POST">
                    <h3>AGREGAR CATEGORIA</h3>
                    <div id='imagen_item'>
                        <img src='<?php $config->get('rootHTTP') ?>assets/icon_categorias.png'/>
                    </div>
                    <table>
                        <tr>
                            <td><label>Nombre: </label></td>
                            <td><input type="text" name="CAT_Nombre" id="CAT_Nombre"/></td>
                        </tr>
                    </table>
                </form>
                <div id="botones_guardar">
                    <button id="botton_guardar">Guardar</button>
                    <button class="x">x</button>
                </div>
            </div>
        </div>
        <!-- FIN FORMULARIO REGISTRAR CATEGORIA -->
        
        <!-- FORMULARIO EDITAR CATEGORIA -->
        <div id="div_editar_categoria" class="oculto">
            <div class="div_datos sucursal">
                <form id="form_editar_categoria" action="?controller=Categoria&action=editar" method="POST">
                    <h3>CATEGORIA</h3>
                    <div id='imagen_item'>
                        <img src='<?php $config->get('rootHTTP') ?>assets/icon_categorias.png'/>
                    </div>
                    <input type="hidden" name="CAT_Id_Editar" id="CAT_Id_Editar"/>
                    <table>
                        <tr>
                            <td><label>Nombre: </label></td>
                            <td><input type="text" name="CAT_Nombre_Editar" id="CAT_Nombre_Editar" disabled/></td>
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
        <!-- FIN FORMULARIO EDITAR CATEGORIA -->
        
        <?php require_once $config->get("rootFolder") . $config->get("viewsFolder") . "template/footer.php"; ?>
    </body>
</html>


