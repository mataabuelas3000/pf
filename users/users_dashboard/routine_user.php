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

 
function getGradientColor($difficulty) {
    switch ($difficulty) {
        case 'Fácil':
            return 'bg-gradient-success-to-secondary'; // Verde y blanco
        case 'Intermedio':
            return 'bg-gradient-warning-to-secondary'; // Amarillo y blanco
        case 'Dificíl':
            return 'bg-gradient-danger-to-secondary'; // Rojo y blanco
        default:
            return 'bg-gradient-primary-to-secondary'; // Valor por defecto
    }
}


    function imprimirRutina($con, $id)
    {
        $sql = "SELECT r.Id_Routine, r.Name_routine, r.Approach_Routine, r.Duration_Routine, d.Difficulty, r.Id_Check
                FROM routine r
                LEFT JOIN difficulty d ON r.Id_Difficulty = d.Id_Difficulty
                WHERE r.Id_User = $id";
        $result = mysqli_query($con, $sql);
    
        if ($result) {
            $count = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $id_rutina = $row['Id_Routine'];
                $nombre_rutina = $row['Name_routine'];
                $descripcion_rutina = $row['Approach_Routine'];
                $duracion_rutina = $row['Duration_Routine'];
                $dificultad = ($row['Difficulty']) ? $row['Difficulty'] : 'Sin dificultad';
                $id_check = $row['Id_Check'];
    
                $gradient_color = getGradientColor($dificultad);
    
                echo '<form method="post" class="col-12 col-md-6 col-lg-4 mb-4">';
                echo '<div class="card2">';
                echo '<div class="card-header d-flex justify-content-between align-items-center">';
                echo '<select class="form-select form-select-bg-dark" aria-label="Default select example" name="updatedificultad" style="border-radius: 5px;" required>';
                switch ($dificultad) {
                    case 'Facil':
                        echo '<option value="1" selected>Facil</option>';
                        echo '<option value="2">Intermedio</option>';
                        echo '<option value="3">Dificil</option>';
                        break;
                    case 'Intermedio':
                        echo '<option value="1">Facil</option>';
                        echo '<option value="2" selected>Intermedio</option>';
                        echo '<option value="3">Dificil</option>';
                        break;
                    case 'Dificil':
                        echo '<option value="1">Facil</option>';
                        echo '<option value="2">Intermedio</option>';
                        echo '<option value="3" selected>Dificil</option>';
                        break;
                    default:
                        echo '<option value="1">Facil</option>';
                        echo '<option value="2">Intermedio</option>';
                        echo '<option value="3">Dificil</option>';
                        break;
                }
                echo '</select>';
                echo '<a href="delete_routine.php?idrutina=' . $id_rutina . '&id_interfaz=' . $id . '" class="eliminar-rutina text-success"><i class="bx bx-x"></i></a>';
                echo '</div>';
    
                echo '<div class="card-img-top ' . $gradient_color . '" style="height: 200px;"></div>';
                echo '<div class="card-body">';
                echo '<input type="text" class="card-title" name="updatenombre" value="' . $nombre_rutina . '">';
                echo '<textarea class="card-text mb-4" name="updatedescripcion">' . $descripcion_rutina . '</textarea>';
    
                $bloquearEnlace = ($id_check == 1) ? 'disabled' : '';
                echo '<form method="post">';
                echo '<input type="hidden" name="id" value="' . $id . '">';
                echo '<input type="hidden" name="idrutina" value="' . $id_rutina . '">';
                echo '<div class="d-flex justify-content-center">';
                echo '<a href="ejercice_user.php?id_personal=' . $id . '&IdRutina=' . $id_rutina . '" style="text-decoration: none;">
                        <button type="button" class="btn btn-primary" style="cursor: pointer;">
                            <span>Iniciar</span>
                        </button>
                      </a>';
                echo '<input type="submit" class="btn btn-secondary ml-5" style="position: relative; left:-15px" name="updaterutina" value="Actualizar">';
                echo '</div>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
                echo '</form>';
    
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

function obtenerNombreUsuario($con, $id)
{
    $sql = "SELECT Name_User 
            FROM user_info 
            WHERE Id_User = $id";

    // Ejecutar la consulta
    $result = mysqli_query($con, $sql);

    // Verificar si se encontró el usuario
    if ($result && mysqli_num_rows($result) > 0) {
        // Obtener el nombre del usuario
        $row = mysqli_fetch_assoc($result);
        return $row['Name_User'];
    } else {
        return null; // Si no se encuentra el usuario, devolver null
    }
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
    <link rel="stylesheet" href="http://localhost/pf/assets/dashboard/style.css">
    <link rel="stylesheet" href="http://localhost/pf/assets/user/routine.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top ">
        <div class="container-fluid">
            <h2><?php 

            $nombreUsuario = obtenerNombreUsuario($con, $id);
            if ($nombreUsuario !== null) {
                echo  $nombreUsuario;
            } else {
                echo "Usuario no encontrado.";
            }            
            
            ?></h2>
            <a href="../crud_users.php"><input type="button" style="position:relative; left:-155px" value="regresar" class="btn btn-danger"></a>
        </div>
    </nav>
    <div class="py-5"></div> <!-- Espacio vertical -->
    <div class="card routine-card mb-5" style="transform: translateX(20%)">
    <div class="card-body routine-body">
        <div id="container-rutina" class="tab-content container2">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="col-12 col-md-6 col-lg-4 mb-5">
                <div class="card2">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <select class="form-select" name="selecciondificultad" required style="border-radius: 5px; width: max-content; padding: 0px 50px; ">
                            <option disabled selected>Nivel de Dificultad</option>
                            <option value="">Sin dificultad</option>
                            <option value="1">Facil</option>
                            <option value="2">Intermedio</option>
                            <option value="3">Avanzado</option>
                        </select>
                    </div>
                    <div class="card-img-top bg-gradient-primary-to-secondary d-flex justify-content-center align-items-center" style="">
                    
                        
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="input-group-text">Nombre</span>
                            <input type="text" class="form-control" name="namerutina" required>
                        </div>
                        <div class="mb-3">
                            <span class="input-group-text">Descripcion</span>
                            <textarea class="form-control" name="descripcion" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-secondary" name="crearrutina">Crear</button>
                    </div>
                </div>
            </form>
            <?php imprimirRutina($con, $id); ?>
        </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</body>

</html>