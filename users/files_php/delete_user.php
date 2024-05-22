<?php
include ('C:\xampp\htdocs\pf\database\connect.php');
$con->set_charset('utf8');

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    // Eliminar primero de la tabla 'calendar'
    $sql_delete_calendar = "DELETE FROM calendar WHERE Id_User = $id";
    $result_delete_calendar = mysqli_query($con, $sql_delete_calendar);

    if ($result_delete_calendar) {
        // Obtener Id_Routine asociados a la persona
        $sql_get_routine_ids = "SELECT Id_Routine FROM routine WHERE Id_User = $id";
        $result_get_routine_ids = mysqli_query($con, $sql_get_routine_ids);

        if ($result_get_routine_ids) {
            while ($row = mysqli_fetch_assoc($result_get_routine_ids)) {
                $routine_id = $row['Id_Routine'];
                
                // Eliminar registros de la tabla 'rut_has_exercise' asociados a cada Id_Routine
                $sql_delete_rut_has_exercise = "DELETE FROM rut_has_exercise WHERE Id_Routine = $routine_id";
                $result_delete_rut_has_exercise = mysqli_query($con, $sql_delete_rut_has_exercise);
                
                if (!$result_delete_rut_has_exercise) {
                    // Si hay un error al eliminar de 'rut_has_exercise', mostrar mensaje de error y salir
                    die(mysqli_error($con));
                }
            }
        } else {
            // Si hay un error al obtener los Id_Routine, mostrar mensaje de error y salir
            die(mysqli_error($con));
        }

        // Eliminar de la tabla 'routine'
        $sql_delete_routine = "DELETE FROM routine WHERE Id_User = $id";
        $result_delete_routine = mysqli_query($con, $sql_delete_routine);

        if ($result_delete_routine) {
            // Luego, eliminar de las otras tablas
            $sql_data = "DELETE FROM data WHERE Id_User = $id";
            $sql_user_info = "DELETE FROM user_info WHERE Id_User = $id";
            $sql_login = "DELETE FROM login WHERE Id_User = $id";

            $result_data = mysqli_query($con, $sql_data);
            $result_user_info = mysqli_query($con, $sql_user_info);
            $result_login = mysqli_query($con, $sql_login);

            // Verificar si se eliminaron los registros de las otras tablas correctamente
            if ($result_data && $result_user_info && $result_login) {
                // Redirigir a la página de administración de usuarios
                echo '<script>alert("Persona eliminada correctamente"); window.location.href = "../crud_users.php";</script>';
                exit;
            } else {
                // Si hubo un error al eliminar de alguna de las otras tablas, mostrar el mensaje de error
                die(mysqli_error($con));
            }
        } else {
            // Si hubo un error al eliminar de 'routine', mostrar el mensaje de error
            die(mysqli_error($con));
        }
    } else {
        // Si hubo un error al eliminar de 'calendar', mostrar el mensaje de error
        die(mysqli_error($con));
    }
}

?>
