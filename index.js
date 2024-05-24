document.getElementById('register-link').addEventListener('click', function() {
    var overlay = document.getElementById('overlay');
    var registerContainer = document.getElementById('register-container');

    // Mostrar overlay y contenedor de registro
    overlay.style.display = 'block';
    registerContainer.style.display = 'flex';

    // Agregar clase para animación de fadeIn
    overlay.classList.add('abrir');
    registerContainer.classList.add('abrir');
});

document.getElementById('login-link').addEventListener('click', function() {
    var overlay = document.getElementById('overlay');
    var loginContainer = document.getElementById('login-container');

    // Mostrar overlay y contenedor de inicio de sesión
    overlay.style.display = 'block';
    loginContainer.style.display = 'flex';

    // Agregar clase para animación de fadeIn
    overlay.classList.add('abrir');
    loginContainer.classList.add('abrir');
});

document.getElementById('cerrar-register').addEventListener('click', function() {
    var overlay = document.getElementById('overlay');
    var registerContainer = document.getElementById('register-container');

    // Ocultar overlay y contenedor de registro
    overlay.style.display = 'none';
    registerContainer.style.display = 'none';

    // Remover clase para animación de fadeIn
    overlay.classList.remove('abrir');
    registerContainer.classList.remove('abrir');
});

document.getElementById('cerrar-login').addEventListener('click', function() {
    var overlay = document.getElementById('overlay');
    var loginContainer = document.getElementById('login-container');

    // Ocultar overlay y contenedor de inicio de sesión
    overlay.style.display = 'none';
    loginContainer.style.display = 'none';

    // Remover clase para animación de fadeIn
    overlay.classList.remove('abrir');
    loginContainer.classList.remove('abrir');
});
