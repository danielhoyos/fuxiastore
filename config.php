<?php
date_default_timezone_set('America/Bogota');
setlocale(LC_MONETARY, 'es_CO');
$config = Config::singleton();
$config instanceof Config;

$folderApp = "FuxiaJeans";
$config->set("dbhost","localhost");
$config->set("dbname","BDS_Tienda_De_Ropa");
$config->set("dbuser","root");
$config->set("dbpass","");
$config->set("folderApp",$folderApp);
$config->set("nameApp","Fuxia Store - Tienda de Ropa Popayán");
$config->set("rootFolder",$_SERVER["DOCUMENT_ROOT"]."/{$folderApp}/");
$config->set("controllersFolder","app/controllers/" );
$config->set("modelsFolder","app/models/" );
$config->set("entitiesFolder","app/entities/" );
$config->set("viewsFolder","app/views/" );
$config->set("classFolder","app/class_/" );
$config->set("assetsFolder","assets/" );
$config->set("facturasFolder","facturas/" );
$config->set("rootHTTP","http://{$_SERVER['HTTP_HOST']}/{$folderApp}/");
?>