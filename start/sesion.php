<?php
session_start();
session_destroy();


// Incluimos el archivo de conexión a la base de datos.
include ('C:\xampp\htdocs\pf\database\connect.php');

// Verificamos si se ha enviado el formulario de inicio de sesión.
if (isset($_POST['enviar'])) {
    // Obtenemos el ID de usuario y la contraseña proporcionados por el formulario.
    $id = $_POST['id'];
    $password = $_POST['password'];

    // Consulta SQL para obtener el hash de contraseña almacenado en la base de datos.
    $query = 'SELECT Password, Id_Role_User FROM login WHERE Id_User = ?';
    $statement = $con->prepare($query);

    // Ligamos el parámetro y ejecutamos la consulta.
    $statement->bind_param('i', $id);
    $statement->execute();
    
    // Obtenemos el resultado de la consulta.
    $result = $statement->get_result();

    // Verificamos si se encontró el usuario.
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_password = $row['Password'];
        $rol = $row['Id_Role_User'];

        // Verificamos si la contraseña proporcionada coincide con el hash almacenado.
        if (password_verify($password, $stored_password)) {
            // Redirigimos según el rol del usuario.
            if ($rol == 1) {
                // Iniciamos la sesión y establecemos la variable de sesión.
                session_start();
                $_SESSION['id'] = $id;

                // Redirigimos al dashboard de usuarios.
                header('Location: dashboard/interface.php');
                exit;
            } else if ($rol == 2) {
                // Iniciamos la sesión y establecemos la variable de sesión.
                session_start();
                $_SESSION['id'] = $id;

                // Redirigimos al panel de administración de usuarios.
                header('Location: users/crud_users.php');
                exit;
            }
        } else {
            // Si la contraseña no coincide, mostramos un mensaje de error.
            echo "<script> alert('Contraseña incorrecta'); </script>";
        }
    } else {
        // Si no se encuentra el usuario, mostramos un mensaje de error.
        echo "<script> alert('El usuario no existe'); </script>";
    }
}

// Verificamos si se ha enviado el formulario de registro.
if (isset($_POST['enviar2'])) {
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
    if (!preg_match('/^\d{2,3}\.\d{1}$/', $peso) && !preg_match('/^\d{2}\.\d{2}$/', $peso)) {
        echo "<script>alert('El peso debe tener el formato ##.# o ###.#');</script>";
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
                echo "<script>alert('Bienvenido a nuestro gimnasio');</script>";
                session_start();
                $_SESSION['id'] = $id;

                // Redirigir al dashboard de usuarios
                header('Location: start/continue/continue.php');
                exit;
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
