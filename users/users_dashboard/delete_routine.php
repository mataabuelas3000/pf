<?php
include ('C:\xampp\htdocs\pf\database\connect.php');
$con->set_charset("utf8");

if (isset($_GET['idrutina']) && isset($_GET['id_interfaz'])) {
    $idrutina = $_GET['idrutina'];
    $id_interfaz = $_GET['id_interfaz'];

    // Eliminar la rutina del calendario si está programada
    $delete_calendar_query = 'DELETE FROM calendar WHERE Id_Routine = ?';
    $delete_calendar_statement = $con->prepare($delete_calendar_query);
    $delete_calendar_statement->bind_param('i', $idrutina);
    $delete_calendar_result = $delete_calendar_statement->execute();
    $delete_calendar_statement->close();

    if (!$delete_calendar_result) {
        echo '<script>alert("Error al eliminar la rutina del calendario.");</script>';
        echo '<script>window.location.href = "routine_user.php?id_personal='.$id_interfaz.'";</script>';
        exit; // Salir del script si hay un error
    }

    // Eliminar los ejercicios asociados a la rutina
    $delete_exercises_query = 'DELETE FROM rut_has_exercise WHERE Id_Routine = ?';
    $delete_exercises_statement = $con->prepare($delete_exercises_query);
    $delete_exercises_statement->bind_param('i', $idrutina);
    $delete_exercises_result = $delete_exercises_statement->execute();
    $delete_exercises_statement->close();

    if (!$delete_exercises_result) {
        echo '<script>alert("Error al eliminar los ejercicios asociados a la rutina.");</script>';
        echo '<script>window.location.href = "routine_user.php?id_personal='.$id_interfaz.'";</script>';
        exit; // Salir del script si hay un error
    }

    // Finalmente, eliminar la rutina
    $delete_routine_query = 'DELETE FROM routine WHERE Id_Routine = ?';
    $delete_routine_statement = $con->prepare($delete_routine_query);
    $delete_routine_statement->bind_param('i', $idrutina);
    $delete_routine_result = $delete_routine_statement->execute();
    $delete_routine_statement->close();

    if ($delete_routine_result) {
        echo '<script>alert("La rutina se eliminó correctamente.");</script>';
        echo '<script>window.location.href = "routine_user.php?id_personal='.$id_interfaz.'";</script>';
    } else {
        echo '<script>alert("Error al eliminar la rutina y sus ejercicios asociados.");</script>';
        echo '<script>window.location.href = "routine_user.php?id_personal='.$id_interfaz.'";</script>';
    }
}
?>
