<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once "../PHP/connection.php";

session_start();

if (isset($_SESSION["user"])) {
    
} else {
    
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/menuStyle.css?v=1"> 
    <link rel="stylesheet" href="../Styles/404.css?v=1">

    <title>Coordinación</title>
</head>
<nav>
        <div class="user-profile">
            <img src="<?php echo "../". $_SESSION["foto"];?>" >
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
            <li><a href="inicio.php">Inicio</a></li>
            <li><a href="">Reservaciones</a></li>
            <li><a href="salones.php">Salones</a></li>
            <li><a href="alumnos.php">Alumnos</a></li>
            <li><a href="PHP/logout.php">Cerrar sesión</a></li>
        </ul>
    </nav>
<body>
    <div class="error">
        <img src="../Resources/img/646.jpg">
    </div>
</body>
</html>