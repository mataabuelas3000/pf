<?php
include('C:\xampp\htdocs\pf\database\connect.php');
session_start();

// Verificar si no hay una sesión activa de personal o de rutina
if (empty($_SESSION['id']) && empty($_SESSION['idrutina'])) {
    header('Location: ../interface.php');
    exit();
} else {
    // Redirigir a la página de interfaz si hay una sesión activa
    $id = $_SESSION['id'];
    $idrutina = $_SESSION['idrutina'];
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
        $sql = 'SELECT g.Name_Group, e.url_video, e.Name_Exercise, e.Id_Exercise
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
        $sql = 'SELECT g.Name_Group, e.url_video, e.Name_Exercise, e.Id_Exercise
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
        echo '<div class="container " style="margin-top: 30px;width: 100%;display: flex; flex-wrap: wrap;  justify-content: right;">';
        while ($row = mysqli_fetch_assoc($result)) {
            $nombregrupo =  $row['Name_Group'];
            $nombreejercicio = $row['Name_Exercise'];
            $idejercicio = $row['Id_Exercise'];
            $video = $row['url_video'];
            if ($nombregrupo != $current_grupo) {
                if ($current_grupo != '') {
                    echo '</ul>';
                }
                echo '<ul class="list-group ml-4 mt-3" style="width: 30%; border-radius: 20px">';
                echo '<li class="list-group-item list-group-item-info text-light text-center bg-dark" style="margin-top:20px; padding: 15px;font-size: 20px">' . $nombregrupo . '</li>';
                $current_grupo = $nombregrupo;
            }

            echo '<li class="list-group-item" style="padding: 13px; border: 1px solid rgba(41, 41, 41, 0.116)">
                    <input class="form-check-input ml-1 me-1" type="checkbox" value="' . $idejercicio . '" id="checkbox_' . $idejercicio . '" name="seleccioncheck[]">
                    <label class="form-check-label ml-5" for="checkbox_' . $idejercicio . '">' . $nombreejercicio . '</label>
               
                </li>';
        }
        echo '</ul></div>';

        // Agregar un botón para enviar el formulario después de seleccionar los ejercicios
        echo '
        <div class="d-flex justify-content-end"><button type="submit" class="btn btn-dark mt-4" name="agregarejer">Agregar Ejercicios Seleccionados</button></div>';
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
// Función para contar la cantidad de ejercicios en la rutina actual
function contarEjerciciosRutina($con, $idrutina) {
    $sql_contar = 'SELECT COUNT(*) AS total FROM rut_has_exercise WHERE Id_Routine = ?';
    $stmt_contar = mysqli_prepare($con, $sql_contar);
    if ($stmt_contar) {
        mysqli_stmt_bind_param($stmt_contar, 'i', $idrutina);
        mysqli_stmt_execute($stmt_contar);
        mysqli_stmt_bind_result($stmt_contar, $total);
        mysqli_stmt_fetch($stmt_contar);
        mysqli_stmt_close($stmt_contar);
        return $total;
    } else {
        return false;
    }
}

// Verificar si se puede agregar más ejercicios a la rutina
if (isset($_POST['agregarejer'])) {
    if (isset($_POST['seleccioncheck'])) {
        // Obtener los ejercicios seleccionados del formulario
        $ejerciciosSeleccionados = $_POST['seleccioncheck'];

        // Contar la cantidad actual de ejercicios en la rutina
        $cantidadActual = contarEjerciciosRutina($con, $idrutina);

        // Verificar si se pueden agregar más ejercicios (máximo 8)
        if ($cantidadActual !== false && $cantidadActual + count($ejerciciosSeleccionados) <= 8) {
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
            echo "<script>alert('No se pueden agregar más de 8 ejercicios a la rutina')</script>";
        }
    } else {
        // Si no se han seleccionado ejercicios, mostrar un mensaje de error
        echo "<script>alert('Selecciona al menos un ejercicio')</script>";
    }
}


function misjercicios($con, $idrutina, $ejercicios){

    // Verificar si hay ejercicios en la rutina
    if (empty($ejercicios)) {
        echo '<p class="text-light">No hay ejercicios en esta rutina.</p>';
    } else {
        // Iterar sobre los ejercicios y mostrarlos
        foreach ($ejercicios as $ejercicio) {
            echo '
        <div class="card mb-4 ejercicio-item" id="ejercicio_' . $ejercicio['IdEjercicio'] . '" style="border-radius: 10px; background-color: #24baae; color: white; font-size: 20px">
            <i class="bx bx-dialpad-alt draggable-handle justify-content-center align-items-center d-flex"></i>
            <form method="post">
                <button type="submit" name="eliminareje" value="' . $ejercicio['IdEjercicio'] . '" class="bx bx-x eliminareje justify-content-end align-items-center d-flex" style="background: none;color: white; border: none; cursor: pointer;"></button>
            </form>
            <div class="card-header" style="background: #13756d">' .$ejercicio['NombreEjercicio'] . '</div>
            <div class="card-body" style="background: #178b82">
                <p>Descripcion: ' . $ejercicio['DescripcionEjercicio'] . '</p>
                <p>Duracion: ' . $ejercicio['DuracionEjercicio'] . ' Minutos</p>
            </div>
        </div>';
        }
    }
}


function modals($con, $idrutina, $ejercicios){


    if (!empty($ejercicios)) {
        echo '
            
        <div id="boton-chatbot">
        <button type="button" id="btnComenzar"  class="btn btn-primary" data-toggle="modal" data-target="#modal1"><i class="bx bx-play-circle bx-play"></i></button>
    </div>
        ';
    } 
    // Establecer el conjunto de caracteres a UTF-8
    // Obtener ejercicios de la rutina
    $con->set_charset('utf8');
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
    echo '<div id="cuentaRegresiva' . $modalId . '" class="cuenta-regresiva "><span>' . $ejercicio['DuracionEjercicio'] . ':00</span></div>';
    echo '<h1 class="modal-title" id="exampleModalToggleLabel">' . $ejercicio['NombreEjercicio'] . '</h1>';
    echo '<button type="button" class="btn-close" id="closebtn' . $modalId . '" data-dismiss="modal" aria-label="Close" onclick="cerrarTodosLosModals()"></button>';
    echo '</div>';
    echo '<div class="modal-body text-center" style="display:flex; align-items: center;justify-content: center ">';
    echo '<div style="flex-direction: column;"><p style="font-size:30px; margin-bottom: 80px" >' . $ejercicio['DescripcionEjercicio'] . '</p>';
    echo '<video autoplay muted loop width="900" style="border-radius: 30px;">
    <source src="'.$ejercicio['Video'].'" type="video/mp4">
    </video>
    </div>';
    echo '</div>';
    echo '<div class="modal-footer">';
    if ($key < $totalEjercicios - 1) {
        $nextModalId = 'modal' . ($key + 2);
        $descansoModalId = 'descansoModal' . ($key + 1);
        echo '<button type="button" id="btnIniciar' . $modalId . '" class="btn btn-success" onclick="iniciarCuentaRegresiva(\'' . $modalId . "',  " . ($ejercicio['DuracionEjercicio'] * 60) . ", '" . $nextModalId . '\')">Iniciar</button>';
        echo '<button type="button" id="btnDetener' . $modalId . '" class="btn btn-danger d-none" onclick="detenerCuentaRegresiva(\'' . $modalId . '\')">Detener</button>';
        echo '<button type="button" id="btnSiguiente' . $modalId . '" class="btn btn-primary d-none" data-toggle="modal" data-target="#' . $descansoModalId . '" onclick="miFuncion(\'' . $descansoModalId . '\')">Siguiente</button>';
        echo '<div class="modal fade" id="' . $descansoModalId . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">';
        echo '<div class="modal-dialog modal-fullscreen">';
        echo '<div class="modal-content">';
        echo '<div class="modal-header">';
        echo '<div class="cuenta-regresiva" id="pEliminado' . $descansoModalId . '"><span id="contadorSiguiente' . $descansoModalId . '">60</span></div>';
        echo '<h1 class="modal-title" id="exampleModalToggleLabel">Descanso</h1>';
        echo '<button type="button" class="btn-close" id="closebtn' . $descansoModalId . '" onclick="cerrarTodosLosModals()" data-dismiss="modal" aria-label="Close"></button>';
        echo '</div>';
        echo '<div class="modal-body text-center" style="display:flex; align-items: center;justify-content: center ">';
        echo '<div style="flex-direction: column;">';
        echo '<p style="font-size:30px; margin-bottom: 80px">Es hora de tomar un descanso.</p>';
        echo '<img src="../../images/img4.svg" width="600">';
        echo '</div>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '<button type="button" id="btnSiguiente2' . $descansoModalId . '" class="btn btn-success d-none" style="margin-right: 40px" data-toggle="modal" data-target="#' . $nextModalId . '">Siguiente</button>';
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
        echo '      document.getElementById("btnSiguiente2" + descansoModalId).classList.remove("d-none");';
        echo '    }';
        echo '  }, 10);';
        echo '}';
        echo '</script>';
    } else {
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
                if ($completionTime >= '23:10:00' && $hora_deseada_manana <='05:00:00') {
                    echo "<script>alert('No se puede comenzar la rutina después de las 10:00 PM y antes de las 5:00 AM. Espere hasta la hora deseada.'); window.location.href = '../interface.php';</script>";
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

                 echo "<script>alert('Esta rutina ya está completada.'); window.location.href = '../interface.php';</script>";
             }
        
        }
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }
}



?>