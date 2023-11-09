<?php
require_once "PHP/connection.php";

session_start();

if (isset($_SESSION["user"])) {
    
    if (isset($_GET['id'])) {
        $perfilId = $_GET['id'];
        
        $coleccion = 'Profesor';
        
        if (isset($_GET['cargo'])) {
            if ($_GET['cargo'] === 'coordinador') {
                $coleccion = 'Coordinador';
            }
        }
        
        $filtro = ['_id' => new MongoDB\BSON\ObjectID($perfilId)]; 
        $consulta = new MongoDB\Driver\Query($filtro);
        $perfil = $mongo->executeQuery('VocabloDB.' . $coleccion, $consulta)->toArray();
    
        if (count($perfil) > 0) {
            $perfil = $perfil[0];

            $fechaNacimiento = date('Y-m-d', $perfil->fechaNacimiento->toDateTime()->getTimestamp());

        } else {
            echo 'Perfil no encontrado';
        }
    }  

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
    <link rel="stylesheet" href="Styles/menuBarStyle.css?v=1">
    <link rel="stylesheet" href="Styles/footerStyle.css?v=1">
    <title>Registro personal</title>
    <script src="JS/validaciones.js"></script>
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
            <li><a href="PHP/logout.php">Cerrar sesion</a></li>
        </ul>
    </nav>
</header>
<body style="background-color: white;">
    <?php
    if ($perfil->estatus === 'activo') {
        $buttonText = 'Desactivar usuario';
        $buttonClass = 'btnPerfil';
    } else {
        $buttonText = 'Reactivar usuario';
        $buttonClass = 'btnIngresar';
    }
    ?>
    <div id="menu-bar">
        <a href="PHP/cambiarEstatus.php?perfil_id=<?php echo $perfilId; ?>"><button class="<?php echo $buttonClass; ?>"><?php echo $buttonText; ?></button></a>
    </div>
    <center>
    <div class="form-container">
        <h2>Edición de información</h2>
        <form action="PHP/modificarTrabajador.php" method="POST" enctype="multipart/form-data" onsubmit="return validarFormulario()">
        <input type="hidden" name="perfil_id" value="<?php echo $perfilId; ?>">
            <div class="form-group">
                <label for="cargo">Cargo:</label>
                <select name="cargo" id="cargo">
                    <option value="profesor" <?php if ($perfil->cargo === 'profesor') echo 'selected'; ?>>Profesor</option>
                    <option value="coordinador" <?php if ($perfil->cargo === 'coordinador') echo 'selected'; ?>>Coordinador</option>
                </select>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="nombres" id="nombres" 
                    value="<?php echo $perfil->nombres; ?>" placeholder="Nombre(s)" autocomplete="off" >
                    <input type="text" name="apellido-paterno" id="apellido-paterno" 
                    value="<?php echo $perfil->apellidoPaterno; ?>" autocomplete="off" placeholder="Apellido Paterno" >
                </div>
            </div>
            <div class="form-group">
                <input type="text" name="apellido-materno" id="apellido-materno" 
                value="<?php echo $perfil->apellidoMaterno; ?>" autocomplete="off" placeholder="Apellido Materno" >
                <select name="genero" id="genero">
                    <option value="masculino" <?php if ($perfil->genero === 'masculino') echo 'selected'; ?>>Masculino</option>
                    <option value="femenino" <?php if ($perfil->genero === 'femenino') echo 'selected'; ?>>Femenino</option>
                    <option value="otro" <?php if ($perfil->genero === 'otro') echo 'selected'; ?>>Otro</option>
                </select>
            </div>
            <div class="form-group">
            <label for="foto-perfil">Foto de perfil:</label>
                <input type="file" name="foto-perfil" id="foto-perfil" accept=".png, .jpg, .jpeg">
            </div>
            <div class="form-group">
                <label>Foto de perfil actual:</label>
                <input type="hidden" name="foto-perfil-actual" value="<?php echo $perfil->fotoPerfil; ?>">
                <img src="<?php echo $perfil->fotoPerfil;?>" alt="Foto de perfil actual" width="100">
            </div>
            <div class="form-group">
                <div class="input-group">
                    <label for="fecha-nacimiento">Fecha de nacimiento:</label>
                    <input type="date" name="fecha-nacimiento" id="fecha-nacimiento" 
                    value="<?php echo $fechaNacimiento; ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="curp" id="curp" 
                    value="<?php echo $perfil->curp; ?>" placeholder="CURP" autocomplete="off" minlength="18" maxlength="18">
                    <input type="tel" name="telefono" id="telefono" 
                    value="<?php echo $perfil->telefono; ?>" placeholder="Teléfono" autocomplete="off" minlength="10" maxlength="10">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="usuario" id="usuario" 
                    value="<?php echo $perfil->usuario; ?>" placeholder="Usuario" autocomplete="off" readOnly>
                    <input type="password" name="contrasena" id="contrasena" 
                    value="<?php echo $perfil->contrasena; ?>" placeholder="Contraseña" autocomplete="off" minlength="8">
                    <button type="button" id="mostrarContrasena" onclick="mostrarOcultarContrasena()">Mostrar Contraseña</button>

                </div>
            </div>
            
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <div class="input-group">
                    <input type="text" name="calle" 
                    value="<?php echo $perfil->direccion->calle; ?>" autocomplete="off" placeholder="Calle">
                    <input type="text" name="numero" 
                    value="<?php echo $perfil->direccion->numero; ?>" autocomplete="off" placeholder="Número">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="colonia" 
                    value="<?php echo $perfil->direccion->colonia; ?>" autocomplete="off" placeholder="Colonia">
                    <input type="text" name="cp" autocomplete="off" 
                    value="<?php echo $perfil->direccion->cp; ?>" placeholder="Código Postal">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="ciudad" 
                    value="<?php echo $perfil->direccion->ciudad; ?>" autocomplete="off" placeholder="Ciudad">
                    <input type="text" name="estado" 
                    value="<?php echo $perfil->direccion->estado; ?>" autocomplete="off" placeholder="Estado">
                </div>
                    </div>
        
            <button type="submit">Modificar</button>
        </form>
    </div>
    </center>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("usuario").readOnly = true;
            var fotoPerfilActual = document.getElementById("foto-perfil-actual").value;
            
        });
        </script>
        
</body>
<footer class="footer">
    <div class="container">
        <p>&copy; 2023 Todos los derechos reservados.</p>
    </div>
</footer>
</html>