<?php
require_once "connection.php";

ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        if (
            isset($_POST['perfil_id']) &&
            isset($_POST['cargo']) &&
            isset($_POST['nombres']) &&
            isset($_POST['apellido-paterno']) &&
            isset($_POST['apellido-materno']) &&
            isset($_POST['genero']) &&
            isset($_POST['fecha-nacimiento']) &&
            isset($_POST['curp']) &&
            isset($_POST['telefono']) &&
            isset($_POST['usuario']) &&
            isset($_POST['calle']) &&
            isset($_POST['numero']) &&
            isset($_POST['colonia']) &&
            isset($_POST['cp']) &&
            isset($_POST['ciudad']) &&
            isset($_POST['estado']) &&
            isset($_POST['foto-perfil-actual'])
        ) {
            $perfilId = $_POST['perfil_id'];
            $cargo = $_POST['cargo'];
            $nombres = $_POST['nombres'];
            $apellidoPaterno = $_POST['apellido-paterno'];
            $apellidoMaterno = $_POST['apellido-materno'];
            $genero = $_POST['genero'];
            $fechaNacimiento = new MongoDB\BSON\UTCDateTime(strtotime($_POST['fecha-nacimiento']) * 1000);
            $curp = $_POST['curp'];
            $telefono = $_POST['telefono'];
            $usuario = $_POST['usuario'];
            $contrasena = $_POST['contrasena'];
            $calle = $_POST['calle'];
            $numero = $_POST['numero'];
            $colonia = $_POST['colonia'];
            $cp = $_POST['cp'];
            $ciudad = $_POST['ciudad'];
            $estado = $_POST['estado'];
            $fotoPerfil = $_POST['foto-perfil-actual'];

            $requiredFields = ['cargo', 'nombres', 'apellido-paterno', 'apellido-materno', 'genero', 'fecha-nacimiento', 'curp', 'telefono', 'usuario', 'calle', 'numero', 'colonia', 'cp', 'ciudad'];
            foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                echo '<script>alert("Por favor, complete todos los campos"); window.location.href="../personal.php";</script>';
                exit();
            }
            }

            $coleccion = ($cargo === 'profesor') ? 'Profesor' : 'Coordinador';


            $consultaPassword = new MongoDB\Driver\Query(['_id' => new MongoDB\BSON\ObjectID($perfilId)], ['projection' => ['contrasena' => 1]]);
            $contrasenaActual = $mongo->executeQuery('VocabloDB.' . $coleccion, $consultaPassword)->toArray()[0]->contrasena;

            if ($contrasena !== null && $contrasena !== '') {
                $hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);
            } else {
            $hashedPassword = $contrasenaActual;
            }
            if (isset($_FILES['foto-perfil']) && $_FILES['foto-perfil']['error'] === UPLOAD_ERR_OK) {
                $identificadorUnico = uniqid();
                $targetDirectory = '../Resources/perfiles/';
                $targetFile = $targetDirectory . basename($identificadorUnico . '-' . $_FILES['foto-perfil']['name']);
                $tagFile = 'Resources/perfiles/' . basename($identificadorUnico . '-' . $_FILES['foto-perfil']['name']);
                if (move_uploaded_file($_FILES['foto-perfil']['tmp_name'], $targetFile)) {
                    $fotoPerfil = $tagFile;
                } else {
                    $fotoPerfil = $_POST['foto-perfil-actual'];
                }
            }


            $filtro = ['_id' => new MongoDB\BSON\ObjectID($perfilId)];
            $actualizacion = [
                '$set' => [
                    'cargo' => $cargo,
                    'nombres' => $nombres,
                    'apellidoPaterno' => $apellidoPaterno,
                    'apellidoMaterno' => $apellidoMaterno,
                    'genero' => $genero,
                    'fotoPerfil' => $fotoPerfil,
                    'fechaNacimiento' => $fechaNacimiento,
                    'curp' => $curp,
                    'telefono' => $telefono,
                    'usuario' => $usuario,
                    'contrasena' => $hashedPassword,
                    'direccion' => [
                        'calle' => $calle,
                        'numero' => $numero,
                        'colonia' => $colonia,
                        'cp' => $cp,
                        'ciudad' => $ciudad,
                        'estado' => $estado
                    ]
                ]
            ];

            $bulkWrite = new MongoDB\Driver\BulkWrite;
            $bulkWrite->update($filtro, $actualizacion);
            $mongo->executeBulkWrite('VocabloDB.' . $coleccion, $bulkWrite);

            echo '<script>alert("Perfil actualizado exitosamente."); window.location.href="../personal.php";</script>';
        } else {
            
        }
    } catch (Exception $e) {
        echo '<script>alert("Error al actualizar el perfil: ' . $e->getMessage() . '");</script>';
    }
} else {
    echo '<script>alert("La solicitud no es válida.");</script>';
}
?>
