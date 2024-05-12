<?php
include ('C:\xampp\htdocs\pf\database\connect.php');
$con->set_charset('utf8');

if (isset($_GET['id']) && isset($_GET['idpersonal'])) {
    $rutinaID = $_GET['id'];
    $idPersonal = $_GET['idpersonal'];

    $sqlRutina = "SELECT * FROM chat_Routine WHERE Id_Chat_Routine = $rutinaID";
    $resultRutina = $con->query($sqlRutina);

    if ($resultRutina) {
        if ($resultRutina->num_rows > 0) {
            $rowRutina = $resultRutina->fetch_assoc();
            $nombreRutina = $rowRutina["Name_Chat_Routine"];
            $descripcionRutina = $rowRutina["Description_Chat_Routine"];
            $duracionRutina = $rowRutina["Duration_Chat_Routine"];
            $dificultadRutina = $rowRutina["Id_Difficulty"];

            $check_existing_query = "SELECT Id_Routine FROM routine WHERE Name_routine = ? AND Approach_Routine = ? AND Id_User = ?";
            $stmt_check_existing = mysqli_prepare($con, $check_existing_query);
            mysqli_stmt_bind_param($stmt_check_existing, 'ssi', $nombreRutina, $descripcionRutina, $idPersonal);
            mysqli_stmt_execute($stmt_check_existing);
            $check_existing_result = mysqli_stmt_get_result($stmt_check_existing);

            if ($check_existing_result && $check_existing_result->num_rows > 0) {
                echo '<script>alert("La rutina ya existe");window.location.href = "interface.php";</script>';
                exit;
            }

            $getLastIdQuery = "SELECT MAX(Id_Routine) AS LastId FROM routine";
            $lastIdResult = $con->query($getLastIdQuery);
            $lastIdRow = $lastIdResult->fetch_assoc();
            $newRutinaId = $lastIdRow['LastId'] + 1;

            $insertRutina = "INSERT INTO routine (Id_Routine, Name_routine, Approach_Routine, Duration_Routine, Id_Difficulty, Id_User) 
                             VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_insert_rutina = mysqli_prepare($con, $insertRutina);
            mysqli_stmt_bind_param($stmt_insert_rutina, 'isssii', $newRutinaId, $nombreRutina, $descripcionRutina, $duracionRutina, $dificultadRutina, $idPersonal);
            $result_insert_rutina = mysqli_stmt_execute($stmt_insert_rutina);

            if ($result_insert_rutina) {
                $sql = "SELECT * 
                        FROM exercise
                        INNER JOIN chat_routine_exercises ON exercise.Id_Exercise = chat_routine_exercises.Id_Exercise
                        WHERE chat_routine_exercises.Id_Chat_Routine = $rutinaID";
                $result = $con->query($sql);
                if ($result) {
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $idEjercicio = $row["Id_Exercise"];
                            $insertRelacion = "INSERT INTO rut_has_exercise (Id_Routine, Id_Exercise) VALUES ($newRutinaId, $idEjercicio)";
                            if ($con->query($insertRelacion) !== TRUE) {
                                echo "Error al establecer la relación entre la nueva rutina y los ejercicios: " . $con->error;
                            }
                        }
                        echo "<script>alert('La rutina se añadió satisfactoriamente');window.location.href = 'interface.php';</script>";
                    } else {
                        echo "<p>No se encontraron ejercicios para esta rutina.</p>";
                    }
                } else {
                    echo "Error en la consulta: " . $con->error;
                }
            } else {
                echo "Error al insertar la rutina: " . $con->error;
            }
        } else {
            echo "No se encontró la rutina seleccionada.";
        }
    } else {
        echo "Error en la consulta: " . $con->error;
    }
} else {
    echo "Error: ID de rutina o ID de personal no proporcionado.";
}
?>
