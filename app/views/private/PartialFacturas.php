<html>
    <head>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/style.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/usuario.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/almacen.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>fonts/style.css"/>
        <script src="<?php echo $config->get("rootHTTP"); ?>js/lib/jquery.js"></script>
        <script src="<?php echo $config->get("rootHTTP"); ?>js/contabilidad.js"></script>
    </head>
    <body>
        <table id="tabla_facturas">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>IDENTIFICACIÓN</th>
                    <th>NOMBRE</th>
                    <th>VALOR</th>
                    <th>FECHA</th>
                    <th>VENDEDOR</th>
                    <th>DATOS</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($facturas as $f) {
                    $f instanceof Venta;

                    foreach ($vendedores as $v) {
                        $v instanceof Persona;
                        $selected = "";
                        if ($v->getPK_PSN_Id() === $f->getVEN_VEND_Id())
                            $vendedor = $v->getPSN_Nombre() . " " . $v->getPSN_Apellido();
                    }

                    echo " <tr>"
                    . " <td>{$f->getVEN_Id()}</td>"
                    . " <td>{$f->PSN_Identificacion}</td>"
                    . " <td>{$f->PSN_Nombre} {$f->PSN_Apellido}</td>"
                    . "<td>{$f->getVEN_Total()}</td>"
                    . "<td>{$f->getVEN_Fecha_Venta()}</td>"
                    . "<td>{$vendedor}</td>"
                    . "<td><button class='ver_factura' id='{$f->getVEN_Id()}'>VER</button></td>"
                    . "</tr>";
                }
                ?>
            </tbody>
        </table>
    </body>   
</html>


