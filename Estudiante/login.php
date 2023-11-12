<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/stylesLog.css">
    <link rel="stylesheet" type="text/css" href="../Styles/modal.css">
    <title>Login Estudiantes</title>
</head>
<body>
<div class="login-container" >
            <h2>Estudiantes</h2>
            <form class="login-form" action="PHP/log.php" method="POST" onsubmit="return validarFormulario()" >
                <a class="logo" href="../index.html"><img src="../Resources/img/logoVocablo.png" alt=""></a>
                <div class="input-container">
                    <input type="text" id="user" name="user" required placeholder="Usuario">
                </div>
                <div class="input-container">
                    <input type="password" id="pass" name="pass" required placeholder="Contraseña">
                </div>
                <button type="submit">Iniciar Sesión</button>
            </form>
        </div>

    <div id="errorModal" class="modal">
        <div class="modal-content error">
            <span class="close" id="closeErrorModal">&times;</span>
            <p>Usuario o contraseña incorrectos!</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        <?php
        session_name('estudiante');
        session_start();
        
        if (isset($_SESSION['errorModal']) && $_SESSION['errorModal']){
            echo "showErrorModal();";
            unset($_SESSION['errorModal']);
        }
        ?>
    });
</script>
    
    <script src="../JS/modal.js"></script>
</body>
</html>