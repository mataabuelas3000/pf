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
    <link rel="stylesheet" href="http://localhost/pf/assets/crud.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand text-light" style="color: #D7FBE8 !important;font-size: 30px; position:relative; left:45px"><strong>Administrador</strong></a>
            <form class="d-flex" role="search" method="post">
                <div class="input_box">
                    <span class="icon">
                        <box-icon name='search' style="margin-top: 10px"></box-icon>
                    </span>
                    <input class="search" type="text" 
                        placeholder="Ingrese ID" name="search" aria-label="Search" required>
                </div>
                <div class="input_box">
                    <button class="btn btn-success  detalles toggle-details" type="submit"
                        name="buscar" style="color: white !important;">Buscar</button>
                </div>
            </form>
            <a href="../auth/logout.php" class="text-light"><input type="button" class="btcerrar btn btn-danger"
                    value="Cerrar sesion"></a>
        </div>
    </nav>
    <form method="post">
    <div class="container my-5">
      <button class="btn btn-danger my-5" name="refresh"><a class="text-light">Refresh</a></button>
      <a href="create_user/create_user.php" class="text-light"><input type="button" class="btn btn-success"
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
    <script src="script.js"></script>
</body>

</html>