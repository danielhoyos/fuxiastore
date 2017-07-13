<?php
     $pathIcon = $config->get("rootHTTP") . $config->get("assetsFolder") . "user/user.png";

     if ($user->USR_Avatar !== "") {
         $path = $config->get("rootHTTP") . $config->get("assetsFolder") . "user/" . $user->USR_Avatar;
         $url = get_headers($path);
         $string = $url[0];
         if (strpos($string, "200")) {
             $avatar = $path;
         } else {
             $avatar = $pathIcon;
         }
     } else {
         $avatar = $pathIcon;
     }
?>

<header class="header">
    <div id="header_first">
        <div class="header1">
            <img id="logo_tienda" src="<?php echo $config->get("rootHTTP") . $config->get("assetsFolder") ?>icono_tienda.png"/>
            <label id='nombre_tienda'>FUXIA STORE</label>

            <a href="?action=perfil"><img id='avatar' src='<?php echo $path ?>'/></a>
            <label id='nom_user'><?php echo $user->PSN_Nombre . " " . $user->PSN_Apellido ?></label>
        </div>
    </div>
    <div id="header_second">
        <div class="header2">
                <span id="icon_tipos_ropa" class="icon-t-shirt"></span>
                <label id='tipos_ropa'> VESTIDOS - BLUSAS - BLUSONES - CHAQUETAS - PANTALONES - FALDAS - ZAPATOS - SANDALIAS</label>
                <a href="?controller=Auth&action=CerrarSesion" id='exit' title="Cerrar Sesión"><span class="icon-sign-in"></span></a>
                <a href="?action=index" id='home'><span class="icon-home"></span>   HOME</a>
        </div>
    </div>
</header>

