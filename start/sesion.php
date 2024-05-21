<?php
// Iniciamos la sesión y destruimos cualquier sesión existente para asegurarnos de un inicio limpio.
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

?>