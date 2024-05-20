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
    WHERE user_info.Id_User";

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

        echo ' <div class="card" style=" background-image: linear-gradient(to top right , #111 39.3%, #24baae 39.3%); border:none;box-shadow: 10px 10px 10px 0px rgba(0, 0, 0, 0.5);">
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
function imprimirRutina($con, $id)
{
    // Consulta para seleccionar las rutinas del usuario
    $sql = "SELECT r.Id_Routine, r.Name_routine, r.Approach_Routine, r.Duration_Routine, d.Difficulty, r.Id_Check
    FROM routine r
    LEFT JOIN difficulty d ON r.Id_Difficulty = d.Id_Difficulty
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
            $dificultad = ($row['Difficulty']) ? $row['Difficulty'] : 'Sin dificultad'; // Verificar si hay dificultad o establecer "Sin dificultad"
            $id_check = $row['Id_Check'];
            // Imprimir el formulario para cada rutina
            echo '<form method="post" style="width: 30%; margin-right:20px" >';
            echo '<div class="card" style="border: 1px solid black; width: 100%; height: 440px; padding: 0px; margin-bottom: 20px; margin-right: 20px; position: relative;">';

            // Selector de dificultad
            echo '<div style="position: absolute; top: 10px; left: 5%; display: flex; align-items: center;"><div class="mr-2"></div>';
            echo '<p style="border-radius: 5px; "> '.$dificultad.'';
            echo '</p></div>';

            // Imprimir duración de la rutina si está presente
            if (!empty($duracion_rutina)) {
                echo '<div style="position: absolute; top: 160px; left: 60%; display: flex; align-items: center; "><box-icon name="stopwatch" class="reloj"></box-icon><div class="mr-2"></div> ' . $duracion_rutina . ' Minutos</div>';
            }

            // Enlace para eliminar la rutina
            echo '<a href="delete_routine.php?idrutina=' . $id_rutina . '&id_interfaz=' . $id . '" class="eliminar-rutina" style="position: absolute; top: 5px; right: 5px; color: white; font-size: 30px"><i class="bx bx-x"></i></a>';

            // Imprimir imagen de la rutina
            echo '<div class="card-img-top" style="background-image: linear-gradient(to bottom right, #4a6eb0, #9cd2d3); height: 200px;border-top-right-radius: 8px;
            border-top-left-radius: 8px; "></div>';
            echo '<div class="card-body" style="padding: 35px;">';

            // Campos para editar nombre y descripción de la rutina
            echo '<p class="card-title">' . $nombre_rutina . '</p>';
            echo '<p >' . $descripcion_rutina . '</p> <br>';

            $bloquearEnlace = ($id_check == 1) ? 'disabled' : '';
            // Enlace para iniciar la rutina y botón para actualizar la rutina
                echo '<div>
                <form method="post">
                <input type="hidden" name="id" value="'.$id.'">
                <input type="hidden" name="idrutina" value="'.$id_rutina.'">
                <button type="submit" name="openroutine" class="btn btn-primary" style="margin-right: 10px;'.$bloquearEnlace.'">Iniciar</button>
                </form>';
                echo '</div>
            </div>
            </div>';
            // Cierre de los divs card, card-body y form
            echo '</form>'; // Cierre del formulario

            $count++;
        }
    }
}

?>
<?php

function obtenerurlroutine($id, $idrutina){
    session_start();
    $_SESSION['id'] = $id;
    $_SESSION['idrutina'] = $idrutina;
    header('Location: routine.php');
    exit();
}

function obtenerurlinfo($id){
    session_start();
    $_SESSION['id'] = $id;
    header('Location: update_profile.php');
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

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="interface_style.css">
    <title>GYM</title>
</head>

<body>


    <nav class="sidebar" id="sidebar">
        <!-- Logo de usuario -->
        <a href="#info" class="nav-link buton-info " onclick="setActiveLink(this); openTab('info');">
            <span class="icon d-flex align-items-center justify-content-center" title="Info">
            <i class='bx bxs-user-circle' style="font-size: 35px" ></i>
            </span>
        </a>
        <hr>
        <!-- Enlaces de navegación -->

        <div class="nav-container buttons-nav" style="margin-top:20vh; margin-bottom: 25vh">
            <a class="nav-link a-rutina" href="#" onclick="setActiveLink(this); openTab('container-rutina');" title="Rutina">
                <span class="icon d-flex align-items-center justify-content-center">
                <i class='bx bx-run' style="font-size: 35px"></i>
                </span>
            </a>
            <a class="nav-link a-calendar" href="#" onclick="setActiveLink(this); openTab('container-calendario');" title="Calendario">
                <span class="icon d-flex align-items-center justify-content-center">
                <i class='bx bxs-calendar' style="font-size: 35px"></i>
                </span>
            </a>
            <a class="nav-link" href="#" onclick="setActiveLink(this);  openTab('container-tienda');" title="Tienda">
                <span class="icon d-flex align-items-center justify-content-center">
                <i class='bx bxs-store' style="font-size: 35px"></i>
                </span>
            </a>
        
        <!-- Enlace para cerrar sesión -->
        <a class="nav-link text-light " href="../auth/logout.php"
            style="text-decoration:none; transform: translateY(33vh)" title="Cerrar sesion">
            <span class="icon d-flex align-items-center justify-content-center">
            <i class='bx bx-log-out' style="font-size: 35px"></i>
            </span>
        </a>
        </div>
    </nav>

    <!-- Widget del chatbot -->
    <div id="boton-chatbot">
        <i class='bx bxs-chat btn'></i>
    </div>
    <!-- Widget del chatbot -->
    <div class="widget" id="widget" style="display: none;">
        <div id="window" class="window">
            <button id="chatbot-close-button"><i class='bx bxs-down-arrow'></i></button>
            <div style="transform: translateY(30px)"> 
                <h1>Chatbot</h1> 
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#fff" fill-opacity="1" d="M0,160L60,160C120,160,240,160,360,176C480,192,600,224,720,213.3C840,203,960,149,1080,117.3C1200,85,1320,75,1380,69.3L1440,64L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path></svg>
        </div>
        <div class="chatbot-widget" id="chatbot-widget">
            <div class="chat-container" id="chat-box">
                <div class="message-chat">¡Hola! Soy Jhon tu entrenador personal y estoy para ayudarte a crear tus
                    rutinas.</div>
                <div class="message-chat">En que estas interesado?</div>
                <br>
                <div class="container-buttons">
                    <button onclick="mostrarRutinas()" class="mb-1 btn btn-primary">Rutina</button>
                    <button onclick="mostrarAlimentacion()" class="mb-1 btn btn-primary">Alimentación</button>
                </div>
                <div id="rutinas-container" class="mt-3" style="display: none;">
                    <hr>
                </div>

                <div class="mb-3"></div>
            </div>
        </div>
    </div>
    <script>
    function mostrarRutinas() {
        const rutinasContainer = document.getElementById('rutinas-container');
        rutinasContainer.innerHTML = ''; // Limpiar contenido previo
        rutinasContainer.style.display = 'block'; // Mostrar contenedor

        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                rutinasContainer.innerHTML = this.responseText; // Agregar botones de rutinas
            }
        };
        xhttp.open("GET", "obtener_rutinas.php", true); // Ruta al archivo PHP que obtiene las rutinas
        xhttp.send();
    }

    function mostrarEjercicios(rutinaID) {
        const ejerciciosContainer = document.getElementById('rutinas-container');
        const backButton = document.createElement('button');
        backButton.textContent = 'Atrás';
        backButton.classList.add('mb-1', 'btn', 'btn-info');
        backButton.onclick = mostrarMenuPrincipal;
        ejerciciosContainer.innerHTML = '';

        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                ejerciciosContainer.innerHTML = this.responseText;
                ejerciciosContainer.appendChild(backButton); // Añadir el botón de atrás
                ejerciciosContainer.style.display = 'block';
            }
        };
        xhttp.open("GET", "obtener_ejercicios.php?id=" + rutinaID + "&idpersonal=" + <?php echo $id; ?>, true);
        xhttp.send();
    }

    function mostrarAlimentacion(alimentacion) {
        const alimentacionContainer = document.getElementById('rutinas-container');
        alimentacionContainer.innerHTML = '';
        const backButton = document.createElement('button');
        backButton.textContent = 'Atrás';
        backButton.classList.add('mb-1', 'btn', 'btn-info');
        backButton.onclick = mostrarMenuPrincipal;

        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alimentacionContainer.innerHTML = this.responseText;
                alimentacionContainer.appendChild(backButton);
                alimentacionContainer.style.display = 'block';
            }
        };
        xhttp.open("GET", "obtener_alimentos.php", true); // Cambia el nombre del archivo según tu estructura
        xhttp.send();

    }
    //
    function mostrarMenuPrincipal() {
        document.getElementById('rutinas-container').style.display = 'none';
        document.getElementById('ejercicios-container').style.display = 'none';
        document.getElementById('chat-box').style.display = 'block';
    }

    function enviarPregunta(pregunta, respuesta) {
        const chatBox = document.getElementById('chat-box');
        mostrarMensaje(chatBox, 'Usuario: ' + pregunta, 'user-message');

        setTimeout(function() {
            mostrarMensaje(chatBox, 'Chatbot: ' + respuesta, 'chatbot-message');
        }, 200);
    }

    function mostrarMensaje(chatBox, mensaje, clase) {
        const mensajeElement = document.createElement('div');
        const iconoElement = document.createElement('i');
        mensajeElement.textContent = mensaje;
        mensajeElement.classList.add('chat-message', clase);
        iconoElement.classList.add('bx', clase === 'user-message' ? 'bx-user' : 'bx-chat');
        mensajeElement.prepend(iconoElement);
        chatBox.appendChild(mensajeElement);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    const botonChatbot = document.getElementById('boton-chatbot');
const chatbotWindow = document.getElementById('widget');

botonChatbot.addEventListener('click', () => {
    // Eliminar la clase de animación de salida si está presente
    chatbotWindow.classList.remove('animate-fade-out');

    // Hacer visible el chatbot antes de mostrarlo nuevamente
    chatbotWindow.style.display = 'block';
    botonChatbot.style.display = 'none';

    // Opcional: Si quieres agregar una animación de entrada suave al abrir el chatbot, puedes agregar una clase y utilizar setTimeout para retrasar la aplicación de la clase
    setTimeout(() => {
        chatbotWindow.classList.add('animate-fade-in');
    }, 100); // Ajusta este valor según sea necesario
});

    const chatbotCloseButton = document.getElementById('chatbot-close-button');

chatbotCloseButton.addEventListener('click', () => {
    // Agregar la clase de animación de salida
    chatbotWindow.classList.add('animate-fade-out');

    // Esperar a que se complete la animación y luego ocultar el chatbot
    setTimeout(() => {
        chatbotWindow.style.display = 'none';
        botonChatbot.style.display = 'block';
    }, 100); // Ajusta este valor para que coincida con la duración de la animación en milisegundos
});

    </script>



    <div class="py-4"></div> <!-- Espacio vertical -->
    <div class="card routine-card mb-5">
        <div class="card-body" style='width: 110%'>

            <div  id="container-rutina" class="tab-content container-others container"
                style="padding: 20px; display: flex; flex-wrap: wrap; justify-content: center;">

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="width:30%; margin-right: 20px;">
                    <!-- Formulario -->
                    <div class="card"
                        style="border: 1px solid black; width: 100%; padding: 0px; margin-bottom: 20px; margin-right: 0px;  position: relative;">
                        <!-- Tarjeta del formulario -->
                        <div
                            style="position: absolute; top: 10px; left: 5%; display: flex; align-items: center; color: white">
                            <!-- Selector de dificultad -->
                            <div class="mr-2"></div>
                            <select class="form-select form-select-bg-dark" aria-label="Default select example"
                                name="selecciondificultad" style="border-radius: 5px;" required>
                                <!-- Menú desplegable -->
                                <option disabled selected>Nivel de Dificultad</option> <!-- Opción por defecto -->
                                <option value="">Sin dificultad</option> <!-- Opciones de dificultad -->
                                <option value="1">Facil</option>
                                <option value="2">Intermedio</option>
                                <option value="3">Avanzado</option>
                            </select>
                        </div>
                        <div
                            style="position: absolute; top: 70px; left: 38%; display: flex; align-items: center; color: white;font-size: 90px">
                            <!-- Ícono de agregar -->
                            <i class='bx bxs-plus-circle bx-flashing-hover'></i> <!-- Ícono de más -->
                        </div>
                        <div class="card-img-top" style="background-image: linear-gradient(to bottom right,  #4a6eb0, #9cd2d3); height: 200px;border-top-right-radius: 8px;
    border-top-left-radius: 8px;">
                        </div> <!-- Imagen de fondo -->
                        <div class="card-body" style="padding:35px">
                            <!-- Cuerpo de la tarjeta del formulario -->
                            <div class="input-group mb-3">
                                <!-- Grupo de entrada para el nombre de la rutina -->
                                <span class="input-group-text" id="basic-addon1">Nombre</span>
                                <!-- Etiqueta del nombre -->
                                <input type="text" class="form-control" name="namerutina"
                                    value="<?php if (isset($_POST['namerutina'])) echo $_POST['namerutina']; ?>"
                                     required> <!-- Entrada para el nombre de la rutina -->
                            </div>
                            <div class="input-group mb-3">
                                <!-- Grupo de entrada para la descripción de la rutina -->
                                <span class="input-group-text">Descripcion</span> <!-- Etiqueta de la descripción -->
                                <textarea class="form-control" name="descripcion" 
                                    required><?php if (isset($_POST['descripcion'])) echo $_POST['descripcion']; ?></textarea>
                                <!-- Área de texto para la descripción -->
                            </div>
                            <input class="btn btn-secondary" type="submit" value="Crear" name="crearrutina">
                            <!-- Botón para crear la rutina -->
                        </div>
                    </div>
                </form>
                <!-- Rutinas existentes -->
                <?php
                    imprimirRutina($con, $id);  // Función para imprimir las rutinas existentes
                ?>
            </div>




        <div class="saas" id="calendar">
            <div class="card-body tab-content" id="container-calendario" style="display:none; ">
                <br>
                <form method="post" id="calendarioForm" style="width: 90%;">
                    <div class="container ">
                        <table class="table table-light  table-hover" style=" border-radius: 10px">
                            <thead>
                                <tr>
                                    <?php
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
                                                        echo '<a href="delete_calendar_routine.php?id_personal=' . $id . '&idRutina=' . $idRutinaDia . '&dia=' . $dia . '" style="text-decoration: none; color: black; font-size: 20px"><i class="bx bx-x"></i></a>';
                                                        echo '<p class="ml-3">' . $nombreRutinaDia . '</p>';
                                                    } else {
                                                        echo '<a href="delete_calendar_routine.php?id_personal=' . $id . '&idRutina=' . $idRutinaDia . '&dia=' . $dia . '" style="text-decoration: none; color: black; font-size: 20px"><i class="bx bx-x"></i></a>';
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
                                    ?>
                            </thead>
                        </table>
                        <div class="buttons-container mt-4">
    <button type="submit" class="btn btn-primary " name="guardarcalendario">Guardar Calendario</button>
    <a href="pdf.php?id=<?php echo $id; ?>" target="_blank" class="btn btn-success ml-4">Descargar Calendario</a>
</div>
                    </div>

            </form>
            </div>
        </div>

        <div class="container tab-content" id="container-tienda" style="display:none; flex-direction: column; transform: translateX(-5vh); margin-bottom: 80px  ">
            <div class="row" style="">
                <div class="col-md-6">
                    <input type="text" id="buscador" class="form-control mb-3" placeholder="Buscar...">
                </div>
                <div class="ml-5 mb-5 justify-content-center align-items-center d-flex">
                    <div class="col-md-8 ">
                        <h5 class="mt-2">Filtrar por precio</h5>
                    </div>
                    <div class="col-md-6">
                        <input type="range" id="rangoPrecio" min="0" max="100" step="5" value="0" class="form-range">
                        <div class="d-flex justify-content-between mt-2">
                            <div id="rangoPrecioValor"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div id="mensajeNoProductos" class="alert alert-warning" style="display: none;">
                        No hay productos disponibles en este momento.
                    </div>
                    <div id="resultadosProductos" class="carousel slide">
                        <div class="carousel-inner" id="listaProductos">

                        </div>
                        <button class="carousel-control-prev position-absolute top-50 translate-middle-y"
                            style="left: -30px; width: 50px; height: 50px; border-radius: 50%; transform: translateX(-6vh); margin-top: 17vh;background: #24baae; color: white; border: none;"
                            type="button" data-bs-target="#resultadosProductos" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next position-absolute top-50 translate-middle-y"
                            style="right: -30px; width: 50px; height: 50px; border-radius: 50%;  transform: translateX(6vh); margin-top: 17vh; background: #111; color: white; border: none;"
                            type="button" data-bs-target="#resultadosProductos" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="producto" id="producto">

        </div>


    <div id="info" class="tab-content" style="display:none; ">
        <?php
            imprimir($id, $con);

        ?>
    </div>


<div class="card-body" style="border-radius: 10px; padding: 20px;">
    <hr style="border-top: 1px solid #dee2e6;width: 60%"> <!-- Línea horizontal -->
    <p style="color: #6c757d;">Para cualquier consulta o pregunta, por favor contáctanos utilizando la siguiente
        información:</p> <!-- Párrafo de información de contacto -->
    <ul style="list-style-type: none; padding-left: 0;">
        <!-- Lista de información de contacto -->
        <li style="margin-bottom: 10px;"><strong style="color: #343a40;">Teléfono:</strong> <span
                style="color: #6c757d;">+123456789</span></li> <!-- Elemento de lista: Teléfono -->
        <li style="margin-bottom: 10px;"><strong style="color: #343a40;">Correo electrónico:</strong> <span
                style="color: #6c757d;">info@gym.com</span></li> <!-- Elemento de lista: Correo electrónico -->
        <li style="margin-bottom: 10px;"><strong style="color: #343a40;">Dirección:</strong> <span
                style="color: #6c757d;">Av. Principal #123, Ciudad, País</span></li>
        <!-- Elemento de lista: Dirección -->
    </ul>

</div>
                                </div>   
<script>
  

    //--------------------------------------------------------------------------------------------------
    function setActiveLink(clickedLink, active = true) {
    var navLinks = document.querySelectorAll(".nav-link");
    navLinks.forEach(function(link) {
        link.classList.remove("active");
    });

    if (active) {
        clickedLink.classList.add("active");
    }
}
window.addEventListener('load', function() {
        var rutinaLink = document.querySelector('.a-rutina');
        setActiveLink(rutinaLink);
    });

    //--------------------------------------------------------------------------------------------------
     function setActiveButton(clickedLink) {
        var Buttons = document.querySelectorAll(".tab");
        Buttons.forEach(function(btn) {
            btn.classList.remove("color");
        });

        clickedLink.classList.add("color");
    }
    //--------------------------------------------------------------------------------------------------
    var rangoPrecio = document.getElementById("rangoPrecio");
    var rangoPrecioValor = document.getElementById("rangoPrecioValor");

    rangoPrecio.addEventListener("input", function() {
        rangoPrecioValor.textContent = "$" + this.value;
    });

    // Datos de ejemplo de productos (puedes obtener estos datos de la base de datos)
    var productos = [{
            nombre: "camiseta",
            imagen: "../images/camiseta.jpg",
            precio: 20.0,
        },
        {
            nombre: "licras",
            imagen: "../images/licras.jpg",
            precio: 30.0,
        },
        {
            nombre: "sudaderas",
            imagen: "../images/sudadera.jpg",
            precio: 25.0,
        },
        {
            nombre: "suplementos",
            imagen: "../images/suplementos.jpg",
            precio: 20.0,
        },
        {
            nombre: "mancuernas",
            imagen: "../images/mancuernas.jpg",
            precio: 30.0,
        },
        {
            nombre: "tennis",
            imagen: "../images/zapatos.jpg",
            precio: 25.0,
        },
    ];

    // Función para mostrar los productos
    function mostrarProductos(productosAMostrar) {
        var listaProductos = document.getElementById("listaProductos");
        var carrusel = document.getElementById("resultadosProductos");
        var mensaje = document.getElementById("mensajeNoProductos");

        // Si no hay productos para mostrar, mostrar un mensaje y ocultar el carrusel
        if (productosAMostrar.length === 0) {
            mensaje.style.display = "block";
            carrusel.style.display = "none";
            return; // Salir de la función
        } else {
            mensaje.style.display = "none";
            carrusel.style.display = "block";
        }

        listaProductos.innerHTML = "";

        for (var i = 0; i < productosAMostrar.length; i += 3) {
            var divCarouselItem = document.createElement("div");
            divCarouselItem.classList.add("carousel-item");
            if (i === 0) {
                divCarouselItem.classList.add("active");
            }

            var divRow = document.createElement("div");
            divRow.classList.add("row");

            for (var j = i; j < i + 3 && j < productosAMostrar.length; j++) {
                var producto = productosAMostrar[j];
                var divProducto = document.createElement("div");
                divProducto.classList.add("col-md-4");

                var divCardBody = document.createElement("div");
                divCardBody.classList.add("carte", "mb-4", "text-center", "h-100");

                var imgProducto = document.createElement("img");
                imgProducto.classList.add("card-img-top");
                imgProducto.style.borderRadius = "20px";
                imgProducto.src = producto.imagen;
                imgProducto.alt = producto.nombre;

                var divCardBodyInner = document.createElement("div");
                divCardBodyInner.classList.add(
                    "card-body",
                    "d-flex",
                    "flex-column",
                    "justify-content-between"
                );

                var h5Producto = document.createElement("h5");
                h5Producto.classList.add("card-title");
                h5Producto.textContent = producto.nombre;

                var pPrecio = document.createElement("p");
                pPrecio.classList.add("card-text");
                pPrecio.textContent = "Precio: $" + producto.precio.toFixed(2);

                var btnComprar = document.createElement("button");
                btnComprar.classList.add("btn", "btn-primary", "mt-4"); // Agregar mt-auto para alinear el botón inferiormente
                btnComprar.textContent = "Buy";
                btnComprar.addEventListener(
                    "click",
                    (function(producto) {
                        return function() {
                            var telefono = "3155748135"; // Coloca aquí tu número de teléfono de WhatsApp
                            var mensaje =
                                "¡Hola! Estoy interesado en comprar el producto " +
                                producto.nombre +
                                ". ¿Está disponible?";
                            var url =
                                "https://api.whatsapp.com/send?phone=" +
                                telefono +
                                "&text=" +
                                encodeURIComponent(mensaje);
                            window.open(url, "_blank");
                        };
                    })(producto)
                );

                divCardBodyInner.appendChild(h5Producto);
                divCardBodyInner.appendChild(pPrecio);
                divCardBodyInner.appendChild(btnComprar);
                divCardBody.appendChild(imgProducto);
                divCardBody.appendChild(divCardBodyInner);
                divProducto.appendChild(divCardBody);
                divRow.appendChild(divProducto);
            }

            divCarouselItem.appendChild(divRow);
            listaProductos.appendChild(divCarouselItem);
        }
    }

    mostrarProductos(productos);

    // Filtro por nombre
    document.getElementById("buscador").addEventListener("input", function() {
        var filtro = this.value.toLowerCase();
        var productosFiltrados = productos.filter(function(producto) {
            return producto.nombre.toLowerCase().includes(filtro);
        });
        mostrarProductos(productosFiltrados);
    });
    //--------------------------------------------------------------------------------------------------
    // Filtro por precio
    document.getElementById("rangoPrecio").addEventListener("input", function() {
        var precioMaximo = parseFloat(this.value);
        var productosFiltrados = productos.filter(function(producto) {
            return producto.precio <= precioMaximo;
        });
        mostrarProductos(productosFiltrados);
    });
    //--------------------------------------------------------------------------------------------------
    const toggleButtons = document.querySelectorAll('.toggle-details');

    toggleButtons.forEach(button => {
        button.addEventListener('click', () => {
            const details = button.nextElementSibling;

            if (details.style.display === 'none' || details.style.display === '') {
                details.style.display = 'block';
                button.textContent = 'Cancelar';
            } else {
                details.style.display = 'none';
                button.textContent = 'Agregar nuevo material';
            }
        });
    });
    //--------------------------------------------------------------------------------------------------
    function enableInput(input) {
        input.removeAttribute('readonly');
    }

    var inputs = document.querySelectorAll('input[type="number"]');

    inputs.forEach(function(input) {
        input.addEventListener('input', function() {
            var valor = this.value.trim();
            var soloNumeros = valor.replace(/[^0-9]/g, '');
            this.value = soloNumeros;
        });
    });
    //--------------------------------------------------------------------------------------------------

    function openTab(tabName) {
      var i, tabContent;
      tabContent = document.getElementsByClassName("tab-content");
      for (i = 0; i < tabContent.length; i++) {
        tabContent[i].style.display = "none";
      }
      document.getElementById(tabName).style.display = "flex";
    }


    window.addEventListener('load', function() {
    if (window.location.href.indexOf('#calendar') !== -1) {
        var calendarLink = document.querySelector('.a-calendar');
        setActiveLink(calendarLink);
        openTab('container-calendario');
    }
});

window.addEventListener('load', function() {
    if (window.location.href.indexOf('#info') !== -1) {
        var calendarLink = document.querySelector('.buton-info');
        setActiveLink(calendarLink);
        openTab('info');
    }
});
 inputs = document.querySelectorAll('input[type="number"]');

    inputs.forEach(function(input) {
        input.addEventListener('input', function() {
            var valor = this.value.trim();
            var soloNumeros = valor.replace(/[^0-9]/g, '');
            this.value = soloNumeros;
        });
    });
    //--------------------------------------------------------------------------------------------------

    function openTab(tabName) {
      var i, tabContent;
      tabContent = document.getElementsByClassName("tab-content");
      for (i = 0; i < tabContent.length; i++) {
        tabContent[i].style.display = "none";
      }
      document.getElementById(tabName).style.display = "flex";
    }


    window.addEventListener('load', function() {
    if (window.location.href.indexOf('#calendar') !== -1) {
        var calendarLink = document.querySelector('.a-calendar');
        setActiveLink(calendarLink);
        openTab('container-calendario');
    }
});

window.addEventListener('load', function() {
    if (window.location.href.indexOf('#info') !== -1) {
        var calendarLink = document.querySelector('.buton-info');
        setActiveLink(calendarLink);
        openTab('info');
    }
});
</script>

    <script type="text/javascript" src="jspdf.min.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>