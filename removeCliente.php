<?php
include_once "vendor/autoload.php";

if (!isset($_SESSION)) {
    session_start();
}

function error () {
    $_SESSION['error'] = "No existe el cliente";
    include_once "mainAdmin.php";
}

$valido = false;

if (isset($_POST["selectedCliente"])) {
    foreach ($_SESSION['clientes'] as $cliente) {
        if ($cliente->getUsuario() == $_POST["selectedCliente"] && $_SESSION["usuario"] == "admin") {     
            $valido = true;
            unset($_SESSION["clientes"][$cliente->getNumero()]);
        } 
    }
}

if ($valido) {
    header("Location: mainAdmin.php");
}else {
    error();
}
