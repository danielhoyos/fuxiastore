<?php
$config = Config::singleton();
$user = AppController::$login;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>.: Productos - Tienda de Ropa</title>
        <link rel="icon" type="image" href="<?php echo $config->get("rootHTTP"); ?>assets/icon.png"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/style.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/usuario.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/almacen.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>fonts/style.css"/>
        <script src="<?php echo $config->get("rootHTTP"); ?>js/lib/jquery.js"></script>
        <script src="<?php echo $config->get("rootHTTP"); ?>js/productos.js"></script>
    </head>
    <body class="admin">
        <?php require_once $config->get("rootFolder") . $config->get("viewsFolder") . "template/header.php"; ?>
        <div id="contenedor_principal">
            <center><br><h1 class="titulo1">PRODUCTOS</h1><br></center>

            <div title="AGREGAR NUEVO PRODUCTO" class="agregar" id="agregar_producto">+</div>
            <div id="estadoProducto">
                <a href="?controller=Producto&action=productos&estado=todos">TODOS</a>
                <a href="?controller=Producto&action=productos&estado=disponibles">DISPONIBLES</a>
                <a href="?controller=Producto&action=productos&estado=nodisponibles">NO DISPONIBLES</a>
                <a href="?controller=Producto&action=productos&estado=vendidos">VENDIDOS</a>
            </div>

            <input class="buscarProducto" type="text" name="producto_buscar" id="producto_buscar" placeholder="Código del Producto"/>
            <div class="icon_buscar"><span class="icon-search"></span></div>    
            <div id="contenedor_productos">
                <?php
                require_once "{$config->get("rootFolder")}{$config->get("viewsFolder")}private/PartialProductos.php";
                ?>
            </div>
            <!-- FORMULARIO REGISTRAR PRODUCTO -->
            <div id="div_agregar_producto" class="oculto">
                <div class="div_datos producto">
                    <form id="form_agregar_producto" action="?controller=Producto&action=registrar" method="POST">
                        <h3>AGREGAR PRODUCTO</h3>
                        <div id='imagen_item'>
                            <img src='<?php $config->get('rootHTTP') ?>assets/icon_producto.png'/>
                        </div>
                        <table>
                            <tr>
                                <td><label>Nombre: </label></td>
                                <td><input type="text" name="PRO_Nombre" id="PRO_Nombre"/></td>
                            </tr>
                            <tr>
                                <td><label>Talla: </label></td>
                                <td><select name="PRO_Talla" id="PRO_Talla">
                                        <option value="XS">XS</option>
                                        <option value="S">S</option>
                                        <option value="M">M</option>
                                        <option value="L">L</option>
                                        <option value="XL">XL</option>
                                        <option value="XXL">XXL</option>
                                        <option value="6">6</option>
                                        <option value="8">8</option>
                                        <option value="10">10</option>
                                        <option value="12">12</option>
                                        <option value="14">14</option>
                                        <option value="16">16</option>
                                        <option value="32">32</option>
                                        <option value="33">33</option>
                                        <option value="34">34</option>
                                        <option value="35">35</option>
                                        <option value="36">36</option>
                                        <option value="37">37</option>
                                        <option value="38">38</option>
                                        <option value="39">39</option>
                                        <option value="40">40</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Valor Compra: </label></td>
                                <td><input type="number" name="PRO_Precio_Compra" id="PRO_Precio_Compra"/></td>
                            </tr>
                            <tr>
                                <td><label>Valor Venta: </label></td>
                                <td><input type="number" name="PRO_Precio_Venta" id="PRO_Precio_Venta"/></td>
                            </tr>
                            <tr>
                                <td><label>Categoria: </label></td>
                                <td>
                                    <select name="FK_CAT_Id" id="FK_CAT_Id">
                                        <?php
                                        foreach ($categorias as $c) {
                                            $c instanceof Categoria;
                                            echo "<option value ='{$c->getCAT_Id()}'>{$c->getCAT_Nombre()}</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Marca: </label></td>
                                <td>
                                    <select name="FK_MAR_Id" id="FK_MAR_Id">
                                        <?php
                                        foreach ($marcas as $m) {
                                            $m instanceof Marca;
                                            echo "<option value ='{$m->getMar_id()}'>{$m->getMar_nombre()}</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Sucursal: </label></td>
                                <td>
                                    <select name="FK_SUC_Id" id="FK_SUC_Id">
                                        <?php
                                        foreach ($sucursales as $s) {
                                            $s instanceof Sucursal;
                                            echo "<option value ='{$s->getSUC_Id()}'>{$s->getSUC_Nombre()}</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <div id="botones_guardar">
                        <button id="botton_guardar">Guardar</button>
                        <button class="x">x</button>
                    </div>
                </div>
            </div>
            <!-- FIN FORMULARIO PRODUCTO SUCURSAL -->

            <!-- FORMULARIO EDITAR PRODUCTO -->
            <div id="div_editar_producto" class="oculto">
                <div class="div_datos producto_editar">
                    <form id="form_editar_producto" action="?controller=Producto&action=editar" method="POST">
                        <h3>EDITANDO PRODUCTO</h3>
                        <div id='imagen_item'>
                            <img src='<?php $config->get('rootHTTP') ?>assets/icon_producto.png'/>
                        </div>
                        <input type="hidden" name="PRO_Id_Editar" id="PRO_Id_Editar"/>
                        <table>
                            <tr>
                                <td><label>Nombre: </label></td>
                                <td><input type="text" name="PRO_Nombre_Editar" id="PRO_Nombre_Editar" disabled/></td>
                            </tr>
                            <tr>
                                <td><label>Talla: </label></td>
                                <td><select name="PRO_Talla_Editar" id="PRO_Talla_Editar" disabled>
                                        <option value="XS">XS</option>
                                        <option value="S">S</option>
                                        <option value="M">M</option>
                                        <option value="L">L</option>
                                        <option value="XL">XL</option>
                                        <option value="XXL">XXL</option>
                                        <option value="6">6</option>
                                        <option value="8">8</option>
                                        <option value="10">10</option>
                                        <option value="12">12</option>
                                        <option value="14">14</option>
                                        <option value="16">16</option>
                                        <option value="32">32</option>
                                        <option value="33">33</option>
                                        <option value="34">34</option>
                                        <option value="35">35</option>
                                        <option value="36">36</option>
                                        <option value="37">37</option>
                                        <option value="38">38</option>
                                        <option value="39">39</option>
                                        <option value="40">40</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Valor Compra: </label></td>
                                <td><input type="number" name="PRO_Precio_Compra_Editar" id="PRO_Precio_Compra_Editar" disabled/></td>
                            </tr>
                            <tr>
                                <td><label>Valor Venta: </label></td>
                                <td><input type="number" name="PRO_Precio_Venta_Editar" id="PRO_Precio_Venta_Editar" disabled/></td>
                            </tr>
                            <tr>
                                <td><label>Categoria: </label></td>
                                <td>
                                    <select name="FK_CAT_Id_Editar" id="FK_CAT_Id_Editar" disabled>
                                        <?php
                                        foreach ($categorias as $c) {
                                            $c instanceof Categoria;
                                            echo "<option value = {$c->getCAT_Id()}>{$c->getCAT_Nombre()}</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Marca: </label></td>
                                <td>
                                    <select name="FK_MAR_Id_Editar" id="FK_MAR_Id_Editar" disabled>
                                        <?php
                                        foreach ($marcas as $m) {
                                            $m instanceof Marca;
                                            echo "<option value = {$m->getMar_id()}>{$m->getMar_nombre()}</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Sucursal: </label></td>
                                <td>
                                    <select name="FK_SUC_Id_Editar" id="FK_SUC_Id_Editar" disabled>
                                        <?php
                                        foreach ($sucursales as $s) {
                                            $s instanceof Sucursal;
                                            echo "<option value = {$s->getSUC_Id()}>{$s->getSUC_Nombre()}</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Estado: </label></td>
                                <td>
                                    <select name="PRO_Estado_Editar" id="PRO_Estado_Editar" disabled>
                                        <option value='disponible'>DISPONIBLE</option>
                                        <option value='no disponible'>NO DISPONIBLE</option>
                                        <option value='devolución'>DEVOLUCIÓN</option>
                                        <option value='separado'>SEPARADO</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Fecha Ingreso</label></td>
                                <td><input type="date" name="PRO_Fecha_Ingreso" id="PRO_Fecha_Ingreso" readonly/></td>
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
            <!-- FIN FORMULARIO PRODUCTO SUCURSAL -->
        </div>
        <?php require_once $config->get("rootFolder") . $config->get("viewsFolder") . "template/footer.php"; ?>
    </body>
</html>

