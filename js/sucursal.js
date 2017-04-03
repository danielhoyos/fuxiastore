$(function () {
    $("#agregar_sucursal").click(function () {
        $("#div_agregar_sucursal").removeClass("oculto");
    });
    
    $(".x").click(function () {
        $("#div_agregar_sucursal").addClass("oculto");
        $("#div_editar_sucursal").addClass("oculto");
    });
    
    $("#botton_guardar").click(function () {
        $("#SUC_Nit").removeClass("error_data");
        $("#SUC_Nombre").removeClass("error_data");
        $("#SUC_Direccion").removeClass("error_data");
        $("#SUC_Telefono").removeClass("error_data");
        var correcto = true;
        if ($("#SUC_Nit").val() === "") {
            $("#SUC_Nit").addClass("error_data");
            correcto = false;
        }
        if ($("#SUC_Nombre").val() === "") {
            $("#SUC_Nombre").addClass("error_data");
            correcto = false;
        }
        if ($("#SUC_Direccion").val() === "") {
            $("#SUC_Direccion").addClass("error_data");
            correcto = false;
        }
        if ($("#SUC_Telefono").val() === "") {
            $("#SUC_Telefono").addClass("error_data");
            correcto = false;
        }

        if (correcto === true) {
            $("#form_agregar_sucursal").submit();
        }
    });
    
    $(".botton_ver").click(function (e) {
        $("#div_editar_sucursal").removeClass("oculto");
        var id = e.target.id;
        var obj = new Object();
        obj.SUC_Id = id;
        $.ajax({
            url: "?controller=Sucursal&action=sucursalesPorId",
            method: "POST",
            data: obj,
            dataType: "json",
            success: function (r) {
                $("#SUC_Id_Editar").val(id);
                $("#SUC_Nit_Editar").val(r.data.SUC_Nit);
                $("#SUC_Nombre_Editar").val(r.data.SUC_Nombre);
                $("#SUC_Direccion_Editar").val(r.data.SUC_Direccion);
                $("#SUC_Telefono_Editar").val(r.data.SUC_Telefono);
            },
            error: function (e, f) {
            }
        });
    });
    
    $("#botton_editar").click(function () {
        $("#SUC_Nit_Editar").prop("disabled",false);
        $("#SUC_Nombre_Editar").prop("disabled",false);
        $("#SUC_Direccion_Editar").prop("disabled",false);
        $("#SUC_Telefono_Editar").prop("disabled",false);
        
        $("#botton_editar").addClass("oculto");
        $("#botton_guardar_edicion").removeClass("oculto");
        $("#botton_eliminar").removeClass("oculto");
    });
    
    $("#botton_guardar_edicion").click(function () {
        $("#SUC_Nit_Editar").removeClass("error_data");
        $("#SUC_Nombre_Editar").removeClass("error_data");
        $("#SUC_Direccion_Editar").removeClass("error_data");
        $("#SUC_Telefono_Editar").removeClass("error_data");
        
        var correcto = true;
        if ($("#SUC_Nit_Editar").val() === "") {
            $("#SUC_Nit_Editar").addClass("error_data");
            correcto = false;
        }
        if ($("#SUC_Nombre_Editar").val() === "") {
            $("#SUC_Nombre_Editar").addClass("error_data");
            correcto = false;
        }
        if ($("#SUC_Direccion_Editar").val() === "") {
            $("#SUC_Direccion_Editar").addClass("error_data");
            correcto = false;
        }
        if ($("#SUC_Telefono_Editar").val() === "") {
            $("#SUC_Telefono_Editar").addClass("error_data");
            correcto = false;
        }

        if (correcto === true) {
            $("#form_editar_sucursal").submit();
        }
    });
    
    $("#botton_eliminar").click(function () {
        var obj = new Object();
        obj.SUC_Id = $("#SUC_Id_Editar").val();
        $.ajax({
            url: "?controller=Sucursal&action=eliminar",
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