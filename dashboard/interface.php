<?php
include('files/index.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <title>GYM</title>
</head>

<body>
    <nav class="sidebar" id="sidebar">
        <!-- Logo de usuario -->
        <a href="#info" class="nav-link buton-info " onclick="setActiveLink(this); openTab('info');">
            <span class="icon d-flex align-items-center justify-content-center" title="Info">
                <i class='bx bxs-user-circle' style="font-size: 35px"></i>
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
            <a class="nav-link text-light " href="../auth/logout.php" style="text-decoration:none; transform: translateY(33vh)" title="Cerrar sesion">
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
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#fff" fill-opacity="1" d="M0,160L60,160C120,160,240,160,360,176C480,192,600,224,720,213.3C840,203,960,149,1080,117.3C1200,85,1320,75,1380,69.3L1440,64L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
            </svg>
        </div>
        <div class="chatbot-widget" id="chatbot-widget">
            <div class="chat-container" id="chat-box">
                <div class="message-chat">¡Hola! Soy Jhon tu entrenador personal y estoy para ayudarte a crear tus rutinas.</div>
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
            xhttp.open("GET", "chatbot/obtener_rutinas.php", true); // Ruta al archivo PHP que obtiene las rutinas
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
            xhttp.open("GET", "chatbot/obtener_ejercicios.php?id=" + rutinaID + "&idpersonal=" + <?php echo $id; ?>, true);
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
            xhttp.open("GET", "chatbot/obtener_alimentos.php", true); // Cambia el nombre del archivo según tu estructura
            xhttp.send();
        }

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
            <div id="container-rutina" class="tab-content container-others container" style="padding: 20px; display: flex; flex-wrap: wrap; justify-content: center;">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="width:30%; margin-right: 20px;">
                    <!-- Formulario -->
                    <div class="card" style="border: 1px solid black; width: 100%; padding: 0px; margin-bottom: 20px; margin-right: 0px;  position: relative;">
                        <!-- Tarjeta del formulario -->
                        <div style="position: absolute; top: 10px; left: 5%; display: flex; align-items: center; color: white">
                            <!-- Selector de dificultad -->
                            <div class="mr-2"></div>
                            <select class="form-select form-select-bg-dark" aria-label="Default select example" name="selecciondificultad" style="border-radius: 5px;" required>
                                <!-- Menú desplegable -->
                                <option disabled selected>Nivel de Dificultad</option> <!-- Opción por defecto -->
                                <option value="">Sin dificultad</option> <!-- Opciones de dificultad -->
                                <option value="1">Facil</option>
                                <option value="2">Intermedio</option>
                                <option value="3">Avanzado</option>
                            </select>
                        </div>
                        <div style="position: absolute; top: 70px; left: 38%; display: flex; align-items: center; color: white;font-size: 90px">
                            <!-- Ícono de agregar -->
                            <i class='bx bxs-plus-circle bx-flashing-hover'></i> <!-- Ícono de más -->
                        </div>
                        <div class="card-img-top" style="background-image: linear-gradient(to bottom right,  #4a6eb0, #9cd2d3); height: 200px;border-top-right-radius: 8px; border-top-left-radius: 8px;"></div> <!-- Imagen de fondo -->
                        <div class="card-body" style="padding:35px">
                            <!-- Cuerpo de la tarjeta del formulario -->
                            <div class="input-group mb-3">
                                <!-- Grupo de entrada para el nombre de la rutina -->
                                <span class="input-group-text" id="basic-addon1">Nombre</span> <!-- Etiqueta del nombre -->
                                <input type="text" class="form-control" name="namerutina" value="<?php if (isset($_POST['namerutina'])) echo $_POST['namerutina']; ?>" required> <!-- Entrada para el nombre de la rutina -->
                            </div>
                            <div class="input-group mb-3">
                                <!-- Grupo de entrada para la descripción de la rutina -->
                                <span class="input-group-text">Descripcion</span> <!-- Etiqueta de la descripción -->
                                <textarea class="form-control" name="descripcion" required><?php if (isset($_POST['descripcion'])) echo $_POST['descripcion']; ?></textarea> <!-- Área de texto para la descripción -->
                            </div>
                            <input class="btn btn-secondary" type="submit" value="Crear" name="crearrutina"> <!-- Botón para crear la rutina -->
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
                                        imprimirCalendario($con, $id);
                                        ?>
                                    </tr>
                                </thead>
                            </table>
                            <div class="buttons-container mt-4">
                                <button type="submit" class="btn btn-primary " name="guardarcalendario">Guardar Calendario</button>
                                <a href="files/pdf.php?id=<?php echo $id; ?>" target="_blank" class="btn btn-success ml-4">Descargar Calendario</a>
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
                            <button class="carousel-control-prev position-absolute top-50 translate-middle-y" style="left: -30px; width: 50px; height: 50px; border-radius: 50%; transform: translateX(-6vh); margin-top: 17vh;background: #24baae; color: white; border: none;" type="button" data-bs-target="#resultadosProductos" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </button>
                            <button class="carousel-control-next position-absolute top-50 translate-middle-y" style="right: -30px; width: 50px; height: 50px; border-radius: 50%;  transform: translateX(6vh); margin-top: 17vh; background: #111; color: white; border: none;" type="button" data-bs-target="#resultadosProductos" data-bs-slide="next">
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
                <p style="color: #6c757d;">Para cualquier consulta o pregunta, por favor contáctanos utilizando la siguiente información:</p> <!-- Párrafo de información de contacto -->
                <ul style="list-style-type: none; padding-left: 0;">
                    <!-- Lista de información de contacto -->
                    <li style="margin-bottom: 10px;"><strong style="color: #343a40;">Teléfono:</strong> <span style="color: #6c757d;">3162352634 - 3155748135</span></li> <!-- Elemento de lista: Teléfono -->
                    <li style="margin-bottom: 10px;"><strong style="color: #343a40;">Correo electrónico:</strong> <span style="color: #6c757d;">Santiago_gonzalezbe@fet.edu.co</span></li> <!-- Elemento de lista: Correo electrónico -->
                    <li style="margin-bottom: 10px;"><strong style="color: #343a40;">Dirección:</strong> <span style="color: #6c757d;">Calle 18H sur #32-88</span></li> <!-- Elemento de lista: Dirección -->
                </ul>
            </div>
        </div>
    </div>
</div>   
<script src="script.js">
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