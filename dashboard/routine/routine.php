<?php
    include('files/index.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metadatos -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rutina <?php echo $idrutina ?></title>
    <!-- Enlaces a archivos CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="http://localhost/pf/assets/dashboard/routine/style.css">
</head>

<body>
    <!-- Barra de navegación -->
    <nav class="navbar">
        <div class="container-fluid">
            <h5 class="nav-link text-light"><?php echo $nombrerutina ?></h5>
            <a class="nav-link text-light"  href="../interface.php">
               Regresar <i class='bx bx-log-out bx-logout'></i>
            </a>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="card1 d-flex justify-content-between">
        <img src="../../images/img2.svg" alt="" width="900">
            <form method="post">
                <div class="details">
                    <?php mostrarejercicios($con, $idrutina); ?>
                </div>
            </form>
    </div>

    <div class="card" style="width: 100%; background-color: #1FA398">
        <div class="card-body">
            <h2 class="text-light">Mis ejercicios</h2>
            <br>
            <div id="ejercicios-lista">
                <?php
                // Obtener ejercicios de la rutina
                $ejercicios = obtenerEjerciciosDeRutina($con, $idrutina);
                    misjercicios($con, $idrutina, $ejercicios);
                ?>
            </div>
        </div>
    </div>
</body>

        <?php

                modals($con, $idrutina, $ejercicios);
        ?>


        <!-- Modal de felicitaciones -->
        <div class="modal fade" id="modalFelicitaciones" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Felicitaciones</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¡Has completado tu rutina con éxito! ¡Excelente trabajo!
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="location.reload();">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Asegúrate de tener jQuery cargado -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</script>



</body>
</html>