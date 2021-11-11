<?php
    // Recuperamos la información de la sesión

use Dwes\ProyectoVideoClub\VideoClub;

if(!isset($_SESSION)) {
        session_start();
    }
    //echo var_dump($_SESSION["usuario"]);


    // Y comprobamos que el usuario se haya autentificado
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] != "admin") {
        die("<span style='font-size: 1.5em'>Error - debe <a href='index.php'>identificarse</a>.<br /> Vete de aquí,</span> <p><b style='font-size: 6em '>🤡¡PAYASO!🤡</b></p>");
    }
    include "inicio3.php";   

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de productos</title>
</head>
<body>
    <h1>Bienvenido <?= $_SESSION['usuario'] ?></h1>
    <p>Pulse <a href="logout.php">aquí</a> para salir</p>
    <p><a href="formCreateCliente.php">Formulario creación de cliente</a></p>
    <p><a href="formCreateCliente.php">Formulario creación de cliente</a></p>

    <?php $vc->listarSocios(); echo "<br>"; $vc->listarProductos() ?>
</body>
</html>