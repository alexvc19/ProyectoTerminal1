<?php
session_start();
$mongo = new MongoDB\Driver\Manager('mongodb+srv://tester:kAfntY15YnoAJKs5@cluster0.vjhlz.mongodb.net/?retryWrites=true&w=majority');

$databaseName = "VocabloDB";
$collectionName = "Administrador";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["user"];
    $pass = $_POST["pass"];

    $query = new MongoDB\Driver\Query(["usuario" => $user]);

    try {
        $cursor = $mongo->executeQuery("$databaseName.$collectionName", $query);

        $document = current($cursor->toArray());
        if ($document) {
            if ($pass === $document->contrasena) {
                $_SESSION["user"] = $user;
                $_SESSION["nombre"] = $document->nombres;

                header("Location: homeAdm.php");
                exit();
            } else {
                echo "Contraseña incorrecta ";
                echo $document->nombres;
            }
        } else {
            echo "Usuario no encontrado";
        }
    } catch (MongoDB\Driver\Exception\Exception $e) {
        echo "Error al realizar la consulta: " . $e->getMessage();
    }
}
?>
