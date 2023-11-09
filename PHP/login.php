

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once "connection.php";

session_start();

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
                $_SESSION["apellidoP"] = $document->apellidoPaterno;
                $_SESSION["apellidoM"] = $document->apellidoMaterno;
                $_SESSION["sucursal"] = $document->sucursal;

                header("Location: ../homeAdm.php");
                exit();
            } else {
                $_SESSION['errorModal'] = true;
                header("Location: ../loginAdm.php");
                exit();
            }
        } else {
            $_SESSION['errorModal'] = true;
            header("Location: ../loginAdm.php");
                exit();
        }
    } catch (MongoDB\Driver\Exception\Exception $e) {
        echo "Error al realizar la consulta: " . $e->getMessage();
        echo "<script>window.location = '../loginAdm.html';</script>";
    }
}
?>