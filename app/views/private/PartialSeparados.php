<br>
<?php
     if (count($separados) > 0) {
         ?>
         <br><table class="tablasProductos">
             <thead>
                 <tr>
                     <th>IDENTIFICACIÓN</th>
                     <th>NOMBRES</th>
                     <th>CODIGO PROD.</th>
                     <th>NOMBRE PROD.</th>
                     <th>TALLA PROD.</th>
                     <th>VALOR PROD.</th>
                     <th>VALOR SEP.</th>
                     <th>ESTADO SEP.</th>
                     <th>FECHA SEP.</th>
                     <th>OPC</th>
                 </tr>
             </thead>
             <tbody>
                 <?php
                 $separado = "";
                 foreach ($separados as $s) {
                     $s instanceof Separado;
                     $separado.= "<tr>";
                     $separado.= "<td>{$s->PSN_Identificacion}</td>";
                     $separado.= "<td>{$s->PSN_Nombre} {$s->PSN_Apellido}</td>";
                     $separado.= "<td>{$s->PRO_Id}</td>";
                     $separado.= "<td>{$s->PRO_Nombre}</td>";
                     $separado.= "<td>{$s->PRO_Talla}</td>";
                     $separado.= "<td>{$s->PRO_Precio_Venta}</td>";
                     $separado.= "<td>{$s->getSEP_Valor()}</td>";
                     $separado.= "<td>{$s->getSEP_Estado()}</td>";
                     $separado.= "<td>{$s->getSEP_Fecha()}</td>";
                     $separado.= "<td><button class='ver_separado' id='{$s->getSEP_Id()}'><span class='icon-note'></span></button></td>";
                     $separado.= "</tr>";
                 }
                 echo $separado;
                 ?>
             </tbody>
         </table><br><br>
         <?php
         if (isset($cantSep) && $cantSep > 50) {
             $prev;
             $next;
             
             $dataPag = "<div class='paginacion'>";
             $dataPag .= "<a class='button-opc-pag' href='?controller=Separado&action={$_REQUEST["action"]}&pag=1'>INICIO</a>";
             $numPag = ceil($cantSep / 50);
             $pag = isset($_REQUEST["pag"]) ? $_REQUEST["pag"] : 1;

             $prev = isset($_REQUEST["pag"]) ? $_REQUEST["pag"] - 1 : 0;
             $dataPag.= $prev > 0 ? "<a class='button-opc-pag' href='?controller=Separado&action={$_REQUEST["action"]}&pag={$prev}'><</a>" : "";

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
                 $dataPag .= "<a class='{$class}' href='?controller=Separado&action={$_REQUEST["action"]}&pag={$i}'>{$i}</a>";
             }
             $next = isset($_REQUEST["pag"]) ? $_REQUEST["pag"] + 1 : 2;
             $dataPag.= $next <= $numPag ? "<a class='button-opc-pag' href='?controller=Separado&action={$_REQUEST["action"]}&pag={$next}'>></a>" : "";
             $dataPag.= "<a class='button-opc-pag' href='?controller=Separado&action={$_REQUEST["action"]}&pag={$numPag}'>FIN</a>";
             $dataPag.= "</div>";
             echo $dataPag;
         }
     } else {
         ?>
         <br><br><center><h3>NO SE ENCONTRARON SEPARADOS...</h3></center>
         <?php
     }
?>
<!-- FORMULARIO ABONAR SEPARADO -->
<div id="div_abonar_separado" class="oculto">
    <div class="div_datos separado">
        <form id="form_abonar_separado" action="?controller=Separado&action=abonar" method="POST">
            <h3>ABONAR A SEPARADO</h3>
            <div id='imagen_item'>
                <img src='<?php $config->get('rootHTTP') ?>assets/icon_producto.png'/>
            </div>
            <table>
                <input type="hidden" name="SEP_Id_Buscar" id="SEP_Id_Buscar"/>
                <tr>
                    <td><label>Codigo Producto: </label></td>
                    <td><input type="number" name="codigo_producto" id="codigo_producto_buscar" readonly/></td>
                </tr>
                <tr>
                    <td><label>Nombre Producto: </label></td>
                    <td><input type="text" name="nombre_producto" id="nombre_producto_buscar" disabled/></td>
                </tr>
                <tr>
                    <td><label>Valor Producto: </label></td>
                    <td><input type="number" name="valor_producto" id="valor_producto_buscar" readonly/></td>
                </tr>
                <tr>
                    <td><label>Valor Separado: </label></td>
                    <td><input type="number" name="valor_separado" id="valor_separado_buscar" readonly/></td>
                </tr>
                <tr class="retirar">
                    <td><label>Saldo: </label></td>
                    <td><input type="number" name="valor_saldo" id="valor_saldo_buscar" disabled/></td>
                </tr>

                <tr class="retirar">
                    <td><label>Abonar: </label></td>
                    <td><input type="number" name="abonar_separado" id="abonar_separado" disabled/></td>
                </tr>
            </table>
        </form>
        <div id="botones_guardar">
            <button id="botton_abonar">Abonar</button>
            <button id="botton_guardar_edicion" class="oculto">Guardar</button>
            <button id="botton_eliminar" class="oculto">Eliminar</button>
            <button class="x">x</button>
        </div>
    </div>
</div>
<!-- FIN FORMULARIO PRODUCTO SUCURSAL -->