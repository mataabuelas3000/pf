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

    // Verificar si la contraseña está vacía
    if (!empty($password)) {
        // Hashear la nueva contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // Actualizar la contraseña y los otros datos del usuario en la base de datos
        $sql = "UPDATE login 
                INNER JOIN user_info ON login.Id_User = user_info.Id_User 
                INNER JOIN data ON login.Id_User = data.Id_User 
                SET login.Password = '$hashed_password', 
                    user_info.Name_User = '$primernombre', user_info.Last_Name_User = '$primerapellido', user_info.Email_User = '$correo', user_info.Gender_User = '$genero', 
                    data.Height_User = '$altura', data.Weight_User = '$peso', data.Imc_User = '$IMC' 
                WHERE login.Id_User = '$idviejo'";
    } else {
        // Actualizar solo los otros datos del usuario en la base de datos sin la contraseña
        $sql = "UPDATE login 
                INNER JOIN user_info ON login.Id_User = user_info.Id_User 
                INNER JOIN data ON login.Id_User = data.Id_User 
                SET user_info.Name_User = '$primernombre', user_info.Last_Name_User = '$primerapellido', user_info.Email_User = '$correo', user_info.Gender_User = '$genero', 
                    data.Height_User = '$altura', data.Weight_User = '$peso', data.Imc_User = '$IMC' 
                WHERE login.Id_User = '$idviejo'";
    }

    // Ejecutar la consulta
    $result = mysqli_query($con, $sql);
    if ($result) {
        echo '<script>alert("Datos actualizados"); window.location.href = "../crud_users.php";</script>';
        exit;
    } else {
        // Mostrar un mensaje de error si la actualización falla
        die(mysqli_error($con));
    }
} elseif (isset($_POST['cancelar'])) {
    // Redirigir de vuelta a la página de administración de usuarios si se cancela la actualización
    header('location: ../crud_users.php');
}
?>