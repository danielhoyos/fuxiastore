$(function () {

    var i = $("#productos tr").length + 1;
    var f = i - 1;

    $("#agregarProducto").click(function () {

        $("#productos").append("<tr>\n\
                                    <td><input type='number' class='inputCorto codigo_producto' name='codigo[]' id='codigo_producto" + i + "'/></td>\n\
                                    <td><input type='text' class='inputLargo' name='nombre[]' id='nombre_producto" + i + "' readonly/></td>\n\
                                    <td><input type='text' class='inputCorto'  name='talla[]' id='talla_producto" + i + "' readonly/></td>\n\
                                    <td><input type='number'  class='inputMedio'  name='subtotal[]' id='subtotal_producto" + i + "' readonly/></td>\n\
                            </tr>");
        i++;
        f++;
        $("#cantidad_productos").val(f);
    });

    $("#productos").on("change", ".codigo_producto", function () {
        $("#total_compra").val(0);
        organizarProductos();
    });

    function organizarProductos() {
        for (var p = 1; p < f + 1; p++) {
            $("#nombre_producto" + p).val("");
            $("#talla_producto" + p).val("");
            $("#subtotal_producto" + p).val("");
            var encontrado = false;
            
            if (f > 1) {
                for (var c = 1; c < p; c++) {
                    $("#codigo_producto" + p).removeClass("error_data");
                    $("#codigo_producto" + c).removeClass("error_data");
                    if ($("#codigo_producto" + p).val() === $("#codigo_producto" + c).val()) {
                        alert("Producto Ya Esta Facturado");
                        $("#codigo_producto" + p).addClass("error_data");
                        $("#codigo_producto" + c).addClass("error_data");

                        encontrado = true;
                        break;
                    } else {
                        encontrado = false;
                    }
                }
            }

            if (f === 1 || encontrado === false) {
                buscarProducto($("#codigo_producto" + p).val(), p);
            }
        }
    }

    function buscarProducto($id, $num) {

        var obj = new Object();
        obj.PRO_Id = $id;
        $.ajax({
            url: "?controller=Producto&action=productoPorId",
            method: "POST",
            data: obj,
            dataType: "json",
            success: function (r) {
                if (r.status === 200) {
                    if (r.data.PRO_Estado === "disponible") {
                        $("#codigo_producto" + $num).removeClass("error_data");
                        $("#nombre_producto" + $num).val(r.data.PRO_Nombre);
                        $("#talla_producto" + $num).val(r.data.PRO_Talla);
                        $("#subtotal_producto" + $num).val(r.data.PRO_Precio_Venta);
                        $subtotal = $("#subtotal_producto" + $num).val();
                        $total = $("#total_compra").val();
                        $("#total_compra").val(parseInt($total) + parseInt($subtotal));
                    } else {
                        $("#codigo_producto" + $num).addClass("error_data");
                    }
                } else {
                    $("#codigo_producto" + $num).addClass("error_data");
                }
            }
        });
    }

    $(".venderProducto").click(function () {
        $("#PSN_Identificacion").removeClass("error_factura");

        $correcto = true;

        if ($("#PSN_Identificacion").val() === "") {
            $("#PSN_Identificacion").addClass("error_factura");
            $correcto = false;
        }

        if ($("#cantidad_producto1").val() === "") {
            $correcto = false;
        }

        if ($("#codigo_producto1").val() === "") {
            $correcto = false;
        }


        if ($correcto) {
            $("#registrarVenta").submit();
        } else {
            alert("Para Realizar una venta debe registrar por lo menos 1 producto");
        }
    });
    
    $("#PSN_Identificacion").change(function () {
        var identificacion = $("#PSN_Identificacion").val();
        $("#PSN_Nombre").val("");
        $("#PSN_Apellido").val("");
        $("#PSN_Fecha_Nacimiento").val("");
        $("#PSN_Telefono").val("");
        $("#PSN_Nombre").prop("disabled", false);
        $("#PSN_Apellido").prop("disabled", false);
        $("#PSN_Fecha_Nacimiento").prop("disabled", false);
        $("#PSN_Telefono").prop("disabled", false);

        var obj = new Object();
        obj.PSN_Identificacion = identificacion;
        $.ajax({
            url: "?controller=Usuario&action=personaByIdentificacion",
            method: "POST",
            data: obj,
            dataType: "json",
            success: function (r) {
                if (r.status === 200) {
                    $("#PK_PSN_Id").val(r.data.PK_PSN_Id);
                    $("#PSN_Nombre").val(r.data.PSN_Nombre);
                    $("#PSN_Apellido").val(r.data.PSN_Apellido);
                    $("#PSN_Fecha_Nacimiento").val(r.data.PSN_Fecha_Nacimiento);
                    $("#PSN_Telefono").val(r.data.PSN_Telefono);

                    $("#PSN_Nombre").prop('readonly', true);
                    $("#PSN_Apellido").prop('readonly', true);
                    $("#PSN_Fecha_Nacimiento").prop('readonly', true);
                    $("#PSN_Telefono").prop('readonly', true);
                }
            },
            error: function (e, f) {
            }
        });
    });
});

