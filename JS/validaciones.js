
function validarFormulario() {
    var nombre = document.getElementById("nombres").value;
    var apellidoPaterno = document.getElementById("apellido-paterno").value;
    var apellidoMaterno = document.getElementById("apellido-materno").value;


    var curp = document.getElementById("curp").value;
    var telefono = document.getElementById("telefono").value;
    var contrasena = document.getElementById("contrasena").value;
    var fechaNacimiento = document.getElementById("fecha-nacimiento").value;
    var contrasena = document.getElementById("contrasena").value;

    var fechaActual = new Date();
    var fechaNacimientoDate = new Date(fechaNacimiento);
    var edad = fechaActual.getFullYear() - fechaNacimientoDate.getFullYear();

    if (!nombre) {  
        mostrarModal('Por favor, escribe tu nombre.');
        return false;
    }
    if (!apellidoPaterno) {
        mostrarModal('Por favor, escribe tu apellido paterno.');
        
        return false;
    }   
    if (!apellidoMaterno) {
        mostrarModal('Por favor, escribe tu apellido materno.');
        
        return false;
    }   
    
    if (inputArchivo.files.length === 0) {
        mostrarModal('Por favor, selecciona una foto de perfil.');
        return false;
    }

    
    if (!fechaNacimiento) {
        mostrarModal('Por favor, escribe tu fecha de nacimiento.');
        return false;
    }

    if (edad < 18 && fechaNacimiento ) {
        mostrarModal('El usuario que intentas registrar no cumple la edad minima');
        return false;
    }

    if (curp.length !== 18) {
        mostrarModal('La CURP debe contener exactamente 18 caracteres.');
        
        return false;
    }

    if (!/^\d{10}$/.test(telefono)) {
        mostrarModal('El teléfono debe contener exactamente 10 dígitos.');
        return false;
    }

    if (!/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(contrasena)) {
        mostrarModal('La contraseña debe contener al menos 8 caracteres, una letra mayúscula, un número y un carácter especial.');
        return false;
    }
    if (edad < 18) {
        mostrarModal('El usuario que intentas registrar no cumple la edad minima');
        return false; 
    }

    return true;
}
function validarForm(){
    var nombre = document.getElementById("nombres").value;
    var apellidoPaterno = document.getElementById("apellido-paterno").value;
    var apellidoMaterno = document.getElementById("apellido-materno").value;

    var curp = document.getElementById("curp").value;
    var telefono = document.getElementById("telefono").value;
    var fechaNacimiento = document.getElementById("fecha-nacimiento").value;
    var contrasena = document.getElementById("contrasena").value; 
    
    var cp = document.getElementById("cp").value;
    var calle = document.getElementById("calle").value;
    var numero = document.getElementById("numero").value;
    var colonia = document.getElementById("colonia").value;

    var fechaActual = new Date();
    var fechaNacimientoDate = new Date(fechaNacimiento);
    var edad = fechaActual.getFullYear() - fechaNacimientoDate.getFullYear();

    if (!nombre) {
        mostrarModal('Por favor, escribe tu nombre.');
        return false;
    }
    if (!apellidoPaterno) {
        mostrarModal('Por favor, escribe tu apellido paterno.');
        return false;
    }
    if (!apellidoMaterno) {
        mostrarModal('Por favor, escribe tu apellido materno.');
        return false;
    }

    if (!fechaNacimiento) {
        mostrarModal('Por favor, escribe tu fecha de nacimiento.');
        return false;
    }

    if (edad < 18 && fechaNacimiento) {
        mostrarModal('El usuario que intentas registrar no cumple la edad mínima');
        return false;
    }

    if (curp.length !== 18) {
        mostrarModal('La CURP debe contener exactamente 18 caracteres.');
        return false;
    }

    if (!/^\d{10}$/.test(telefono)) {
        mostrarModal('El teléfono debe contener exactamente 10 dígitos.');
        return false;
    }

    if (contrasena !== null && contrasena.trim() !== '' && !/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(contrasena)) {
        mostrarModal('La contraseña debe contener al menos 8 caracteres, una letra mayúscula, un número y un carácter especial.');
        return false;
    }

    if (edad < 18) {
        mostrarModal('El usuario que intentas registrar no cumple la edad mínima');
        return false;
    }

    if(!numero){
        mostrarModal('Por favor, escribe tu número de casa.');
        return false;
    }
    if(!calle){
        mostrarModal('Por favor, escribe tu calle.');
        return false;
    }
    if(!cp){
        mostrarModal('Por favor, escribe tu código postal.');
        return false;
    }
    if(!colonia){
        mostrarModal('Por favor, escribe tu colonia.');
        return false;
    }
    return true;
}

function mostrarOcultarContrasena(){
    var tipo = document.getElementById("contrasena");
    if(tipo.type == "password"){
        tipo.type = "text";
    }else{
        tipo.type = "password";
    }
}



function mostrarModal(texto) {
    var modal = document.getElementById('genericModal');
    var modalText = document.getElementById('modalText');

    modalText.innerText = texto;

    modal.style.display = 'block';

    window.onclick = function (event) {
        if (event.target == modal) {
            cerrarModal('genericModal');
        }
    };
}

function cerrarModal(idModal) {
    var modal = document.getElementById(idModal);
    modal.style.display = 'none';
}