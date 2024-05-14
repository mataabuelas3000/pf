<?php
include('C:\xampp\htdocs\pf\database\connect.php');
$con->set_charset('utf8');
session_start();

// Verificar si no hay una sesión activa de personal o de rutina
if (empty($_SESSION['id_personal']) && empty($_SESSION['IdRutina'])) {
    // Obtener los IDs de personal y de rutina de la URL
    $id = $_GET['id_personal'];
    $idrutina = $_GET['IdRutina'];
} else {
    // Redirigir a la página de interfaz si hay una sesión activa
    header('Location: interface.php');
    exit();
}

// Consultar la base de datos para obtener los detalles de la rutina seleccionada
$sql = "SELECT * FROM routine r INNER JOIN user_info p ON r.Id_User = p.Id_User  WHERE r.Id_Routine = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, 'i', $idrutina);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);


// Verificar si se obtuvieron resultados de la consulta
if ($result) {
    // Recorrer los resultados y asignar los valores a las variables correspondientes
    while ($row = mysqli_fetch_assoc($result)) {
        $nombrerutina = $row['Name_routine'];
        $descripcionrtuina = $row['Approach_Routine'];
        $duracionrutina = $row['Duration_Routine'];
        $dificultad = $row['Id_Difficulty'];
    }
}

// Función para mostrar los ejercicios disponibles para agregar a la rutina
function mostrarejercicios($con, $idRutina)
{
    // Consultar la dificultad de la rutina
    $query_dificultad = 'SELECT Id_Difficulty FROM routine WHERE Id_Routine = ?';
    $stmt_dificultad = mysqli_prepare($con, $query_dificultad);
    mysqli_stmt_bind_param($stmt_dificultad, 'i', $idRutina);
    mysqli_stmt_execute($stmt_dificultad);
    $result_dificultad = mysqli_stmt_get_result($stmt_dificultad);
    $row_dificultad = mysqli_fetch_assoc($result_dificultad);
    $dificultad_rutina = $row_dificultad['Id_Difficulty'];

    // Consultar los ejercicios disponibles según la dificultad de la rutina
    if ($dificultad_rutina != null) {
        $sql = 'SELECT g.Name_Group, e.Name_Exercise, e.Id_Exercise
                FROM muscle_group g 
                INNER JOIN exercise e ON g.Id_Muscle_Group = e.Id_Muscle_Group 
                WHERE e.Id_Exercise NOT IN (
                    SELECT re.Id_Exercise 
                    FROM rut_has_exercise re 
                    WHERE re.Id_Routine = ?
                ) 
                AND e.Id_Difficulty = ?
                ORDER BY g.Id_Muscle_Group';

        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'is', $idRutina, $dificultad_rutina);
    } else {
        $sql = 'SELECT g.Name_Group, e.Name_Exercise, e.Id_Exercise
                FROM muscle_group g 
                INNER JOIN exercise e ON g.Id_Muscle_Group = e.Id_Muscle_Group 
                WHERE e.Id_Exercise NOT IN (
                    SELECT re.Id_Exercise 
                    FROM rut_has_exercise re 
                    WHERE re.Id_Routine = ?
                ) 
                ORDER BY g.Id_Muscle_Group';

        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $idRutina);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Verificar si se obtuvieron resultados de la consulta
    if ($result) {
        $current_grupo = '';
        echo '<div class="container " style="margin-top: 30px;display: flex; flex-wrap: wrap;  justify-content: center;">';
        while ($row = mysqli_fetch_assoc($result)) {
            $nombregrupo = iconv('ISO-8859-1', 'UTF-8', $row['Name_Group']);
            $nombreejercicio = iconv('ISO-8859-1', 'UTF-8', $row['Name_Exercise']);
            $idejercicio = $row['Id_Exercise'];
            if ($nombregrupo != $current_grupo) {
                if ($current_grupo != '') {
                    echo '</ul>';
                }
                echo '<ul class="list-group ml-4 mt-3" style="width: 30%">';
                echo '<li class="list-group-item list-group-item-info" style="margin-top:20px; border-radius: 4px; padding: 15px">' . $nombregrupo . '</li>';
                $current_grupo = $nombregrupo;
            }

            echo '<li class="list-group-item" style="padding: 13px; border: 1px solid rgba(41, 41, 41, 0.116)">
                    <input class="form-check-input ml-1 me-1" type="checkbox" value="' . $idejercicio . '" id="checkbox_' . $idejercicio . '" name="seleccioncheck[]">
                    <label class="form-check-label ml-5" for="checkbox_' . $idejercicio . '">' . $nombreejercicio . '</label>
                </li>';
        }
        echo '</ul></div>';

        // Agregar un botón para enviar el formulario después de seleccionar los ejercicios
        echo '<button type="submit" class="btn btn-primary mt-4" name="agregarejer">Agregar Ejercicios Seleccionados</button>';
    }
}

// Función para obtener los ejercicios de una rutina
function obtenerEjerciciosDeRutina($con, $idRutina)
{
    $sql = 'SELECT r.Name_Routine AS NombreRutina, r.Approach_Routine AS DescripcionRutina, r.Duration_Routine AS Duracion, r.Id_Difficulty AS Dificultad,
                   e.Id_Exercise AS IdEjercicio, e.Name_Exercise AS NombreEjercicio, e.Description_Exercise AS DescripcionEjercicio, e.Duration_Exercise AS DuracionEjercicio, e.url_video AS Video,
                   g.Name_Group AS GrupoMuscular
            FROM rut_has_exercise AS re
            INNER JOIN routine AS r ON re.Id_Routine = r.Id_Routine
            INNER JOIN exercise AS e ON re.Id_Exercise = e.Id_Exercise
            INNER JOIN muscle_group AS g ON e.Id_Muscle_Group = g.Id_Muscle_Group
            WHERE r.Id_Routine = ?';

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $idRutina);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $ejercicios = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $ejercicios[] = $row;
    }

    mysqli_stmt_close($stmt);
    return $ejercicios;
}

// Función para recalcular la duración total de la rutina y actualizarla en la base de datos
function recalcularDuracionRutina($con, $idRutina)
{
    // Obtener los ejercicios de la rutina
    $sql = 'SELECT e.Duration_Exercise AS Duracion
            FROM rut_has_exercise AS re
            INNER JOIN exercise AS e ON re.Id_Exercise = e.Id_Exercise
            WHERE re.Id_Routine = ?';

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $idRutina);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $duracionTotal = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $duracionTotal += $row['Duracion'];
    }
    mysqli_stmt_close($stmt);

    // Obtener la cantidad de ejercicios en la rutina
    $sql = 'SELECT COUNT(*) AS total FROM rut_has_exercise WHERE Id_Routine = ?';
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $idRutina);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $totalEjercicios = 0;
    if ($row = mysqli_fetch_assoc($result)) {
        $totalEjercicios = $row['total'];
    }
    mysqli_stmt_close($stmt);

    // Sumar un minuto por cada ejercicio en la rutina
    $duracionTotal += $totalEjercicios;

    // Actualizar la duración de la rutina en la base de datos
    $sql = 'UPDATE routine SET Duration_Routine = ? WHERE Id_Routine = ?';
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $duracionTotal, $idRutina);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $success;
}

// Lógica para agregar un ejercicio a la rutina...
// Lógica para eliminar un ejercicio de la rutina...
if (isset($_POST['eliminareje'])) {
    $idEjercicio = $_POST['eliminareje'];

    // Realizar la eliminación del ejercicio de la rutina en la base de datos
    $stmt_eliminar = mysqli_prepare($con, "DELETE FROM rut_has_exercise WHERE Id_Routine = ? AND Id_Exercise = ?");
    mysqli_stmt_bind_param($stmt_eliminar, 'ii', $idrutina, $idEjercicio);
    $resultado = mysqli_stmt_execute($stmt_eliminar);

    // Verificar si la eliminación fue exitosa
    if ($resultado) {
        // Recalcular la duración total de la rutina y actualizarla en la base de datos
        if (recalcularDuracionRutina($con, $idrutina)) {
            echo '<script>alert("El ejercicio se eliminó correctamente."); window.history.back();</script>';
            exit;
        } else {
            echo "<script>alert('Error no se pudo eliminar ejercicio')</script>";
        }
    } else {
        // Si hubo un error, mostrar la alerta
        echo '<script>alert("Hubo un error al eliminar el ejercicio.");</script>';
    }
}

if (isset($_POST['agregarejer'])) {
    if (isset($_POST['seleccioncheck'])) {
        // Obtener los ejercicios seleccionados del formulario
        $ejerciciosSeleccionados = $_POST['seleccioncheck'];

        // Preparar la consulta para insertar los ejercicios seleccionados en la base de datos
        $sql_agregar = 'INSERT INTO rut_has_exercise (Id_Routine, Id_Exercise) VALUES (?, ?)';
        $stmt_agregar = mysqli_prepare($con, $sql_agregar);

        // Verificar si la preparación de la consulta fue exitosa
        if ($stmt_agregar) {
            // Enlazar los parámetros de la consulta
            mysqli_stmt_bind_param($stmt_agregar, 'ii', $idrutina, $idejercicio);

            // Recorrer los ejercicios seleccionados y ejecutar la consulta para cada uno
            foreach ($ejerciciosSeleccionados as $idejercicio) {
                mysqli_stmt_execute($stmt_agregar);
            }

            // Cerrar la consulta preparada
            mysqli_stmt_close($stmt_agregar);

            // Recalcular la duración total de la rutina y actualizarla en la base de datos
            if (recalcularDuracionRutina($con, $idrutina)) {
                echo '<script>alert("Ejercicio nuevo añadido a tu rutina"); window.history.back();</script>';
                exit;
            } else {
                echo "<script>alert('Error al actualizar la duración de la rutina')</script>";
            }
        } else {
            // Si hay un error en la preparación de la consulta, mostrar el mensaje de error
            echo 'Error en la preparación de la consulta: ' . mysqli_error($con);
        }
    } else {
        // Si no se han seleccionado ejercicios, mostrar un mensaje de error
        echo "<script>alert('Selecciona al menos un ejercicio')</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metadatos -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rutina <?php echo $idrutina ?></title>
    <!-- Enlaces a archivos CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="routine_styles.css">
</head>

<body>
    <!-- Barra de navegación -->
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <h5><?php echo $nombrerutina ?></h5>
            <a class="nav-link text-light" href="interface.php?id_personal=<?php echo $id; ?>">
                <input value="Regresar" type="button" class="btn btn-danger">
            </a>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="card">
        <div class="card-body mb-4">
            <form method="post">
                <button type="button" class="btn btn-secondary detalles toggle-details" style="margin-left:-40px">Ver
                    Ejercicios</button>
                <div class="details" style="display: none;">
                    <?php mostrarejercicios($con, $idrutina); ?>
                </div>
            </form>
        </div>
    </div>

    <div class="card1" style="width: 100%">
        <div class="card-body">
            <h3>Mis ejercicios</h3>
            <br>
            <div id="ejercicios-lista">
                <?php
                // Obtener ejercicios de la rutina
                $ejercicios = obtenerEjerciciosDeRutina($con, $idrutina);

                // Verificar si hay ejercicios en la rutina
                if (empty($ejercicios)) {
                    echo '<p>No hay ejercicios en esta rutina.</p>';
                } else {
                    // Iterar sobre los ejercicios y mostrarlos
                    foreach ($ejercicios as $ejercicio) {
                        echo '
                    <div class="card mb-4 ejercicio-item" id="ejercicio_' . $ejercicio['IdEjercicio'] . '" style="border-radius: 10px">
                        <i class="bx bx-dialpad-alt draggable-handle justify-content-center align-items-center d-flex"></i>
                        <form method="post">
                            <button type="submit" name="eliminareje" value="' . $ejercicio['IdEjercicio'] . '" class="bx bx-x eliminareje justify-content-center align-items-center d-flex" style="background: none; border: none; cursor: pointer;"></button>
                        </form>
                        <div class="card-header" style="">' . utf8_encode($ejercicio['NombreEjercicio']) . '</div>
                        <div class="card-body">
                            <p>Descripcion: ' . utf8_encode($ejercicio['DescripcionEjercicio']) . '</p>
                            <p>Duracion: ' . utf8_encode($ejercicio['DuracionEjercicio']) . ' Minutos</p>
                        </div>
                    </div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>


<br>
<div class="card">
    <div class="card-body">
        <h3>Iniciar rutina</h3>
        <video autoplay muted loop>
                <source src="../videos/Dosaminadas1.mp4" type="video/mp4">
              </video>
        <?php

        if (empty($ejercicios)) {
            echo '<p>No hay ejercicios en esta rutina.</p>';
        } else {
                echo '<button type="button" id="btnComenzar" class="btn btn-primary" data-toggle="modal" data-target="#modal1">Comenzar</button>';
            }

        ?>

        <?php
        // Establecer el conjunto de caracteres a UTF-8
        // Obtener ejercicios de la rutina
        $ejercicios = obtenerEjerciciosDeRutina($con, $idrutina);
        if (!empty($ejercicios)) {
            // Contar el total de ejercicios
            $totalEjercicios = count($ejercicios);
            // Iterar sobre los ejercicios y mostrarlos
            foreach ($ejercicios as $key => $ejercicio) {
                $modalId = 'modal' . ($key + 1);
                echo '<div class="modal fade" id="' . $modalId . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">';
                echo '<div class="modal-dialog modal-fullscreen">';
                echo '<div class="modal-content">';
                echo '<div class="modal-header">';
                echo '<h1 class="modal-title fs-5" id="exampleModalToggleLabel">' . $ejercicio['NombreEjercicio'] . '</h1>';
                echo '<button type="button" class="btn-close" id="closebtn' . $modalId . '" data-dismiss="modal" aria-label="Close" onclick="limpiarEstado(\'' . $modalId . '\')"></button>';
                echo '</div>';
                echo '<div class="modal-body text-center">';
                echo '<p>' . $ejercicio['DescripcionEjercicio'] . '</p>';
                echo '<video autoplay muted loop>
                <source src="'.$ejercicio['Video'].'" type="video/mp4">
              </video>';
                echo '<div class="modal-footer">';
                if ($key < $totalEjercicios - 1) {
                    $nextModalId = 'modal' . ($key + 2);
                    $descansoModalId = 'descansoModal' . ($key + 1);
                    // Ejercicio
                    echo '<div id="cuentaRegresiva' . $modalId . '" class="cuenta-regresiva d-none">Tiempo restante: <span>' . $ejercicio['DuracionEjercicio'] . ':00</span></div>';
                    echo '<button type="button" id="btnIniciar' . $modalId . '" class="btn btn-primary" onclick="iniciarCuentaRegresiva(\'' . $modalId . "',  " . ($ejercicio['DuracionEjercicio'] * 60) . ", '" . $nextModalId . '\')">Iniciar</button>';
                    echo '<button type="button" id="btnDetener' . $modalId . '" class="btn btn-danger d-none" onclick="detenerCuentaRegresiva(\'' . $modalId . '\')">Detener</button>';
                    echo '<button type="button" id="btnSiguiente' . $modalId . '" class="btn btn-primary d-none" data-toggle="modal" data-target="#' . $descansoModalId . '" onclick="miFuncion(\'' . $descansoModalId . '\')">Siguiente</button>';
                    // Descanso
                    echo '<div class="modal fade" id="' . $descansoModalId . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">';
                    echo '<div class="modal-dialog modal-fullscreen">';
                    echo '<div class="modal-content">';
                    echo '<div class="modal-header">';
                    echo '<h1 class="modal-title fs-5" id="exampleModalToggleLabel">Descanso</h1>';
                    echo '<button type="button" class="btn-close" id="closebtn' . $descansoModalId . '" data-dismiss="modal" aria-label="Close"></button>';
                    echo '</div>';
                    echo '<div class="modal-body text-center">';
                    echo '<p>Es hora de tomar un descanso.</p>';
                    echo '<img src="https://via.placeholder.com/900x500">';
                    echo '<div class="modal-footer">';
                    echo '<p id="pEliminado' . $descansoModalId . '">Descansa   <span id="contadorSiguiente' . $descansoModalId . '">60</span> segundos</p>';
                    echo '<button type="button" id="btnSiguiente2' . $descansoModalId . '" class="btn btn-primary d-none" data-toggle="modal" data-target="#' . $nextModalId . '">Siguiente</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '<script>';
                    echo 'function miFuncion(descansoModalId) {';
                    echo '  var tiempoRestante = 60;';
                    echo '  var intervalo = setInterval(function() {';
                    echo '    tiempoRestante--;';
                    echo '    document.getElementById("contadorSiguiente" + descansoModalId).textContent = tiempoRestante;';
                    echo '    if (tiempoRestante <= 0) {';
                    echo '      clearInterval(intervalo);';
                    echo '      document.getElementById("pEliminado" + descansoModalId).textContent = "Ya puedes pasar al siguiente ejercicio";';
                    echo '      document.getElementById("btnSiguiente2" + descansoModalId).classList.remove("d-none");';
                    echo '    }';
                    echo '  }, 10);';
                    echo '}';
                    echo '</script>';
                } else {
                    // Descanso final (no se muestra el botón de siguiente)
                    echo '<div id="cuentaRegresiva' . $modalId . '" class="cuenta-regresiva d-none">Tiempo restante: <span>' . $ejercicio['DuracionEjercicio'] . ':00</span></div>';
                    echo '<button type="button" id="btnIniciar' . $modalId . '" class="btn btn-primary" onclick="iniciarUltimoEjercicio(\'' . $modalId . "', " . ($ejercicio['DuracionEjercicio'] * 60) . ')">Iniciar</button>';
                    echo '<button type="button" id="btnDetener' . $modalId . '" class="btn btn-danger d-none" onclick="detenerUltimoEjercicio(\'' . $modalId . '\')">Detener</button>';
                     // Mostrar el botón "Felicitaciones" 
                       $sqlCheck = "SELECT Id_Check FROM routine WHERE Id_Routine = ?";
                    $stmtCheck = mysqli_prepare($con, $sqlCheck);
                    mysqli_stmt_bind_param($stmtCheck, 'i', $idrutina);
                    mysqli_stmt_execute($stmtCheck);
                    $resultCheck = mysqli_stmt_get_result($stmtCheck);

            // Verificar si se obtuvieron resultados de la consulta
            if ($resultCheck) {
                // Obtener el estado del check
                $rowCheck = mysqli_fetch_assoc($resultCheck);
                $id_check = $rowCheck['Id_Check'];

                // Procesar la actualización del estado de la rutina cuando se recibe la solicitud POST
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_rutina"])) {
                    $idRutina = $_POST["id_rutina"];
                    $sqlUpdate = "UPDATE routine SET Id_Check = 1 WHERE Id_Routine = ?";
                    $stmtUpdate = mysqli_prepare($con, $sqlUpdate);
                    mysqli_stmt_bind_param($stmtUpdate, 'i', $idRutina);
                    if (mysqli_stmt_execute($stmtUpdate)) {
                        echo "success";
                    } else {
                        echo "Error al actualizar el estado de la rutina: " . mysqli_error($con);
                    }
                }


                    date_default_timezone_set('America/Bogota');
                    // Obtener la hora deseada en formato HH:MM:SS
                    $hora_deseada = '23:59:59'; // Modificar aquí la hora deseada en formato HH:MM:SS

                    $fecha_actual = date('Y-m-d');
                    $completionTime = date('H:i:s');
                    $fecha_manana = date('Y-m-d', strtotime('+1 day'));
                    $hora_manana = '05:00:00';
                    // Crear la fecha y hora completa para las 5:00 AM del día siguiente
                    $hora_deseada_manana = $fecha_manana . ' ' . $hora_manana;

                    $reanudar_rutina = date('Y-m-d', strtotime('today')) . ' ' . $hora_deseada; // Establecer la fecha actual y la hora deseada
                    $sql = "UPDATE routine SET completion_time = '$completionTime', resume_time = '$reanudar_rutina' WHERE Id_Routine = $idrutina";

                    if (mysqli_query($con, $sql)) {
                        echo "";
                    } else {
                        echo "Error al actualizar la hora de finalización: " . mysqli_error($con);
                    }

                    $sqlHoraActual = "SELECT CURTIME() AS hora_actual";
                    $resultHoraActual = mysqli_query($con, $sqlHoraActual);
                    $rowHoraActual = mysqli_fetch_assoc($resultHoraActual);
                    $hora_actual_servidor = $rowHoraActual['hora_actual'];

                    // Verificar si la hora actual está dentro del rango de 10:00 PM a 5:00 AM
                    if ($completionTime >= '22:00:00') {
                        echo "<script>alert('No se puede comenzar la rutina después de las 10:00 PM y antes de las 5:00 AM. Espere hasta la hora deseada.'); window.location.href = 'interface.php';</script>";
                        exit; // Terminar la ejecución del script para evitar que se continúe con el resto del código
                    } else {
                        // Verificar si la hora actual es mayor que la hora deseada para cambiar el id_check a 0
                        if ($id_check == 1 && $hora_actual_servidor > $hora_deseada) {
                            $sqlUpdateCheck = "UPDATE routine SET Id_Check = 0, completion_time = '$completionTime' WHERE Id_Routine = ?";
                            $stmtUpdateCheck = mysqli_prepare($con, $sqlUpdateCheck);
                            mysqli_stmt_bind_param($stmtUpdateCheck, 'i', $idrutina);
                            if (mysqli_stmt_execute($stmtUpdateCheck)) {
                                echo "";
                                $id_check = 0; // Actualiza la variable local $id_check también
                            } else {
                                echo "Error al actualizar Id_Check: " . mysqli_error($con);
                            }
                        }
                    }

                if ($id_check == 0) {
                    echo '<button type="button" id="btnFelicitaciones" class="btn btn-primary d-none" data-toggle="modal" data-target="#modalFelicitaciones" onclick="actualizarEstadoRutina()">Felicitaciones</button>'; 
                     echo '<script>
                    function actualizarEstadoRutina() {
                        var idRutina = ' . $idrutina . ';
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "", true); // Dejar vacío para enviar la solicitud al mismo archivo
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.onreadystatechange = function () {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                var response = xhr.responseText;
                                if (response === "success") {
                                    console.log("Estado de rutina actualizado correctamente.");
                                } else {
                                    console.error("Error al actualizar el estado de la rutina: " + response);
                                }
                            }
                        };
                        xhr.send("id_rutina=" + idRutina);
                    }
                    </script>';
                 } else {
 
                     echo "<script>alert('Esta rutina ya está completada.'); window.location.href = 'interface.php';</script>";
                 }
            
            }
                }
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        }
        ?>


        <!-- Modal de felicitaciones -->
        <div class="modal fade" id="modalFelicitaciones" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Felicitaciones</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¡Has completado tu rutina con éxito! ¡Excelente trabajo!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    var intervalos = {}; // Objeto para almacenar los intervalos de cada cuenta regresiva
    var tiemposRestantes = {}; // Objeto para almacenar los tiempos restantes de cada cuenta regresiva

    function iniciarCuentaRegresiva(modalId, duracion, nextModalId, id_rutina) {
        var cuentaRegresiva = document.getElementById("cuentaRegresiva" + modalId);
        var btnIniciar = document.getElementById("btnIniciar" + modalId);
        var btnDetener = document.getElementById("btnDetener" + modalId);
        var btnSiguiente = document.getElementById("btnSiguiente" + modalId);
        var btnClose = document.getElementById("closebtn" + modalId);

        // Detener cualquier cuenta regresiva en curso
        detenerCuentaRegresiva(modalId);

        // Verificar si hay un tiempo restante almacenado para reanudar la cuenta regresiva
        var tiempoRestante = tiemposRestantes[modalId] || duracion;

        // Ocultar el botón de cierre al iniciar la cuenta regresiva
        btnClose.style.display = "none";

        // Función para actualizar la cuenta regresiva
        function actualizarCuentaRegresiva() {
            var minutos = Math.floor(tiempoRestante / 60);
            var segundos = tiempoRestante % 60;
            cuentaRegresiva.querySelector("span").innerText = minutos.toString().padStart(2, '0') + ":" + segundos
                .toString().padStart(2, '0');
        }

        // Función para iniciar la cuenta regresiva
        function iniciarCuentaRegresiva() {
            intervalos[modalId] = setInterval(function() {
                tiempoRestante--;
                actualizarCuentaRegresiva();
                if (tiempoRestante <= 0) {
                    clearInterval(intervalos[modalId]);
                    if (nextModalId.startsWith("descanso")) {
                        // Si es un descanso, abrir el siguiente ejercicio automáticamente
                        $('#' + nextModalId).modal('show');
                    } else {
                        // Si es el último ejercicio, mostrar los botones correspondientes
                        btnSiguiente.classList.remove(
                            "d-none"); // Mostrar botón "Siguiente" cuando termine el tiempo
                        btnClose.style.display = "block"; // Mostrar el botón de cierre cuando termine el tiempo
                        btnIniciar.style.display = "none"; // Ocultar el botón de iniciar
                        btnDetener.style.display = "none"; // Ocultar el botón de detener
                        cuentaRegresiva.classList.add("d-none");
                    }
                }
            }, 1);
        }

        // Mostrar botón de detener y ocultar botón de iniciar
        btnDetener.classList.remove("d-none");
        btnIniciar.classList.add("d-none");
        cuentaRegresiva.classList.remove("d-none");
        iniciarCuentaRegresiva();
        actualizarIdRutina(id_rutina);
    }

    function actualizarIdRutina(id_rutina) {
        var inputIdRutina = document.getElementById('id_rutina');
        if (inputIdRutina) {
            inputIdRutina.value = id_rutina;
        }
    }

    function detenerCuentaRegresiva(modalId) {
        var btnDetener = document.getElementById("btnDetener" + modalId);
        var btnIniciar = document.getElementById("btnIniciar" + modalId);
        var btnClose = document.getElementById("closebtn" + modalId);

        // Detener la cuenta regresiva si está en curso
        clearInterval(intervalos[modalId]);

        // Almacenar el tiempo restante
        tiemposRestantes[modalId] = calcularTiempoRestante(modalId);

        // Ocultar el botón de detener y mostrar el botón de iniciar
        btnDetener.classList.add("d-none");
        btnIniciar.classList.remove("d-none");

        // Mostrar el botón de cierre
        btnClose.style.display = "block";
    }

    // Función para calcular el tiempo restante en segundos
    function calcularTiempoRestante(modalId) {
        var cuentaRegresiva = document.getElementById("cuentaRegresiva" + modalId);
        var tiempoTexto = cuentaRegresiva.querySelector("span").innerText;
        var partesTiempo = tiempoTexto.split(":");
        var minutos = parseInt(partesTiempo[0]);
        var segundos = parseInt(partesTiempo[1]);
        return minutos * 60 + segundos;
    }

    // Función para iniciar el último ejercicio
    function iniciarUltimoEjercicio(modalId, duracion) {
        var btnIniciar = document.getElementById("btnIniciar" + modalId);
        var btnDetener = document.getElementById("btnDetener" + modalId);
        var cuentaRegresiva = document.getElementById("cuentaRegresiva" + modalId);
        var btnClose = document.getElementById("closebtn" + modalId);
        // Mostrar cuenta regresiva y botón de detener
        cuentaRegresiva.classList.remove("d-none");
        btnDetener.classList.remove("d-none");
        btnClose.style.display = "none";
        // Ocultar botón de iniciar
        btnIniciar.classList.add("d-none");

        // Iniciar cuenta regresiva
        iniciarCuentaRegresiva(modalId, duracion, "");
    }

    function detenerUltimoEjercicio(modalId) {
        var btnIniciar = document.getElementById("btnIniciar" + modalId);
        var btnDetener = document.getElementById("btnDetener" + modalId);
        var btnSiguiente = document.getElementById("btnSiguiente" + modalId);
        var cuentaRegresiva = document.getElementById("cuentaRegresiva" + modalId);
        var btnFelicitaciones = document.getElementById("btnFelicitaciones"); // Botón de felicitaciones con ID único
        var btnClose = document.getElementById("closebtn" + modalId);

        // Ocultar cuenta regresiva y botón de detener
        cuentaRegresiva.classList.add("d-none");
        btnDetener.classList.add("d-none");

        // Mostrar botón de iniciar
        btnIniciar.classList.remove("d-none");

        // Limpiar el intervalo y el tiempo restante
        clearInterval(intervalos[modalId]);
        tiemposRestantes[modalId] = null;
        btnClose.style.display = "block";

        // Verificar si el tiempo restante es menor o igual a cero para mostrar el botón de felicitaciones
        var tiempoRestante = calcularTiempoRestante(modalId);
        if (tiempoRestante <= 0) {
            btnFelicitaciones.classList.remove("d-none");
            cuentaRegresiva.classList.add("d-none");
            btnDetener.classList.add("d-none");
            btnIniciar.classList.add("d-none");
        }
    }
    //-------------------------------------------------



    const toggleButtons = document.querySelectorAll('.toggle-details');

    toggleButtons.forEach(button => {
        button.addEventListener('click', () => {
            const details = button.nextElementSibling;

            if (details.style.display === 'none' || details.style.display === '') {
                details.style.display = 'block';
                button.textContent = 'Cerrar ';
            } else {
                details.style.display = 'none';
                button.textContent = 'Ver Ejercicios';
            }
        });
    });

    window.onload = function() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
    };


    var inputs = document.querySelectorAll('input[type="number"]');

    inputs.forEach(function(input) {
        input.addEventListener('input', function() {
            var valor = this.value.trim();
            var soloNumeros = valor.replace(/[^0-9]/g, '');
            this.value = soloNumeros;
        });
    });


    $(function() {
        $("#ejercicios-lista").sortable({
            handle: '.draggable-handle', // especifica que el icono es el mango para arrastrar
            update: function(event, ui) {
                // Obtener el nuevo orden de los ejercicios
                var nuevoOrden = $(this).sortable('toArray').toString();

                // Almacenar el nuevo orden en el almacenamiento local
                localStorage.setItem('nuevoOrden', nuevoOrden);
            }
        });

        var ordenGuardado = localStorage.getItem('nuevoOrden');
        if (ordenGuardado) {
            var ejerciciosLista = $("#ejercicios-lista");
            var ejercicios = ordenGuardado.split(',');
            for (var i = 0; i < ejercicios.length; i++) {
                var ejercicio = $("#" + ejercicios[i]);
                ejerciciosLista.append(ejercicio);
            }
        }

        $("#ejercicios-lista").disableSelection();
    });
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Asegúrate de tener jQuery cargado -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
</script>

</body>

</html>