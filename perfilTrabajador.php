<?php
require_once "PHP/connection.php";

session_start();

if (isset($_SESSION["user"])) {
    if (isset($_GET['id'])) {
        $perfilId = $_GET['id'];
        
        $coleccion = 'Profesor';
        
        if (isset($_GET['cargo'])) {
            if ($_GET['cargo'] === 'coordinador') {
                $coleccion = 'Coordinador';
            }
        }
        
        $filtro = ['_id' => new MongoDB\BSON\ObjectID($perfilId)]; 
        $consulta = new MongoDB\Driver\Query($filtro);
        $perfil = $mongo->executeQuery('VocabloDB.' . $coleccion, $consulta)->toArray();
    
        if (count($perfil) > 0) {
            $perfil = $perfil[0];
        } else {
            echo 'Perfil no encontrado';
        }
    }    
    

} else {
    
    header("Location: loginAdm.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Styles/perfilStyle.css?v=1">
    <link rel="stylesheet" href="Styles/menuStyle.css?v=1">
    <link rel="stylesheet" href="Styles/footerStyle.css?v=1">
    <link rel="icon" type="image/png" href="Resources/icons/personal.png">

    <title>Perfil de Usuario</title>
</head>
<header>
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
            <li><a href="homeAdm.php">Inicio</a></li>
            <li><a href="personal.php">Personal</a></li>
            <li><a href="PHP/logout.php">Cerrar sesión</a></li>
        </ul>
    </nav>
</header>
<body>
    <div class="profile-container">
        <h1>Perfil del Trabajador</h1>
        <div class="profile-details">
            <div class="profile-info">
                <img src="<?php echo $perfil->fotoPerfil; ?>">
                <h2>Nombre: <?php echo $perfil->nombres; ?></h2>
                <p>Apellido Paterno: <?php echo $perfil->apellidoPaterno; ?></p>
                <p>Apellido Materno: <?php echo $perfil->apellidoMaterno; ?></p>
                <p>Género: <?php echo $perfil->genero; ?></p>
                <p>Fecha de Nacimiento: <?php echo date('d/m/Y', strtotime($perfil->fechaNacimiento->toDateTime()->format('Y-m-d H:i:s'))); ?></p>
                <p>CURP: <?php echo $perfil->curp; ?></p>
                <p>Usuario: <?php echo $perfil->usuario; ?></p>
                <p>Teléfono: <?php echo $perfil->telefono; ?></p>
                <p>Cargo: <?php echo $perfil->cargo; ?></p>
                <p>Fecha de Incorporación: <?php echo date('d/m/Y', strtotime($perfil->fechaIncorporacion)); ?></p>
                <p>Estatus: <?php echo $perfil->estatus; ?></p>
            </div>
            <div class="profile-address">
                <h2>Dirección</h2>
                <p>Calle: <?php echo $perfil->direccion->calle; ?></p>
                <p>Número: <?php echo $perfil->direccion->numero; ?></p>
                <p>Colonia: <?php echo $perfil->direccion->colonia; ?></p>
                <p>Código Postal: <?php echo $perfil->direccion->cp; ?></p>
                <p>Ciudad: <?php echo $perfil->direccion->ciudad; ?></p>
                <p>Estado: <?php echo $perfil->direccion->estado; ?></p>
            </div>
        </div>
        <a href="edithPerfil.php?id=<?php echo $perfil->_id; ?>&cargo=<?php echo $perfil->cargo;  ?>"><button class="edit-button">Editar Información</button></a>
    </div>
</body>
<footer class="footer">
    <div class="container">
        <p>&copy; 2023 Todos los derechos reservados.</p>
    </div>
</footer>
</html>