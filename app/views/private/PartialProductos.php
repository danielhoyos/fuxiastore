<?php
$config = Config::singleton();
$user = AppController::$login;
?>

<html>
    <head>
        <link rel="icon" type="image" href="<?php echo $config->get("rootHTTP"); ?>assets/icon.png"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/style.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/usuario.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/almacen.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>fonts/style.css"/>
        <script src="<?php echo $config->get("rootHTTP"); ?>js/lib/jquery.js"></script>
        <script src="<?php echo $config->get("rootHTTP"); ?>js/productos.js"></script>
    </head>
    <body>
        <table class="tablasProductos">
            <thead>
                <tr>
                    <th>COD.</th>
                    <th>NOMBRE</th>
                    <th>T</th>
                    <th>$ V/C</th>
                    <th>$ V/U.</th>
                    <th>MARCA</th>
                    <th>CATEGORIA</th>
                    <th>ALMACÉN</th>
                    <?php
                    if (!isset($_REQUEST["estado"]) || $_REQUEST["estado"] !== "vendidos") {
                        echo "<th>EDITAR</th>";
                    }
                    ?>

                    <?php
                    if (!isset($_REQUEST["estado"]) || ($_REQUEST["estado"] == "todos")) {
                        echo "<th>ESTADO</th>";
                    }
                    ?>
                    <th>INGRESO</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($productos as $p) {
                    $p instanceof Producto;
                    foreach ($categorias as $c) {
                        $c instanceof Categoria;

                        $categoria = "";
                        if ($c->getCAT_Id() == $p->getFK_CAT_Id()) {
                            $categoria = $c->getCAT_Nombre();
                            break;
                        }
                    }
                    foreach ($sucursales as $s) {
                        $s instanceof Sucursal;

                        $sucursal = "";
                        if ($s->getSUC_Id() == $p->getFK_SUC_Id()) {
                            $sucursal = $s->getSUC_Nombre();
                            break;
                        }
                    }
                    foreach ($marcas as $m) {
                        $m instanceof Marca;

                        $marca = "";
                        if ($m->getMar_id() == $p->getFK_MAR_Id()) {
                            $marca = $m->getMar_nombre();
                            break;
                        }
                    }
                    $datos = "<tr>
                                    <td>{$p->getPRO_Id()}</td>
                                    <td>{$p->getPRO_Nombre()}</td>
                                    <td>{$p->getPRO_Talla()}</td>
                                    <td>$ {$p->getPRO_Precio_Compra()}</td>
                                    <td>$ {$p->getPRO_Precio_Venta()}</td>
                                    <td>{$marca}</td>
                                    <td>{$categoria}</td>
                                    <td>{$sucursal}</td>";
                    if (!isset($_REQUEST["estado"]) || $_REQUEST["estado"] !== "vendidos") {

                        if ($p->getPRO_Estado() == "vendido") {
                            $datos .= "<td><img title='Los Articulos Vendidos No se Pueden Editar' width = 20px heigth = 20px src = '{$config->get("rootHTTP")}{$config->get("assetsFolder")}icon_sold.png'/></td>";
                        } else {
                            $datos .= "<td><img class = 'editar_producto' id = '{$p->getPRO_Id()}' width = 20px heigth = 20px src = '{$config->get("rootHTTP")}{$config->get("assetsFolder")}ver_edit.png'/></td>";
                        }
                    }

                    $estado = strtoupper($p->getPRO_Estado());

                    if (!isset($_REQUEST["estado"]) || ($_REQUEST["estado"] == "todos")) {
                        $datos .= "<td>{$estado}</td>";
                    }
                    $datos.="<td>{$p->getPRO_Fecha_Ingreso()}</td>";
                    $datos .= "</tr>";

                    echo $datos;
                }
                ?>

            </tbody>
        </table>
    </body>
</html>
