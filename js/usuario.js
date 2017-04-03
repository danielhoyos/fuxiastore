$(function () {

    // Validar Botton Inicio Sesion
    $("#validarAdministrador").click(function () {
        $("#USR_Usuario").removeClass("errorInput");
        $("#USR_Usuario").removeClass("errorInput");
        $("#mensaje_error").hide();

        $correcto = true;

        if ($("#USR_Usuario").val() === "") {
            $("#USR_Usuario").addClass("errorInput");
            $correcto = false;
        }
        if ($("#USR_Password").val() === "") {
            $("#USR_Password").addClass("errorInput");
            $correcto = false;
        }

        if ($correcto === false) {
            $("#texto_error").html("Por favor diligencie todos los Campos para Iniciar Sesión");
            $("#mensaje_error").show();
        } else {
            $("#form_login").submit();
        }
    });
    // Fin Validar Botton Inicio Sesion

    //Validar Editar Avatar

    $("#USR_Avatar").change(function () {
        $("#editarAvatar").submit();
    });

    $("#USR_Portada").change(function () {
        $("#editarPortada").submit();
    });

// Fin Validar Editar Avatar

// Botones del Crud
    $("#botton_editar").click(function () {
        $("#botton_editar").addClass("botton_oculto");
        $("#botton_guardar").removeClass("botton_oculto");
        $("#botton_cancelar").removeClass("botton_oculto");

        $("#PSN_Id_Tipo_Identificacion").prop("disabled", false);
        $("#PSN_Identificacion").prop("disabled", false);
        $("#PSN_Nombre").prop("disabled", false);
        $("#PSN_Apellido").prop("disabled", false);
        $("#PSN_Fecha_Nacimiento").prop("disabled", false);
        $("#PSN_Genero").prop("disabled", false);
        $("#PSN_Direccion").prop("disabled", false);
        $("#PSN_Telefono").prop("disabled", false);
        $("#PSN_Correo").prop("disabled", false);

        $("#USR_Usuario").prop("disabled", false);
    });

    $("#botton_cancelar").click(function () {
        $("#botton_editar").removeClass("botton_oculto");
        $("#botton_guardar").addClass("botton_oculto");
        $("#botton_cancelar").addClass("botton_oculto");

        $("#PSN_Id_Tipo_Identificacion").prop("disabled", true);
        $("#PSN_Identificacion").prop("disabled", true);
        $("#PSN_Nombre").prop("disabled", true);
        $("#PSN_Apellido").prop("disabled", true);
        $("#PSN_Fecha_Nacimiento").prop("disabled", true);
        $("#PSN_Genero").prop("disabled", true);
        $("#PSN_Direccion").prop("disabled", true);
        $("#PSN_Telefono").prop("disabled", true);
        $("#PSN_Correo").prop("disabled", true);

        $("#USR_Usuario").prop("disabled", true);
    });

    $("#botton_guardar").click(function () {
        $("#PSN_Identificacion").removeClass("error_data");
        $("#PSN_Nombre").removeClass("error_data");
        $("#PSN_Apellido").removeClass("error_data");
        $("#PSN_Fecha_Nacimiento").removeClass("error_data");
        $("#PSN_Genero").removeClass("error_data");
        $("#PSN_Direccion").removeClass("error_data");
        $("#PSN_Telefono").removeClass("error_data");
        $("#PSN_Correo").removeClass("error_data");

        $("#USR_Usuario").removeClass("error_data");
        
        
        var correcto = true;
        
        if($("#PSN_Identificacion").val() === ""){
            correcto = false;
            $("#PSN_Identificacion").addClass("error_data");
        }
        if($("#PSN_Nombre").val() === ""){
           correcto = false; 
           $("#PSN_Nombre").addClass("error_data");
        }
        if($("#PSN_Apellido").val() === ""){
           correcto = false; 
           $("#PSN_Apellido").addClass("error_data");
        }
        if($("#PSN_Fecha_Nacimiento").val() === ""){
           correcto = false; 
           $("#PSN_Fecha_Nacimiento").addClass("error_data");
        }
        if($("#PSN_Direccion").val() === ""){
           correcto = false; 
           $("#PSN_Direccion").addClass("error_data");
        }
        if($("#PSN_Telefono").val() === ""){
           correcto = false; 
           $("#PSN_Telefono").addClass("error_data");
        }
        if($("#PSN_Correo").val() === ""){
           correcto = false; 
           $("#PSN_Correo").addClass("error_data");
        }
        if($("#USR_Usuario").val() === ""){
           correcto = false; 
           $("#USR_Usuario").addClass("error_data");
        }
        
        if(correcto === true){
          $("#form_editar").submit();  
        }
    });
// Fin Botones del Crud

// Input de Cambio de Password
    $("#USR_Password").change(function () {
        $("#USR_PasswordNew").prop("disabled", true);
        $("#USR_PasswordConfirmar").prop("disabled", true);

        if ($("#USR_Password").val() !== "") {
            $("#USR_PasswordNew").prop("disabled", false);
            $("#USR_PasswordConfirmar").prop("disabled", false);
        }
    });

    $("#USR_PasswordNew").change(function () {
        $("#USR_PasswordNew").removeClass("correct_data");
        $("#USR_PasswordConfirmar").removeClass("correct_data");
        $("#USR_PasswordNew").removeClass("error_data");
        $("#USR_PasswordConfirmar").removeClass("error_data");
        $("#mensajeAjax").html("");
        $("#mensajeAjax").removeClass("success");
        $("#mensajeAjax").removeClass("error");
        $("#botton_editar_password").prop("disabled", true);

        if (($("#USR_PasswordNew").val() !== "" & $("#USR_PasswordConfirmar").val() !== "") 
                & ($("#USR_PasswordNew").val() === $("#USR_PasswordConfirmar").val())) {
            $("#USR_PasswordNew").addClass("correct_data");
            $("#USR_PasswordConfirmar").addClass("correct_data");
            $("#mensajeAjax").html("Las Contraseñas Coinciden");
            $("#botton_editar_password").prop("disabled", false);
            $("#mensajeAjax").html("Las Contraseñas Coinciden");
            $("#mensajeAjax").addClass("success");
            $("#mensajeAjax").show();

        } else {
            if ($("#USR_PasswordConfirmar").val() !== "") {
                $("#USR_PasswordNew").addClass("error_data");
                $("#USR_PasswordConfirmar").addClass("error_data");
                $("#botton_editar_password").prop("disabled", true);
                $("#mensajeAjax").html("Las Contraseñas No Coinciden");
                $("#mensajeAjax").addClass("error");
                $("#mensajeAjax").show();
            }
        }
    });

    $("#USR_PasswordConfirmar").change(function () {
        $("#USR_PasswordNew").removeClass("correct_data");
        $("#USR_PasswordConfirmar").removeClass("correct_data");
        $("#USR_PasswordNew").removeClass("error_data");
        $("#USR_PasswordConfirmar").removeClass("error_data");
        $("#mensajeAjax").html("");
        $("#mensajeAjax").removeClass("success");
        $("#mensajeAjax").removeClass("error");
        $("#botton_editar_password").prop("disabled", true);

        if (($("#USR_PasswordNew").val() !== "" & $("#USR_PasswordConfirmar").val() !== "")
                & ($("#USR_PasswordConfirmar").val() === $("#USR_PasswordNew").val())) {
            $("#USR_PasswordNew").addClass("correct_data");
            $("#USR_PasswordConfirmar").addClass("correct_data");
            $("#botton_editar_password").prop("disabled", false);
            $("#mensajeAjax").html("Las Contraseñas Coinciden");
            $("#mensajeAjax").addClass("success");
            $("#mensajeAjax").show();

        } else {
            if ($("#USR_PasswordNew").val() !== "") {
                $("#USR_PasswordNew").addClass("error_data");
                $("#USR_PasswordConfirmar").addClass("error_data");
                $("#botton_editar_password").prop("disabled", true);
                $("#mensajeAjax").html("Las Contraseñas No Coinciden");
                $("#mensajeAjax").addClass("error");
                $("#mensajeAjax").show();
            }
        }
    });

    $("#botton_editar_password").click(function () {
        $("#editarPassword").submit();
    });

    $("#botton_volver").click(function () {
        location.replace("?controller=Index&action=perfil");
    });

    // Validar Ocultar/Mostrar Contraseña
    var USR_Password = 0;
    var USR_PasswordNew = 0;
    var USR_PasswordConfirmar = 0;

    $("#ver_USR_Password").click(function () {
        if (USR_Password === 0) {
            USR_Password = 1;
            $('#USR_Password').removeAttr("type", "password");
            $('#USR_Password').prop("type", "text");
            $('#ver_USR_Password').addClass("verPasswordActivo");

        } else {
            USR_Password = 0;
            $('#USR_Password').removeAttr("type", "text");
            $('#USR_Password').prop("type", "password");
            $('#ver_USR_Password').removeClass("verPasswordActivo");
        }
    });

    $("#ver_USR_PasswordNew").click(function () {
        if (USR_PasswordNew === 0) {
            USR_PasswordNew = 1;
            $('#USR_PasswordNew').removeAttr("type", "password");
            $('#USR_PasswordNew').prop("type", "text");
            $('#ver_USR_PasswordNew').addClass("verPasswordActivo");
        } else {
            USR_PasswordNew = 0;
            $('#USR_PasswordNew').removeAttr("type", "text");
            $('#USR_PasswordNew').prop("type", "password");
            $('#ver_USR_PasswordNew').removeClass("verPasswordActivo");
        }
    });

    $("#ver_USR_PasswordConfirmar").click(function () {
        if (USR_PasswordConfirmar === 0) {
            USR_PasswordConfirmar = 1;
            $('#USR_PasswordConfirmar').removeAttr("type", "password");
            $('#USR_PasswordConfirmar').prop("type", "text");
            $('#ver_USR_PasswordConfirmar').addClass("verPasswordActivo");
        } else {
            USR_PasswordConfirmar = 0;
            $('#USR_PasswordConfirmar').removeAttr("type", "text");
            $('#USR_PasswordConfirmar').prop("type", "password");
            $('#ver_USR_PasswordConfirmar').removeClass("verPasswordActivo");
        }
    });

    // Validar Ocultar/Mostrar Contraseña
// Fin Input de Cambio de Password
});



