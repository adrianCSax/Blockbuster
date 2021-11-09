<?php

if (!isset($_SESSION)) {
    session_start();
}

// Y comprobamos que el usuario se haya autentificado
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] != "admin") {
    die("<span style='font-size: 1.5em'>Error - debe <a href='index.php'>identificarse</a>.<br /> Vete de aquí,</span> <p><b style='font-size: 6em '>🤡¡PAYASO!🤡</b></p>");
}

$error = "";
if (isset($_SESSION["error"])) {
    $error = $_SESSION["error"];
}

?>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario creación de cliente</title>
    <style>
        * {
            margin: .5em 0 0 .5em;
        }

        label,
        input {
            display: block;
        }

        label {
            margin-top: 1em;
        }

        input[type="radio"],
        input[type="checkbox"] {
            display: inline;
            margin-right: .5em;
        }
    </style>
</head>

<body>
    <h1>CREACIÓN DE CLIENTE</h1>
    <p><?=$error?></p>
    <form action="createCliente.php" method="post">
        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" id="nombre" required>
        <label for="email">Usuario: </label>
        <input type="text" name="user" id="user" required>
        <label for="password">Contraseña: </label>
        <input type="password" name="password" id="password" required>
        <input type="submit" value="Crear usuario">
    </form>
</body>

</html>