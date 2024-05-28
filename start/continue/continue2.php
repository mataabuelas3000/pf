<?php
session_start();

// Verificar si se ha iniciado sesión
if (empty($_SESSION['id'])) {
    // Redirigir a la página de inicio de sesión
    header('Location: ../../index.php');
    exit;
}
// Recuperar el ID de sesión
$id = $_SESSION['id'];

// Verificar si se ha seleccionado una carta
if (isset($_SESSION['selected_card_text'])) {
    $selected_card_text = $_SESSION['selected_card_text'];
    echo "El texto seleccionado es: $selected_card_text";
} else {
    echo "No se ha seleccionado ninguna carta.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['card'])) {
    $_SESSION['selected_card_text_continue2'] = $_POST['card'];
    // Redirigir a index.php
    header('Location: index.php');
    exit;
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
            height: 33vh;
            margin-right: 30vh;
            width: 36vh;
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
    <h1 class="mb-4">Selecciona tu enfoque</h1>
    <div class="row justify-content-center">
        <div class="col-md-4 mb-4">
            <form method="post">
                <input type="hidden" name="card" value="Perder Peso">
                <div class="card" style="cursor: pointer;" onclick="this.parentElement.submit();">
                    <img src="https://s3.abcstatics.com/media/bienestar/2022/02/09/perder-peso-kYfC--1248x698@abc.jpg" class="card-img-top" alt="Image 1">
                    <div class="card-body">
                        <p class="card-text">Perder Peso</p>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-4 mb-4">
            <form method="post">
                <input type="hidden" name="card" value="Aumentar Masa Muscular">
                <div class="card" style="cursor: pointer;" onclick="this.parentElement.submit();">
                    <img src="https://consultanutricional.cl/wp-content/uploads/100.-Aumenta-tu-masa-muscular-gracias-al-HMB.jpg" class="card-img-top" alt="Image 2">
                    <div class="card-body">
                        <p class="card-text">Aumentar Masa Muscular</p>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-4 mb-4">
            <form method="post">
                <input type="hidden" name="card" value="Tonificar">
                <div class="card" style="cursor: pointer;" onclick="this.parentElement.submit();">
                    <img src="https://lirp.cdn-website.com/13f4e7e0/dms3rep/multi/opt/amazing-young-sports-woman-showing-biceps-7057281a-640w.jpg" class="card-img-top" alt="Image 3">
                    <div class="card-body">
                        <p class="card-text">Tonificar</p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
