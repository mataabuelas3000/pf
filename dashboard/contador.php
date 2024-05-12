<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contador y Actualización de Rutina</title>
</head>
<body>
<div id="contador">Tiempo restante hasta la media noche:</div>
<button id="volverRutina" style="display: none;">Volver a la Rutina</button>

<script>
function iniciarContador() {
    var ahora = new Date();
    var mediaNoche = new Date();
    mediaNoche.setHours(24, 0, 0, 0); // Establecer la hora de media noche (00:00:00)

    var tiempoRestante = mediaNoche - ahora;
    var segundos = Math.floor(tiempoRestante / 1000);
    var minutos = Math.floor(segundos / 60);
    var horas = Math.floor(minutos / 60);

    segundos %= 60;
    minutos %= 60;

    var contador = document.getElementById("contador");
    contador.innerHTML = "Tiempo restante hasta la media noche: " + horas + "h " + minutos + "m " + segundos + "s";

    if (tiempoRestante <= 0) {
        clearInterval(intervalo);
        contador.innerHTML = "¡Es hora de volver a la rutina!";
        document.getElementById("volverRutina").style.display = "block";
    }
}

var intervalo = setInterval(iniciarContador, 1000);

document.getElementById("volverRutina").addEventListener("click", function() {
    // Realizar una solicitud POST para actualizar la rutina en la base de datos
    var idRutina = <?php echo isset($_POST['id_rutina']) ? $_POST['id_rutina'] : 0; ?>;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "", true); // Dejar vacío para enviar la solicitud al mismo archivo
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = xhr.responseText;
            console.log(response); // Mostrar la respuesta en la consola
        }
    };
    xhr.send("id_rutina=" + idRutina);
});
</script>

<?php
// Incluir el archivo de conexión a la base de datos
include('C:\xampp\htdocs\pf\database\connect.php');

// Verificar si se recibió el ID de la rutina a actualizar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_rutina'])) {
    // Obtener el ID de la rutina desde la solicitud POST
    $idRutina = $_POST['id_rutina'];

    // Consultar y actualizar la rutina en la base de datos
    $sqlUpdate = "UPDATE routine SET Id_Check = 0 WHERE Id_Routine = ?";
    $stmtUpdate = mysqli_prepare($con, $sqlUpdate);
    mysqli_stmt_bind_param($stmtUpdate, 'i', $idRutina);

    if (mysqli_stmt_execute($stmtUpdate)) {
        echo "<script>alert('La rutina ha sido marcada como no completada en la base de datos.');</script>";
    } else {
        echo "<script>alert('Error al actualizar la rutina: " . mysqli_error($con) . "');</script>";
    }
}
?>
</body>
</html>
