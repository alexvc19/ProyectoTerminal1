<?php

$user ='tester';
$pass ='kAfntY15YnoAJKs5';

try {
    $mongo = new MongoDB\Driver\Manager('mongodb+srv://'.$user.':'.$pass.'@cluster0.vjhlz.mongodb.net/?retryWrites=true&w=majority');
} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "Error de conexión a MongoDB: " . $e->getMessage();
    exit;
}
