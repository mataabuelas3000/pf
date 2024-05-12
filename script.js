document.getElementById('show_password').addEventListener('change', function () {
    var passwordField = document.getElementsByName('password')[0];
    passwordField.type = this.checked ? 'text' : 'password';
});

