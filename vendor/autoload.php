<?php
spl_autoload_register( function( $nombreClase ) {
    //Sustituimos las barras
    $ruta = "app/".$nombreClase.".php";
    $ruta = str_replace("\\", "/", $ruta);
    include_once $ruta;
} );
