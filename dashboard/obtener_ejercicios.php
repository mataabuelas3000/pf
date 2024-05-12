<?php
include ('C:\xampp\htdocs\pf\database\connect.php');
$con->set_charset('utf8');

if (isset($_GET['id']) && isset($_GET['idpersonal'])) {
    $rutinaID = $_GET['id'];
    $idPersonal = $_GET['idpersonal'];

    // Consulta para obtener el nombre de la rutina seleccionada
    $sqlNombreRutina = "SELECT Name_Chat_Routine FROM chat_routine WHERE Id_Chat_Routine = $rutinaID";
    $resultNombreRutina = $con->query($sqlNombreRutina);

    if ($resultNombreRutina) {
        $rowNombreRutina = $resultNombreRutina->fetch_assoc();
        $nombreRutina = $rowNombreRutina['Name_Chat_Routine'];

        echo '<button class="mb-2 mr-2 btn btn-secondary">'.$nombreRutina.'</button>'; // Mostrar el nombre de la rutina seleccionada

        // Consulta para obtener los ejercicios de la rutina seleccionada
        $sql = "SELECT * 
        FROM exercise 
        INNER JOIN chat_routine_exercises ON exercise.Id_Exercise = chat_routine_exercises.Id_Exercise
        INNER JOIN difficulty ON  difficulty.Id_Difficulty = exercise.Id_Difficulty 
        WHERE chat_routine_exercises.Id_Chat_Routine = $rutinaID";
        $result = $con->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="mb-4">';
                    echo '<b>Nombre del ejercicio:</b> ' . $row["Name_Exercise"] . '<br>';
                    echo '<b>Descripción:</b> ' . $row["Description_Exercise"] . '<br>';
                    echo '<b>Duración:</b> ' . $row["Duration_Exercise"] .' Minutos'.'<br>';
                    echo '<b>Dificultad:</b> ' . $row["Difficulty"] . '<br> <hr>';

                    echo '</div>';
                }
                echo "<a class='mb-1 btn btn-success' href='registrar_rutina.php?id=" . $rutinaID . "&idpersonal=" . $idPersonal . "'>Agregar</a><br>";
            } else {
                echo "<p>No se encontraron ejercicios para esta rutina.</p>";
            }
        } else {
            echo "Error en la consulta: " . $con->error;
        }
    } else {
        echo "Error al obtener el nombre de la rutina: " . $con->error;
    }
} else {
    echo "Error: ID de rutina o ID de personal no proporcionado.";
}
?>
