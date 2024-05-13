<?php
// Incluir el archivo de conexión a la base de datos
include ('C:\xampp\htdocs\pf\database\connect.php');
$con->set_charset('utf8');
// Obtener el ID del usuario a actualizar de los parámetros GET
$idviejo = $_GET['updateid'];

// Consultar los datos del usuario a actualizar utilizando INNER JOIN
$sql = "SELECT login.*, user_info.*, data.Height_User, data.Weight_User, data.Imc_User 
        FROM login 
        INNER JOIN user_info ON login.Id_User = user_info.Id_User 
        INNER JOIN data ON login.Id_User = data.Id_User 
        WHERE login.Id_User = $idviejo";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

// Obtener los datos del usuario a actualizar
$id = $row['Id_User'];
$password = $row['Password'];
$rol = $row['Id_Role_User'];
$primernombre = $row['Name_User'];
$primerapellido = $row['Last_Name_User'];
$correo = $row['Email_User'];
$genero = $row['Gender_User'];
$altura = $row['Height_User'];
$peso = $row['Weight_User'];
$IMC = $row['Imc_User'];

// Verificar si se ha enviado el formulario para actualizar los datos
if (isset($_POST['mandar'])) {
    // Obtener los datos enviados por el formulario
    $password = $_POST['pass'];
    $primernombre = $_POST['primernombre'];
    $primerapellido = $_POST['primerapellido'];
    $correo = $_POST['correo'];
    $genero = $_POST['genero'];
    $altura = $_POST['altura'];
    $peso = $_POST['peso'];

    // Validar el formato de la altura (debe ser #.##)
    if (!preg_match('/^\d+\.\d{2}$/', $altura)) {
        echo "<script>alert('La altura debe tener el formato #.##');</script>";
    }

    if (!preg_match('/^\d{2}\.\d{2}$/', $peso)) {
        echo "<script>alert('El peso debe tener el formato ##.##');</script>";
    }

    // Calcular el Índice de Masa Corporal (IMC)
    $IMC = $peso / ($altura * $altura);

    // Actualizar los datos del usuario en la base de datos
    $sql = "UPDATE login 
            INNER JOIN user_info ON login.Id_User = user_info.Id_User 
            INNER JOIN data ON login.Id_User = data.Id_User 
            SET login.Password = '$password', login.Id_Role_User = '$rol', 
                user_info.Name_User = '$primernombre', user_info.Last_Name_User = '$primerapellido', user_info.Email_User = '$correo', user_info.Gender_User = '$genero', 
                data.Height_User = '$altura', data.Weight_User = '$peso', data.Imc_User = '$IMC' 
            WHERE login.Id_User = '$idviejo'";
    $result = mysqli_query($con, $sql);
    if ($result) {
        echo '<script>alert("Datos actualizados"); window.location.href = "interface.php#info";</script>';
        exit;
    } else {
        // Mostrar un mensaje de error si la actualización falla
        die(mysqli_error($con));
    }
} else if (isset($_POST['cancelar'])) {
    // Redirigir de vuelta a la página de administración de usuarios si se cancela la actualización
    header('location: interface.php#info');
}
?>




        <!doctype html>
        <html lang="en">

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
            <link rel="stylesheet" href="interface_style.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-Kpv8THDbkGt7upobz6i8tM8aK5MUKWk1z/zUJQ+xhxC5xR3nTO2EoeGvEY5mCZQ7mKqm40sv5Yq97h4ajc0L2Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />

            <title>actualizar</title>
        </head>

        <body>
            
           
            
            <div class="container my-7" id="cerrar">
            <h1 style="text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.5);">
        Actualiza tus Datos
        </h1>
        <hr class="hr">
                <form method="post" id="actualizarForm">
                    <div class="row ">
                        <div class="col-md-6">
                            <div class="form-group input-container">
                                <label class="form-label">ID</label>
                                <input type="number" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                    class="form-control" name="id" placeholder="Ingrese su id"
                                    value="<?php echo $idviejo ?>" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group input-container">
                                <label class="form-label">Primer nombre</label>
                                <input type="text" class="form-control" name="primernombre" id="inputText" onkeypress="return soloLetras(event)"
                                    placeholder="Ingrese su nombre" value="<?php echo $primernombre ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group input-container">
                                <label class="form-label">Apellidos</label>
                                <input type="text" class="form-control" name="primerapellido"id="inputText" onkeypress="return soloLetras(event)"
                                    placeholder="Ingrese su Segundo apellido" value="<?php echo $primerapellido ?>"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group input-container">
                                <label class="form-label">Correo</label>
                                <input type="email" class="form-control" name="correo" placeholder="Ingrese su correo"
                                    value="<?php echo $correo ?>" required>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group input-container" style="margin-top:30px;box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5);">
                                <label class="form-label">Genero</label>
                                <select class="form-select" style="width:100%; margin-top:0px" name="genero" required>
                                    <option value="M" <?php if ($genero === 'M') echo 'selected'; ?>>Masculino</option>
                                    <option value="F" <?php if ($genero === 'F') echo 'selected'; ?>>Femenino</option>
                                    <option value="O" <?php if ($genero === 'O') echo 'selected'; ?>>Otro</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group input-container">
                                <label class="form-label">Altura</label>
                                <input type="number" step="0.01" class="form-control" id="altura" name="altura"
                                    placeholder="Ingrese su altura" value="<?php echo $altura ?>" required>
                            </div>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group input-container">
                                <label class="form-label">Peso</label>
                                <input type="number" step="0.01" class="form-control" id="peso" name="peso"
                                    placeholder="Ingrese su peso" value="<?php echo $peso ?>" required>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group input-container">
                                <label class="form-label">Contraseña</label>
                                <input type="password" class="form-control" name="pass"
                                    placeholder="Ingrese su contraseña" value="<?php echo $password ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 checkbox">
                        <input type="checkbox" name="show_password" id="show_password">
                        <label for="show_password">Mostrar contraseña</label>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-dark" name="mandar" id="updatebtn">Actualizar</button>
                    <button type="submit" class="btn btn-danger" name="cancelar">Cancelar</button>
            </div>
            <div class="mr-5"></div>
            </form>
            </div>
            <script>
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
                var passwordField = document.getElementsByName('pass')[0];
                passwordField.type = this.checked ? 'text' : 'password';
            });
            </script>

        </body>

        </html>