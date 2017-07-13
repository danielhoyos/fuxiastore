<?php
$config = Config::singleton();
$user = AppController::$login;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>.: Notificaciones - <?php echo $config->get("nameApp"); ?></title>
        <link rel="icon" type="image" href="<?php echo $config->get("rootHTTP"); ?>assets/icon.png"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/style.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/usuario.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/almacen.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>fonts/style.css"/>
        <script src="<?php echo $config->get("rootHTTP"); ?>js/lib/jquery.js"></script>
        <script src="<?php echo $config->get("rootHTTP"); ?>js/notificaciones.js"></script>
    </head>
    <body class="admin">
        <?php require_once $config->get("rootFolder") . $config->get("viewsFolder") . "template/header.php"; ?>
        <div id="contenedor_principal">
            <center><br><h1 class="titulo1">NOTIFICACIONES</h1><br></center><br><br><br>
            <div id="estadoNotificaciones">
                <a id="productos30" class="activo">PRODUCTOS(+30 DIAS)</a>
                <a id="productos15">PRODUCTOS(+15 DIAS)</a>
                <a id="cumpleanios">CUMPLEAÑOS</a>
            </div>
            <table class="tablasProductos" id="tablaProductos30">
                <thead>
                    <tr>
                        <th>COD.</th>
                        <th>NOMBRE</th>
                        <th>TALLA</th>
                        <th>VALOR VENTA</th>
                        <th>MARCA</th>
                        <th>CATEGORIA</th>
                        <th>ALMACÉN</th>
                        <th>DESCRIPCIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($productos as $p) {
                        $p instanceof Producto;
                        $dias = (strtotime(date("Y-m-d")) - strtotime($p->getPRO_Fecha_Ingreso())) / 86400;

                        if ($dias > 30) {
                            ?>
                            <tr>
                                <td><?php echo $p->getPRO_Id() ?></td>
                                <td><?php echo $p->getPRO_Nombre() ?></td>
                                <td><?php echo $p->getPRO_Talla() ?></td>
                                <td><?php echo $p->getPRO_Precio_Venta() ?></td>
                                <td>
                                    <?php
                                    foreach ($marcas as $m) {
                                        $m instanceof Marca;
                                        if ($m->getMar_id() == $p->getFK_MAR_Id()) {
                                            echo $m->getMar_nombre();
                                            break;
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    foreach ($categorias as $c) {
                                        $c instanceof Categoria;
                                        if ($c->getCAT_Id() == $p->getFK_CAT_Id()) {
                                            echo $c->getCAT_Nombre();
                                            break;
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    foreach ($sucursales as $s) {
                                        $s instanceof Sucursal;
                                        if ($s->getSUC_Id() == $p->getFK_SUC_Id()) {
                                            echo $s->getSUC_Nombre();
                                            break;
                                        }
                                    }
                                    ?>
                                </td>
                                <td><?php echo "El Producto lleva {$dias} dias registrado actividad" ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>

            <table class="tablasProductos oculto" id="tablaProductos15">
                <thead>
                    <tr>
                        <th>COD.</th>
                        <th>NOMBRE</th>
                        <th>TALLA</th>
                        <th>VALOR VENTA</th>
                        <th>MARCA</th>
                        <th>CATEGORIA</th>
                        <th>ALMACÉN</th>
                        <th>DESCRIPCIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($productos as $p) {
                        $p instanceof Producto;
                        $dias = (strtotime(date("Y-m-d")) - strtotime($p->getPRO_Fecha_Ingreso())) / 86400;

                        if ($dias > 15 && $dias <= 30) {
                            ?>
                            <tr>
                                <td><?php echo $p->getPRO_Id() ?></td>
                                <td><?php echo $p->getPRO_Nombre() ?></td>
                                <td><?php echo $p->getPRO_Talla() ?></td>
                                <td><?php echo $p->getPRO_Precio_Venta() ?></td>
                                <td>
                                    <?php
                                    foreach ($marcas as $m) {
                                        $m instanceof Marca;
                                        if ($m->getMar_id() == $p->getFK_MAR_Id()) {
                                            echo $m->getMar_nombre();
                                            break;
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    foreach ($categorias as $c) {
                                        $c instanceof Categoria;
                                        if ($c->getCAT_Id() == $p->getFK_CAT_Id()) {
                                            echo $c->getCAT_Nombre();
                                            break;
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    foreach ($sucursales as $s) {
                                        $s instanceof Sucursal;
                                        if ($s->getSUC_Id() == $p->getFK_SUC_Id()) {
                                            echo $s->getSUC_Nombre();
                                            break;
                                        }
                                    }
                                    ?>
                                </td>
                                <td><?php echo "El Producto lleva {$dias} dias registrado sin actividad." ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>

            <table class="tablasProductos oculto" id="tablaCumpleanios">
                <thead>
                    <tr>
                        <th>IDENTIFICACIÓN</th>
                        <th>NOMBRES</th>
                        <th>TELÉFONO</th>
                        <th>FECHA NACIMIENTO</th>
                        <th>DESCRIPCIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($clientes as $c) {
                        $c instanceof Persona;
                        ?>
                        <tr>
                            <td><?php echo $c->getPSN_Identificacion() ?></td>
                            <td><?php echo $c->getPSN_Nombre() . " " . $c->getPSN_Apellido() ?></td>
                            <td><?php echo $c->getPSN_Telefono() ?></td>
                            <td><?php echo $c->getPSN_Fecha_Nacimiento() ?></td>
                            <td>!!! Hoy esta de Cumpleaños ¡¡¡</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php require_once $config->get("rootFolder") . $config->get("viewsFolder") . "template/footer.php"; ?>
    </body>
</html>

