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

    // Verificar el formato del peso (debe ser ##.#)
    if (!preg_match('/^\d{2}\.\d$/', $peso)) {
        echo "<script>alert('El peso debe tener el formato ##.#');</script>";
        exit;
    }

    // Calcular el IMC
    $imc = $peso / ($altura * $altura);

    // Insertar en la tabla login
    $sql_login = "INSERT INTO login (Id_User, Password, Id_Role_User) VALUES ('$id', '$contrasena', 1)";
    $result_login = mysqli_query($con, $sql_login);

    if ($result_login) {
        echo "Usuario insertado correctamente en la tabla 'login'.<br>";

        // Insertar en la tabla user_info
        $sql_user_info = "INSERT INTO user_info (Id_User, Name_User, Last_Name_User, Email_User, Gender_User) VALUES ('$id', '$primernombre $segundonombre', '$primerapellido $segundoapellido', '$correo', '$genero')";
        $result_user_info = mysqli_query($con, $sql_user_info);

        if ($result_user_info) {
            echo "Usuario insertado correctamente en la tabla 'user_info'.<br>";

            // Insertar en la tabla data
            $sql_data = "INSERT INTO data (Id_User, Height_User, Weight_User, Imc_User) VALUES ('$id', $altura, $peso, $imc)";
            $result_data = mysqli_query($con, $sql_data);

            if ($result_data) {
                echo "<script>alert('Usuario insertado correctamente en la tabla data.')</script>";
            } 
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

<body>
    
    <div class=" container my-5" style="width:70%">
        <form method="post" class="form">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Id</label>
                        <input type="number" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                            class="form-control" id="id" name="id" placeholder="Ingrese su Numero de documento" required
                            value="<?php if (isset($_POST['id'])) echo $_POST['id']; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Primer nombre</label>
                        <input type="text" class="form-control" id="primernombre" name="primernombre"
                            placeholder="Ingrese su nombre"
                            value="<?php if (isset($_POST['primernombre'])) echo $_POST['primernombre']; ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Segundo nombre</label>
                        <input type="text" class="form-control" id="segundonombre" name="segundonombre"
                            placeholder="Ingrese su Segundo nombre"
                            value="<?php if (isset($_POST['segundonombre'])) echo $_POST['segundonombre']; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Primer apellido</label>
                        <input type="text" class="form-control" id="primerapellido" name="primerapellido"
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
                        <input type="text" class="form-control" id="segundoapellido" name="segundoapellido"
                            placeholder="Ingrese su Segundo apellido"
                            value="<?php if (isset($_POST['segundoapellido'])) echo $_POST['segundoapellido']; ?>"
                            required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo"
                            placeholder="Ingrese su correo"
                            value="<?php if (isset($_POST['correo'])) echo $_POST['correo']; ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group box-select input-container">
                        <label class="form-label">Genero</label>
                        <select class="form-select" style="width:100%;margin-top:0px" id="genero" name="genero"
                            required>
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
                        <input type="password" class="form-control" id="contraseña" name="contraseña"
                            placeholder="Ingrese su contraseña"
                            value="<?php if (isset($_POST['contraseña'])) echo $_POST['contraseña']; ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Altura</label>
                        <input type="number" step="0.01" class="form-control" id="altura" name="altura"
                            placeholder="Ingrese su altura"
                            value="<?php if (isset($_POST['altura'])) echo $_POST['altura']; ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Peso</label>
                        <input type="number" step="0.01" class="form-control" id="peso" name="peso"
                            placeholder="Ingrese su peso"
                            value="<?php if (isset($_POST['peso'])) echo $_POST['peso']; ?>" required>
                    </div>

                </div>
            </div>


            <div class="row">

                <div class="col-md-6 checkbox">
                    <input type="checkbox" name="show_password" id="show_password">
                    <label for="show_password">Mostrar contraseña</label>
                </div>
            </div>


            <div class="py-2">
            </div>
            <button type="submit" class="btn btn-secondary mr-4" name="enviar">Confirmar</button>
            <a href="crud_users.php"><button type="button" class="btn btn-danger" name="enviar">Cancelar</button></a>
        </form>
    </div>


    <script>
    document.getElementById('show_password').addEventListener('change', function() {
        var passwordField = document.getElementsByName('contraseña')[0];
        passwordField.type = this.checked ? 'text' : 'password';
    });
    </script>

</body>

</html>