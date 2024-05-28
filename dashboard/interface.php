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
    <link rel="stylesheet" href="http://localhost/pf/assets/dashboard/style.css">
    <title>GYM</title>
</head>
<style>
.chat-container {
        background: #ffffff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width:500px;
        height: 620px;
        max-width: 100%;
        padding: 10px;
        box-sizing: border-box;
    }

    .chat-box {
        padding: 10px;
        height: 400px;
        overflow-y: scroll;
        margin-bottom: 0px;
        border-radius:5px;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.3);
    }

    .user-input {
        width: 300px;
        padding: 10px;
        margin-right: 1px;
        border-radius:5px;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.3);
        border:none;
    }

    button {
        padding: 10px 20px;
        cursor: pointer;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
    }

    .user-message {
        text-align: right;
        margin: 10px 0;
    }

    .bot-message {
        text-align: left;
        margin: 0px;
        color: blue;
    }
    
</style>
<body>
    <div class="box-menu" id="box-menu">
    <i class='bx bx-menu' style="font-size: 35px"></i>
    </div>
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

    <div class="overlay" id="overlay"></div>
    <!-- Widget del chatbot -->
    
    <div onclick="openChatWidget()" id="boton-chatbot">
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
            
        <div class="chat-container">
                <div id="chat-box" class="chat-box"></div>
                <br>
                <div class="user-input-container">
                    <input type="text" id="user-input" class="user-input" placeholder="Escribe tu pregunta..." onkeypress="handleKeyPress(event)">
                    <button onclick="sendMessage()">Enviar</button>
                </div>
                <br>
                <div class="suggested-options-1" style="display: none;">
                    <p>Opciones sugeridas:</p>
                    <button onclick="sendMessage('servicios')">¿Qué servicios ofrecen?</button>
                    <button onclick="sendMessage('ofertas')">¿Qué ofertas tienen?</button>
                </div>

                <div class="suggested-options-2" style="display: none;">
                    <p>Opciones sugeridas:</p>
                    <button onclick="sendMessage('Cuando estan abiertos')">¿Cuándo están abiertos?</button>
                    <button onclick="sendMessage('Que horarios tienen')">¿Qué horarios tienen?</button>
                </div>

                <div class="suggested-options-3" style="display: none;">
                    <p>Opciones sugeridas:</p>
                    <button onclick="sendMessage(' Cuanto cuesta')">¿Cuánto cuesta?</button>
                    <button onclick="sendMessage('Que precios tienen')">¿Qué precios tienen?</button>
                </div>

                <div class="suggested-options-4" style="display: none;">
                    <p>Opciones sugeridas:</p>
                    <button onclick="sendMessage('plan de entrenamiento')">Plan de entrenamiento</button>
                    <button onclick="sendMessage('ejercicios')">Rutina de ejercicios</button>
                </div>

                <div class="suggested-routines" style="display: none;">
                <p>Rutinas y Alimmentacion:</p>
                    <button onclick="mostrarRutinas()" class="mb-1 btn btn-primary">Rutina</button>
                    <button onclick="mostrarAlimentacion()" class="mb-1 btn btn-primary">Alimentación</button>
                </div>
                <div id="rutinas-container" class="mt-3" style="display: none;">
                    <hr>
                </div>
                
            </div>
        </div>
    
    </div>
    <!-- -->
    <script>

    function openChatWidget() {
        // Crear el contenedor del widget de chat
        var chatWidgetContainer = document.createElement('div');
        chatWidgetContainer.classList.add('chat-widget-container');
        // Agregar el widget de chat al cuerpo del documento
        document.body.appendChild(chatWidgetContainer);

        // Enviar un saludo automáticamente al abrir el widget de chat
        sendMessageToBot("Hola");
    }

    function sendMessage(message) {
        if (!message) {
            var userInput = document.getElementById("user-input").value;
            if (userInput.trim() === "") return;
            message = userInput;
        }
        sendMessageToBot(message);
    }

    function handleKeyPress(event) {
        if (event.keyCode === 13) { // 13 is the key code for "Enter" key
            sendMessage();
        }
    }

    function sendMessageToBot(message) {
    var chatBox = document.getElementById("chat-box");
    var isScrolledToBottom = chatBox.scrollHeight - chatBox.clientHeight <= chatBox.scrollTop + 1;

    chatBox.innerHTML += "<div class='user-message'>" + message + "</div>";
    document.getElementById("user-input").value = "";

    // Ocultar los botones de sugerencias al enviar un mensaje
    document.querySelector(".suggested-routines").style.display = "none";

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "chatbot/chat.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        if (this.status === 200) {
            var botResponse = this.responseText;
            chatBox.innerHTML += "<div class='bot-message'>" + botResponse + "</div>";

            // Mostrar los botones de sugerencias si la respuesta contiene la solicitud de rutina
            if (botResponse.includes("Aquí tienes algunas rutinas populares para empezar.")) {
                document.querySelector(".suggested-routines").style.display = "block";
            }

            // Mostrar los botones de sugerencias si la respuesta contiene las palabras clave para sugerencias
            if (botResponse.includes("¡Hola! Bienvenido al gimnasio. Soy el asistente virtual del gimnasio. ¿En qué puedo ayudarte?")) {
                document.querySelector(".suggested-options-1").style.display = "block";
                document.querySelector(".suggested-options-2").style.display = "none";
            }

            if (botResponse.includes("Gym JS ofrece una plataforma integral que fusiona tecnología y conocimiento en fitness para mejorar la experiencia de entrenamiento. Nuestra misión es transformar la forma en que las personas abordan su bienestar físico.")) {
                document.querySelector(".suggested-options-2").style.display = "block";
                document.querySelector(".suggested-options-1").style.display = "none";
            }

            if (botResponse.includes("Nuestro aplicativo web, Gym JS, está disponible las 24 horas del día, los 7 días de la semana. Esto te ofrece acceso continuo a nuestra plataforma de entrenamiento y bienestar, permitiéndote disfrutar de nuestros servicios y recursos en cualquier momento que se ajuste a tu horario.")) {
                document.querySelector(".suggested-options-3").style.display = "block";
                document.querySelector(".suggested-options-2").style.display = "none";
                document.querySelector(".suggested-options-1").style.display = "none";
            }

            if (botResponse.includes("¡En Gym JS, todo es gratis! Accede a entrenamiento personalizado, seguimiento de progreso, asesoramiento y comunidad en línea sin costo alguno. Únete ahora para una vida más activa sin preocupaciones por cargos adicionales.")) {
                document.querySelector(".suggested-options-4").style.display = "block";
                document.querySelector(".suggested-options-3").style.display = "none";
                document.querySelector(".suggested-options-2").style.display = "none";
                document.querySelector(".suggested-options-1").style.display = "none";
            }

            if (botResponse.includes("Ofrecemos rutinas específicas para entrenar en casa, que incluyen ejercicios de peso corporal y el uso de equipamiento básico. Aquí tienes algunas rutinas populares para empezar. Selecciona una para más detalles:")) {
                document.querySelector(".suggested-options-4").style.display = "none";
                document.querySelector(".suggested-options-3").style.display = "none";
                document.querySelector(".suggested-options-2").style.display = "none";
                document.querySelector(".suggested-options-1").style.display = "none";
            }

            // Desplazar automáticamente el scroll hacia abajo si estaba en el fondo antes de agregar el nuevo mensaje
            if (isScrolledToBottom) {
                chatBox.scrollTop = chatBox.scrollHeight;
            }

            // Guardar el historial de chat en el almacenamiento local
            localStorage.setItem('chatHistory', chatBox.innerHTML);
        }
    };
    xhr.send("message=" + encodeURIComponent(message));
}


    function selectRoutine(routine) {
        // Mostrar qué rutina se seleccionó
        var chatBox = document.getElementById("chat-box");
        chatBox.innerHTML += "<div class='user-message'>Seleccionaste la rutina: " + routine + "</div>";

        // Enviar la selección de la rutina al servidor
        sendMessageToBot("Quiero más detalles sobre la rutina: " + routine);

        // Desplazar automáticamente el scroll hacia abajo después de seleccionar una rutina
        setTimeout(function() {
            chatBox.scrollTop = chatBox.scrollHeight;
        }, 100);
    }


        // --------------------------------
        function mostrarRutinas() {
            const rutinasContainer = document.getElementById('chat-box');
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
            const ejerciciosContainer = document.getElementById('chat-box');
            ejerciciosContainer.innerHTML = '';

            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    ejerciciosContainer.innerHTML = this.responseText;
                    ejerciciosContainer.style.display = 'block';
                }
            };
            xhttp.open("GET", "chatbot/obtener_ejercicios.php?id=" + rutinaID + "&idpersonal=" + <?php echo $id; ?>, true);
            xhttp.send();
        }

        function mostrarAlimentacion(alimentacion) {
            const alimentacionContainer = document.getElementById('chat-box');
            alimentacionContainer.innerHTML = '';

            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alimentacionContainer.innerHTML = this.responseText;
                    alimentacionContainer.style.display = 'block';
                }
            };
            xhttp.open("GET", "chatbot/obtener_alimentos.php", true); // Cambia el nombre del archivo según tu estructura
            xhttp.send();
        }


        function mostrarMenuPrincipal() {
            document.getElementById('suggested-routines').style.display = 'none';
            document.getElementById('suggested-routines').style.display = 'none';
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
        chatbotWindow.classList.remove('animate-fade-out');
        chatbotWindow.style.display = 'block';
        chatbotWindow.classList.add('animate-fade-in');
        botonChatbot.style.display = 'none';
    });

    const chatbotCloseButton = document.getElementById('chatbot-close-button');

    chatbotCloseButton.addEventListener('click', () => {
        chatbotWindow.classList.remove('animate-fade-in');
        chatbotWindow.classList.add('animate-fade-out');

        setTimeout(() => {
            chatbotWindow.style.display = 'none';
            botonChatbot.style.display = 'block';
        }, 500); // Duración de la animación de salida
    });

    </script>

    <div class="py-4"></div> <!-- Espacio vertical -->
    <div class="card routine-card mb-5">
    <div class="card-body routine-body">
        <div id="container-rutina" class="tab-content container2">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="col-12 col-md-6 col-lg-4 mb-5">
                <div class="card2">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <select class="form-select" name="selecciondificultad" required>
                            <option disabled selected>Nivel de Dificultad</option>
                            <option value="">Sin dificultad</option>
                            <option value="1">Facil</option>
                            <option value="2">Intermedio</option>
                            <option value="3">Avanzado</option>
                        </select>
                    </div>
                    <div class="card-img-top bg-gradient-primary-to-secondary d-flex justify-content-center align-items-center" style="height: 200px;">
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
                            <input type="range" id="rangoPrecio" min="0" max="100000" step="10000" value="0" class="form-range">
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

</body>
</html>