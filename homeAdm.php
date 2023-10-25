<?php

session_start();

if (isset($_SESSION["user"])) {
    
} else {
    
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Styles/menuStyle.css"> 

    <title>Administración</title>
</head>
<body>
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
            <li><a href="#">Personal</a></li>
            <li><a href="PHP/logout.php">Cerrar sesion</a></li>
        </ul>
    </nav>
    <img class="back" src="Resources/img/646.jpg">
</body>
</html>