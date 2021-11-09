<?php

//Array con usuarios y constraseñas
$array = ["usuario" => "usuario", "admin" => "admin"];

// Comprobamos si ya se ha enviado el formulario
if (isset($_POST['enviar'])) {
    $usuario = $_POST['inputUsuario'];
    $password = $_POST['inputPassword'];

    // validamos que recibimos ambos parámetros
    if (empty($usuario) || empty($password)) {
        $error = "Debes introducir un usuario y contraseña";
        include "index.php";
    } else {
        //Comprobamos si en el array de keys está el nombre de usuario introducido y si la contraseña coincide
        if (in_array($usuario, array_keys($array)) && $password == $array[$usuario]) {
            // almacenamos el usuario en la sesión
            session_start();
            $_SESSION['usuario'] = $usuario;
            // cargamos la página principal
            //Si es admin cargamos mainAdminphp si no cargamos main php
            $usuario=="admin"?include "mainAdmin.php":include "main.php";
        } else {
            // Si las credenciales no son válidas, se vuelven a pedir
            $error = "Usuario o contraseña no válidos!";
            include "index.php";
        }
    }
}