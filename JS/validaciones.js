
function validarFormulario() {
    var nombre = document.getElementById("nombres").value;
    var apellidoPaterno = document.getElementById("apellido-paterno").value;
    var apellidoMaterno = document.getElementById("apellido-materno").value;

    var curp = document.getElementById("curp").value;
    var telefono = document.getElementById("telefono").value;
    var contrasena = document.getElementById("contrasena").value;
    var fechaNacimiento = document.getElementById("fecha-nacimiento").value;
    var inputArchivo = document.getElementById("foto-perfil");

    var fechaActual = new Date();
    var fechaNacimientoDate = new Date(fechaNacimiento);
    var edad = fechaActual.getFullYear() - fechaNacimientoDate.getFullYear();

    if (!nombre) {  
        alert("Por favor, escribe tu nombre.");
        return false;
    }
    if (!apellidoPaterno) {
        alert("Por favor, escribe tu apellido paterno.");
        return false;
    }   
    if (!apellidoMaterno) {
        alert("Por favor, escribe tu apellido materno.");
        return false;
    }   
    if (inputArchivo.files.length === 0) {
        alert("Por favor, selecciona una foto antes de enviar el formulario.");
        return false;
    }
    
    if (!fechaNacimiento) {
        alert("Por favor, selecciona una fecha de nacimiento.");
        return false;
    }

    if (edad < 18 && fechaNacimiento ) {
        alert("El usuario que intentas registrar no cumple la edad mínima.");
        return false;
    }

    if (curp.length !== 18) {
        alert("La CURP debe tener exactamente 18 caracteres.");
        
        return false;
    }

    if (!/^\d{10}$/.test(telefono)) {
        alert("El teléfono debe contener exactamente 10 dígitos numéricos.");
        return false;
    }

    if (!/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(contrasena)) {
        alert("La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial.");
        return false;
    }
    if (edad < 18) {
        alert("El usuario que intentas registrar no cumple la edad minima");
        return false; 
    }

    return true;
}

function mostrarOcultarContrasena() {
    var contrasenaInput = document.getElementById("contrasena");
    if (contrasenaInput.type === "password") {
        contrasenaInput.type = "text";
    } else {
        contrasenaInput.type = "password";
    }
}