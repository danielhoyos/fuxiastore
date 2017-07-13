$(function () {
    $("#agregar_producto").click(function () {
        $("#div_agregar_producto").removeClass("oculto");
    });

    $(".x").click(function () {
        $("#div_agregar_producto").addClass("oculto");
        $("#div_editar_producto").addClass("oculto");
    });

    $("#botton_guardar").click(function () {
        $("#PRO_Nombre").removeClass("error_data");
        $("#PRO_Precio_Compra").removeClass("error_data");
        $("#PRO_Precio_Venta").removeClass("error_data");
        $("#FK_CAT_Id").removeClass("error_data");
        $("#FK_SUC_Id").removeClass("error_data");

        var correcto = true;

        if ($("#PRO_Nombre").val() === "") {
            $("#PRO_Nombre").addClass("error_data");
            correcto = false;
        }
        if ($("#PRO_Precio_Compra").val() === "") {
            $("#PRO_Precio_Compra").addClass("error_data");
            correcto = false;
        }
        if ($("#PRO_Precio_Venta").val() === "") {
            $("#PRO_Precio_Venta").addClass("error_data");
            correcto = false;
        }

        if (correcto === true) {
            $("#form_agregar_producto").submit();
        }
    });

    $(".editar_producto").click(function (e) {
        $("#div_editar_producto").removeClass("oculto");

        var id = e.target.id;
        var obj = new Object();
        obj.PRO_Id = id;
        $.ajax({
            url: "?controller=Producto&action=productoPorId",
            method: "POST",
            data: obj,
            dataType: "json",
            success: function (r) {
                $("#PRO_Id_Editar").val(id);
                $("#PRO_Nombre_Editar").val(r.data.PRO_Nombre);
                $("#PRO_Talla_Editar").val(r.data.PRO_Talla);
                $("#PRO_Precio_Compra_Editar").val(r.data.PRO_Precio_Compra);
                $("#PRO_Precio_Venta_Editar").val(r.data.PRO_Precio_Venta);
                $("#FK_MAR_Id_Editar").val(r.data.FK_MAR_Id);
                $("#FK_CAT_Id_Editar").val(r.data.FK_CAT_Id);
                $("#FK_SUC_Id_Editar").val(r.data.FK_SUC_Id);
                $("#PRO_Estado_Editar").val(r.data.PRO_Estado);
                $("#PRO_Fecha_Ingreso").val(r.data.PRO_Fecha_Ingreso);
                
                console.log(r.data);
            },
            error: function (e, f) {
            }
        });
    });

    $("#botton_editar").click(function () {
        $("#PRO_Nombre_Editar").prop("disabled",false);
        $("#PRO_Talla_Editar").prop("disabled",false);
        $("#PRO_Precio_Compra_Editar").prop("disabled",false);
        $("#PRO_Precio_Venta_Editar").prop("disabled",false);
        $("#FK_CAT_Id_Editar").prop("disabled",false);
        $("#FK_MAR_Id_Editar").prop("disabled",false);
        $("#FK_SUC_Id_Editar").prop("disabled",false);
        
        if($("#PRO_Estado_Editar").val() !== "separado"){
            $("#PRO_Estado_Editar").prop("disabled",false);
        }
        $("#botton_editar").addClass("oculto");
        $("#botton_guardar_edicion").removeClass("oculto");
        $("#botton_eliminar").removeClass("oculto");
    });
    
    $("#botton_guardar_edicion").click(function(){
        $("#PRO_Nombre_Editar").removeClass("error_data");
        $("#PRO_Precio_Compra_Editar").removeClass("error_data");
        $("#PRO_Precio_Venta_Editar").removeClass("error_data");

        var correcto = true;

        if ($("#PRO_Nombre_Editar").val() === "") {
            $("#PRO_Nombre_Editar").addClass("error_data");
            correcto = false;
        }
        if ($("#PRO_Precio_Compra_Editar").val() === "") {
            $("#PRO_Precio_Compra_Editar").addClass("error_data");
            correcto = false;
        }
        if ($("#PRO_Precio_Venta_Editar").val() === "") {
            $("#PRO_Precio_Venta_Editar").addClass("error_data");
            correcto = false;
        }

        if (correcto === true) {
            $("#form_editar_producto").submit();
        }
    });
    
    $("#botton_eliminar").click(function () {
        var obj = new Object();
        obj.PRO_Id = $("#PRO_Id_Editar").val();
        $.ajax({
            url: "?controller=Producto&action=eliminar",
            method: "POST",
            data: obj,
            dataType: "json",
            success: function (r) {
                location.reload();
            },
            error: function (e, f) {
            }
        });
    });
});