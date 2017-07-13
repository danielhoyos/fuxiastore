<?php
$config = Config::singleton();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Tienda de Ropa</title>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/style.css"/>
        <link rel="stylesheet" href="<?php echo $config->get("rootHTTP"); ?>css/usuario.css"/>
        <script src="<?php echo $config->get("rootHTTP"); ?>js/lib/jquery.js"></script>
        <script src="<?php echo $config->get("rootHTTP"); ?>js/usuario.js"></script>
    </head>
    <body class="home">
        <div class="login">
            <h1>Login</h1>
            <form action="?controller=Auth&action=validarAdministrador" method="post" id="form_login">
                <input type="text" name="USR_Usuario" id="USR_Usuario" placeholder="Usuario">
                <input type="password" name="USR_Password" id="USR_Password" placeholder="Contraseña">

                <div id="mensaje_error">
                    <div id="imagen_error" class="aling"></div>
                    <div id="texto_error" class="aling">
                        <?php
                        if ($_REQUEST["status"] == 201) {
                            echo "<script language='javascript'> document.getElementById('mensaje_error').style.display='block'; </script>";
                            echo $_REQUEST["msg"];
                        }
                        ?>
                    </div>
                </div>
            </form>
            <button type="submit" id="validarAdministrador">Ingresar</button>
        </div>
    </body>
</html>
