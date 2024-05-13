    <?php
// Iniciamos la sesión y destruimos cualquier sesión existente para asegurarnos de un inicio limpio.
session_start();
session_destroy();

// Incluimos el archivo de conexión a la base de datos.
include ('C:\xampp\htdocs\pf\database\connect.php');

// Verificamos si se ha enviado el formulario de inicio de sesión.
if (isset($_POST['enviar'])) {
    // Obtenemos el ID de usuario y la contraseña proporcionados por el formulario.
    $id = $_POST['id'];
    $password = $_POST['password'];

    // Consulta SQL para obtener el ID de rol del usuario.
    $query = 'SELECT Id_Role_User FROM login WHERE Id_User = ? AND Password = ?';
    $statement = $con->prepare($query);

    // Ligamos los parámetros y ejecutamos la consulta.
    $statement->bind_param('is', $id, $password);
    $statement->execute();
    
    // Obtenemos el resultado de la consulta.
    $result = $statement->get_result();

    // Verificamos si se encontró el usuario y su rol.
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $rol = $row['Id_Role_User'];

        // Redirigimos según el rol del usuario.
        if ($rol == 1) {
            // Iniciamos la sesión y establecemos la variable de sesión.
            session_start();
            $_SESSION['id'] = $id;

            // Redirigimos al dashboard de usuarios.
            header('Location: dashboard/interface.php');
            exit;
        } else if ($rol == 2) {
            // Iniciamos la sesión y establecemos la variable de sesión.
            session_start();
            $_SESSION['id'] = $id;

            // Redirigimos al panel de administración de usuarios.
            header('Location: users/crud_users.php');
            exit;
        }
    } else {
        // Si no se encuentra el usuario, mostramos un mensaje de error.
        echo "<script> alert('El usuario no existe'); </script>";
    }
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

</div>



<nav class="navbar navbar-expand-lg bg-body-tertiary ">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">  <img src="images/Logo.svg" alt="Logo" width="70" height="54" class="d-inline-block align-text-top"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
       
      </ul>
        <ul class="navbar-nav mb-2 mb-lg-0" >
            <li class="nav-item">
            <a class="nav-link" href="#" id="login-link">Iniciar Sesión</a>
            </li>
        </ul>
     
    </div>
  </div>
</nav>

<div class="overlay" id="overlay"></div>
    <div class="container login-container" style="display:none" id="login-container" >
        <div class="form">
        <div class="cerrar d-flex justify-content-end" id="cerrar">
        <box-icon name='x' color='brown'></box-icon>
          </div>
            <h1>Iniciar Sesión</h1>
            <br>
            <form method="post">
                <div class="input_box">
                    <span class="icon">
                        <box-icon color='brown' name='id-card'></box-icon>
                    </span>
                    <input type="number" oninput="this.value = this.value.replace(/[^0-9]/g);" name="id"
                        placehorder="Ingrese cedula" required>
                    <label>Cedula</label>
                </div>
                <div class="input_box">
                    <span class="icon">
                        <box-icon name='lock-alt' color="brown"></box-icon>
                    </span>
                    <input type="password" name="password" placehorder="Ingrese contraseña" required>
                    <label>Contraseña</label>
                </div>
                <input type="checkbox" name="show_password" id="show_password"> Mostrar Contraseña
                <br><br>
                <br>
                <button name="enviar" class="boton">Ingresar</button>
            </form>
        </div>
       
    </div>

<main class="container d-flex">
<div class="container mt-5">
<h1>GYM JS</h1>
<h2>El mundo del ejercicio</h2>
<hr>
<p> Lorem ipsum dolor sit amet con sectetur adipisicing elit. Doloremque voluptatem, tenetur, omnis quidem minima, dolorem debitis atque nesciunt quibusdam dicta placeat. Corrupti libero ab saepe vitae eaque. Id, facere tempora!</p>

<a class="btn1" href="https://api.whatsapp.com/send?phone=3162352634&text=¡Hola! quiero registrarme" target="_blank">
    Registrate
</a>
<button class="btn">
   Nosotros
</button>
</div>
<div class="img-content">
<img class="img-principal" src="images/img1.svg" alt="">
</div>
</main>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="script.js"></script>
        <script>
        document.getElementById('login-link').addEventListener('click', function() {
            document.getElementById('overlay').style.display = 'block'; // Mostrar overlay
            document.getElementById('login-container').style.display = 'flex'; // Mostrar contenedor de inicio de sesión
        });

        document.getElementById('cerrar').addEventListener('click', function() {
        document.getElementById('overlay').style.display = 'none'; // Ocultar overlay
        document.getElementById('login-container').style.display = 'none'; // Ocultar contenedor de inicio de sesión
    });
    </script>
</body>
</html>