var intervalos = {}; // Objeto para almacenar los intervalos de cada cuenta regresiva
var tiemposRestantes = {}; // Objeto para almacenar los tiempos restantes de cada cuenta regresiva

function iniciarCuentaRegresiva(modalId, duracion, nextModalId, id_rutina) {
    var cuentaRegresiva = document.getElementById("cuentaRegresiva" + modalId);
    var btnIniciar = document.getElementById("btnIniciar" + modalId);
    var btnDetener = document.getElementById("btnDetener" + modalId);
    var btnSiguiente = document.getElementById("btnSiguiente" + modalId);
    var btnClose = document.getElementById("closebtn" + modalId);

    // Detener cualquier cuenta regresiva en curso
    detenerCuentaRegresiva(modalId);

    // Verificar si hay un tiempo restante almacenado para reanudar la cuenta regresiva
    var tiempoRestante = tiemposRestantes[modalId] || duracion;

    // Ocultar el botón de cierre al iniciar la cuenta regresiva
    btnClose.style.display = "none";

    // Función para actualizar la cuenta regresiva
    function actualizarCuentaRegresiva() {
        var minutos = Math.floor(tiempoRestante / 60);
        var segundos = tiempoRestante % 60;
        cuentaRegresiva.querySelector("span").innerText = minutos.toString().padStart(2, '0') + ":" + segundos
            .toString().padStart(2, '0');
    }

    // Función para iniciar la cuenta regresiva
    function iniciarCuentaRegresiva() {
        intervalos[modalId] = setInterval(function() {
            tiempoRestante--;
            actualizarCuentaRegresiva();
            if (tiempoRestante <= 0) {
                clearInterval(intervalos[modalId]);
                if (nextModalId.startsWith("descanso")) {
                    // Si es un descanso, abrir el siguiente ejercicio automáticamente
                    $('#' + nextModalId).modal('show');
                } else {
                    // Si es el último ejercicio, mostrar los botones correspondientes
                    btnSiguiente.classList.remove(
                        "d-none"); // Mostrar botón "Siguiente" cuando termine el tiempo
                    btnClose.style.display = "block"; // Mostrar el botón de cierre cuando termine el tiempo
                    btnIniciar.style.display = "none"; // Ocultar el botón de iniciar
                    btnDetener.style.display = "none"; // Ocultar el botón de detener
                    cuentaRegresiva.classList.add("d-none");
                }
            }
        }, 1);
    }

    // Mostrar botón de detener y ocultar botón de iniciar
    btnDetener.classList.remove("d-none");
    btnIniciar.classList.add("d-none");
    cuentaRegresiva.classList.remove("d-none");
    iniciarCuentaRegresiva();
    actualizarIdRutina(id_rutina);
}

function actualizarIdRutina(id_rutina) {
    var inputIdRutina = document.getElementById('id_rutina');
    if (inputIdRutina) {
        inputIdRutina.value = id_rutina;
    }
}

function detenerCuentaRegresiva(modalId) {
    var btnDetener = document.getElementById("btnDetener" + modalId);
    var btnIniciar = document.getElementById("btnIniciar" + modalId);
    var btnClose = document.getElementById("closebtn" + modalId);

    // Detener la cuenta regresiva si está en curso
    clearInterval(intervalos[modalId]);

    // Almacenar el tiempo restante
    tiemposRestantes[modalId] = calcularTiempoRestante(modalId);

    // Ocultar el botón de detener y mostrar el botón de iniciar
    btnDetener.classList.add("d-none");
    btnIniciar.classList.remove("d-none");

    // Mostrar el botón de cierre
    btnClose.style.display = "block";
}

// Función para calcular el tiempo restante en segundos
function calcularTiempoRestante(modalId) {
    var cuentaRegresiva = document.getElementById("cuentaRegresiva" + modalId);
    var tiempoTexto = cuentaRegresiva.querySelector("span").innerText;
    var partesTiempo = tiempoTexto.split(":");
    var minutos = parseInt(partesTiempo[0]);
    var segundos = parseInt(partesTiempo[1]);
    return minutos * 60 + segundos;
}

// Función para iniciar el último ejercicio
function iniciarUltimoEjercicio(modalId, duracion) {
    var btnIniciar = document.getElementById("btnIniciar" + modalId);
    var btnDetener = document.getElementById("btnDetener" + modalId);
    var cuentaRegresiva = document.getElementById("cuentaRegresiva" + modalId);
    var btnClose = document.getElementById("closebtn" + modalId);
    // Mostrar cuenta regresiva y botón de detener
    cuentaRegresiva.classList.remove("d-none");
    btnDetener.classList.remove("d-none");
    btnClose.style.display = "none";
    // Ocultar botón de iniciar
    btnIniciar.classList.add("d-none");

    // Iniciar cuenta regresiva
    iniciarCuentaRegresiva(modalId, duracion, "");
}

function detenerUltimoEjercicio(modalId) {
    var btnIniciar = document.getElementById("btnIniciar" + modalId);
    var btnDetener = document.getElementById("btnDetener" + modalId);
    var btnSiguiente = document.getElementById("btnSiguiente" + modalId);
    var cuentaRegresiva = document.getElementById("cuentaRegresiva" + modalId);
    var btnFelicitaciones = document.getElementById("btnFelicitaciones"); // Botón de felicitaciones con ID único
    var btnClose = document.getElementById("closebtn" + modalId);

    // Ocultar cuenta regresiva y botón de detener
    cuentaRegresiva.classList.add("d-none");
    btnDetener.classList.add("d-none");

    // Mostrar botón de iniciar
    btnIniciar.classList.remove("d-none");

    // Limpiar el intervalo y el tiempo restante
    clearInterval(intervalos[modalId]);
    tiemposRestantes[modalId] = null;
    btnClose.style.display = "block";

    // Verificar si el tiempo restante es menor o igual a cero para mostrar el botón de felicitaciones
    var tiempoRestante = calcularTiempoRestante(modalId);
    if (tiempoRestante <= 0) {
        btnFelicitaciones.classList.remove("d-none");
        cuentaRegresiva.classList.add("d-none");
        btnDetener.classList.add("d-none");
        btnIniciar.classList.add("d-none");
    }
}
//-------------------------------------------------



window.onload = function() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
};


var inputs = document.querySelectorAll('input[type="number"]');

inputs.forEach(function(input) {
    input.addEventListener('input', function() {
        var valor = this.value.trim();
        var soloNumeros = valor.replace(/[^0-9]/g, '');
        this.value = soloNumeros;
    });
});


$(function() {
    $("#ejercicios-lista").sortable({
        handle: '.draggable-handle', // especifica que el icono es el mango para arrastrar
        update: function(event, ui) {
            // Obtener el nuevo orden de los ejercicios
            var nuevoOrden = $(this).sortable('toArray').toString();

            // Almacenar el nuevo orden en el almacenamiento local
            localStorage.setItem('nuevoOrden', nuevoOrden);
        }
    });

    var ordenGuardado = localStorage.getItem('nuevoOrden');
    if (ordenGuardado) {
        var ejerciciosLista = $("#ejercicios-lista");
        var ejercicios = ordenGuardado.split(',');
        for (var i = 0; i < ejercicios.length; i++) {
            var ejercicio = $("#" + ejercicios[i]);
            ejerciciosLista.append(ejercicio);
        }
    }

    $("#ejercicios-lista").disableSelection();
});