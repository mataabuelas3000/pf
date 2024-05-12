<?php
include ('C:\xampp\htdocs\pf\database\connect.php');
$con->set_charset('utf8');
if (isset($_GET['idrutina']) && isset($_GET['id_interfaz'])) {
    $idrutina = $_GET['idrutina'];
    $id_interfaz = $_GET['id_interfaz'];

    // Consulta SQL para verificar si la rutina está programada en el calendario
    $check_calendar_query = 'SELECT Id_Routine FROM calendar WHERE Id_Routine = ?';
    $check_calendar_statement = $con->prepare($check_calendar_query);
    $check_calendar_statement->bind_param('i', $idrutina);
    $check_calendar_statement->execute();
    $check_calendar_result = $check_calendar_statement->get_result();

    // Si la rutina está programada en el calendario, eliminarla de la tabla calendario
    if ($check_calendar_result->num_rows > 0) {
        $delete_calendar_query = 'DELETE FROM calendar WHERE Id_Routine = ?';
        $delete_calendar_statement = $con->prepare($delete_calendar_query);
        $delete_calendar_statement->bind_param('i', $idrutina);
        if ($delete_calendar_statement->execute()) {
        } else {
            echo '<script>alert("Error al eliminar la rutina del calendario.");</script>';
            echo '<script>window.location.href = "interface.php";</script>';
        }
        $delete_calendar_statement->close();
    }

    // Eliminar los ejercicios asociados a la rutina
    $delete_ejercicios_query = 'DELETE FROM rut_has_exercise WHERE Id_Routine = ?';
    $delete_ejercicios_statement = $con->prepare($delete_ejercicios_query);
    $delete_ejercicios_statement->bind_param('i', $idrutina);
    if ($delete_ejercicios_statement->execute()) {
        // Eliminar la rutina
        $delete_rutina_query = 'DELETE FROM routine WHERE Id_Routine = ?';
        $delete_rutina_statement = $con->prepare($delete_rutina_query);
        $delete_rutina_statement->bind_param('i', $idrutina);
        if ($delete_rutina_statement->execute()) {
            echo '<script>alert("La rutina se elimino correctamente.");</script>';
            echo '<script>window.location.href = "interface.php";</script>';
        } else {
            echo '<script>alert("Error al eliminar la rutina y sus ejercicios asociados.");</script>';
            echo '<script>window.location.href = "interface.php";</script>';
        }
        $delete_rutina_statement->close();
    } else {
        echo '<script>alert("Error al eliminar los ejercicios asociados a la rutina.");</script>';
        echo '<script>window.location.href = "interface.php";</script>';
    }

    $check_calendar_statement->close();
    $delete_ejercicios_statement->close();
}
?>
