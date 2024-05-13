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

<nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
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
          <a class="nav-link" href="#entrenamiento">Entrenamiento</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#planes">Planes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#contacto">Contactanos</a>
        </li>

       
      </ul>
        <ul class="navbar-nav mb-2 mb-lg-0" >
            <li class="nav-item">
            <a class="nav-link" href="#"  id="login-link">Iniciar Sesión</a>
            </li>
        </ul>
     
    </div>
  </div>
</nav>

<div class="overlay" id="overlay"></div>
    <div class="container login-container" style="display:none" id="login-container" >
        <div class="form">
        <div class="cerrar d-flex justify-content-end" id="cerrar">
        <box-icon name='x' color='#fff'></box-icon>
          </div>
            <h1>Iniciar Sesión</h1>
            <br>
            <form method="post">
                <div class="input_box">
                    <span class="icon">
                        <box-icon color='#fff' name='id-card'></box-icon>
                    </span>
                    <input type="number" oninput="this.value = this.value.replace(/[^0-9]/g);" name="id"
                        placehorder="Ingrese cedula" required>
                    <label>Cedula</label>
                </div>
                <div class="input_box">
                    <span class="icon">
                        <box-icon name='lock-alt' color="#fff"></box-icon>
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
<a class="btn" href="#nosotros">
   Nosotros
</a>
</div>
<div class="img-content">
<img class="img-principal" src="images/img1.svg" alt="">
</div>

</main>

<section id="entrenamiento" class="py-5 my-5 bg-dark" >
    <div class="container mt-5 ">
        <div class="row">
            <div class="col">
                <h2>Entrenamiento</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque voluptatem, tenetur, omnis quidem minima, dolorem debitis atque nesciunt quibusdam dicta placeat. Corrupti libero ab saepe vitae eaque. Id, facere tempora!</p>
            </div>
            <div class="col">
                <h2>Entrenamiento</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque voluptatem, tenetur, omnis quidem minima, dolorem debitis atque nesciunt quibusdam dicta placeat. Corrupti libero ab saepe vitae eaque. Id, facere tempora!</p>
            </div>
            <div class="col">
                <h2>Entrenamiento</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque voluptatem, tenetur, omnis quidem minima, dolorem debitis atque nesciunt quibusdam dicta placeat. Corrupti libero ab saepe vitae eaque. Id, facere tempora!</p>
            </div>
        </div>
    </div>
</section>


<section id="planes" class="py-5 my-5">
    <div class="container">
        <h2 class="text-center mb-4">Planes</h2>
        <div class="row">
            <div class="col-lg-4">
                <div class="card bg-dark" data-bs-theme="dark">
                    <div class="card-body">
                        <h5 class="card-title">Plan Básico</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        <a href="#" class="">Más información</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card bg-dark" data-bs-theme="dark">
                    <div class="card-body">
                        <h5 class="card-title">Plan Estándar</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        <a href="#" class="">Más información</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card bg-dark" data-bs-theme="dark">
                    <div class="card-body">
                        <h5 class="card-title">Plan Premium</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        <a href="#" class="">Más información</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section id="nosotros" class="py-5 my-5 bg-dark">
    <div class="container">
        <h2 class="text-center mb-4">Nosotros</h2>
        <div class="row">
            <div class="col-lg-6 mt-5">
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fugiat veniam accusantium id inventore quo itaque maiores facilis eos molestias illum! Inventore dignissimos, odit non, distinctio amet consectetur odio facere aut rerum natus tempora ex voluptas sed quidem molestiae! Veritatis accusantium assumenda reprehenderit ducimus commodi asperiores corporis neque quasi, quae alias voluptates cum qui omnis odit possimus nobis magni amet tempora architecto labore molestiae odio ea. Inventore blanditiis debitis rerum excepturi adipisci dolor dolorem voluptates quidem consequatur, dolore doloremque nulla esse, quia officiis. Autem maiores quam, voluptatum eveniet dolorum veritatis minima, saepe nulla tenetur fugiat placeat quos eius sed dolores nemo doloribus! Fugit veniam officia praesentium doloremque fugiat voluptate quos illo iusto est impedit. Aliquam ipsam obcaecati commodi, esse quasi iure nihil dignissimos eum? Aliquid asperiores voluptate reiciendis nisi facere laborum voluptatum odit sed doloribus eaque quam fugiat ad optio distinctio ut eius, fugit quod nihil officiis iure rerum et iusto.</p>
            </div>
            <div class="col-lg-6">
                <img src="images/Logo.svg" alt="Logo" width="400" height="400" class="d-inline-block align-text-top">
            </div>
        </div>
    </div>
</section>



<section id="contacto" class="py-5 my-5">
    <div class="container">
        <h2 class="text-center mb-4">Contacto</h2>
        <div class="row">
            <div class="col-lg-6">
                <p>Para cualquier consulta o información adicional, no dudes en ponerte en contacto con nosotros.</p>
                <ul class="text-secondary">
                    <li>Teléfono: 123-456-789</li>
                    <li>Correo electrónico: info@example.com</li>
                    <li>Dirección: Calle Principal #123, Ciudad, País</li>
                </ul>
            </div>
            <div class="col-lg-6">
                <form>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" placeholder="Nombre">
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="correo" placeholder="Correo electrónico">
                    </div>
                    <div class="mb-3">
                        <label for="mensaje" class="form-label">Mensaje</label>
                        <textarea class="form-control" id="mensaje" rows="3" placeholder="Mensaje"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</section>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="index.js"></script>
    <script src="SmoothScroll.js"></script>

</body>
</html>