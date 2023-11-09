

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once "connection.php";

session_start();

function bloquearUsuarioTemporalmente() {
    $_SESSION['intentos_fallidos'] = 0;
    $_SESSION['tiempo_bloqueo'] = time() + 60; 
}

function registrarIntentoFallido() {
    $_SESSION['intentos_fallidos']++;

    if ($_SESSION['intentos_fallidos'] >= 3) {
        bloquearUsuarioTemporalmente();
    }
}

function usuarioBloqueado() {
    return isset($_SESSION['tiempo_bloqueo']) && $_SESSION['tiempo_bloqueo'] > time();
}


$databaseName = "VocabloDB";
$collectionName = "Administrador";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["user"];
    $pass = $_POST["pass"];

    $query = new MongoDB\Driver\Query(["usuario" => $user]);

    if (usuarioBloqueado()) {
        echo "<script>alert('Usuario bloqueado temporalmente. Inténtalo de nuevo más tarde.');</script>";
        echo "<script>window.location = '../loginAdm.php';</script>";
        exit();
    }

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
                $_SESSION['intentos_fallidos'] = 0;

                header("Location: ../homeAdm.php");
                exit();
            } else {
                $_SESSION['errorModal'] = true;
                registrarIntentoFallido();
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
        echo "<script>window.location = '../loginAdm.php';</script>";
    }
}
?>