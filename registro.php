<?php

session_name('sesion_adm');
session_start();

if (isset($_SESSION["user"])) {
    
} else {
    
    header("Location: loginAdm.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Styles/formularioStyle.css?v=1">
    <link rel="stylesheet" href="Styles/menuStyle.css?v=1">
    <link rel="stylesheet" href="Styles/footerStyle.css?v=1">
    <link rel="stylesheet" href="Styles/modalG.css?v=1">
    <link rel="icon" type="image/png" href="Resources/icons/personal.png">

    <title>Registro personal</title>
    <script src="JS/modal.js"></script>
</head>
<header>
    <nav>
        <div class="user-profile">
            <img src="Resources/img/perfil.jpeg" >
            <div class="user-info">
                <h1>
                <?php echo $_SESSION["nombre"] .
                " ". $_SESSION["apellidoP"]. 
                " ". $_SESSION["apellidoM"]; 
                ?>
                </h1>
                <p>
                <?php echo $_SESSION["sucursal"]; ?>
                </p>
            </div>
        </div>
        <ul class="menu">
            <li><a href="homeAdm.php">Inicio</a></li>
            <li><a href="personal.php">Personal</a></li>
            <li><a href="PHP/logout.php">Cerrar sesión</a></li>
        </ul>
    </nav>
</header>
<body style="background-color: white;">
    <center>
    <div class="form-container">
        <h2>Registro de colaboradores</h2>
        <form action="PHP/registrarTrabajador.php" method="POST" enctype="multipart/form-data" onsubmit="return validarFormulario()">
            <div class="form-group">
                <label for="cargo">Cargo:</label>
                <select name="cargo" id="cargo">
                    <option value="profesor">Profesor</option>
                    <option value="coordinador">Coordinador</option>
                </select>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="nombres" id="nombres" placeholder="Nombre(s)" autocomplete="off" >
                    <input type="text" name="apellido-paterno" id="apellido-paterno" autocomplete="off" placeholder="Apellido Paterno" >
                </div>
            </div>
            <div class="form-group">
                <input type="text" name="apellido-materno" id="apellido-materno" autocomplete="off" placeholder="Apellido Materno" >
                <select name="genero" id="genero">
                    <option value="masculino">Masculino</option>
                    <option value="femenino">Femenino</option>
                    <option value="otro">Otro</option>
                </select>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <label for="foto-perfil">Foto de perfil:</label>
                    <input type="file" name="foto-perfil" id="foto-perfil" accept=".png, .jpg, .jpeg">
                </div>

            </div>
            <div class="form-group">
                <div class="input-group">
                    <label for="fecha-nacimiento">Fecha de nacimiento:</label>
                    <input type="date" name="fecha-nacimiento" id="fecha-nacimiento" >
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="curp" id="curp" placeholder="CURP" autocomplete="off" maxlength="18">
                    <input type="tel" name="telefono" id="telefono" placeholder="Teléfono" autocomplete="off" minlength="10" maxlength="10">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="usuario" id="usuario" placeholder="Usuario" autocomplete="off" >
                    <input type="password" name="contrasena" id="contrasena" placeholder="Contraseña" autocomplete="off" >
                    <button type="button" id="mostrarContrasena" onclick="mostrarOcultarContrasena()">Mostrar Contraseña</button>
                </div>
            </div>
            
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <div class="input-group">
                    <input type="text" name="calle" autocomplete="off" placeholder="Calle">
                    <input type="text" name="numero" autocomplete="off" placeholder="Número">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="colonia" autocomplete="off" placeholder="Colonia">
                    <input type="text" name="cp" autocomplete="off" placeholder="Código Postal">
                </div>
            </div>
            <div class="form-group">
                    <div class="input-group">
                    <select name="ciudad" id="ciudad" autocomplete="off">
                    <option value="Manzanillo">Manzanillo</option>
                    <option value="Colima">Colima</option>
                    <option value="Tecomán">Tecomán</option>
                    <option value="Villa de Álvarez">Villa de Álvarez</option>
                    <option value="Armería">Armería</option>
                    <option value="Comala">Comala</option>
                    <option value="Coquimatlán">Coquimatlán</option>
                    <option value="Cuauhtémoc">Cuauhtémoc</option>
                    <option value="Ixtlahuacán">Ixtlahuacán</option>
                    <option value="Minatitlán">Minatitlán</option>
                </select>
                    <select name="estado" id="estado" autocomplete="off">
                        <option value="Colima">Colima</option>
                    </select>
                </div>
            </div>
        
            <button type="submit">Registrar</button>
        </form>
    </div>
    </center>
    <div id="genericModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal('genericModal')">&times;</span>
            <p id="modalText"></p>
        </div>
    </div>
    <script>
        var inputArchivo = document.getElementById("foto-perfil"); 
        var contrasena = document.getElementById("contrasena").value;   
    </script>
    <script src="JS/validaciones.js"></script>
</body>
<footer class="footer">
    <div class="container">
        <p>&copy; 2023 Todos los derechos reservados.</p>
    </div>
</footer>
</html>