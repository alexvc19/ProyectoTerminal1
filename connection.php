
<?php

use MongoDB\Client;
use MongoDB\Driver\ServerApi;
use Exception;

error_reporting(E_ALL);
ini_set('display_errors', 1);

$mongo = new MongoDB\Driver\Manager('mongodb+srv://tester:kAfntY15YnoAJKs5@cluster0.vjhlz.mongodb.net/?retryWrites=true&w=majority');
$query = new MongoDB\Driver\Query([]);
try {
        $cursor = $mongo->executeQuery('VocabloDB.Administrador', $query);

        foreach ($cursor as $document) {
            echo "ID: " . $document->_id . "<br>";
            echo "Nombre: " . $document->nombres . "<br>";
            echo "Apellido: " . $document->apellidoPaterno . "<br>";
            echo "<hr>";
        }
} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "Error al conectar a MongoDB: " . $e->getMessage();
}
?>
