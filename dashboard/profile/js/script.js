function soloLetras(event) {
    var charCode = event.which ? event.which : event.keyCode;
    if ((charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122)) {
        event.preventDefault();
        return false;
    }
    return true;
}

                 document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('actualizarForm');
            const inputs = form.querySelectorAll('input, select');

            inputs.forEach(input => {
                input.addEventListener('input', function () {
                    if (input.checkValidity()) {
                        input.classList.remove('border-danger');
                        input.classList.add('border-success');
                        input.nextElementSibling.classList.add('icon-success');
                        input.nextElementSibling.classList.remove('icon-error');
                        input.nextElementSibling.style.display = 'inline-block'; // Mostrar el icono de "correcto"
                    } else {
                        input.classList.remove('border-success');
                        input.classList.add('border-danger');
                        input.nextElementSibling.classList.remove('icon-success');
                        input.nextElementSibling.classList.add('icon-error');
                        input.nextElementSibling.style.display = 'inline-block'; // Mostrar el icono de "error"
                    }
                });
            });
        });
                document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('actualizarForm');
            const inputs = form.querySelectorAll('input, select');

            inputs.forEach(input => {
                input.addEventListener('input', function () {
                    if (input.checkValidity()) {
                        input.classList.remove('border-danger');
                        input.classList.add('border-success');
                        if (!input.nextElementSibling || !input.nextElementSibling.classList.contains('fa-check')) {
                            const icon = document.createElement('i');
                            icon.className = 'fas fa-check ml-2 text-success';
                            input.parentNode.insertBefore(icon, input.nextElementSibling);
                        }
                    } else {
                        input.classList.remove('border-success');
                        input.classList.add('border-danger');
                        const icon = input.nextElementSibling;
                        if (icon && icon.classList.contains('fa-check')) {
                            icon.remove();
                        }
                    }
                });
            });

            const nombreInput = form.querySelector('input[name="primernombre"]');
            const apellidoInput = form.querySelector('input[name="primerapellido"]');
            const correoInput = form.querySelector('input[name="correo"]');

            nombreInput.addEventListener('input', function () {
                if (/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(nombreInput.value)) {
                    nombreInput.classList.remove('border-danger');
                    nombreInput.classList.add('border-success');
                } else {
                    nombreInput.classList.remove('border-success');
                    nombreInput.classList.add('border-danger');
                }
            });

            apellidoInput.addEventListener('input', function () {
                if (/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(apellidoInput.value)) {
                    apellidoInput.classList.remove('border-danger');
                    apellidoInput.classList.add('border-success');
                } else {
                    apellidoInput.classList.remove('border-success');
                    apellidoInput.classList.add('border-danger');
                }
            });

            correoInput.addEventListener('input', function () {
                if (/^\S+@\S+\.\S+$/.test(correoInput.value)) {
                    correoInput.classList.remove('border-danger');
                    correoInput.classList.add('border-success');
                } else {
                    correoInput.classList.remove('border-success');
                    correoInput.classList.add('border-danger');
                }
            });
        });
            document.getElementById('show_password').addEventListener('change', function() {
        var passwordFields = document.querySelectorAll('[name="passlast"], [name="passnew"]');
        for (var i = 0; i < passwordFields.length; i++) {
            passwordFields[i].type = this.checked ? 'text' : 'password';
        }
    });