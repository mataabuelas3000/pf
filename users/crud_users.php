<?php 
include ('C:\xampp\htdocs\pf\users\files_php\crud.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jefe</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style_user2.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top  bg-dark" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand text-light"><strong>Jefe</strong></a>
            <form class="d-flex" role="search" method="post">
                <div class="input_box">
                    <span class="icon">
                        <box-icon name='search' style="margin-top: 10px"></box-icon>
                    </span>
                    <input class="search" type="number" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                        placeholder="Ingrese ID" name="search" aria-label="Search" required>
                </div>
                <div class="input_box">
                    <button class="btn btn-outline-light  detalles toggle-details" type="submit"
                        name="buscar">Buscar</button>
                </div>
            </form>
            <a href="../auth/logout.php" class="text-light"><input type="button" class="btn btn-danger"
                    value="Cerrar sesion"></a>
        </div>
    </nav>
    <form method="post">
    <div class="container my-5">
      <button class="btn btn-danger my-5" name="refresh"><a class="text-light">Refresh</a></button>
      <a href="create_user.php" class="text-light"><input type="button" class="btn btn-light my-5"
          value="Agregar Usuario"></a>
    </div>
    </form>
    <div class="container">
        <?php mostrar($con) ?>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="script_users.js"></script>
</body>

</html>