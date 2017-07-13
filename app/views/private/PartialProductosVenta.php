<?php
if (isset($productos)) {
    foreach ($productos as $p) {
        $p instanceof Producto;
        ?>
        <tr>
            <td><input type="number" class="inputCorto codigo_producto" value="<?php echo $p->getPRO_Id(); ?>" readonly/></td>
            <td><input type="text" class="inputLargo" value="<?php echo $p->PRO_Nombre; ?>" readonly/></td>
            <td><input type="text" class="inputCorto" value="<?php echo $p->PRO_Talla; ?>" readonly/></td>
            <td><input type="number"  class="inputMedio" value="<?php echo $p->PRO_Precio_Venta; ?>" class="subtotal" readonly/></td>
        </tr>
        <?php
    }
}