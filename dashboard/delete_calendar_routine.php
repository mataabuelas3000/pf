<?php
include ('C:\xampp\htdocs\pf\database\connect.php');
$con->set_charset('utf8');
// Verificar si se recibieron los parámetros necesarios
if (isset($_GET['id_personal']) && isset($_GET['idRutina']) && isset($_GET['dia'])) {
    // Recuperar los valores de los parámetros
    $id_personal = $_GET['id_personal'];
    $idRutina = $_GET['idRutina'];
    $dia = $_GET['dia'];

    // Consultar el nombre del día correspondiente al ID_Day
    $day_query = 'SELECT Day FROM days WHERE Id_Day = ?';
    $day_statement = $con->prepare($day_query);
    $day_statement->bind_param('i', $dia);
    $day_statement->execute();
    $day_result = $day_statement->get_result();
    $day_row = $day_result->fetch_assoc();
    $nombre_dia = $day_row['Day'];

    // Realizar la eliminación de la rutina del día en la tabla 'calendario'
    $delete_query = 'DELETE FROM calendar WHERE Id_User= ? AND Id_Routine = ? AND Id_Day = ?';
    $delete_statement = $con->prepare($delete_query);
    $delete_statement->bind_param('iii', $id_personal, $idRutina, $dia);

    // Ejecutar la eliminación
    if ($delete_statement->execute()) {
        // La rutina se eliminó correctamente
        echo '<script>alert("La rutina se eliminó correctamente del día ' . $nombre_dia . '");</script>';
    } else {
        // Ocurrió un error al intentar eliminar la rutina
        echo '<script>alert("Ocurrió un error al intentar eliminar la rutina del día ' . $nombre_dia . '");</script>';
    }

    // Cerrar las consultas preparadas
    $delete_statement->close();
    $day_statement->close();
    // Cerrar la conexión a la base de datos
    $con->close();
} else {
    // No se recibieron todos los parámetros necesarios
    echo '<script>alert("Faltan parámetros necesarios para eliminar la rutina del calendario.");</script>';
}

// Redirigir de vuelta a la interfaz u otra página, incluyendo el id_personal en la URL
echo '<script>window.location.href = "interface.php#calendar";</script>';

?>
