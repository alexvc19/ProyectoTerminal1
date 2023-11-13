<?php
require_once "connection.php";

if (
    isset($_POST['cargo']) &&
    isset($_POST['nombres']) &&
    isset($_POST['apellido-paterno']) &&
    isset($_POST['apellido-materno']) &&
    isset($_POST['genero']) &&
    isset($_POST['fecha-nacimiento']) &&
    isset($_POST['curp']) &&
    isset($_POST['telefono']) &&
    isset($_POST['usuario']) &&
    isset($_POST['contrasena']) &&
    isset($_POST['calle']) &&
    isset($_POST['numero']) &&
    isset($_POST['colonia']) &&
    isset($_POST['cp']) &&
    isset($_POST['ciudad'])
) {
    try {
        
        $requiredFields = ['cargo', 'nombres', 'apellido-paterno', 'apellido-materno', 'genero', 'fecha-nacimiento', 'curp', 'telefono', 'usuario', 'contrasena', 'calle', 'numero', 'colonia', 'cp', 'ciudad'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                echo '<script>alert("Por favor, complete todos los campos"); window.location.href="../registro.php";</script>';
                exit();
            }
        }
        
        $fechaIncorporacion = date("Y-m-d H:i:s");
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
        $hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);
        $calle = $_POST['calle'];
        $numero = $_POST['numero'];
        $colonia = $_POST['colonia'];
        $cp = $_POST['cp'];
        $ciudad = $_POST['ciudad'];
        $estado = $_POST['estado'];
        $estatus = "activo";

        $queryProfesor = new MongoDB\Driver\Query(['usuario' => $usuario]);
        $cursorProfesor = $mongo->executeQuery("VocabloDB.Profesor", $queryProfesor);
        $existingUserProfesor = current($cursorProfesor->toArray());

        $queryCoordinador = new MongoDB\Driver\Query(['usuario' => $usuario]);
        $cursorCoordinador = $mongo->executeQuery("VocabloDB.Coordinador", $queryCoordinador);
        $existingUserCoordinador = current($cursorCoordinador->toArray());

        if ($existingUserProfesor || $existingUserCoordinador) {
            echo '<script>alert("Ya existe un usuario con el mismo nombre. Por favor, elige otro nombre de usuario."); window.location.href="../registro.php";</script>';
            exit();
        }

        if (isset($_FILES['foto-perfil']) && $_FILES['foto-perfil']['error'] === UPLOAD_ERR_OK) {
            $identificadorUnico = uniqid();
            $targetDirectory = '../Resources/perfiles/';
            $targetFile = $targetDirectory . basename($identificadorUnico.'-'.$_FILES['name']);
            $tagFile = 'Resources/perfiles/' . basename($identificadorUnico.'-'.$_FILES['name']);

            if (move_uploaded_file($_FILES['foto-perfil']['tmp_name'], $targetFile)) {
                $fotoPerfil = $tagFile;

                $documento = [
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
                    'fechaIncorporacion' => $fechaIncorporacion,
                    'estatus' => $estatus,
                    'direccion' => [
                        'calle' => $calle,
                        'numero' => $numero,
                        'colonia' => $colonia,
                        'cp' => $cp,
                        'ciudad' => $ciudad,
                        'estado' => $estado
                    ]
                ];

                $coleccion = ($cargo === 'profesor') ? 'Profesor' : 'Coordinador';

                $bulkWrite = new MongoDB\Driver\BulkWrite;
                $bulkWrite->insert($documento);
                $mongo->executeBulkWrite('VocabloDB.' . $coleccion, $bulkWrite);

                echo '<script>alert("Registro exitoso."); window.location.href="../personal.php";</script>';
            } else {
                echo '<script>alert("Error al cargar el archivo.");</script>';
            }
        } else {
            echo '<script>alert("Por favor, complete todos los campos"); window.location.href="../registro.php";</script>';
        }
    } catch (Exception $e) {
        echo '<script>alert("Error al insertar el registro: ' . $e->getMessage() . '");</script>';
    }
}
?>
