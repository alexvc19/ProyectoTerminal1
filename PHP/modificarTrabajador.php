<?php
require_once "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        if (
            isset($_POST['perfil_id']) &&
            isset($_POST['cargo']) &&
            isset($_POST['nombres']) &&
            isset($_POST['apellido-paterno']) &&
            isset($_POST['apellido-materno']) &&
            isset($_POST['fecha-nacimiento']) &&
            isset($_POST['curp']) &&
            isset($_POST['telefono']) &&
            isset($_POST['usuario']) &&
            isset($_POST['contrasena']) &&
            isset($_POST['calle']) &&
            isset($_POST['numero']) &&
            isset($_POST['colonia']) &&
            isset($_POST['cp']) &&
            isset($_POST['ciudad']) &&
            isset($_POST['estado'])&&
            isset($_POST['foto-perfil-actual'])
        ) {
            $perfilId = $_POST['perfil_id'];
            $cargo = $_POST['cargo'];
            $nombres = $_POST['nombres'];
            $apellidoPaterno = $_POST['apellido-paterno'];
            $apellidoMaterno = $_POST['apellido-materno'];
            $fechaNacimiento = new MongoDB\BSON\UTCDateTime(strtotime($_POST['fecha-nacimiento']) * 1000);
            $curp = $_POST['curp'];
            $telefono = $_POST['telefono'];
            $usuario = $_POST['usuario'];
            $calle = $_POST['calle'];
            $numero = $_POST['numero'];
            $colonia = $_POST['colonia'];
            $cp = $_POST['cp'];
            $ciudad = $_POST['ciudad'];
            $estado = $_POST['estado'];
            $fotoPerfil = $_POST['foto-perfil-actual'];


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

            $coleccion = ($cargo === 'profesor') ? 'Profesor' : 'Coordinador';

            $filtro = ['_id' => new MongoDB\BSON\ObjectID($perfilId)];
            $actualizacion = [
                '$set' => [
                    'cargo' => $cargo,
                    'nombres' => $nombres,
                    'apellidoPaterno' => $apellidoPaterno,
                    'apellidoMaterno' => $apellidoMaterno,
                    'fotoPerfil' => $fotoPerfil,
                    'fechaNacimiento' => $fechaNacimiento,
                    'curp' => $curp,
                    'telefono' => $telefono,
                    'usuario' => $usuario,
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
            echo '<script>alert("Por favor, completa todos los campos obligatorios.");</script>';
            
            
        }
    } catch (Exception $e) {
        echo '<script>alert("Error al actualizar el perfil: ' . $e->getMessage() . '");</script>';
    }
} else {
    echo '<script>alert("La solicitud no es válida.");</script>';
}
?>
