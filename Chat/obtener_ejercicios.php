<?php
// Verificar si se proporcionó el ID de la rutina
if (isset($_GET['id'])) {
    $rutinaID = $_GET['id'];

    // Conectar a la base de datos
    $conn = new mysqli("localhost", "root", "", "pf", 3306);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Consulta SQL para obtener los ejercicios de la rutina seleccionada
    $sql = "SELECT ejercicios.* FROM ejercicios INNER JOIN rutinas_ejercicio ON ejercicios.ID_Rutina = rutinas_ejercicio.ID_Rutina WHERE rutinas_ejercicio.ID_Rutina = $rutinaID";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            // Mostrar los datos de los ejercicios con checkboxes
            while($row = $result->fetch_assoc()) {
                echo '<input type="checkbox" name="ejercicio[]" value="' . $row["ID_Ejercicio"] . '">';
                echo "Nombre del ejercicio: " . $row["Nombre_Ejercicio"] . "<br>";
                echo "Descripción: " . $row["Descripcion"] . "<br>";
                echo "Duración: " . $row["Duracion"] . "<br>";
                echo "Dificultad: " . $row["Dificultad"] . "<br>";
                echo "Grupo Muscular: " . $row["Grupo_Muscular"] . "<br>";
                echo "<br>";
            }
        } else {
            echo "No se encontraron ejercicios para esta rutina.";
        }
    } else {
        echo "Error en la consulta: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Error: ID de rutina no proporcionado.";
}
?>
