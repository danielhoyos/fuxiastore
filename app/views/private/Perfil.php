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
            <div class="col col1">
                <div class="icon_Col">
                    <img src="<?php echo $config->get("rootHTTP") . $config->get("assetsFolder") . "datospersona.png"; ?>"/>
                </div>
                <h3 class="titulo_Col">DATOS PERSONALES</h3>
                <form id="form_editar" action="?controller=Usuario&action=editarUsuario" method="POST">
                    <table>

                        <tr>
                            <td><label>Tipo de Identificación:</label></td>
                            <td>
                                <select name="PSN_Id_Tipo_Identificacion" id="PSN_Id_Tipo_Identificacion" disabled="disabled">
                                    <?php
                                    foreach ($tiposIdentificacion as $ti) {
                                        $ti instanceof TipoIdentificacion;
                                        $class = "";

                                        if ($ti->getTI_id() == $user->PSN_Id_Tipo_Identificacion) {
                                            $class = "selected";
                                        }

                                        echo "<option {$class} value='{$ti->getTI_id()}'>{$ti->getTI_nombre()}</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label>Identificación:</label></td>
                            <td><input type="text" name="PSN_Identificacion" id="PSN_Identificacion" value="<?php echo $user->PSN_Identificacion ?>" disabled="disabled"/></td>
                        </tr>
                        <tr>
                            <td><label>Nombre (s):</label></td>
                            <td><input type="text" name="PSN_Nombre" id="PSN_Nombre" value="<?php echo $user->PSN_Nombre ?>" disabled="disabled"/></td>
                        </tr>
                        <tr>
                            <td><label>Apellido (s):</label></td>
                            <td><input type="text" name="PSN_Apellido" id="PSN_Apellido" value="<?php echo $user->PSN_Apellido ?>" disabled="disabled"/></td>
                        </tr>
                        <tr>
                            <td><label>Fecha de Nacimiento:</label></td>
                            <td><input type="date" name="PSN_Fecha_Nacimiento" id="PSN_Fecha_Nacimiento" value="<?php echo $user->PSN_Fecha_Nacimiento ?>" disabled="disabled"/></td>
                        </tr>
                        <tr>
                            <td><label>Teléfono (s):</label></td>
                            <td><input type="text" name="PSN_Telefono" id="PSN_Telefono" value="<?php echo $user->PSN_Telefono ?>" disabled="disabled"/></td>
                        </tr>
                    </table>
            </div>
            
            <div class="col col2">
                <div class="icon_Col">
                    <img src="<?php echo $config->get("rootHTTP") . $config->get("assetsFolder") . "datoscuenta.png"; ?>"/>
                </div>
                <h3 class="titulo_Col">DATOS DE CUENTA</h3>
                <table>
                    <tr>
                        <td><label>Usuario:</label></td>
                        <td><input type="text" name="USR_Usuario" id="USR_Usuario" value="<?php echo $user->USR_Usuario ?>" disabled="disabled"/></td>
                    </tr>
                    <tr>
                        <td><label>Contraseña:</label></td>
                        <td><input type="password" name="USR_Password" id="USR_Password" value="<?php echo $user->USR_Password ?>" disabled="disabled"/><a href="?action=formEditarPassword" id="icon_editar_Password" title="Editar Contraseña"><span class="icon-pencil"></span></a>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Tipo de Usuario:</label></td>
                        <td><input type="text" name="PSN_Id_Tipo_Identificacion" id="PSN_Id_Tipo_Identificacion" value="Administrador (a)" disabled="disabled"/></td>
                    </tr>
                    <tr>
                        <td><label>Fecha de Modificación:</label></td>
                        <td><input type="text" name="USR_Fecha_Modificacion" id="USR_Fecha_Modificacion" value="<?php echo $user->USR_Fecha_Modificacion ?>" disabled="disabled"/></td>
                    </tr>
                </table>
                </form>
                <div id="botones_crud">
                    <button id="botton_editar">Editar</button>
                    <button class="botton_oculto" id="botton_guardar">Guardar</button>
                    <button class="botton_oculto" id="botton_cancelar">Cancelar</button>
                </div>
            </div>
        </div>

        <?php require_once $config->get("rootFolder") . $config->get("viewsFolder") . "template/footer.php"; ?>

    </body>
</html>
