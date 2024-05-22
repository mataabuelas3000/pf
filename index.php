<?php

include ('C:\xampp\htdocs\pf\start\sesion.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style2.css">

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
        <p>Gym JS es una plataforma interactiva que permite a los usuarios crear, personalizar y seguir rutinas de ejercicio de manera sencilla y eficiente. Con una interfaz intuitiva y funcionalidades avanzadas, Gym JS se adapta tanto a principiantes que buscan orientación como a atletas experimentados que necesitan un seguimiento detallado de su progreso.</p>

        <div class="btn-container">
            <a class="btn btn1" href="https://api.whatsapp.com/send?phone=3162352634&text=¡Hola! quiero registrarme" target="_blank">
                Regístrate
            </a>
            <a class="btn" href="#nosotros">
                Nosotros
            </a>
        </div>

    </div>
    <div class="img-content">
        <img class="img-principal" src="images/img1.svg" alt="">
    </div>
</main>

<section id="entrenamiento" class="py-5 my-5 bg-dark" >
    <div class="container mt-5 ">
        <div class="row">
            <div class="col">
                <h2>Entrenamiento Aeróbico:</h2>
                <p>Actividades de intensidad moderada durante períodos prolongados que utilizan oxígeno para producir energía, como correr o nadar. Beneficia la salud cardiovascular, mejora la resistencia y quema grasa.</p>
            </div>
            <div class="col">
                <h2>Entrenamiento Anaeróbico:</h2>
                <p>Ejercicios de alta intensidad y corta duración que no dependen de oxígeno para producir energía, como levantamiento de pesas o sprints. Aumenta la fuerza muscular, mejora la potencia y promueve el crecimiento muscular.</p>
            </div>
            <div class="col">
                <h2>Entrenamiento Funcional:</h2>
                <p>Enfoque en movimientos cotidianos para mejorar la eficiencia y seguridad en las actividades diarias, como sentadillas o levantamientos. Mejora el equilibrio, la flexibilidad y previene lesiones.</p>
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
                        <h5 class="card-title">Plan Principiante</h5>
                        <p class="card-text">Este programa está diseñado para aquellos que están dando sus primeros pasos en el mundo del fitness y desean establecer una base sólida para un estilo de vida más activo y saludable.</p>
                        <a href="#" class="">Más información</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card bg-dark" data-bs-theme="dark">
                    <div class="card-body">
                        <h5 class="card-title">Plan Perdida de Peso</h5>
                        <p class="card-text">Este programa busca quemar grasa, tonificar el cuerpo y mejorar la salud en general con entrenamiento cardiovascular, ejercicios de fuerza y sesiones de entrenamiento funcional.</p>
                        <a href="#" class="">Más información</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card bg-dark" data-bs-theme="dark">
                    <div class="card-body">
                        <h5 class="card-title">Plan Ganancia</h5>
                        <p class="card-text">Este programa fortalece y tonifica el cuerpo mediante ejercicios de fuerza para el crecimiento muscular, combinados con una dieta alta en proteínas.</p>
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
                <p>En Gym JS, somos un equipo apasionado por el fitness y la tecnología, comprometidos con la misión de facilitar y mejorar la experiencia de entrenamiento de nuestros usuarios. Desde la concepción de nuestra idea, hemos trabajado incansablemente para desarrollar una plataforma que combine lo mejor de la tecnología con el conocimiento en fitness, con el objetivo de transformar la manera en que las personas abordan su bienestar físico. <br><br><br>
                La idea de Gym JS nació de la observación de las dificultades comunes que enfrentan muchas personas al tratar de mantener una rutina de ejercicio efectiva y constante. Nos dimos cuenta de que las barreras no eran solo físicas, sino también logísticas y motivacionales. Muchas personas abandonaban sus objetivos de fitness debido a la falta de una estructura clara, herramientas de seguimiento adecuadas y apoyo constante. Con esta problemática en mente, decidimos crear una solución integral que abordara todos estos aspectos, brindando una experiencia de entrenamiento completa y adaptada a las necesidades individuales de cada usuario.
                </p>
            </div>
            <div class="col-lg-6">
                <img src="images/Logo.svg" alt="Logo" width="400" height="400" class="d-inline-block align-text-top">
            </div>
        </div>
    </div>
</section>




<section id="contacto" class="py-5 my-5">
    <div class="container">
        <h2 class="text-center " style="margin-bottom: 130px">Contacto</h2>
        <div class="row">
            <div class="col-lg-6">
                <p>Estamos aquí para ayudarte en cada paso de tu viaje de fitness. Si tienes preguntas, sugerencias o necesitas asistencia, no dudes en ponerte en contacto con nosotros.</p>
                <ul class="text-secondary">
                    <li>Teléfono: 3162352634 - 3155748135</li>
                    <li>Correo electrónico: Santiago_gonzalezbe@fet.edu.co</li>
                    <li>Dirección: Calle 18H sur #32-88</li>
                </ul>
                
            </div>



            <div class="col-lg-6">
                <div class="card" style="background-color: #ffffff0c; border-radius: 20px; color: white ">
                    <div class="card-body map">
                    <iframe style="border-radius: 10px" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.677959239184!2d-75.27047018835216!3d2.9087374545689513!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3b73ed87208a97%3A0xa861323af6a982ea!2sCl.%2018h%20Sur%20%2332-04%2C%20Neiva%2C%20Huila!5e0!3m2!1ses-419!2sco!4v1716223119581!5m2!1ses-419!2sco" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>

    
</section>
<center><p>¡Prepárate para una experiencia de entrenamiento revolucionaria con Gym JS!</p></center>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script src="SmoothScroll.js"></script>

</body>
</html>