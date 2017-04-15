<?php
     $config = Config::singleton();
     $user = AppController::$login;

     if (count($productos) > 0) {
         ?>
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
                         ?>
                         <th>EDITAR</th>
                         <?php
                     }
                     ?>

                     <?php
                     if (!isset($_REQUEST["estado"]) || ($_REQUEST["estado"] == "todos")) {
                         ?>
                         <th>ESTADO</th>
                         <?php
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
                     $prodCompra = number_format($p->getPRO_Precio_Compra());
                     $prodVenta = number_format($p->getPRO_Precio_Venta());
                     
                     $datos = "<tr>
                                <td>{$p->getPRO_Id()}</td>
                                <td>{$p->getPRO_Nombre()}</td>
                                <td>{$p->getPRO_Talla()}</td>
                                <td>$ {$prodCompra}</td>
                                <td>$ {$prodVenta}</td>
                                <td>{$marca}</td>
                                <td>{$categoria}</td>
                                <td>{$sucursal}</td>";
                     if (!isset($_REQUEST["estado"]) || $_REQUEST["estado"] !== "vendidos") {
                         if ($p->getPRO_Estado() == "vendido") {
                             $datos .= "<td><img title='Los Articulos Vendidos No se Pueden Editar' width=20px heigth=20px src='{$config->get("rootHTTP")}{$config->get("assetsFolder")}icon_sold.png'/></td>";
                         } else {
                             $datos .= "<td><img class='editar_producto' id='{$p->getPRO_Id()}' width=20px heigth=20px src='{$config->get("rootHTTP")}{$config->get("assetsFolder")}ver_edit.png'/></td>";
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
         </table><br><br>
         <?php
         if (isset($cantProd) && $cantProd > 50) {
             $prev;
             $next;
             if (isset($prodBuscar)) {
                 $productoBuscar = "&producto_buscar=" . $prodBuscar;
                 $estado = "";
             } else {
                 $productoBuscar = "";
                 $estado = isset($_REQUEST["estado"]) ? "estado={$_REQUEST["estado"]}" : "estado=todos";
             }
             $dataPag = "<div class='paginacion'>";
             $dataPag .= "<a class='button-opc-pag' href='?controller=Producto&action={$_REQUEST["action"]}&{$estado}&pag=1{$productoBuscar}'>INICIO</a>";
             $numPag = ceil($cantProd / 50);
             $pag = isset($_REQUEST["pag"]) ? $_REQUEST["pag"] : 1;

             $prev = isset($_REQUEST["pag"]) ? $_REQUEST["pag"] - 1 : 0;
             $dataPag.= $prev > 0 ? "<a class='button-opc-pag' href='?controller=Producto&action={$_REQUEST["action"]}&{$estado}&pag={$prev}{$productoBuscar}'><</a>" : "";

             if ($numPag <= 20) {
                 $minPag = 1;
                 $maxPag = $numPag;
             } else {
                 if ($pag <= 10) {
                     $minPag = 1;
                     $maxPag = 20;
                 } else {
                     if ($pag > ($numPag - 10)) {
                         $maxPag = $numPag;
                         $minPag = $numPag - 20;
                     } else {
                         $minPag = $pag - 10;
                         $maxPag = $pag + 10;
                     }
                 }
             }

             for ($i = $minPag; $i <= $maxPag; $i++) {
                 $class = $pag == $i ? "button-pag-select" : "button-num-pag";
                 $dataPag .= "<a class='{$class}' href='?controller=Producto&action={$_REQUEST["action"]}&{$estado}&pag={$i}{$productoBuscar}'>{$i}</a>";
             }
             $next = isset($_REQUEST["pag"]) ? $_REQUEST["pag"] + 1 : 2;
             $dataPag.= $next <= $numPag ? "<a class='button-opc-pag' href='?controller=Producto&action={$_REQUEST["action"]}&{$estado}&pag={$next}{$productoBuscar}'>></a>" : "";
             $dataPag.= "<a class='button-opc-pag' href='?controller=Producto&action={$_REQUEST["action"]}&{$estado}&pag={$numPag}{$productoBuscar}'>FIN</a>";
             $dataPag.= "</div>";
             echo $dataPag;
         }
     } else {
         ?>
         <center><h3>NO SE ENCONTRARON PRODUCTOS...</h3></center>
         <?php
     }
?>