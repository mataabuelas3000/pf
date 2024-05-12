<?php
// Incluir archivo de conexión a la base de datos
include ('C:\xampp\htdocs\pf\database\connect.php');
$con->set_charset('utf8');

// Iniciar sesión
session_start();

// Verificar si se proporciona el parámetro 'id_personal' en la URL
if (isset($_GET['id_personal'])) {
    // Obtener el ID del usuario desde la URL
    $id = $_GET['id_personal'];

 

    function imprimirRutina($con, $id)
{
    // Consulta para seleccionar las rutinas del usuario
    $sql = "SELECT r.Id_Routine, r.Name_routine, r.Approach_Routine, r.Duration_Routine, r.Id_Difficulty
            FROM routine r
            WHERE r.Id_User = $id";
    $result = mysqli_query($con, $sql);

    // Verificar si la consulta se ejecutó correctamente
    if ($result) {
        // Contador para las rutinas
        $count = 0;
        // Iterar sobre cada fila de resultados
        while ($row = mysqli_fetch_assoc($result)) {
            // Obtener los datos de la rutina
            $id_rutina = $row['Id_Routine'];
            $nombre_rutina = $row['Name_routine'];
            $descripcion_rutina = $row['Approach_Routine'];
            $duracion_rutina = $row['Duration_Routine'];
            $dificultad = $row['Id_Difficulty'];

            // Imprimir el formulario para cada rutina
            echo '<form method="post" style="width: 30%; margin-right:20px" >';
            echo '<div class="card" style="border: 1px solid black; width: 100%; height: 440px; padding: 0px; margin-bottom: 20px; margin-right: 20px; position: relative;">';
            echo '<input type="hidden" name="idrutina" value="' . $id_rutina . '">';

            // Selector de dificultad
            echo '<div style="position: absolute; top: 10px; left: 5%; display: flex; align-items: center;"><div class="mr-2"></div>';
            echo '<select class="form-select form-select-bg-dark" aria-label="Default select example" name="updatedificultad" style="border-radius: 5px; " required>';
            // Seleccionar opciones según la dificultad actual
            switch ($dificultad) {
                case 1:
                    echo '<option value="">Sin dificultad</option>
                          <option value="1" selected>Facil</option>
                          <option value="2">Intermedio</option>
                          <option value="3">Dificil</option>';
                    break;
                case 2:
                    echo '<option value="">Sin dificultad</option>
                          <option value="1">Facil</option>
                          <option value="2" selected>Intermedio</option>
                          <option value="3">Dificl</option>';
                    break;
                case 3:
                    echo '<option value="">Sin dificultad</option>
                          <option value="1">Facil</option>
                          <option value="2">Intermedio</option>
                          <option value="3" selected>Dificil</option>';
                    break;
                default:
                    echo '<option value="" selected>Sin dificultad</option>
                          <option value="1">Facil</option>
                          <option value="2">Intermedio</option>
                          <option value="3">Avanzado</option>';
                    break;
            }
            echo '</select></div>';

            // Imprimir duración de la rutina si está presente
            if (!empty($duracion_rutina)) {
                echo '<div style="position: absolute; top: 160px; left: 60%; display: flex; align-items: center; "><box-icon name="stopwatch" class="reloj"></box-icon><div class="mr-2"></div> ' . $duracion_rutina . ' Minutos</div>';
            }

            // Enlace para eliminar la rutina
            echo '<a href="delete_routine.php?idrutina=' . $id_rutina . '&id_interfaz=' . $id . '" class="eliminar-rutina" style="position: absolute; top: 5px; right: 5px; color: white; font-size: 30px"><i class="bx bx-x"></i></a>';

            // Imprimir imagen de la rutina
            echo '<div class="card-img-top" style="background-image: linear-gradient(to bottom right, #3399ff, #ff66cc); height: 200px;"></div>';
            echo '<div class="card-body" style="padding: 35px;">';

            // Campos para editar nombre y descripción de la rutina
            echo '<input type="text" class="card-title" name="updatenombre" value="' . $nombre_rutina . '">';
            echo '<textarea class="card-text" name="updatedescripcion">' . $descripcion_rutina . '</textarea> <br>';

            // Enlace para iniciar la rutina y botón para actualizar la rutina
            echo '<div class="d-flex justify-content-center"><a href="ejercice_user.php?id_personal=' . $id . '&IdRutina=' . $id_rutina . '" style="text-decoration: none; "><box-icon name="play" ></box-icon>Iniciar</a>';
            echo '<input type="submit" class="btn btn-secondary ml-5" name="updaterutina" value="Actualizar">';
            echo '</div></div></div>';  // Cierre de los divs card, card-body y form
            echo '</form>';  // Cierre del formulario

            $count++;
        }
    }
}
// Manejo del formulario para crear una nueva rutina
if (isset($_POST['crearrutina'])) {
    $nombrerutina = $_POST['namerutina'];
    $enfoque = $_POST['enfoque'];
    
    // Verificar si se ha seleccionado una dificultad
    if(isset($_POST['selecciondificultad'])) {
        // Si se ha seleccionado una dificultad, obtenemos el valor
        $dificultad = $_POST['selecciondificultad'];
        // Si la dificultad es una cadena vacía, la convertimos a NULL
        if($dificultad === "") {
            $dificultad = NULL;
        }
    } else {
        echo "<script>alert('Por favor, seleccione la dificultad de la rutina.'); window.history.back();</script>";
        exit;
    }
    // Obtener el último ID de rutina insertado
    $sql_last_routine_id = "SELECT MAX(Id_Routine) AS last_id FROM routine";
    $result_last_routine_id = mysqli_query($con, $sql_last_routine_id);
    $row_last_routine_id = mysqli_fetch_assoc($result_last_routine_id);
    $last_routine_id = $row_last_routine_id['last_id'];

    // Calcular el próximo ID de rutina
    $new_routine_id = $last_routine_id + 1;

    // Verificar si el nombre de la rutina ya existe
    $query_check_name = "SELECT COUNT(*) AS count FROM routine WHERE Id_User = ? AND Name_routine = ?";
    $stmt_check_name = mysqli_prepare($con, $query_check_name);
    mysqli_stmt_bind_param($stmt_check_name, 'is', $id, $nombrerutina);
    mysqli_stmt_execute($stmt_check_name);
    $result_check_name = mysqli_stmt_get_result($stmt_check_name);
    $row_check_name = mysqli_fetch_assoc($result_check_name);
    $rutina_existente = $row_check_name['count'] > 0;

    if ($rutina_existente) {
        echo "<script>alert('¡Una rutina con el mismo nombre ya existe!');window.history.back();</script>";
        exit;
    }

    echo "Valor de \$dificultad: $dificultad";

    // Insertar la rutina si el nombre no existe
    $sql_insert_routine = "INSERT INTO routine (Id_Routine, Name_routine, Approach_Routine, Id_Difficulty, Id_User) VALUES (?, ?, ?, ?, ?)";
    $stmt_insert_routine = mysqli_prepare($con, $sql_insert_routine);
    mysqli_stmt_bind_param($stmt_insert_routine, 'isssi', $new_routine_id, $nombrerutina, $enfoque, $dificultad, $id);
    $result_insert_routine = mysqli_stmt_execute($stmt_insert_routine);
    
    if ($result_insert_routine) {
        echo "<script>alert('Rutina creada exitosamente. ID de rutina: $new_routine_id');window.history.back();</script>";
        exit;
    } else {
        echo 'Error al agregar la rutina: ' . mysqli_error($con);
    }
}

if (isset($_POST['updaterutina'])) {
    $idRutina = $_POST['idrutina'];  
    $nombrerutina = $_POST['updatenombre'];
    $descripcion = $_POST['updatedescripcion'];

    // Verificar si se ha seleccionado una dificultad
    $dificultad = isset($_POST['updatedificultad']) ? $_POST['updatedificultad'] : null;

    if ($dificultad === '') {
        $dificultad = null;
    }

    // Verificar si el nombre de la rutina ya existe
    $query_check_name = 'SELECT COUNT(*) AS count FROM routine WHERE Name_routine = ? AND Id_Routine != ?';
    $stmt_check_name = mysqli_prepare($con, $query_check_name);
    mysqli_stmt_bind_param($stmt_check_name, 'si', $nombrerutina, $idRutina);
    mysqli_stmt_execute($stmt_check_name);
    $result_check_name = mysqli_stmt_get_result($stmt_check_name);
    $row_check_name = mysqli_fetch_assoc($result_check_name);
    $rutina_existente = $row_check_name['count'] > 0;

    if ($rutina_existente) {
        echo "<script>alert('¡Una rutina con el mismo nombre ya existe!'); window.history.back();</script>";
        exit;
    }

    // Actualizar la rutina
    $sql = 'UPDATE routine SET Name_routine = ?, Approach_Routine = ?, Id_Difficulty = ? WHERE Id_Routine = ?';
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'ssii', $nombrerutina, $descripcion, $dificultad, $idRutina);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo "<script>alert('Rutina actualizada exitosamente.');window.history.back();</script>";
        exit;
    } else {
        echo 'Error al actualizar la rutina: ' . mysqli_error($con);
    }
}
} else {
    // Si 'id' no está definido en $_GET, mostrar un mensaje de error o redireccionar a otra página.
    echo "Error: No se proporcionó el parámetro 'id' en la URL.";
    // O redireccionar a otra página
    // header("Location: pagina_error.php");
    exit;  // Terminar el script
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="routine_user_styles.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>

<body>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <h5>Rutina</h5>
            <a href="../crud_users.php"><input type="button" value="regresar" class="btn btn-danger"></a>
        </div>
    </nav>
    <div class="card" style="width: 100%;">
        <div class="container" style="padding: 20px; display: flex; flex-wrap: wrap;  justify-content: center;">
            <form action="" method="post" style="width:30%; margin-right: 20px;">
                <div class="card"
                    style="border: 1px solid black; width: 100%; padding: 0px; margin-bottom: 20px; margin-right: 0px;  position: relative;">
                    <div
                        style="position: absolute; top: 10px; left: 5%; display: flex; align-items: center; color: white">
                        <div class="mr-2"></div> <select class="form-select form-select-bg-dark"
                            aria-label="Default select example" name="selecciondificultad" style="border-radius: 5px; "
                            required>
                            <option disabled selected>Nivel de Dificultad</option>
                            <option value="">Sin dificultad</option>
                            <option value="1">Facil</option>
                            <option value="2">Intermedio</option>
                            <option value="3">Dificil</option>
                        </select>
                    </div>
                    <div
                        style="position: absolute; top: 70px; left: 38%; display: flex; align-items: center; color: white;font-size: 90px">
                        <i class='bx bxs-plus-circle bx-flashing-hover'></i>
                    </div>
                    <div class="card-img-top"
                        style="background-image: linear-gradient(to bottom right, #3399ff, #ff66cc); height: 200px;">
                    </div>
                    <div class="card-body" style="padding:35px">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Nombre</span>
                            <input type="text" class="form-control" name="namerutina" value=""
                                placeholder="Nombre rutina" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Descripcion</span>
                            <textarea class="form-control" name="enfoque" placeholder="Descripción"
                                required></textarea>
                        </div>
                        <input class="btn btn-secondary" type="submit" value="Crear" name="crearrutina">
                    </div>
                </div>
            </form>
            <?php
                // Llamar a la función para imprimir las rutinas del usuario
                imprimirRutina($con, $id);
            ?>
        </div>
    </div>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</body>

</html>