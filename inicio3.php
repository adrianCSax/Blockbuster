<?php
if (!isset($_SESSION)) {
    session_start();
}
// No incluimos nada más

use Dwes\ProyectoVideoClub\Util\VideoClubException;
use Dwes\ProyectoVideoClub\VideoClub;
include_once "vendor/autoload.php";




$vc = new Videoclub("Severo 8A");

//voy a incluir unos cuantos soportes de prueba 
$vc->incluirJuego("God of War", 19.99, "PS4", 1, 1)->incluirJuego("The Last of Us Part II", 49.99, "PS4", 1, 1)->incluirDvd("Torrente", 4.5, "es", "16:9")->incluirDvd("Origen", 4.5, "es,en,fr", "16:9")->incluirDvd("El Imperio Contraataca", 3, "es,en", "16:9")->incluirCintaVideo("Los cazafantasmas", 3.5, 107)->incluirCintaVideo("El nombre de la Rosa", 1.5, 140);
$vc->incluirJuego("Smash Bros", 59.95, "SW",1,4);
//listo los productos 
/* $vc->listarProductos();
 */
//voy a crear algunos socios 


if (isset($_SESSION["clientes"])) {
    $vc->setSocios($_SESSION["clientes"]);
} else {
    $vc->incluirSocio("Amancio Ortega", "amancio", "amancio")->incluirSocio("Pablo Picasso", "picasso", "picasso", 2);
    $vc->incluirSocio("Cliente Feliz", "usuario", "usuario");
    $vc->getSocios()[0]->devolver(1);
    $vc->getSocios()[0]->alquilar($vc->getProductos()[0]); 
    $vc->alquilaSocioProducto("0", "7");
    $vc->alquilaSocioProducto("0", "8");
    $vc->alquilaSocioProducto("1", "7");
    $vc->alquilarSocioProductos("0", [7,0]);
    // echo "<pre>";
    // echo print_r($vc->getProductos());
    // echo "</pre>";
    $_SESSION["clientes"] = $vc->getSocios();
}


// try {
//     $vc->alquilaSocioProducto(1, 2)->alquilaSocioProducto(1, 3)->alquilaSocioProducto(1, 2)->alquilaSocioProducto(1, 6);
// } catch (VideoClubException $e) {
//     echo "Se ha producido un error: " . $e->getMessage();
// }

//listo los socios 
// $vc->listarSocios();
