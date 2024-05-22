<?php
include ('C:\xampp\htdocs\pf\database\connect.php');
$con->set_charset('utf8');

if (isset($_POST['enviar'])) {
    // Obtener los datos del formulario
    $id = $_POST['id'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
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
if (!preg_match('/^\d{2}\.\d{2}$/', $peso)) {
    echo "<script>alert('El peso debe tener el formato ##.##');</script>";
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
        $sql_user_info = "INSERT INTO user_info (Id_User, Name_User, Last_Name_User, Email_User, Gender_User) VALUES ('$id', '$nombres', '$apellidos', '$correo', '$genero')";
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
                echo '<script>alert("Usuario insertado correctamente en la tabla data."); window.location.href = "../crud_users.php";</script>';
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