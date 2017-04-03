$(function () {
    $(".ver_factura").click(function (e) {
        $("#div_ver_factura").removeClass("oculto");

        var id = e.target.id;
        var obj = new Object();
        obj.VEN_Id = id;

        $.ajax({
            url: "?controller=Venta&action=ventasById",
            method: "POST",
            data: obj,
            dataType: "json",
            success: function (r) {
                $("#PSN_Identificacion").val(r.data.PSN_Identificacion);
                $("#PSN_Nombre").val(r.data.PSN_Nombre);
                $("#PSN_Apellido").val(r.data.PSN_Apellido);
                $("#PSN_Fecha_Nacimiento").val(r.data.PSN_Fecha_Nacimiento);
                $("#PSN_Telefono").val(r.data.PSN_Telefono);
                $("#FK_VEN_Id").val(r.data.VEN_VEND_Id);

                $("#num").html(id);
                $("#fecha_factura").val(r.data.VEN_Fecha_Venta);
                $("#total_compra").val(r.data.VEN_Total);

                $.ajax({
                    url: "?controller=Venta&action=productosVenta",
                    method: "POST",
                    data: obj,
                    dateType: "html",
                    success: function (data) {
                        $("#productos_ventas").html(data);
                    }
                });
            }
        });
    });

    $("#cerrar_factura").click(function () {
        $("#div_ver_factura").addClass("oculto");
    });

    $(".icon_buscar_factura").click(function () {

        $fechainicio = $("#facturas_inicio_buscar").val();
        $fechafin = $("#facturas_fin_buscar").val();
        loadFacturasPorFecha($fechainicio, $fechafin);
    });

    $(".buscarVentaIdentificacion").change(function () {
        var obj = new Object();
        obj.VEN_Identificacion = $("#venta_identificacion_buscar").val();

        $.ajax({
            url: "?controller=Venta&action=facturasIdentificacion",
            data: obj,
            method: "post",
            dataType: "html",
            success: function (data) {
                $(".tablaFacturas").html(data);
            }
        });
    });
});

function loadFacturasPorFecha(fechainicio, fechafin) {
    var obj = new Object();
    obj.Fecha_Inicio = fechainicio;
    obj.Fecha_Fin = fechafin;

    $.ajax({
        url: "?controller=Venta&action=facturasFecha",
        data: obj,
        method: "post",
        dataType: "html",
        success: function (data) {
            $(".tablaFacturas").html(data);
        }
    });
}