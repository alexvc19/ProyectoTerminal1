function validarFormulario() {
    var usuario = document.getElementById("user").value;
    var contrasena = document.getElementById("pass").value;

    if (!usuario || !contrasena) {
        alert("Por favor, completa todos los campos.");
        return false;
    }
    /*
    var caracteresEspeciales = /[!@#$%^&*(),.?":{}|<>]/;
    if (!caracteresEspeciales.test(contrasena)) {
        alert("La contraseña debe contener al menos un caracter especial.");
        return false;
    }*/

    var expresionSQL = /([';{}()\-])/;
    if (expresionSQL.test(usuario) || expresionSQL.test(contrasena)) {
        alert("Se ha detectado un intento de SQL injection.");
        return false;
    }


    return true;
}
