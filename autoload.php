<?php
spl_autoload_register( function( $nombreClase ) {

    $directorio = $nombreClase.'.php';
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $directorio);
    include_once $file;
} );