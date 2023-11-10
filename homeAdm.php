<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once "PHP/connection.php";

session_start();

if (isset($_SESSION["user"])) {
    
    $databaseName = "VocabloDB";
    $coleccionCoordinadores = "Coordinador";
    $coleccionProfesores = "Profesor";

    $queryCoordinadores = new MongoDB\Driver\Query([]);
    $cursorCoordinadores = $mongo->executeQuery("$databaseName.$coleccionCoordinadores", $queryCoordinadores);
    $numCoordinadores = iterator_count($cursorCoordinadores);

    $queryProfesores = new MongoDB\Driver\Query([]);
    $cursorProfesores = $mongo->executeQuery("$databaseName.$coleccionProfesores", $queryProfesores);
    $numProfesores = iterator_count($cursorProfesores);

} else {
    
    header("Location: loginAdm.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Styles/menuStyle.css?v=1"> 
    <link rel="stylesheet" href="Styles/cards.css?v=1">
    <link rel="icon" type="image/png" href="Resources/icons/inicio.png">

    <title>Administración</title>
</head>
<nav>
        <div class="user-profile">
            <img src="Resources/img/perfil.jpeg" >
            <div class="user-info">
                <h1>
                <?php echo $_SESSION["nombre"] .
                " ". $_SESSION["apellidoP"]. 
                " ". $_SESSION["apellidoM"]; 
                ?>
                </h1>
                <p>
                <?php echo $_SESSION["sucursal"]; ?>
                </p>
            </div>
        </div>
        <ul class="menu">
            <li><a href="">Inicio</a></li>
            <li><a href="personal.php">Personal</a></li>
            <li><a href="PHP/logout.php">Cerrar sesión</a></li>
        </ul>
    </nav>
<body>
<div class="container">
        <div class="card">
            <h2>Coordinadores</h2>
            <p><span id="numCoordinadores"><?php echo $numCoordinadores; ?></span></p>
        </div>
        <div class="card">
            <h2>Profesores</h2>
            <p><span id="numProfesores"><?php echo $numProfesores; ?></span></p>
        </div>
    </div>

</body>
</html>