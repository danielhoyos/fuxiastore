<?php
$config = Config::singleton();
$user = AppController::$login;

$portada = "";

if ($user->USR_Portada !== "") {
    $path = $config->get("rootHTTP") . $config->get("assetsFolder") . "portada/" . $user->USR_Portada;
    $url = get_headers($path);
    $string = $url[0];
    if (strpos($string, "200")) {
        $portada = $path;
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>.: <?php echo $user->PSN_Nombre ?> - <?php echo $config->get("nameApp"); ?></title>
        <link rel="icon" type="image" href="<?php echo $config->get("rootHTTP"); ?>assets/icon.png"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/style.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/usuario.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>fonts/style.css"/>
        <script src="<?php echo $config->get("rootHTTP"); ?>js/lib/jquery.js"></script>
        <script src="<?php echo $config->get("rootHTTP"); ?>js/usuario.js"></script>
    </head>
    <body class="admin">

        <?php require_once $config->get("rootFolder") . $config->get("viewsFolder") . "template/header.php"; ?>

        <div id="contenedor_principal">
            <div class='portada'>
                <img src="<?php echo $portada ?>"/>

                <div id='imgPerfil'>
                    <img src="<?php echo $avatar ?>"/>
                    <h6>ADMINISTRADOR</h6>
                    <h3><?php echo $user->PSN_Nombre ?></h3>
                </div>

                <form id="editarAvatar" action="?controller=Usuario&action=editarAvatar" enctype="multipart/form-data" method="POST">
                    <div class="upload_Img upload_Perfil"><input name="USR_Avatar" type="file" id="USR_Avatar" /></div>
                </form>

                <form id="editarPortada" action="?controller=Usuario&action=editarPortada" enctype="multipart/form-data" method="POST">
                    <div class="upload_Img upload_Portada"><input name="USR_Portada" type="file" id="USR_Portada" /></div>
                </form>
            </div>

            <div class="col">
                <div class="icon_Col">
                    <img src="<?php echo $config->get("rootHTTP") . $config->get("assetsFolder") . "edit_password.png"; ?>"/>
                </div>
                <h3 class="titulo_Col">EDITAR CONTRASEÑA</h3><br>
                <form id="editarPassword" action="?controller=Usuario&action=editarPassword" method="POST">
                    <table>
                        <tr>
                            <td><label>Contraseña Actual:</label></td>
                            <td><input type="password" name="USR_Password" id="USR_Password"/><span class="icon-eye icon_verPassword" id="ver_USR_Password"></span></a></td>
                        </tr>
                        <tr>
                            <td><label>Nueva Contraseña :</label></td>
                            <td><input type="password" name="USR_PasswordNew" id="USR_PasswordNew" disabled="disabled"/><span class="icon-eye icon_verPassword" id="ver_USR_PasswordNew"></span></a></td>
                        </tr>
                        <tr>
                            <td><label>Verificar Contraseña:</label></td>
                            <td><input type="password" name="USR_PasswordConfirmar" id="USR_PasswordConfirmar" disabled="disabled"/><span class="icon-eye icon_verPassword" id="ver_USR_PasswordConfirmar"></span></a></td>
                        </tr>
                    </table>
                    
                </form>
                <div class="mensajeAjax" id="mensajeAjax"></div>
                <br>
                <div id="botones_edit">
                    <button id="botton_editar_password" disabled="disabled">Guardar</button>
                    <button id="botton_volver">Volver</button>
                </div>
            </div>
        </div>

        <?php require_once $config->get("rootFolder") . $config->get("viewsFolder") . "template/footer.php"; ?>

    </body>
</html>

