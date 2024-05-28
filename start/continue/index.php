<?php
include ('C:\xampp\htdocs\pf\database\connect.php');
$con->set_charset('utf8');
session_start();

// Verificar si se ha iniciado sesión
if (empty($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
}

$idPersonal = $_SESSION['id'];

// Verificar si se han recibido las selecciones de las cartas
if (isset($_SESSION['selected_card_text']) && isset($_SESSION['selected_card_text_continue2'])) {
    $selection_continue1 = $_SESSION['selected_card_text'];
    $selection_continue2 = $_SESSION['selected_card_text_continue2'];

    echo "Selección de continue.php: $selection_continue1 <br>";
    echo "Selección de continue2.php: $selection_continue2 <br>";

    $tipos_cuerpo = ["Ectomorfo", "Mesomorfo", "Endomorfo"];
    $enfoques = ["Perder Peso", "Aumentar Masa Muscular", "Tonificar"];
    $combinaciones = [];

    foreach ($tipos_cuerpo as $tipo) {
        foreach ($enfoques as $enfoque) {
            $combinaciones[] = ["tipo_cuerpo" => $tipo, "enfoque" => $enfoque];
        }
    }

    $coincidencias = [];
    foreach ($combinaciones as $combinacion) {
        if ($combinacion['tipo_cuerpo'] == $selection_continue1 && $combinacion['enfoque'] == $selection_continue2) {
            $coincidencias[] = $combinacion;
        }
    }

    // Realizar acciones basadas en las combinaciones coincidentes
    foreach ($coincidencias as $coincidencia) {
        switch ($coincidencia['tipo_cuerpo']) {
            case 'Ectomorfo':
                if ($coincidencia['enfoque'] == 'Perder Peso') {
                    $arrayIds = [10, 11, 12]; // IDs específicos para Ectomorfo - Perder Peso
                    foreach ($arrayIds as $rutinaID) {
                        ejecutarAcciones($con, $rutinaID, $idPersonal);
                    }
                } elseif ($coincidencia['enfoque'] == 'Aumentar Masa Muscular') {
                    $arrayIds = [13, 14, 15]; // IDs específicos para Ectomorfo - Aumentar Masa Muscular
                    foreach ($arrayIds as $rutinaID) {
                        ejecutarAcciones($con, $rutinaID, $idPersonal);
                    }
                    echo "Acciones para tipo de cuerpo ectomorfo con enfoque en aumentar masa muscular <br>";
                } elseif ($coincidencia['enfoque'] == 'Tonificar') {
                    $arrayIds = [16, 17, 18]; // IDs específicos para Ectomorfo - Tonificar
                    foreach ($arrayIds as $rutinaID) {
                        ejecutarAcciones($con, $rutinaID, $idPersonal);
                    }
                    echo "Acciones para tipo de cuerpo ectomorfo con enfoque en tonificar <br>";
                } else {
                    echo "Acciones para combinación no reconocida <br>";
                }
                break;
            case 'Mesomorfo':
                if ($coincidencia['enfoque'] == 'Perder Peso') {
                    $arrayIds = [19, 20, 21]; // IDs específicos para Mesomorfo - Perder Peso
                    foreach ($arrayIds as $rutinaID) {
                        ejecutarAcciones($con, $rutinaID, $idPersonal);
                    }
                    echo "Acciones para tipo de cuerpo mesomorfo con enfoque en perder peso <br>";
                } elseif ($coincidencia['enfoque'] == 'Aumentar Masa Muscular') {
                    $arrayIds = [22, 23, 24]; // IDs específicos para Mesomorfo - Aumentar Masa Muscular
                    foreach ($arrayIds as $rutinaID) {
                        ejecutarAcciones($con, $rutinaID, $idPersonal);
                    }
                    echo "Acciones para tipo de cuerpo mesomorfo con enfoque en aumentar masa muscular <br>";
                } elseif ($coincidencia['enfoque'] == 'Tonificar') {
                    $arrayIds = [25, 26, 18]; // IDs específicos para Mesomorfo - Tonificar
                    foreach ($arrayIds as $rutinaID) {
                        ejecutarAcciones($con, $rutinaID, $idPersonal);
                    }
                    echo "Acciones para tipo de cuerpo mesomorfo con enfoque en tonificar <br>";
                } else {
                    echo "Acciones para combinación no reconocida <br>";
                }
                break;
            case 'Endomorfo':
                if ($coincidencia['enfoque'] == 'Perder Peso') {
                    $arrayIds = [27, 28, 18]; // IDs específicos para Endomorfo - Perder Peso
                    foreach ($arrayIds as $rutinaID) {
                        ejecutarAcciones($con, $rutinaID, $idPersonal);
                    }
                    echo "Acciones para tipo de cuerpo endomorfo con enfoque en perder peso <br>";
                } elseif ($coincidencia['enfoque'] == 'Aumentar Masa Muscular') {
                    $arrayIds = [29, 30, 31]; // IDs específicos para Endomorfo - Aumentar Masa Muscular
                    foreach ($arrayIds as $rutinaID) {
                        ejecutarAcciones($con, $rutinaID, $idPersonal);
                    }
                    echo "Acciones para tipo de cuerpo endomorfo con enfoque en aumentar masa muscular <br>";
                } elseif ($coincidencia['enfoque'] == 'Tonificar') {
                    $arrayIds = [25, 17, 18]; // IDs específicos para Endomorfo - Tonificar
                    foreach ($arrayIds as $rutinaID) {
                        ejecutarAcciones($con, $rutinaID, $idPersonal);
                    }
                    echo "Acciones para tipo de cuerpo endomorfo con enfoque en tonificar <br>";
                } else {
                    echo "Acciones para combinación no reconocida <br>";
                }
                break;
            default:
                echo "Acciones para combinación no reconocida <br>";
                break;
        }
    }

    // Redireccionar después de que todas las rutinas hayan sido procesadas
    session_start();
                $_SESSION['id'] = $idPersonal;
                header('Location: ../../dashboard/interface.php');
                exit;

} else {
    echo "No se han recibido las selecciones de las cartas.";
}

function ejecutarAcciones($con, $rutinaID, $idPersonal) {
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
                echo '<script>alert("La rutina ya existe");window.location.href = "../../interface.php";</script>';
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
}
?>
