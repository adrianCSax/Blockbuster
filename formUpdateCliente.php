<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION["clientes"])) {
    $arrayClientes = $_SESSION["clientes"];
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
    <h1>CREACIÓN DE CLIENTE</h1>
    <p><?= $error ?></p>
    <select id="clientes" name="listaClientes">
        <?php foreach ($arrayClientes as $cliente) { ?>

            <option value="<?php $cliente->getUsuario(); ?>"><?= $cliente->getNombre(); ?></option>

        <?php } ?>

    </select>
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