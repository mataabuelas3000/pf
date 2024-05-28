<?php
include ('C:\xampp\htdocs\pf\database\connect.php');
$con->set_charset('utf8');
session_start();
if (empty($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
} else {
    $id = $_SESSION['id'];
}

function imprimir($id, $con)
{
    $sql = "SELECT user_info.*, data.Height_User, data.Weight_User, data.Imc_User, roles.Role
    FROM user_info 
    INNER JOIN data ON user_info.Id_User = data.Id_User 
    INNER JOIN login ON user_info.Id_User = login.Id_User
    INNER JOIN roles ON login.Id_Role_User = roles.Id_Role_User
    WHERE user_info.Id_User = $id";

    $result = mysqli_query($con, $sql);


    if ($result) {
        // Verificar si hay al menos un usuario encontrado
        $row = mysqli_fetch_assoc($result);
        // Crear variables para los campos obtenidos
        $id = $row['Id_User'];
        $nombre = $row['Name_User'];
        $apellido = $row['Last_Name_User'];
        $correo = $row['Email_User'];
        $genero = $row['Gender_User'];
        $altura = $row['Height_User'];
        $peso = $row['Weight_User'];
        $imc = $row['Imc_User'];

        echo ' <div class="card" style=" background-image: linear-gradient(to top right , #111 39.3%, #24baae 39.3%);border:none;box-shadow: 10px 10px 10px 0px rgba(0, 0, 0, 0.5);">
        <div class="card-body">
        <div style="font-size:20px; text-align: center;">
        <h1>Tus datos</h1>
        </div>
        <hr>
        <div class="py-3">
        </div>
        <div class="row" style=""> 
        <div class="col-md-6 input-container">
        <label for="inputEmail4" class="form-label">Primer Nombre</label>
        <input type="text" class="form-control" style="background-color: white" id="inputPrimernom" value="' . $nombre . '"   disabled>
        </div>
        <div class="col-md-6 input-container">
        <label for="inputEmail4" class="form-label">Primer Apellido</label>
        <input type="text" class="form-control" id="inputPrimerape" value="' . $apellido . '"   disabled>
        </div>
        <div class="col-md-6 input-container">
        <label for="inputEmail4" class="form-label">Correo</label>
        <input type="email" class="form-control" id="inputCorreo" value="' . $correo. '"  disabled>
        </div>
        <div class="col-md-6 input-container">
        <label for="inputEmail4" class="form-label">Genero</label>
        <input type="text" class="form-control" id="inputGenero" value="' . $genero . '"  disabled>
        </div>
        <div class="col-md-6 input-container">
        <label for="inputEmail4" class="form-label">Peso</label>
        <input type="text" class="form-control" id="inputPeso" value="' . $peso . '"  disabled>
        </div>
        <div class="col-md-6 input-container">
        <label for="inputEmail4" class="form-label">Altura</label>
        <input type="text" class="form-control" id="inputAltura" value="' . $altura. '"  disabled>
        </div>
        <div class="col-md input-container">
        <label for="inputEmail4" class="form-label">IMC</label>
        <input type="text" class="form-control" id="inputImc" value="' . $imc . '"  disabled>
        </div>
        <div class="py-5">
        </div>
        <div class="col-12 ">
        <form method="post">
        <input type="hidden" name="id" value="' . $id . '">
        <button type="submit" name="updateinfo" class="btn btn-primary" style="margin-right: 10px;">Editar</button>
        </form>
        </div>
        </div>
        </div>
        </div>

        <div class="py-3">
        </div>
        ';
    }
}

function imprimirol($id, $con)
{
    $sql = "SELECT user_info.*, login.Id_User, roles.Role
    FROM user_info
    INNER JOIN login ON user_info.Id_User = login.Id_User
    INNER JOIN roles ON login.Id_Role_User = roles.Id_Role_User
    WHERE user_info.Id_User = $id";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $nombre = $row['Name_User'];
    $apellido = $row['Last_Name_User'];
    $rol = $row['Role'];
    echo $rol;
}

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
            echo '<p>' . $dificultad . '</p>';
            echo '<a href="routine/delete_routine.php?idrutina=' . $id_rutina . '&id_interfaz=' . $id . '" class="eliminar-rutina text-success"><i class="bx bx-x"></i></a>';
            echo '</div>';

            echo '<div class="card-img-top ' . $gradient_color . '" style="height: 200px;"></div>';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $nombre_rutina . '</h5>';
            echo '<p>' . $descripcion_rutina . '</p>';
            
            // Condición para imprimir el icono de reloj y la duración de la rutina
            if (!empty($duracion_rutina)) {
                echo '<p><box-icon name="stopwatch"></box-icon> ' . $duracion_rutina . ' Minutos</p>';
            }

            $bloquearEnlace = ($id_check == 1) ? 'disabled' : '';
            echo '<form method="post">';
            echo '<input type="hidden" name="id" value="' . $id . '">';
            echo '<input type="hidden" name="idrutina" value="' . $id_rutina . '">';
            echo '<button type="submit" name="openroutine" class="btn btn-primary" ' . $bloquearEnlace . '>Iniciar</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
            echo '</form>';

            $count++;
        }
    }
}



function obtenerurlroutine($id, $idrutina){
    session_start();
    $_SESSION['id'] = $id;
    $_SESSION['idrutina'] = $idrutina;
    header('Location: routine/routine.php');
    exit();
}

function obtenerurlinfo($id){
    session_start();
    $_SESSION['id'] = $id;
    header('Location: profile/update_profile.php');
    exit();
}


if (isset($_POST['updateinfo'])){
    $id = $_POST['id'];
    obtenerurlinfo($id);
}


if (isset($_POST['openroutine'])){
    $id = $_POST['id'];
    $idrutina = $_POST['idrutina'];
    obtenerurlroutine($id, $idrutina);
}


if (isset($_POST['guardarcalendario'])) {
    // Suponiendo que $conexion es tu conexión a la base de datos // Debes definir cómo obtener el ID del personal aquí

    // Recorrer los días de la semana
    $diasSemana = ['1', '2', '3', '4', '5', '6', '7'];
    $diasSemana2 = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
    foreach ($diasSemana as  $index => $dia) {
        // Verificar si se seleccionó una rutina para este día
        if (isset($_POST['idRutina_' . strtolower($dia)])) {
            // Obtener el ID de la rutina seleccionada
            $idRutina = $_POST['idRutina_' . strtolower($dia)];
            // Verificar si ya existe una rutina para este día y este usuario
            $check_query = 'SELECT Id_Routine FROM calendar WHERE Id_Day = ? AND Id_User = ?';
            $check_statement = $con->prepare($check_query);
            $check_statement->bind_param('ii', $dia, $id);
            $check_statement->execute();
            $check_result = $check_statement->get_result();

            $rutinas_existentes = [];
            while ($row = $check_result->fetch_assoc()) {
                $rutinas_existentes[] = $row['Id_Routine'];
            }

            if (in_array($idRutina, $rutinas_existentes)) {
                // Si la rutina ya existe para este día, mostrar una alerta y continuar con el siguiente día
                echo '<script>alert("La rutina seleccionada ya está asignada para el día ' . $diasSemana2[$index]. '");window.location.href = "interface.php#calendar";</script>';
                continue;  // Continuar con el siguiente día
            }
            // Verificar si previamente se seleccionó "descanso" para este día
            $query_descanso = 'SELECT Id_Routine FROM calendar WHERE Id_Day = ? AND Id_User = ? LIMIT 1';
            $statement_descanso = $con->prepare($query_descanso);
            $statement_descanso->bind_param('ii', $dia, $id);
            $statement_descanso->execute();
            $result_descanso = $statement_descanso->get_result();
            $row_descanso = $result_descanso->fetch_assoc();

            if ($idRutina == 0 && $row_descanso && $row_descanso['Id_Routine'] != 0) {
                // Si se intenta agregar "descanso" y previamente se seleccionó otra rutina, mostrar alerta y continuar con el siguiente día
                echo '<script>alert("No se puede añadir descanso para el día ' . $diasSemana2[$index] . ' porque ya se han asignado rutinas.");window.location.href = "interface.php#calendar";</script>';
                continue;  // Continuar con el siguiente día
            }

            // Contar la cantidad de rutinas asignadas para este día y este usuario
            $query_count = 'SELECT COUNT(*) as count FROM calendar WHERE Id_Day = ? AND Id_User = ?';
            $statement_count = $con->prepare($query_count);
            $statement_count->bind_param('ii', $dia, $id);
            $statement_count->execute();
            $result_count = $statement_count->get_result();
            $row_count = $result_count->fetch_assoc();
            $count = $row_count['count'];

            if ($row_descanso && $row_descanso['Id_Routine'] == 0) {
                // Si previamente se seleccionó "descanso", mostrar una alerta y continuar con el siguiente día
                echo '<script>alert("No se pueden añadir más rutinas para el día ' . $diasSemana2[$index] . ' porque ya se ha seleccionado descanso.");window.location.href = "interface.php#calendar";</script>';
                continue;  // Continuar con el siguiente día
            }

            if ($count >= 3) {
                // Si ya hay 3 o más rutinas asignadas, mostrar una alerta y detener el proceso
                echo '<script>alert("No se pueden añadir más de 3 rutinas para el día ' . $diasSemana2[$index] . '");window.location.href = "interface.php#calendar";</script>';
                break;  // Detener el proceso
            }

            // Insertar un nuevo registro en la tabla calendario
            $insert_query = 'INSERT INTO calendar (Id_Day, Id_Routine, Id_User) VALUES (?, ?, ?)';
            $insert_statement = $con->prepare($insert_query);
            $insert_statement->bind_param('iii', $dia, $idRutina, $id);
            $insert_statement->execute();
        } elseif (!isset($_POST['idRutina_' . strtolower($dia)])) {
            // Si no se seleccionó ninguna rutina para este día, continuar con el siguiente día
            continue;
        } else {
            // Si no se seleccionó ninguna rutina para este día y previamente se seleccionó "descanso",
            // mostrar una alerta para evitar que se agreguen más rutinas para este día
            $query_descanso = 'SELECT Id_Routine FROM calendar WHERE Id_Day = ? AND Id_User = ? LIMIT 1';
            $statement_descanso = $con->prepare($query_descanso);
            $statement_descanso->bind_param('ii', $dia, $id);
            $statement_descanso->execute();
            $result_descanso = $statement_descanso->get_result();
            $row_descanso = $result_descanso->fetch_assoc();

            if ($row_descanso && $row_descanso['Id_Routine'] == 0) {
                echo '<script>alert("No se pueden añadir más rutinas para el día ' . $diasSemana2[$index] . ' porque ya se ha seleccionado descanso.");window.location.href = "interface.php#calendar";</script>';
            }
        }
    }
    echo "<script>alert('Calendario actualizado correctamente.');window.location.href = 'interface.php#calendar'; </script>";
}

if (isset($_POST['crearrutina'])) {
    // Obtener datos del formulario
    $nombrerutina = $_POST['namerutina'];
    $descripcion = $_POST['descripcion'];

    // Verificar si se ha seleccionado una dificultad
    if (isset($_POST['selecciondificultad'])) {
        // Si se ha seleccionado una dificultad, obtenemos el valor
        $dificultad = $_POST['selecciondificultad'];
        // Si la dificultad es una cadena vacía, la convertimos a NULL
        if ($dificultad === "") {
            $dificultad = NULL;
        }
    } else {
        // Si no se ha seleccionado ninguna dificultad, establecer la dificultad como nula
        $dificultad = NULL;
    }

    // Verificar si el usuario ya ha alcanzado el límite de rutinas permitidas
    $query_count_routines = "SELECT COUNT(*) AS count FROM routine WHERE Id_User = ?";
    $stmt_count_routines = mysqli_prepare($con, $query_count_routines);
    mysqli_stmt_bind_param($stmt_count_routines, 'i', $id);
    mysqli_stmt_execute($stmt_count_routines);
    $result_count_routines = mysqli_stmt_get_result($stmt_count_routines);
    $row_count_routines = mysqli_fetch_assoc($result_count_routines);
    $count_routines = $row_count_routines['count'];

    // Definir el límite de rutinas permitidas
    $limite_rutinas = 6;

    // Verificar si se ha alcanzado el límite
    if ($count_routines >= $limite_rutinas) {
        echo "<script>alert('Ya has creado el máximo número de rutinas permitidas.');window.location.href = 'interface.php';</script>";
        exit;
    }

    // Insertar la nueva rutina si no se ha alcanzado el límite
    $sql_insert_routine = "INSERT INTO routine (Name_routine, Approach_Routine, Id_Difficulty, Id_User) VALUES (?, ?, ?, ?)";
    $stmt_insert_routine = mysqli_prepare($con, $sql_insert_routine);
    mysqli_stmt_bind_param($stmt_insert_routine, 'sssi', $nombrerutina, $descripcion, $dificultad, $id);
    $result_insert_routine = mysqli_stmt_execute($stmt_insert_routine);

    if ($result_insert_routine) {
        echo "<script>alert('Rutina creada exitosamente.');window.location.href = 'interface.php';</script>";
        exit;
    } else {
        echo 'Error al agregar la rutina: ' . mysqli_error($con);
    }
}

if (isset($_GET['creada']) && $_GET['creada'] == 'true') {
    $_POST = array();
}


function botonesrutinas($con)
{
    $sql = 'SELECT 	Name_Chat_Routine as nombre, Description_Chat_Routine as Descripcion, Id_Chat_Routine
    FROM chat_routine';  // Cambia el nombre de la tabla y el campo según tu base de datos
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<button onclick="mostrarEjercicios(' . $row['Id_Chat_Routine'] . ')" class="mb-2 mr-3 btn btn-secondary">' . $row['Name_Chat_Routine'] . '</button>';
        }
        echo '<hr>';
    } else {
        echo 'No se encontraron rutinas.';
    }
}




function imprimircalendario($con, $id){
     // Suponiendo que $conexion es tu conexión a la base de datos

                                    // Consulta SQL para obtener las rutinas asociadas al id_personal
                                    $query = 'SELECT Id_Routine, Name_Routine 
                                    FROM routine WHERE Id_User = ? OR Id_User IS NULL';
                                    $statement = $con->prepare($query);
                                    $statement->bind_param('i', $id);
                                    $statement->execute();
                                    $result = $statement->get_result();

                                    // Verifica si se encontraron rutinas
                                    if ($result->num_rows > 0) {
                                        // Recorre los resultados y muestra cada rutina como una opción en cada día de la semana
                                        $diasSemana = ['1', '2', '3', '4', '5', '6', '7'];
                                        $diasSemana2 = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                                        // Itera sobre los días de la semana
                                        foreach ($diasSemana2 as $dia2) {
                                            echo '<th class="p-2 text-center hola1">' . $dia2 . '</th>';  // Encabezado de la columna con el día
                                        }

                                        echo '</tr> </thead>';  // Cierra la fila del encabezado y abre una nueva fila para los selectores de rutina

                                        // Itera sobre los días de la semana
                                        foreach ($diasSemana as $dia) {
                                            echo '<td>';
                                            echo '<select id="idRutina" name="idRutina_' . strtolower($dia) . '" class="form-control" >';
                                            echo '<option value="" selected disabled>Selecciona una rutina</option>';

                                            // Recorre los resultados y muestra cada rutina como una opción en el selector
                                            $result->data_seek(0);  // Reiniciar el puntero de los resultados
                                            while ($row = $result->fetch_assoc()) {
                                                $idRutina = $row['Id_Routine'];
                                                $nombreRutina = $row['Name_Routine'];
                                                echo "<option value='$idRutina'>$nombreRutina</option>";
                                            }
                                            echo '</select>';
                                            echo '</td>';  // Cierre de la celda para el selector de rutina
                                        }

                                        echo '</tr></thead>';  // Cierre de la fila para los selectores de rutina

                                        // Ahora, agregamos una nueva fila para el nombre de la rutina y el botón de eliminar
                                        echo '<tr></thead>';
                                        foreach ($diasSemana as $index => $dia) {
                                            echo '<td>';
                                            // Consulta SQL para verificar si ya existe una rutina asociada a este día de la semana y este usuario en la tabla calendario
                                            // Consulta SQL para verificar si ya existe una rutina asociada a este día de la semana y este usuario en la tabla calendario
                                            $check_query = 'SELECT r.Id_Routine, r.Name_Routine
                                            FROM calendar c 
                                            INNER JOIN routine r ON c.Id_Routine = r.Id_Routine 
                                            WHERE c.Id_User = ? AND c.Id_Day = ?';
                                            $check_statement = $con->prepare($check_query);
                                            $check_statement->bind_param('ii', $id, $dia); // Aquí usamos 'is' para indicar que el primer parámetro es un entero y el segundo es una cadena
                                            $check_statement->execute();
                                            $check_result = $check_statement->get_result();


                                            if ($check_result->num_rows > 0) {
                                                foreach ($check_result as $check_row) {
                                                    $nombreRutinaDia = $check_row['Name_Routine'];
                                                    $idRutinaDia = $check_row['Id_Routine'];

                                                    echo '<div style="display: flex; border-bottom: 1px solid black;">';
                                                    if ($idRutinaDia == 0) {
                                                        echo '<a href="calendar/delete_calendar_routine.php?id_personal=' . $id . '&idRutina=' . $idRutinaDia . '&dia=' . $dia . '" style="text-decoration: none; color: black; font-size: 20px"><i class="bx bx-x"></i></a>';
                                                        echo '<p class="ml-3">' . $nombreRutinaDia . '</p>';
                                                    } else {
                                                        echo '<a href="calendar/delete_calendar_routine.php?id_personal=' . $id . '&idRutina=' . $idRutinaDia . '&dia=' . $dia . '" style="text-decoration: none; color: black; font-size: 20px"><i class="bx bx-x"></i></a>';
                                                        echo '<p class="ml-3">
                                                        <form method="post">
                                                            <input type="hidden" name="id" value="'.$id.'">
                                                            <input type="hidden" name="idrutina" value="'.$idRutinaDia.'">
                                                            <button type="submit" name="openroutine" class="link-like-button">'.$nombreRutinaDia.'</button>
                                                        </form>
                                                    </p>';
                                                
                                                    }
                                                    echo '</div> <br>';
                                                    
                                                }
                                            } else {
                                                echo "<p>No hay rutina para $diasSemana2[$index]</p>";
                                            }
                                            echo '</td>';  // Cierre de la celda para el nombre de la rutina y el botón de eliminar
                                        }

                                        echo '</tr>';  // Cierre de la fila para el nombre de la rutina y el botón de eliminar
                                    } else {
                                        echo "<tr><td colspan='7'>No se encontraron rutinas asociadas a este usuario.</td></tr>";
                                    }
}




?>
