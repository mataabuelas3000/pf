<?php
include ('C:\xampp\htdocs\pf\database\connect.php');
$con->set_charset('utf8');
// Iniciar la sesión
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
            $nombregrupo = $row['Name_Group'];
            $nombreejercicio =  $row['Name_Exercise'];
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
    <link rel="stylesheet" href="routine_user_styles.css">
</head>

<body>
    <!-- Barra de navegación -->
    <nav class="navbar bg-dark">
        <div class="container-fluid">
            <h5 class="nav-link text-light"><?php echo $nombrerutina ?></h5>
            <a class="nav-link text-light" href="routine_user.php?id_personal=<?php echo $id; ?>">
                <input value="Regresar" type="button" class="btn btn-danger">
            </a>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="card1 d-flex justify-content-end" style="width: 100%;">
            <form method="post">
                <div class="details">
                    <?php mostrarejercicios($con, $idrutina); ?>
                </div>
            </form>
    </div>

    <div class="card bg-dark" style="width: 100%;">
        <div class="card-body">
            <h3 class="text-light">Ejercicios</h3>
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
                    <div class="card mb-4 ejercicio-item" id="ejercicio_' . $ejercicio['IdEjercicio'] . '" style="border-radius: 10px; background-color: #24baae; color: white; font-size: 20px">
                        <i class="bx bx-dialpad-alt draggable-handle justify-content-center align-items-center d-flex"></i>
                        <form method="post">
                            <button type="submit" name="eliminareje" value="' . $ejercicio['IdEjercicio'] . '" class="bx bx-x eliminareje justify-content-end align-items-center d-flex" style="background: none;color: white; border: none; cursor: pointer;"></button>
                        </form>
                        <div class="card-header" style="background: #13756d">' . $ejercicio['NombreEjercicio'] . '</div>
                        <div class="card-body" style="background: #178b82">
                            <p>Descripcion: ' .$ejercicio['DescripcionEjercicio'] . '</p>
                            <p>Duracion: ' .$ejercicio['DuracionEjercicio'] . ' Minutos</p>
                        </div>
                    </div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>


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