function validateTextInput(inputId, errorId) {
    const input = document.getElementById(inputId);
    const errorElement = document.getElementById(errorId);

    input.addEventListener('input', function(event) {
        const value = event.target.value;
        if (/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/.test(value)) {
            input.value = value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
            errorElement.textContent = 'Solo se permiten letras y espacios.';
        } else {
            errorElement.textContent = '';
        }
    });
}

validateTextInput('nombres', 'error-nombres');
validateTextInput('apellidos', 'error-apellidos');



document.getElementById('show_password').addEventListener('change', function() {
    var passwordField = document.getElementsByName('contraseña')[0];
    passwordField.type = this.checked ? 'text' : 'password';
});


document.getElementById('altura').addEventListener('input', function(event) {
    let value = event.target.value.replace(/[^0-9.,]/g, '');
    value = value.replace(',', '.'); // Reemplaza la coma por un punto
    if (value.length > 4) {
        value = value.substring(0, 4);
    }
    if (value.length === 3 && !value.includes('.')) {
        value = value[0] + '.' + value.substring(1);
    }
    event.target.value = value;
});
// Validación de altura
document.getElementById('altura').addEventListener('input', function(event) {
    let value = event.target.value.replace(/[^0-9.]/g, '');
    if (value.length > 4) {
        value = value.substring(0, 4);
    }
    event.target.value = value;
});
// Validación de peso
document.getElementById('peso').addEventListener('input', function(event) {
let value = event.target.value.replace(/[^0-9.,]/g, '');
value = value.replace(',', '.'); // Reemplaza la coma por un punto

// Limitar la longitud máxima a 5 caracteres (incluyendo el punto)
if (value.length > 5) {
value = value.substring(0, 5);
}

// Agregar automáticamente el punto después del tercer número si no hay un punto presente y se ingresaron menos de 4 caracteres
if (value.length === 3 && !value.includes('.')) {
value = value.substring(0, 3) + '.';
}

event.target.value = value;
});
function limitInput(input) {
    // Limitar el valor a 10 dígitos
    if (input.value.length > 10) {
        input.value = input.value.slice(0, 10);
    }
    // Reemplazar cualquier carácter no numérico
    input.value = input.value.replace(/[^0-9]/g, '');
}

// Validar en el envío del formulario que el input tenga al menos 7 dígitos
document.querySelector('form').addEventListener('submit', function(event) {
    var input = document.querySelector('input[type="number"]');
    if (input.value.length < 7) {
        alert('El número debe tener al menos 7 dígitos.');
        event.preventDefault(); // Evitar el envío del formulario
    }
});