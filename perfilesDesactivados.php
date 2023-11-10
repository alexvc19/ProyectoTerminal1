<?php
require_once "PHP/connection.php";
session_start();


if (isset($_SESSION["user"])) {
    try {
        $query = new MongoDB\Driver\Query(['estatus' => 'inactivo']);
        $registros = [];

        $coleccion = "Coordinador";
        $consulta = new MongoDB\Driver\Query(['estatus' => 'inactivo']);

        $cursor = $mongo->executeQuery('VocabloDB.' . $coleccion, $consulta);
        foreach ($cursor as $document) {
            $registros[] = $document;
        }

        $coleccion = "Profesor";
        $consulta = new MongoDB\Driver\Query(['estatus' => 'inactivo']);

        $cursor = $mongo->executeQuery('VocabloDB.' . $coleccion, $consulta);
        foreach ($cursor as $document) {
            $registros[] = $document;
        }


    } catch (Exception $e) {
        echo $e->getMessage();
        header("Location: loginAdm.php");
        exit();
    }
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
    <link rel="stylesheet" href="Styles/tablasStyle.css?v=1">
    <link rel="stylesheet" href="Styles/menuStyle.css?v=1">
    <link rel="stylesheet" href="Styles/menuBarStyle.css?v=1">
    <link rel="stylesheet" href="Styles/footerStyle.css?v=1">
    <title>Personal</title>
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
    <div id="tabla-container">
    <table>
        <tr>
            <th>Nombre(s)</th>
            <th>Apellido Paterno</th>
            <th>Apellido Materno</th>
            <th>Teléfono</th>
            <th>Fecha de Incorporación</th>
            <th>Estatus</th>
            <th>Cargo</th>
            <th>ACCIONES</th>
        </tr>

        <?php foreach ($registros as $registro) : ?>
            <tr>
                <td><?php echo $registro->nombres; ?></td>
                <td><?php echo $registro->apellidoPaterno; ?></td>
                <td><?php echo $registro->apellidoMaterno; ?></td>
                <td><?php echo $registro->telefono; ?></td>
                <td><?php echo date('d/m/Y', strtotime($registro->fechaIncorporacion));?></td>
                <td><?php echo $registro->estatus; ?></td>
                <td><?php echo $registro->cargo; ?></td>
                <td><a  href="perfilTrabajador.php?id=<?php echo $registro->_id; ?>&cargo=<?php echo $registro->cargo; ?>">
                <button class="botton">Ver Perfil</button></a></td>
            </tr>
        <?php endforeach; ?>

    </table>
    </div>
    
</body>
</html>