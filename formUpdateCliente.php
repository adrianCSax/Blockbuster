<?php

include "vendor/autoload.php";

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION["clientes"])) {
    $arrayClientes = $_SESSION["clientes"];
}

$isAdmin = $_SESSION["usuario"] == 'admin';

if (!isset($error)) {
    $error = "";
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
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

<body>
    <h1>ACTUALIZACIÓN DE CLIENTE</h1>
    <p><?= $error ?></p>
    <form action="updateCliente.php" method="post">
        <label for="seleccionCliente">Choose a cliente:</label> <?php 
        if ($isAdmin) { ?>
            <select id="clientes" name="selectedCliente">
                <?php foreach ($arrayClientes as $cliente) { ?>
                    <option value="<?= $cliente->getUsuario(); ?>"><?= $cliente->getNombre(); ?></option>
                <?php } ?>
            </select> <?php 
        } else {
            foreach ($arrayClientes as $cliente) { 
                if ($cliente->getUsuario() == $_SESSION["usuario"]) { ?>
                    <h3><?= $cliente->getUsuario() ?></h3> <?php
                }
            }
        }?>
        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" id="nombre" >
        <label for="user">Usuario: </label>
        <input type="text" name="user" id="user" >
        <label for="password">Contraseña: </label>
        <input type="password" name="password" id="password" >
        <input type="submit" value="Actualizar usuario">
    </form>
</body>

</html>