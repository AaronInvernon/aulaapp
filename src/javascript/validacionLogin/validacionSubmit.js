document.addEventListener('DOMContentLoaded', main, false);

function main() {

    var myForm = document.getElementById("myForm");
    myForm.addEventListener("submit", comprobarForm, false);
    myForm.addEventListener("reset", limpiarSpans, false);

    function comprobarForm(e) {

        var valido = true;

        valido = validarNombreUsuario(myForm.userName);
        valido &= validarContra(myForm.password);

        if (valido) return;
        e.preventDefault();
    }

    function limpiarSpans(){
        var spans = document.getElementsByTagName("span");
        for(var i=0; i<spans.length; i++){
            spans[i].textContent = "";
        }
    }

    function validarNombreUsuario(nombre) {
        nombre.nextElementSibling.textContent = "";
        if (nombre.value.trim().match(/^[A-Za-z0-9]{4,15}$/) == null) {
            nombre.nextElementSibling.textContent = "Introduce " + nombre.title + " correcto";
            return false;
        }
        return true;
    }

    function validarContra(contra) {
        contra.nextElementSibling.textContent = "";
        if (contra.value.trim().match(/^[\w]{6,15}$/) == null) {
            contra.nextElementSibling.textContent = "Introduce " + contra.title + " correcta";
            return false;
        }
        return true;
    }
}