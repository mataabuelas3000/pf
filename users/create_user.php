<?php
include ('C:\xampp\htdocs\pf\database\connect.php');
$con->set_charset('utf8');

if (isset($_POST['enviar'])) {
    // Obtener los datos del formulario
    $id = $_POST['id'];
    $primernombre = $_POST['primernombre'];
    $segundonombre = $_POST['segundonombre'];
    $primerapellido = $_POST['primerapellido'];
    $segundoapellido = $_POST['segundoapellido'];
    $correo = $_POST['correo'];
    $genero = $_POST['genero'];
    $contrasena = $_POST['contraseña'];
    $altura = $_POST['altura'];
    $peso = $_POST['peso'];

    // Verificar y corregir el formato de altura
    $altura = str_replace(',', '.', $altura); // Reemplazar coma por punto
    if (!preg_match('/^\d{1,2}\.\d{2}$/', $altura)) {
        if (preg_match('/^\d{2,3}$/', $altura)) {
            $altura = substr($altura, 0, 1) . '.' . substr($altura, 1);
        } else {
            echo "<script>alert('La altura debe tener el formato #.##');</script>";
            exit;
        }
    }

// Verificar el formato del peso (debe ser ###.# o ##.#)
    $peso = str_replace(',', '.', $peso); // Reemplazar coma por punto
    if (!preg_match('/^\d{1,3}(\.\d{1})?$/', $peso)) { // Permitir uno decimal
        echo "<script>alert('El peso debe tener el formato ###.# o ##.#');</script>";
        exit;
    }


    // Calcular el IMC
    $imc = $peso / ($altura * $altura);

    // Verificar si el ID ya existe en la tabla 'login'
    $check_login = "SELECT * FROM login WHERE Id_User='$id'";
    $result_check_login = mysqli_query($con, $check_login);

    if (mysqli_num_rows($result_check_login) > 0) {
        echo "<script>alert('El ID ya existe en la tabla login.');</script>";
        exit;
    }

    // Insertar en la tabla 'login'
    $hash = password_hash($contrasena, PASSWORD_DEFAULT);
    $sql_login = "INSERT INTO login (Id_User, Password, Id_Role_User) VALUES ('$id', '$hash', 1)";
    $result_login = mysqli_query($con, $sql_login);

    if ($result_login) {
        echo "Usuario insertado correctamente en la tabla 'login'.<br>";

        // Verificar si el ID ya existe en la tabla 'user_info'
        $check_user_info = "SELECT * FROM user_info WHERE Id_User = '$id'";
        $result_check_user_info = mysqli_query($con, $check_user_info);

        if (mysqli_num_rows($result_check_user_info) > 0) {
            echo "<script>alert('El ID ya existe en la tabla user_info.');</script>";
            exit;
        }

        // Insertar en la tabla 'user_info'
        $sql_user_info = "INSERT INTO user_info (Id_User, Name_User, Last_Name_User, Email_User, Gender_User) VALUES ('$id', '$primernombre $segundonombre', '$primerapellido $segundoapellido', '$correo', '$genero')";
        $result_user_info = mysqli_query($con, $sql_user_info);

        if ($result_user_info) {
            echo "Usuario insertado correctamente en la tabla 'user_info'.<br>";

            // Verificar si el ID ya existe en la tabla 'data'
            $check_data = "SELECT * FROM data WHERE Id_User='$id'";
            $result_check_data = mysqli_query($con, $check_data);

            if (mysqli_num_rows($result_check_data) > 0) {
                echo "<script>alert('El ID ya existe en la tabla data.');</script>";
                exit;
            }

            // Insertar en la tabla 'data'
            $sql_data = "INSERT INTO data (Id_User, Height_User, Weight_User, Imc_User) VALUES ('$id', $altura, $peso, $imc)";
            $result_data = mysqli_query($con, $sql_data);

            if ($result_data) {
                echo '<script>alert("Usuario insertado correctamente en la tabla data."); window.location.href = "crud_users.php";</script>';
            } else {
                echo "Error al insertar en la tabla 'data': " . mysqli_error($con) . "<br>";
            }
        } else {
            echo "Error al insertar en la tabla 'user_info': " . mysqli_error($con) . "<br>";
        }
    } else {
        echo "Error al insertar en la tabla 'login': " . mysqli_error($con) . "<br>";
    }
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="stylesheet" href="style.css">
    <title>usuario</title>
</head>
<style>
    body {
        background-color: #202020;
    }
    .container{
        position: relative;
        top: 100px;
    }
    .form{
        padding: 35px;
        border: 2px solid #cccc;
        border-radius: 8px;
    }
    .input-container input {
    padding: 15px;
    border: 1px solid #ffffff;
    margin-top: 26px;
    font-size: 20px;
    }
    .input-container input::placeholder {
        color: #b6b6b6;
    }
    .titulo{
        text-align: center;
        color:white;
        font-size: 25px;
    }
    hr{
        background-color: #ffffff;
    }
    select option {
    color: black;
    /* Color oscuro en hexadecimal */
}
</style>
<body>
    <div class=" container my-5" style="width:100%;">
        <form method="post" class="form bg-dark" data-bs-theme="dark">
            <div class="titulo">
                <h1>REGISTRO DE USUARIO</h1>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Id</label>
                        <input type="number" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                            class="form-control text-light" id="id" name="id" placeholder="Ingrese su Numero de documento" required
                            value="<?php if (isset($_POST['id'])) echo $_POST['id']; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Primer nombre</label>
                        <input type="text" class="form-control text-light" id="primernombre" name="primernombre"
                            placeholder="Ingrese su nombre"
                            value="<?php if (isset($_POST['primernombre'])) echo $_POST['primernombre']; ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Segundo nombre</label>
                        <input type="text" class="form-control text-light" id="segundonombre" name="segundonombre"
                            placeholder="Ingrese su Segundo nombre"
                            value="<?php if (isset($_POST['segundonombre'])) echo $_POST['segundonombre']; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Primer apellido</label>
                        <input type="text" class="form-control text-light" id="primerapellido" name="primerapellido"
                            placeholder="Ingrese su apellido"
                            value="<?php if (isset($_POST['primerapellido'])) echo $_POST['primerapellido']; ?>"
                            required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Segundo apellido</label>
                        <input type="text" class="form-control text-light" id="segundoapellido" name="segundoapellido"
                            placeholder="Ingrese su Segundo apellido"
                            value="<?php if (isset($_POST['segundoapellido'])) echo $_POST['segundoapellido']; ?>"
                            required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Correo</label>
                        <input type="email" class="form-control text-light" id="correo" name="correo"
                            placeholder="Ingrese su correo"
                            value="<?php if (isset($_POST['correo'])) echo $_POST['correo']; ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group box-select input-container">
                        <label class="form-label">Genero</label>
                        <select class="form-select text-light" style="width:100%;margin-top:0px" id="genero" name="genero"
                            required>
                            <option value="" disabled selected  >Tipo de Genero</option>
                            <option value="M"
                                <?php if (isset($_POST['genero']) && $_POST['genero'] === 'M') echo 'selected'; ?>>
                                Masculino</option>
                            <option value="F"
                                <?php if (isset($_POST['genero']) && $_POST['genero'] === 'F') echo 'selected'; ?>>
                                Femenino</option>
                            <option value="O"
                                <?php if (isset($_POST['genero']) && $_POST['genero'] === 'O') echo 'selected'; ?>>Otro
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Contraseña</label>
                        <input type="password" class="form-control text-light" id="contraseña" name="contraseña"
                            placeholder="Ingrese su contraseña"
                            value="<?php if (isset($_POST['contraseña'])) echo $_POST['contraseña']; ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Altura</label>
                        <input type="text" step="0.01" class="form-control text-light" id="altura" name="altura"
                            placeholder="Ingrese su altura (#.##)"
                            value="<?php if (isset($_POST['altura'])) echo number_format($_POST['altura'], 2, '.', ''); ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Peso</label>
                        <input type="text" step="0.01" class="form-control text-light" id="peso" name="peso"
                            placeholder="Ingrese su peso (##.# o ##.##)"
                            value="<?php if (isset($_POST['peso'])) echo number_format($_POST['peso'], 2, '.', ''); ?>" required>
                    </div>
                </div>
            </div>


            <div class="row">

                <div class="col-md-6 checkbox text-light">
                    <input type="checkbox" name="show_password" id="show_password">
                    <label for="show_password">Mostrar contraseña</label>
                </div>
            </div>


            <div class="py-2">
            </div>
            <button type="submit" class="btn btn-light mr-4" name="enviar">Confirmar</button>
            <a href="crud_users.php"><button type="button" class="btn btn-danger" name="enviar">Cancelar</button></a>
        </form>
    </div>


    
    <script>
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




    </script>
</body>
</html>