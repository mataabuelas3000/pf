<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot Widget con Base de Datos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div id="boton-chatbot">
        <i class='bx bx-message-dots btn'></i>
    </div>
    <!-- Widget del chatbot -->
    <div class="widget" id="widget" style="display: none;">
        <div id="window">
            <button id="chatbot-close-button">✕</button>
            <h1>Chatbot</h1>
        </div>
        <div class="chatbot-widget" id="chatbot-widget">
            <div class="chat-container" id="chat-box">
                <div class="container-buttons">
                    <button onclick="mostrarRutinas()" class="mb-1 btn btn-primary">Rutina</button>
                    <button onclick="mostrarAlimentacion()" class="mb-1 btn btn-primary">Alimentación</button>
                </div>
                <div id="rutinas-container" style="display: none;">
                    <!-- PHP para obtener las rutinas -->
                    <?php
                    $conn = new mysqli("localhost", "root", "", "pf", "3306");
                    if ($conn->connect_error) {
                        die("Conexión fallida: " . $conn->connect_error);
                    }

                    $sql = "SELECT Nombre_Rutina as nombre, Descripcion as Descripcion, ID_Rutina FROM rutinas_ejercicio"; // Cambia el nombre de la tabla y el campo según tu base de datos
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<button onclick="mostrarEjercicios(' . $row['ID_Rutina'] . ')" class="mb-1 btn btn-secondary">' . $row['nombre'] . '</button>';
                        }
                    } else {
                        echo "No se encontraron rutinas.";
                    }

                    $conn->close();
                    
                    ?>
                    <!-- Fin del PHP -->
                </div>
                <div id="ejercicios-container" style="display: none;">
                </div>
                <div class="mb-3"></div>
            </div>
            
            <div id="chatbot-input">
                <!-- 
                <input class="mensaje" type="text" placeholder="Escribe tu mensaje aquí..." />
                <br><br>
                <button id="chatbot-send-button">Enviar</button>
                -->
            </div>
        </div>
    </div>

    <script>
        function mostrarRutinas() {
            const rutinasContainer = document.getElementById('rutinas-container');
            rutinasContainer.style.display = 'block';
        }

        function mostrarEjercicios(rutinaID) {
            const ejerciciosContainer = document.getElementById('ejercicios-container');
            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    ejerciciosContainer.innerHTML = this.responseText;
                    ejerciciosContainer.style.display = 'block';
                }
            };
            xhttp.open("GET", "obtener_ejercicios.php?id=" + rutinaID, true);
            xhttp.send();
        }

        function mostrarAlimentacion() {
            // Aquí puedes agregar la lógica para mostrar opciones de alimentación
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
            chatbotWindow.style.display = 'block';
        });

        const chatbotCloseButton = document.getElementById('chatbot-close-button');

        chatbotCloseButton.addEventListener('click', () => {
            chatbotWindow.style.display = 'none';
        });
    </script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</body>
</html>
