<?php
session_start();

// Verificar si se ha iniciado sesión
if (empty($_SESSION['id'])) {
    // Redirigir a la página de inicio de sesión
    header('Location: ../../index.php');
    exit;
} else {
    $id = $_SESSION['id'];
}
// Procesar formulario si se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['card'])) {
        // Obtener el valor del texto de la carta seleccionada
        $selected_card_text = "";
        switch ($_POST['card']) {
            case '1':
                $selected_card_text = "Ectomorfo";
                break;
            case '2':
                $selected_card_text = "Mesomorfo";
                break;
            case '3':
                $selected_card_text = "Endomorfo";
                break;
            default:
                $selected_card_text = "Texto por defecto";
                break;
        }

        // Guardar el texto seleccionado en la variable de sesión
        $_SESSION['selected_card_text'] = $selected_card_text;

        // Redireccionar a continue2.php después de guardar la selección
        header('Location: continue2.php');
        exit; // Salir del script después de la redirección
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Continue</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@800&display=swap");

        * {
        font-family: "Nunito", sans-serif;
        box-sizing: border-box;
        }
        body{
            background-color: #D7FBE8;
        }
        h1{
            color: #1fa398;
            font-size: 3.5rem;
            text-transform: uppercase;
        }
        .card-img-top{
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }
        .card {
            transition: transform 0.3s;
            background-color: #fff;
            border-radius: 20px;
            height: 55vh;
            width: 26vh;
            color: #1fa398;
            text-align: center;
            align-items: center;
            font-size: 1.5rem;
        }
        .card:hover {
            transform: translateY(-10px);
        
        }
        .centered-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container centered-content">
    <h1 class="mb-4">Selecciona tu tipo de cuerpo</h1>
    <div class="row justify-content-center">
        <div class="col-md-4 mb-4">
            <form method="post">
                <input type="hidden" name="card" value="1">
                <div class="card" style="cursor: pointer;" onclick="this.parentElement.submit();">
                    <img src="https://actimax.com.co/wp-content/uploads/2022/07/ectomorfo-1.jpg" class="card-img-top" alt="Image 1">
                    <div class="card-body">
                        <p class="card-text">Ectomorfo</p>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-4 mb-4">
            <form method="post">
                <input type="hidden" name="card" value="2">
                <div class="card" style="cursor: pointer;" onclick="this.parentElement.submit();">
                    <img src="https://actimax.com.co/wp-content/uploads/2022/07/Mesomorfo.jpg" class="card-img-top" alt="Image 2">
                    <div class="card-body">
                        <p class="card-text">Mesomorfo</p>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-4 mb-4">
            <form method="post">
                <input type="hidden" name="card" value="3">
                <div class="card" style="cursor: pointer;" onclick="this.parentElement.submit();">
                    <img src="https://actimax.com.co/wp-content/uploads/2022/07/Ectomorfo.jpg" class="card-img-top" alt="Image 3">
                    <div class="card-body">
                        <p class="card-text">Endomorfo</p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // Deshabilitar el botón de retroceso del navegador
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };
</script>

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
