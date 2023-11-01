<?php
require_once "connection.php";

if (isset($_GET['perfil_id'])) {
    $perfilId = $_GET['perfil_id'];
    
    $filtro = ['_id' => new MongoDB\BSON\ObjectID($perfilId)];
    $consulta = new MongoDB\Driver\Query($filtro);
    
    $coleccion = null;

    $cursor = $mongo->executeQuery('VocabloDB.Profesor', $consulta)->toArray();
    if (count($cursor) > 0) {
        $perfil = $cursor[0];
        $coleccion = 'Profesor';
    } else {
        $cursor = $mongo->executeQuery('VocabloDB.Coordinador', $consulta)->toArray();
        if (count($cursor) > 0) {
            $perfil = $cursor[0];
            $coleccion = 'Coordinador';
        }
    }

    if ($coleccion !== null) {
        // Verificar el estado actual del perfil
        if ($perfil->estatus === 'activo') {
            // Cambiar el estado a inactivo
            $nuevoEstado = 'inactivo';
        } else {
            // Cambiar el estado a activo
            $nuevoEstado = 'activo';
        }

        $actualizacion = [
            '$set' => [
                'estatus' => $nuevoEstado
            ]
        ];

        $bulkWrite = new MongoDB\Driver\BulkWrite;
        $bulkWrite->update($filtro, $actualizacion);
        $mongo->executeBulkWrite('VocabloDB.' . $coleccion, $bulkWrite);

        echo '<script>alert("Estado actualizado exitosamente."); window.location.href="../personal.php";</script>';
    } else {
        echo 'Perfil no encontrado';
    }
} else {
    echo 'ID de perfil no especificado';
}
?>
