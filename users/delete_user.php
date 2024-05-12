<?php
include ('C:\xampp\htdocs\pf\database\connect.php');
$con->set_charset('utf8');
if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    // Eliminar primero de la tabla 'data'
    $sql_data = "DELETE FROM data WHERE Id_User = $id";
    $result_data = mysqli_query($con, $sql_data);

    // Verificar si se eliminaron los registros de 'data' correctamente
    if ($result_data) {
        // Si se eliminaron correctamente, eliminamos de la tabla 'user_info'
        $sql_user_info = "DELETE FROM user_info WHERE Id_User = $id";
        $result_user_info = mysqli_query($con, $sql_user_info);

        // Verificar si se eliminaron los registros de 'user_info' correctamente
        if ($result_user_info) {
            // Finalmente, eliminamos de la tabla 'login'
            $sql_login = "DELETE FROM login WHERE Id_User = $id";
            $result_login = mysqli_query($con, $sql_login);

            // Verificar si se eliminó el usuario de 'login' correctamente
            if ($result_login) {
                // Redirigir a la página de administración de usuarios
                echo '<script>alert("Persona eliminada correctamente"); window.location.href = "crud_users.php";</script>';
                exit;
            } else {
                // Si hubo un error al eliminar de 'login', mostrar el mensaje de error
                die(mysqli_error($con));
            }
        } else {
            // Si hubo un error al eliminar de 'user_info', mostrar el mensaje de error
            die(mysqli_error($con));
        }
    } else {
        // Si hubo un error al eliminar de 'data', mostrar el mensaje de error
        die(mysqli_error($con));
    }
}
?>
