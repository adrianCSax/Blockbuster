<?php
include "vendor/autoload.php";
// No incluimos nada más

use Dwes\ProyectoVideoClub\Util\VideoClubException;
use Dwes\ProyectoVideoClub\VideoClub;

if (!isset($_SESSION)) {
    session_start();
}

$vc = new Videoclub("Severo 8A");

//voy a incluir unos cuantos soportes de prueba 
$vc->incluirJuego("God of War", 19.99, "PS4", 1, 1)->incluirJuego("The Last of Us Part II", 49.99, "PS4", 1, 1)->incluirDvd("Torrente", 4.5, "es", "16:9")->incluirDvd("Origen", 4.5, "es,en,fr", "16:9")->incluirDvd("El Imperio Contraataca", 3, "es,en", "16:9")->incluirCintaVideo("Los cazafantasmas", 3.5, 107)->incluirCintaVideo("El nombre de la Rosa", 1.5, 140);

//listo los productos 
/* $vc->listarProductos();
 */
//voy a crear algunos socios 
$vc->incluirSocio("Amancio Ortega", "amancio", "amancio")->incluirSocio("Pablo Picasso", "picasso", "picasso", 2);
$vc->incluirSocio("Cliente Feliz", "usuario", "usuario");

if (isset($_SESSION["clientes"])) {
    $cliente = $_SESSION["clientes"];

    foreach ($_SESSION["clientes"] as $cliente) {
        $vc->incluirSocio($cliente->getNombre(), $cliente->getUsuario(), $cliente->getPassword());
    }
}



try {
    $vc->alquilaSocioProducto(1, 2)->alquilaSocioProducto(1, 3)->alquilaSocioProducto(1, 2)->alquilaSocioProducto(1, 6);
} catch (VideoClubException $e) {
    echo "Se ha producido un error: " . $e->getMessage();
}

//listo los socios 
// $vc->listarSocios();
