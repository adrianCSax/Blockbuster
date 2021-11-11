<?php

function validar (string $campo) : bool {
    return (isset($campo) && !empty($campo));
}

include "vendor/autoload.php";

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST["selectedCliente"])) {
    foreach ($_SESSION['clientes'] as $cliente) {
        if ($cliente->getUsuario() == $_POST["selectedCliente"]) {
            if (validar($_POST["nombre"])) {
                $cliente->setNombre($_POST["nombre"]);
            }
            if (validar($_POST["user"])) {
                $cliente->setUsuario($_POST["user"]);
            }
            if (validar($_POST["password"])) { 
                $cliente->setPassword($_POST["password"]);
            }
            include "mainAdmin.php";
        } 
    }
} else {
    $_SESSION['error'] = "No existe el cliente";
    include "formUpdateCliente.php";
}
