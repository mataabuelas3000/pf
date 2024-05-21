document.getElementById('show_password').addEventListener('change', function () {
    var passwordField = document.getElementsByName('password')[0];
    passwordField.type = this.checked ? 'text' : 'password';
});

document.getElementById('login-link').addEventListener('click', function() {
    var overlay = document.getElementById('overlay');
    var loginContainer = document.getElementById('login-container');

    // Mostrar overlay y contenedor de inicio de sesión
    overlay.style.display = 'block';
    loginContainer.style.display = 'flex';

    // Aplicar clase para animación de fadeIn
    overlay.classList.remove('cerrar');
    loginContainer.classList.remove('cerrar');

    // Agregar clase para animación de fadeIn
    overlay.classList.add('abrir');
    loginContainer.classList.add('abrir');
});

document.getElementById('cerrar').addEventListener('click', function() {
    var overlay = document.getElementById('overlay');
    var loginContainer = document.getElementById('login-container');

    // Aplicar clase para animación de fadeOut
    overlay.classList.remove('abrir');
    loginContainer.classList.remove('abrir');

    // Agregar clase para animación de fadeOut
    overlay.classList.add('cerrar');
    loginContainer.classList.add('cerrar');

    // Esperar a que termine la animación y luego ocultar el overlay y el contenedor de inicio de sesión
    setTimeout(function() {
        overlay.style.display = 'none';
        loginContainer.style.display = 'none';
    }, 500); // Ajustar este valor según la duración de la animación en CSS
});
