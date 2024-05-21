<?php
include ('C:\xampp\htdocs\pf\database\connect.php');
$con->set_charset('utf8');

$sql = "SELECT Name_Chat_Routine as nombre, Description_Chat_Routine as Descripcion, Id_Chat_Routine FROM chat_routine"; // Cambia el nombre de la tabla y el campo según tu base de datos
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<button onclick="mostrarEjercicios(' . $row['Id_Chat_Routine'] . ')" class="mb-2 mr-3 btn btn-secondary">' . $row['nombre'] . '</button>';
    }
    echo '<hr>';
} else {
    echo "No se encontraron rutinas.";
}
?>
