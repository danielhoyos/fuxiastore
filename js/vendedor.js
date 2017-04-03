/* global SUC_Id */

$(function () {
    $("#agregar_vendedor").click(function () {
        $("#div_agregar_vendedor").removeClass("oculto");
    });
    $(".x").click(function () {
        $("#div_agregar_vendedor").addClass("oculto");
        $("#div_editar_vendedor").addClass("oculto");
    });
    $("#botton_guardar").click(function () {
        $("#PSN_Identificacion").removeClass("error_data");
        $("#PSN_Nombre").removeClass("error_data");
        $("#PSN_Apellido").removeClass("error_data");
        $("#PSN_Fecha_Nacimiento").removeClass("error_data");
        $("#PSN_Telefono").removeClass("error_data");
        
        var correcto = true;
        
        if ($("#PSN_Identificacion").val() === "") {
            correcto = false;
            $("#PSN_Identificacion").addClass("error_data");
        }
        if ($("#PSN_Nombre").val() === "") {
            correcto = false;
            $("#PSN_Nombre").addClass("error_data");
        }
        if ($("#PSN_Apellido").val() === "") {
            correcto = false;
            $("#PSN_Apellido").addClass("error_data");
        }
        if ($("#PSN_Fecha_Nacimiento").val() === "") {
            correcto = false;
            $("#PSN_Fecha_Nacimiento").addClass("error_data");
        }
        if ($("#PSN_Telefono").val() === "") {
            correcto = false;
            $("#PSN_Telefono").addClass("error_data");
        }

        if (correcto === true) {
            $("#form_agregar_vendedor").submit();
        }
    });
    $(".botton_ver").click(function (e) {
        $("#div_editar_vendedor").removeClass("oculto");
        var id = e.target.id;
        var obj = new Object();
        obj.PK_PSN_Id = id;
        $.ajax({url: "?controller=Vendedor&action=vendedorPorId",
            method: "POST",
            data: obj,
            dataType: "json",
            success: function (r) {
                $("#PK_PSN_Id_Editar").val(id);
                $("#PSN_Id_Tipo_Identificacion_Editar").val(r.data.PSN_Id_Tipo_Identificacion);
                $("#PSN_Identificacion_Editar").val(r.data.PSN_Identificacion);
                $("#PSN_Nombre_Editar").val(r.data.PSN_Nombre);
                $("#PSN_Apellido_Editar").val(r.data.PSN_Apellido);
                $("#PSN_Fecha_Nacimiento_Editar").val(r.data.PSN_Fecha_Nacimiento);
                $("#PSN_Telefono_Editar").val(r.data.PSN_Telefono);
                
                console.log(r);

            },
            error: function (e, f) {
            }
        });
    });

    $("#botton_editar").click(function () {
        $("#PSN_Nombre_Editar").prop("disabled", false);
        $("#PSN_Apellido_Editar").prop("disabled", false);
        $("#PSN_Fecha_Nacimiento_Editar").prop("disabled", false);
        $("#PSN_Telefono_Editar").prop("disabled", false);
        $("#botton_editar").addClass("oculto");
        $("#botton_guardar_edicion").removeClass("oculto");
        $("#botton_eliminar").removeClass("oculto");
    });
    $("#botton_guardar_edicion").click(function () {
        $("#PSN_Nombre_Editar").removeClass("error_data");
        $("#PSN_Apellido_Editar").removeClass("error_data");
        $("#PSN_Fecha_Nacimiento_Editar").removeClass("error_data");
        $("#PSN_Telefono_Editar").removeClass("error_data");

        var correcto = true;
        if ($("#PSN_Nombre_Editar").val() === "") {
            $("#PSN_Nombre_Editar").addClass("error_data");
            correcto = false;
        }
        if ($("#PSN_Apellido_Editar").val() === "") {
            $("#PSN_Apellido_Editar").addClass("error_data");
            correcto = false;
        }
        if ($("#PSN_Fecha_Nacimiento_Editar").val() === "") {
            $("#PSN_Fecha_Nacimiento_Editar").addClass("error_data");
            correcto = false;
        }
        if ($("#PSN_Telefono_Editar").val() === "") {
            $("#PSN_Telefono_Editar").addClass("error_data");
            correcto = false;
        }

        if (correcto === true) {
            $("#form_editar_vendedor").submit();
        }
    });
    $("#botton_eliminar").click(function () {
        var obj = new Object();
        obj.PK_PSN_Id = $("#PK_PSN_Id_Editar").val();
        $.ajax({
            url: "?controller=Vendedor&action=eliminar",
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