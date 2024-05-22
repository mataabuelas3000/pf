<?php
// Incluir el archivo de conexión a la base de datos
include ('C:\xampp\htdocs\pf\database\connect.php');
$con->set_charset('utf8');
// Iniciar sesión
session_start();

// Verificar si no hay una sesión activa, en cuyo caso redirigir al usuario a la página de inicio de sesión
if (empty($_SESSION['id'])) {
  header('Location: ../index.php');
  exit();
} else {
  // Obtener el ID de usuario de la sesión
  $cedula = $_SESSION['id'];
}

// Función para mostrar los detalles de los usuarios buscados
function mostrar($con)
{
  // Verificar si se ha enviado un formulario de búsqueda
  if (isset($_POST['buscar'])) {
    // Obtener el término de búsqueda ingresado por el usuario
    $search = $_POST['search'];

    $sql = "SELECT user_info.*, data.Height_User, data.Weight_User, data.Imc_User, roles.Role
    FROM user_info 
    INNER JOIN data ON user_info.Id_User = data.Id_User 
    INNER JOIN login ON user_info.Id_User = login.Id_User
    INNER JOIN roles ON login.Id_Role_User = roles.Id_Role_User
    WHERE user_info.Id_User LIKE '%$search%' OR user_info.Name_User LIKE '%$search%' OR user_info.Last_Name_User LIKE '%$search%'";

// Ejecutar la consulta
$result = mysqli_query($con, $sql);

// Verificar si se encontraron resultados
if ($result) {
// Verificar si hay al menos un usuario encontrado
if (mysqli_num_rows($result) > 0) {
// Iterar sobre los resultados y mostrar los detalles de cada usuario
while ($row = mysqli_fetch_assoc($result)) {
  // Crear variables para los campos obtenidos
  $id = $row['Id_User'];
  $nombre = $row['Name_User'];
  $apellido = $row['Last_Name_User'];
  $correo = $row['Email_User'];
  $genero = $row['Gender_User'];
  $altura = $row['Height_User'];
  $peso = $row['Weight_User'];
  $imc = $row['Imc_User'];

          echo ' <div class="card1 bg-dark" data-bs-theme="dark" style="width: 100%;">
          <div class="card-body">
          <h5 class="card-title text-light">' . $nombre . ' - '.$id.'</h5>
            <div class="py-2">
            </div>
            <button type="button" class="btn btn-light  detalles toggle-details ">Mostrar Detalles</button> 
            <div class="details" style="display: none;" >
            <div class="py-3">
          </div>
          <form class="row g-3 py-2">
          <div class="col-md-6 input-container">
          <label for="inputEmail4" class="form-label text-dark">Nombres</label>
          <input type="text" class="form-control text-light" id="inputPrimernom" value="' . $nombre . '"   disabled>
          </div>
          <div class="col-md-6 input-container">
            <label for="inputEmail4" class="form-label text-dark">Apellidos</label>
            <input type="text" class="form-control text-light" id="inputPrimerape" value="' . $apellido . '"   disabled>
          </div>
          <div class="col-md-6 input-container">
            <label for="inputEmail4" class="form-label text-dark">Correo</label>
            <input type="email" class="form-control text-light" id="inputCorreo" value="' . $correo. '"  disabled>
          </div>
          <div class="col-md-6 input-container">
            <label for="inputEmail4" class="form-label text-dark">Genero</label>
            <input type="text" class="form-control text-light" id="inputGenero" value="' . $genero . '"  disabled>
          </div>
            <div class="col-md-6 input-container">
                        <label for="inputEmail4" class="form-label text-dark">Peso</label>
                        <input type="text" class="form-control text-light" id="inputPeso" value="' . $peso . '"  disabled>
                      </div>
                      <div class="col-md-6 input-container">
                      <label for="inputEmail4" class="form-label text-dark">Altura</label>
                      <input type="text" class="form-control text-light" id="inputAltura" value="' . $altura. '"  disabled>
                    </div>
                    <div class="col-md input-container">
                    <label for="inputEmail4" class="form-label text-dark">IMC</label>
                    <input type="text" class="form-control text-light" id="inputImc" value="' . $imc . '"  disabled>
                  </div>
          <div class="py-5">
          </div>
          <div class="col-12 ">
          <a href="users_dashboard/routine_user.php?id=' . $id . '" class="text-light"><input type="button" class="btn btn-secondary mr-3" value="Rutinas"></a>
          <a href="profile/update_user.php?updateid=' . $id . '" class="text-light"><input type="button" class="btn btn-secondary mr-3" value="Actualizar"></a>
          <a href="#" class="text-light"  onclick="confirmacion(' . $id . ')""><input type="button" class="btn btn-danger" id="delete" value="Eliminar"></a>
          
          </div>
          </form>
          </div>
          </div>
            </div>
            
            <div class="py-3">
            </div>
            
          ';


        }
      } else {
        echo '<h2 class="nofound text-light">La cedula no existe :(</h2>';
      }
    }

  } elseif (isset($_POST['refresh'])) {
    $sql = "SELECT user_info.*, data.Height_User, data.Weight_User, data.Imc_User, roles.Role
    FROM user_info 
    INNER JOIN data ON user_info.Id_User = data.Id_User 
    INNER JOIN login ON user_info.Id_User = login.Id_User
    INNER JOIN roles ON login.Id_Role_User = roles.Id_Role_User
    WHERE user_info.Id_User";

// Ejecutar la consulta
$result = mysqli_query($con, $sql);

// Verificar si se encontraron resultados
if ($result) {
// Verificar si hay al menos un usuario encontrado
if (mysqli_num_rows($result) > 0) {
// Iterar sobre los resultados y mostrar los detalles de cada usuario
while ($row = mysqli_fetch_assoc($result)) {
  // Crear variables para los campos obtenidos
  $id = $row['Id_User'];
  $nombre = $row['Name_User'];
  $apellido = $row['Last_Name_User'];
  $correo = $row['Email_User'];
  $genero = $row['Gender_User'];
  $altura = $row['Height_User'];
  $peso = $row['Weight_User'];
  $imc = $row['Imc_User'];

          echo ' <div class="card1 bg-dark" data-bs-theme="dark" style="width: 100%;">
          <div class="card-body">
          <h5 class="card-title text-light">' . $nombre . ' - '.$id.'</h5>
            <div class="py-2">
            </div>
            <button type="button" class="btn btn-light  detalles toggle-details">Mostrar Detalles</button> 
            <div class="details" style="display: none;" >
            <div class="py-3">
          </div>
          <form class="row g-3 py-2">
          <div class="col-md-6 input-container">
          <label for="inputEmail4" class="form-label text-dark">Nombres</label>
          <input type="text" class="form-control text-light" id="inputPrimernom" value="' . $nombre . '"   disabled>
          </div>
          <div class="col-md-6 input-container">
            <label for="inputEmail4" class="form-label text-dark">Apellidos</label>
            <input type="text" class="form-control text-light" id="inputPrimerape" value="' . $apellido . '"   disabled>
          </div>
          <div class="col-md-6 input-container">
            <label for="inputEmail4" class="form-label text-dark">Correo</label>
            <input type="email" class="form-control text-light" id="inputCorreo" value="' . $correo. '"  disabled>
          </div>
          <div class="col-md-6 input-container">
            <label for="inputEmail4" class="form-label text-dark">Genero</label>
            <input type="text" class="form-control text-light" id="inputGenero" value="' . $genero . '"  disabled>
          </div>
            <div class="col-md-6 input-container">
                        <label for="inputEmail4" class="form-label text-dark">Peso</label>
                        <input type="text" class="form-control text-light" id="inputPeso" value="' . $peso . '"  disabled>
                      </div>
                      <div class="col-md-6 input-container text-dark">
                      <label for="inputEmail4" class="form-label">Altura</label>
                      <input type="text" class="form-control text-light" id="inputAltura" value="' . $altura. '"  disabled>
                    </div>
                    <div class="col-md input-container text-dark">
                    <label for="inputEmail4" class="form-label">IMC</label>
                    <input type="text" class="form-control text-light" id="inputImc" value="' . $imc . '"  disabled>
                  </div>
          <div class="py-5">
          </div>
          <div class="col-12 ">
          <a href="users_dashboard/routine_user.php?id=' . $id . '" class="text-light"><input type="button" class="btn btn-secondary mr-3" value="Rutinas"></a>
          <a href="profile/update_user.php?updateid=' . $id . '" class="text-light"><input type="button" class="btn btn-secondary mr-3" value="Actualizar"></a>
          <a href="#" class="text-light"  onclick="confirmacion(' . $id . ')""><input type="button" class="btn btn-danger" id="delete" value="Eliminar"></a>
          
          </div>
          </form>
          </div>
          </div>
            </div>
            
            <div class="py-3">
            </div>
            
          ';


        }
      }
    }
  } else {
    $sql = "SELECT user_info.*, data.Height_User, data.Weight_User, data.Imc_User, roles.Role
    FROM user_info 
    INNER JOIN data ON user_info.Id_User = data.Id_User 
    INNER JOIN login ON user_info.Id_User = login.Id_User
    INNER JOIN roles ON login.Id_Role_User = roles.Id_Role_User
    WHERE user_info.Id_User";

// Ejecutar la consulta
$result = mysqli_query($con, $sql);

// Verificar si se encontraron resultados
if ($result) {
// Verificar si hay al menos un usuario encontrado
if (mysqli_num_rows($result) > 0) {
// Iterar sobre los resultados y mostrar los detalles de cada usuario
while ($row = mysqli_fetch_assoc($result)) {
  // Crear variables para los campos obtenidos
  $id = $row['Id_User'];
  $nombre = $row['Name_User'];
  $apellido = $row['Last_Name_User'];
  $correo = $row['Email_User'];
  $genero = $row['Gender_User'];
  $altura = $row['Height_User'];
  $peso = $row['Weight_User'];
  $imc = $row['Imc_User'];

          echo ' <div class="card1 bg-dark" data-bs-theme="dark" style="width: 100%; ">
          <div class="card-body">
            <h5 class="card-title text-light">' . $nombre . ' - '.$id.'</h5>
            <div class="py-2">
            </div>
            <button type="button" class="btn btn-light  detalles toggle-details">Mostrar Detalles</button> 
            <div class="details" style="display: none;" >
            <div class="py-3">
          </div>
          <form class="row g-3 py-2">
          <div class="col-md-6 input-container">
          <label for="inputEmail4" class="form-label text-dark">Nombres</label>
          <input type="text" class="form-control text-light" id="inputPrimernom" value="' . $nombre . '"   disabled>
          </div>
          <div class="col-md-6 input-container">
            <label for="inputEmail4" class="form-label text-dark">Apellidos</label>
            <input type="text" class="form-control text-light" id="inputPrimerape" value="' . $apellido . '"   disabled>
          </div>
          <div class="col-md-6 input-container">
            <label for="inputEmail4" class="form-label text-dark">Correo</label>
            <input type="email" class="form-control text-light" id="inputCorreo" value="' . $correo. '"  disabled>
          </div>
          <div class="col-md-6 input-container">
            <label for="inputEmail4" class="form-label text-dark">Genero</label>
            <input type="text" class="form-control text-light" id="inputGenero" value="' . $genero . '"  disabled>
          </div>

            <div class="col-md-6 input-container">
                        <label for="inputEmail4" class="form-label text-dark">Peso</label>
                        <input type="text" class="form-control text-light" id="inputPeso" value="' . $peso . '"  disabled>
                      </div>
                      <div class="col-md-6 input-container">
                      <label for="inputEmail4" class="form-label text-dark">Altura</label>
                      <input type="text" class="form-control text-light" id="inputAltura" value="' . $altura. '"  disabled>
                    </div>
                    <div class="col-md input-container">
                    <label for="inputEmail4" class="form-label text-dark">IMC</label>
                    <input type="text" class="form-control text-light" id="inputImc" value="' . $imc . '"  disabled>
                  </div>
          <div class="py-5">
          </div>
          <div class="col-12 ">
          <a href="users_dashboard/routine_user.php?id_personal=' . $id . '" class="text-light"><input type="button" class="btn btn-light mr-3" value="Rutinas"></a>
          <a href="profile/update_user.php?updateid=' . $id . '" class="text-light"><input type="button" class="btn btn-light mr-3" value="Actualizar"></a>
          <a href="#" class="text-light"  onclick="confirmacion(' . $id . ')""><input type="button" class="btn btn-danger" id="delete" value="Eliminar"></a>
          
          </div>
          </form>
          </div>
          </div>
            </div>
            
            <div class="py-3">
            </div>
            
          ';


        }
      }
    } else {
      die(mysqli_error($con));
    }
  }
}

?>