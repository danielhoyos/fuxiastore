$(function () {
    $("#agregar_categoria").click(function () {
        $("#div_agregar_categoria").removeClass("oculto");
    });

    $(".x").click(function () {
        $("#div_agregar_categoria").addClass("oculto");
        $("#div_editar_categoria").addClass("oculto");
    });

    $("#botton_guardar").click(function () {
        $("#CAT_Nombre").removeClass("error_data");

        var correcto = true;

        if ($("#CAT_Nombre").val() === "") {
            $("#CAT_Nombre").addClass("error_data");
            correcto = false;
        }

        if (correcto) {
            $("#form_agregar_categoria").submit();
        }
    });

    $(".botton_ver").click(function (e) {
        $("#div_editar_categoria").removeClass("oculto");
        var id = e.target.id;
        var obj = new Object();
        obj.CAT_Id = id;
        $.ajax({
            url: "?controller=Categoria&action=categoriasPorId",
            method: "POST",
            data: obj,
            dataType: "json",
            success: function (r) {
                $("#CAT_Id_Editar").val(id);
                $("#CAT_Nombre_Editar").val(r.data.CAT_Nombre);
                console.log(r);
            },
            error: function (e, f) {
            }
        });
    });

    $("#botton_editar").click(function () {
        $("#CAT_Nombre_Editar").prop("disabled", false);

        $("#botton_editar").addClass("oculto");
        $("#botton_guardar_edicion").removeClass("oculto");
        $("#botton_eliminar").removeClass("oculto");
    });

    $("#botton_guardar_edicion").click(function () {
        $("#CAT_Nombre_Editar").removeClass("error_data");

        var correcto = true;

        if ($("#CAT_Nombre_Editar").val() === "") {
            $("#CAT_Nombre_Editar").addClass("error_data");
            correcto = false;
        }
        
        if (correcto === true) {
            $("#form_editar_categoria").submit();
        }
    });
    
    $("#botton_eliminar").click(function () {
        var obj = new Object();
        obj.CAT_Id = $("#CAT_Id_Editar").val();
        $.ajax({
            url: "?controller=Categoria&action=eliminar",
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
