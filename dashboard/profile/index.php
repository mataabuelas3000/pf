<?php
// Incluir el archivo de conexión a la base de datos
include ('C:\xampp\htdocs\pf\database\connect.php');
$con->set_charset('utf8');
// Obtener el ID del usuario a actualizar de los parámetros GET

session_start();
// Verificar si no hay una sesión activa de personal o de rutina
if (empty($_SESSION['id'])) {
    header('Location: ../interface.php');
    exit();
} else {
    // Redirigir a la página de interfaz si hay una sesión activa
    $idviejo = $_SESSION['id'];
    
}

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
    $passwordlast = $_POST['passlast'];
    $passwordnew = $_POST['passnew'];
    $primernombre = $_POST['primernombre'];
    $primerapellido = $_POST['primerapellido'];
    $correo = $_POST['correo'];
    $genero = $_POST['genero'];
    $altura = $_POST['altura'];
    $peso = $_POST['peso'];

    // Validar el formato de la altura (debe ser #.##)
    if (!preg_match('/^\d+\.\d{2}$/', $altura)) {
        echo "<script>alert('La altura debe tener el formato #.##');</script>";
        exit;
    }

    if (!preg_match('/^\d{2}\.\d{2}$/', $peso)) {
        echo "<script>alert('El peso debe tener el formato ##.##');</script>";
        exit;
    }

    // Calcular el Índice de Masa Corporal (IMC)
    $IMC = $peso / ($altura * $altura);
    $error = false;
    // Verificar si se debe cambiar la contraseña
    if (!empty($passwordlast) && empty($passwordnew)) {
        $error = true;
        $error_message = "Por favor, ingrese la nueva contraseña";
    } elseif (empty($passwordlast) && !empty($passwordnew)) {
        $error = true;
        $error_message = "Por favor, confirme la contraseña actual";
    } elseif (!empty($passwordlast) && !empty($passwordnew)) {
        // Verificar si la contraseña actual es correcta
        if (!password_verify($passwordlast, $password)) {
            $error = true;
            $error_message = "La contraseña actual es incorrecta";
        } else {
            // Hashear la nueva contraseña
            $hashed_password = password_hash($passwordnew, PASSWORD_DEFAULT);
        }
    }

    // Si hay un error, mostrar el mensaje de error y evitar la actualización
    if ($error) {
        echo "<script>alert('$error_message');</script>";
    } else {
        // Actualizar los datos del usuario en la base de datos
        $sql = "UPDATE login 
                INNER JOIN user_info ON login.Id_User = user_info.Id_User 
                INNER JOIN data ON login.Id_User = data.Id_User 
                SET ";

        // Añadir los campos a actualizar
        if (!empty($passwordlast) && !empty($passwordnew)) {
            $sql .= "login.Password = '$hashed_password', ";
        }

        $sql .= "login.Id_Role_User = '$rol', 
                user_info.Name_User = '$primernombre', user_info.Last_Name_User = '$primerapellido', user_info.Email_User = '$correo', user_info.Gender_User = '$genero', 
                data.Height_User = '$altura', data.Weight_User = '$peso', data.Imc_User = '$IMC' 
                WHERE login.Id_User = '$idviejo'";

        // Ejecutar la consulta
        $result = mysqli_query($con, $sql);
        if ($result) {
            echo '<script>alert("Datos actualizados"); window.location.href = "../interface.php#info";</script>';
            exit;
        } else {
            // Mostrar un mensaje de error si la actualización falla
            die(mysqli_error($con));
        }
    }
} elseif (isset($_POST['cancelar'])) {
    // Redirigir de vuelta a la página de administración de usuarios si se cancela la actualización
    header('location: ../interface.php#info');
}
?>
