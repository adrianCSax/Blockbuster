<?php
// Recuperamos la información de la sesión

//echo var_dump($_SESSION["usuario"]);


// Y comprobamos que el usuario se haya autentificado
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] != "admin") {
    die("<span style='font-size: 1.5em'>Error - debe <a href='index.php'>identificarse</a>.<br /> Vete de aquí,</span> <p><b style='font-size: 6em '>🤡¡PAYASO!🤡</b></p>");
}
include_once "inicio3.php";


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de productos</title>
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
    <h1>Bienvenido <?= $_SESSION['usuario'] ?></h1>
    <p>Pulse <a href="logout.php">aquí</a> para salir</p>
    <p><a href="formCreateCliente.php">Formulario creación de cliente</a></p>
    <p><a href="formUpdateCliente.php">Formulario de actualización de cliente</a></p>

    <form action="removeCliente.php" method="post">
        <label for="seleccionCliente">Choose a cliente:</label>

        <select id="clientes" name="selectedCliente">
            <?php foreach ($vc->getSocios() as $cliente) { ?>
                <option value="<?= $cliente->getUsuario(); ?>"><?= $cliente->getNombre(); ?></option>
            <?php } ?>
        </select>
       
        <input type="submit" value="Eliminar usuario">
    </form>

    <?php $vc->listarSocios();
    echo "<br>";
    $vc->listarProductos() ?>
</body>

</html>