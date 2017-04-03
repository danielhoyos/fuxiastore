$(function () {
    $("#PSN_Identificacion").change(function () {
        var identificacion = $("#PSN_Identificacion").val();
        $("#PSN_Nombre").val("");
        $("#PSN_Apellido").val("");
        $("#PSN_Fecha_Nacimiento").val("");
        $("#PSN_Telefono").val("");
        $("#PSN_Nombre").prop('readonly', false);
        $("#PSN_Apellido").prop('readonly', false);
        $("#PSN_Fecha_Nacimiento").prop('readonly', false);
        $("#PSN_Telefono").prop('readonly', false);

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

    $("#codigo_producto").change(function () {
        var obj = new Object();
        obj.PRO_Id = $("#codigo_producto").val();
        $.ajax({
            url: "?controller=Producto&action=productoPorId",
            method: "POST",
            data: obj,
            dataType: "json",
            success: function (r) {
                if (r.status === 200) {
                    if (r.data.PRO_Estado === "disponible") {
                        $("#codigo_producto").removeClass("error_data");
                        $("#nombre_producto").val(r.data.PRO_Nombre);
                        $("#talla_producto").val(r.data.PRO_Talla);
                        $("#valor_producto").val(r.data.PRO_Precio_Venta);
                    } else {
                        $("#codigo_producto").addClass("error_data");
                    }
                } else {
                    $("#codigo_producto").addClass("error_data");
                }
            }
        });
    });

    $(".separarProducto").click(function () {
        $("#registrarSeparado").submit();
    });

    $(".ver_separado").click(function (e) {
        $("#div_abonar_separado").removeClass("oculto");
        $(".x").click(function () {
            $("#div_abonar_separado").addClass("oculto");
        });

        var obj = new Object();
        obj.SEP_Id = e.target.id;
        $.ajax({
            url: "?controller=Separado&action=SeparadoPorId",
            method: "POST",
            data: obj,
            dataType: "json",
            success: function (r) {
                console.log(r);
                if (r.status === 200) {
                    $("#SEP_Id_Buscar").val(r.data.SEP_Id);
                    $("#codigo_producto_buscar").val(r.data.PRO_Id);
                    $("#nombre_producto_buscar").val(r.data.PRO_Nombre);
                    $("#valor_producto_buscar").val(r.data.PRO_Precio_Venta);
                    $("#valor_separado_buscar").val(r.data.SEP_Valor);

                    if (r.data.SEP_Estado === "retirado") {
                        $(".retirar").hide();
                        $("#botton_abonar").addClass("oculto");
                        $("#botton_guardar_edicion").addClass("oculto");
                        $("#botton_eliminar").addClass("oculto");
                    } else {
                        $(".retirar").show();
                        $("#botton_abonar").removeClass("oculto");

                        $("#valor_saldo_buscar").val(parseInt($("#valor_producto_buscar").val() - $("#valor_separado_buscar").val()));

                        $("#botton_abonar").click(function () {
                            $("#botton_abonar").addClass("oculto");
                            $("#botton_guardar_edicion").removeClass("oculto");
                            $("#botton_eliminar").removeClass("oculto");

                            $("#abonar_separado").prop("disabled", false);
                        });

                        var abonar = true;

                        $("#abonar_separado").change(function () {
                            $("#abonar_separado").removeClass("error_data");


                            if (parseInt($("#abonar_separado").val()) > parseInt($("#valor_saldo_buscar").val())) {
                                $("#abonar_separado").addClass("error_data");
                                abonar = false;
                            } else
                                abonar = true;
                        });

                        $("#botton_guardar_edicion").click(function () {
                            if (abonar && $("#abonar_separado").val() !== "")
                                $("#form_abonar_separado").submit();
                            else {
                                $("#abonar_separado").addClass("error_data");
                                abonar = false;
                            }
                        });
                    }
                } else {
                    $("#codigo_producto").addClass("error_data");
                }
            }
        });
    });

    $(".icon_buscar_separado").click(function () {
        $fechainicio = $("#separado_inicio_buscar").val();
        $fechafin = $("#separado_fin_buscar").val();
        loadSeparadosPorFecha($fechainicio, $fechafin);
    });

    $(".buscarSeparadoIdentificacion").change(function () {
        var obj = new Object();
        obj.SEP_Identificacion = $("#separado_identificacion_buscar").val();
        
        $.ajax({
            url: "?controller=Separado&action=separadoIdentificacion",
            method: "POST",
            data: obj,
            dataType: "html",
            success: function (data) {
                $("#tabla_separados").html(data);

                $(".ver_separado").click(function (e) {
                    $("#div_abonar_separado").removeClass("oculto");
                    $(".x").click(function () {
                        $("#div_abonar_separado").addClass("oculto");
                    });

                    var obj = new Object();
                    obj.SEP_Id = e.target.id;
                    $.ajax({
                        url: "?controller=Separado&action=SeparadoPorId",
                        method: "POST",
                        data: obj,
                        dataType: "json",
                        success: function (r) {
                            console.log(r);
                            if (r.status === 200) {
                                $("#SEP_Id_Buscar").val(r.data.SEP_Id);
                                $("#codigo_producto_buscar").val(r.data.PRO_Id);
                                $("#nombre_producto_buscar").val(r.data.PRO_Nombre);
                                $("#valor_producto_buscar").val(r.data.PRO_Precio_Venta);
                                $("#valor_separado_buscar").val(r.data.SEP_Valor);

                                if (r.data.SEP_Estado === "retirado") {
                                    $(".retirar").hide();
                                    $("#botton_abonar").addClass("oculto");
                                    $("#botton_guardar_edicion").addClass("oculto");
                                    $("#botton_eliminar").addClass("oculto");
                                } else {
                                    $(".retirar").show();
                                    $("#botton_abonar").removeClass("oculto");

                                    $("#valor_saldo_buscar").val(parseInt($("#valor_producto_buscar").val() - $("#valor_separado_buscar").val()));

                                    $("#botton_abonar").click(function () {
                                        $("#botton_abonar").addClass("oculto");
                                        $("#botton_guardar_edicion").removeClass("oculto");
                                        $("#botton_eliminar").removeClass("oculto");

                                        $("#abonar_separado").prop("disabled", false);
                                    });

                                    var abonar = true;

                                    $("#abonar_separado").change(function () {
                                        $("#abonar_separado").removeClass("error_data");


                                        if (parseInt($("#abonar_separado").val()) > parseInt($("#valor_saldo_buscar").val())) {
                                            $("#abonar_separado").addClass("error_data");
                                            abonar = false;
                                        } else
                                            abonar = true;
                                    });

                                    $("#botton_guardar_edicion").click(function () {
                                        if (abonar && $("#abonar_separado").val() !== "")
                                            $("#form_abonar_separado").submit();
                                        else {
                                            $("#abonar_separado").addClass("error_data");
                                            abonar = false;
                                        }
                                    });
                                }
                            } else {
                                $("#codigo_producto").addClass("error_data");
                            }
                        }
                    });
                });
            }
        });
    });
});


function loadSeparadosPorFecha(fechainicio, fechafin) {
    var obj = new Object();
    obj.Fecha_Inicio = fechainicio;
    obj.Fecha_Fin = fechafin;

    $.ajax({
        url: "?controller=Separado&action=separadosFecha",
        data: obj,
        method: "post",
        dataType: "html",
        success: function (data) {
            console.log(data);
            $("#tabla_separados").html(data);

            $(".ver_separado").click(function (e) {
                $("#div_abonar_separado").removeClass("oculto");
                $(".x").click(function () {
                    $("#div_abonar_separado").addClass("oculto");
                });

                var obj = new Object();
                obj.SEP_Id = e.target.id;
                $.ajax({
                    url: "?controller=Separado&action=SeparadoPorId",
                    method: "POST",
                    data: obj,
                    dataType: "json",
                    success: function (r) {
                        console.log(r);
                        if (r.status === 200) {
                            $("#SEP_Id_Buscar").val(r.data.SEP_Id);
                            $("#codigo_producto_buscar").val(r.data.PRO_Id);
                            $("#nombre_producto_buscar").val(r.data.PRO_Nombre);
                            $("#valor_producto_buscar").val(r.data.PRO_Precio_Venta);
                            $("#valor_separado_buscar").val(r.data.SEP_Valor);

                            if (r.data.SEP_Estado === "retirado") {
                                $(".retirar").hide();
                                $("#botton_abonar").addClass("oculto");
                                $("#botton_guardar_edicion").addClass("oculto");
                                $("#botton_eliminar").addClass("oculto");
                            } else {
                                $(".retirar").show();
                                $("#botton_abonar").removeClass("oculto");

                                $("#valor_saldo_buscar").val(parseInt($("#valor_producto_buscar").val() - $("#valor_separado_buscar").val()));

                                $("#botton_abonar").click(function () {
                                    $("#botton_abonar").addClass("oculto");
                                    $("#botton_guardar_edicion").removeClass("oculto");
                                    $("#botton_eliminar").removeClass("oculto");

                                    $("#abonar_separado").prop("disabled", false);
                                });

                                var abonar = true;

                                $("#abonar_separado").change(function () {
                                    $("#abonar_separado").removeClass("error_data");


                                    if (parseInt($("#abonar_separado").val()) > parseInt($("#valor_saldo_buscar").val())) {
                                        $("#abonar_separado").addClass("error_data");
                                        abonar = false;
                                    } else
                                        abonar = true;
                                });

                                $("#botton_guardar_edicion").click(function () {
                                    if (abonar && $("#abonar_separado").val() !== "")
                                        $("#form_abonar_separado").submit();
                                    else {
                                        $("#abonar_separado").addClass("error_data");
                                        abonar = false;
                                    }
                                });
                            }
                        } else {
                            $("#codigo_producto").addClass("error_data");
                        }
                    }
                });
            });
        }
    });
}

