<?php



    // Recuperamos la información de la sesión
    if(!isset($_SESSION)) {
        session_start();
    }

    // Y comprobamos que el usuario se haya autentificado
    if (!isset($_SESSION['usuario']) || $_SESSION["usuario"] == "admin") {
       die("<span style='font-size: 1.5em'>Error - debe <a href='index.php'>identificarse</a>.<br /> Vete de aquí,</span> <p><b style='font-size: 6em '>🤡¡PAYASO!🤡</b></p>");
    }
    include_once "inicio3.php";

    

  /*   if (!isset($_SESSION["clientes"])) {
        $_SESSION["clientes"] = [];
    } else {
        $arrayClientes = $vc->getSocios();
        $_SESSION["clientes"] = $arrayClientes;
    }
 */
    foreach ($vc->getSocios() as $socio) {
        if ($socio->getUsuario() == $_SESSION["usuario"]) {
            $user = $socio;
        }       
    }


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
    <p><a href="formUpdateCliente.php">Formulario de actualización de cliente</a></p>
    <p>Alquileres</p>
    <ul>
        <?php foreach ($user->getAlquileres() as $alquiler) { ?>
           <li> <?php 
            $alquiler->mostrarResumen();?> </li>
        <?php } ?>
    </ul>
</body>
</html>