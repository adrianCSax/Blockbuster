<?php

function validar (string $campo) : bool {
    return (isset($campo) && !empty($campo));
}


include "vendor/autoload.php";

if (!isset($_SESSION)) {
    session_start();
}

function error () {
    $_SESSION['error'] = "No existe el cliente";
    include "formUpdateCliente.php";
}

$valido = false;

if (isset($_POST["selectedCliente"])) {
    foreach ($_SESSION['clientes'] as $cliente) {
        if (($cliente->getUsuario() == $_POST["selectedCliente"] && $cliente->getUsuario() == $_SESSION["usuario"] ) 
            || $_SESSION["usuario"] == "admin") {     
                $valido = true;

            if (validar($_POST["nombre"])) {
                $cliente->setNombre($_POST["nombre"]);
            }
            if (validar($_POST["user"])) {
                $cliente->setUsuario($_POST["user"]);
                $_SESSION["usuario"] = $_POST["user"];
            }
            if (validar($_POST["password"])) { 
                $cliente->setPassword($_POST["password"]);
                $_SESSION["password"] = $_POST["password"];
            }
        } 
    }
}

if ($valido) {
    $_SESSION["usuario"]=="admin"?include "mainAdmin.php":include "mainCliente.php";

}else {
    error();
}
