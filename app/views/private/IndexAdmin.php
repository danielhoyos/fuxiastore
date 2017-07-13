<?php
$config = Config::singleton();
$user = AppController::$login;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>.: <?php echo $user->PSN_Nombre ?> - <?php echo $config->get("nameApp"); ?></title>
        <link rel="icon" type="image" href="<?php echo $config->get("rootHTTP"); ?>assets/icon.png"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/style.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/usuario.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>fonts/style.css"/>
        <script src="<?php echo $config->get("rootHTTP"); ?>js/lib/jquery.js"></script>
        <script src="<?php echo $config->get("rootHTTP"); ?>js/usuario.js"></script>
    </head>
    <body class="admin">

        <?php require_once $config->get("rootFolder") . $config->get("viewsFolder") . "template/header.php"; ?>
        <div id="contenedor_principal">
            <?php
            $c = '"';
            $contador = 0;

            $menu = [
                "PERFIL" => "?action=perfil",
                "SUCURSALES" => "?controller=Sucursal&action=sucursales",
                "VENDEDORES" => "?controller=Vendedor&action=vendedores",
                "CATEGORIAS" => "?controller=Categoria&action=categorias",
                "PROVEEDORES" => "?controller=Proveedor&action=proveedores",
                "MARCAS" => "?controller=Marca&action=marcas",
                "PRODUCTOS" => "?controller=Producto&action=productos",
                "VENTA" => "?controller=Venta&action=ventas",
                "SEPARADOS" => "?controller=Separado&action=separados",
                "CONTABILIDAD" => "?controller=Contabilidad&action=contabilidad",
            ];

            foreach ($menu as $key => $value) {
                $contador += 1;

                echo "<div class='item_menu centrar' onclick={$c}location.href = '{$value}'{$c}>"
                . "<div id='imagen_item'>"
                . "<img src='{$config->get('rootHTTP')}assets/items/icon{$contador}.png?>'/>"
                . "</div>"
                . "<h3>{$key}</h3>"
                . "</div>";
            }
            ?>
        </div>
        <?php require_once $config->get("rootFolder") . $config->get("viewsFolder") . "template/footer.php"; ?>
    </body>
</html>


