<?php
     if (count($facturas) > 0) {
         ?>
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
                     $valor = number_format($f->getVEN_Total());

                     echo " <tr>"
                     . " <td>{$f->getVEN_Id()}</td>"
                     . " <td>{$f->PSN_Identificacion}</td>"
                     . " <td>{$f->PSN_Nombre} {$f->PSN_Apellido}</td>"
                     . "<td> $ {$valor}</td>"
                     . "<td>{$f->getVEN_Fecha_Venta()}</td>"
                     . "<td>{$vendedor}</td>"
                     . "<td><button class='ver_factura' id='{$f->getVEN_Id()}'>VER</button></td>"
                     . "</tr>";
                 }
                 ?>
             </tbody>
         </table><br><br>
         <?php
         if (isset($cantFac) && $cantFac > 50) {
             $prev;
             $next;

             $dataPag = "<div class='paginacion'>";
             $dataPag .= "<a class='button-opc-pag' href='?controller=Contabilidad&action={$_REQUEST["action"]}'>INICIO</a>";
             $numPag = ceil($cantFac / 50);
             $pag = isset($_REQUEST["pag"]) ? $_REQUEST["pag"] : 1;
             $prev = isset($_REQUEST["pag"]) ? $_REQUEST["pag"] - 1 : 0;

             $dataPag.= $prev > 0 ? "<a class='button-opc-pag' href='?controller=Contabilidad&action={$_REQUEST["action"]}&pag={$prev}'><</a>" : "";

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
                 $dataPag .= "<a class='{$class}' href='?controller=Contabilidad&action={$_REQUEST["action"]}&pag={$i}'>{$i}</a>";
             }
             $next = isset($_REQUEST["pag"]) ? $_REQUEST["pag"] + 1 : 2;
             $dataPag.= $next <= $numPag ? "<a class='button-opc-pag' href='?controller=Contabilidad&action={$_REQUEST["action"]}&pag={$next}'>></a>" : "";
             $dataPag.= "<a class='button-opc-pag' href='?controller=Contabilidad&action={$_REQUEST["action"]}&pag={$numPag}'>FIN</a>";
             $dataPag.= "</div>";
             echo $dataPag;
         }
     } else {
         ?>
         <center><h2>NO SE ENCONTRARON FACTURAS</h2></center>
         <?php
     }
?>
<script src="<?php echo $config->get("rootHTTP"); ?>js/lib/jquery.js"></script>
<script src="<?php echo $config->get("rootHTTP"); ?>js/contabilidad.js"></script>