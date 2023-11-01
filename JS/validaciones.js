
function validarFormulario() {
    var curp = document.getElementById("curp").value;
    var telefono = document.getElementById("telefono").value;
    var contrasena = document.getElementById("contrasena").value;

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