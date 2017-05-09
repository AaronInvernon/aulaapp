document.addEventListener('DOMContentLoaded', main, false);

function main() {

    var myForm = document.getElementById("myForm");

    myForm.userName.addEventListener("blur", validarNombreUsuario, false);
    myForm.password.addEventListener("blur", validarContra, false);
    myForm.rePassword.addEventListener("blur", comprobarContra, false);
    myForm.userNameReal.addEventListener("blur", validarNombreApellidos, false);
    myForm.firstSurname.addEventListener("blur", validarNombreApellidos, false);
    myForm.secondSurname.addEventListener("blur", validarNombreApellidos, false);
    myForm.mail.addEventListener("blur", validarEmail, false);
    myForm.questions.addEventListener("blur", validarPregunta, false);
    myForm.answer.addEventListener("blur", validarRespuesta, false);

    function validarNombreUsuario(nombre) {
        nombre.target.nextElementSibling.textContent = "";
        nombre.target.nextElementSibling.className = "ok";
        if (nombre.target.value.trim().match(/[A-Za-z0-9]{4,15}/) == null) {
            nombre.target.nextElementSibling.className = "error";
            nombre.target.nextElementSibling.textContent = "Introduce " + nombre.target.title + " entre 4 y 15 carácteres alfanúmericos";
            return false;
        }
        return true;
    }

    function validarContra(contra) {
        contra.target.nextElementSibling.textContent = "";
        contra.target.nextElementSibling.className = "ok";
        if (contra.target.value.trim().match(/^[A-Za-z0-9]{6,15}$/) == null) {
            contra.target.nextElementSibling.className = "error";
            contra.target.nextElementSibling.textContent = "Introduce " + contra.target.title + " entre 6 y 15 carácteres alfanúmericos";
            return false;
        }
        return true;
    }

    function comprobarContra(contra) {
        contra.target.nextElementSibling.textContent = "";
        contra.target.nextElementSibling.className = "ok";
        if (contra.target.value != myForm.password.value) {
            contra.target.nextElementSibling.className = "error";
            contra.target.nextElementSibling.textContent = "Las contraseñas no coinciden";
            return false;
        }
        return true;
    }

    function validarNombreApellidos(cadena) {
        cadena.target.nextElementSibling.textContent = "";
        cadena.target.nextElementSibling.className = "ok";
        if (cadena.target.value.trim().match(/^([A-ZÑÁÉÍÓÚa-zñáéíóú]+[\s]?)+$/) == null) {
            cadena.target.nextElementSibling.className = "error";
            cadena.target.nextElementSibling.textContent = "Introduce " + cadena.target.title + ", solo carácteres alfabéticos";
            return false;
        }
        cadena.target.value = cadena.target.value.charAt(0).toUpperCase() + cadena.target.value.slice(1);
        return true;
    }

    function validarEmail(email) {
        email.target.nextElementSibling.textContent = "";
        email.target.nextElementSibling.className = "ok";
        if (email.target.value.trim().match(/^[a-z0-9](\.?[a-z0-9_-]){0,}@[a-z0-9-]+\.([a-z]{1,6}\.)?[a-z]{2,6}$/) == null) {
            email.target.nextElementSibling.className = "error";
            email.target.nextElementSibling.textContent = "Introduce " + email.target.title + " válido, hola@mundo.com";
            return false;
        }
        return true;
    }

    function validarPregunta(pregunta) {
        pregunta.target.nextElementSibling.textContent = "";
        pregunta.target.nextElementSibling.className = "ok";
        if (pregunta.target.selectedIndex == null || pregunta.target.selectedIndex == 0) {
            pregunta.target.nextElementSibling.className = "error";
            pregunta.target.nextElementSibling.textContent = "Selecciona una " + pregunta.target.title + " para recuperar tu cuenta si olvidas tu contraseña";
            return false;
        }
        return true;
    }

    function validarRespuesta(respuesta) {
        respuesta.target.nextElementSibling.textContent = "";
        respuesta.target.nextElementSibling.className = "ok";
        if (respuesta.target.value.trim().length <= 0 || respuesta.target.value.trim().length > 20) {
            respuesta.target.nextElementSibling.className = "error";
            respuesta.target.nextElementSibling.textContent = "Responde la " + respuesta.target.title + " seleccionada";
            return false;
        }
        return true;
    }
}