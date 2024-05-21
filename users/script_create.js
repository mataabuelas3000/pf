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

validateTextInput('primernombre', 'error-primernombre');
validateTextInput('segundonombre', 'error-segundonombre');
validateTextInput('primerapellido', 'error-primerapellido');
validateTextInput('segundoapellido', 'error-segundoapellido');  

document.getElementById('show_password').addEventListener('change', function() {
    var passwordField = document.getElementsByName('contraseña')[0];
    passwordField.type = this.checked ? 'text' : 'password';
});
// Validación de altura
// Validación de altura
// Validación de altura
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