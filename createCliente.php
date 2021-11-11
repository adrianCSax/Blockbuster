<?php

include "vendor/autoload.php";
use Dwes\ProyectoVideoClub\Cliente;

if(!isset($_SESSION)) {
        session_start();
    }

    // Y comprobamos que el usuario se haya autentificado
    if (!isset($_SESSION['usuario']) || $_SESSION["usuario"] != "admin") {
       die("<span style='font-size: 1.5em'>Error - debe <a href='index.php'>identificarse</a>.<br /> Vete de aquí,</span> <p><b style='font-size: 6em '>🤡¡PAYASO!🤡</b></p>");
    }

    function validar (string $campo) : bool {
        if (isset($campo) && !empty($campo)) {
            return true;
        }else {
            return false;
        }
    }

    if (validar($_POST["nombre"]) && validar($_POST["user"]) && validar($_POST["password"]) ) {
        $nombre = trim(htmlspecialchars($_POST["nombre"]));
        $user = trim(htmlspecialchars($_POST["user"]));
        $password = trim(htmlspecialchars($_POST["password"]));

        if (!isset($_SESSION["clientes"])) {
            $_SESSION["clientes"] = [];
        }

        $cliente = new Cliente($nombre, $user, $password);
        $_SESSION["clientes"][] = $cliente;

        include "mainAdmin.php";


    }else {
        $_SESSION["error"] = "Datos incorrectos";
        include "formCreateCliente.php";
    }



?>