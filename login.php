<?php

// Recuperamos la información de la sesión
include_once "vendor/autoload.php";

if(!isset($_SESSION)) {
    session_start();
}

//Array con usuarios y constraseñas
$arrayUserPassword = ["usuario" => "usuario", "admin" => "admin", "amancio"=> "amancio", "picasso"=> "picasso"];


// Comprobamos si ya se ha enviado el formulario
if (isset($_POST['enviar']) && !isset($_SESSION['usuario'])) {

    $usuario = $_POST['inputUsuario'];
    $password = $_POST['inputPassword'];

    // validamos que recibimos ambos parámetros
    if (empty($usuario) || empty($password)) {
        $error = "Debes introducir un usuario y contraseña";
        include "index.php";
    } else {
        //Comprobamos si en el array de keys está el nombre de usuario introducido y si la contraseña coincide
        if (in_array($usuario, array_keys($arrayUserPassword)) && $password == $arrayUserPassword[$usuario]) {
            // almacenamos el usuario en la sesión
            $_SESSION['usuario'] = $usuario;
            $_SESSION["password"] = $password;
            // cargamos la página principal
            //Si es admin cargamos mainAdminphp si no cargamos main php
            $usuario=="admin"?  header("Location: mainAdmin.php") : header("Location: mainCliente.php");

        } else {
            // Si las credenciales no son válidas, se vuelven a pedir
            $error = "Usuario o contraseña no válidos!";
            include "index.php";
        }
    }
} else {
    
    $_SESSION['usuario']=="admin" ? header("Location: mainAdmin.php") : header("Location: mainCliente.php");
}