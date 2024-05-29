<?php
include('C:\xampp\htdocs\pf\users\files_php\update.php');
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="http://localhost/pf/assets/user/style_update.css">
    <title>actualizar</title>
</head>
<body>
    <div class="container my-5" id="cerrar">
        <form method="post" id="actualizarForm" class="form" style="background-color: #198077;">
            <div class="titulo">
                <h1>Actualización de Datos</h1>
            </div>
            <hr>
            <div class="row ">
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">ID</label>
                        <input type="number" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="form-control text-light" name="id" placeholder="Ingrese su id" value="<?php echo $idviejo ?>" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Nombres</label>
                        <input type="text" class="form-control text-light" name="primernombre" onkeypress="return soloLetras(event)" placeholder="Ingrese su nombre" value="<?php echo $primernombre ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Apellidos</label>
                        <input type="text" class="form-control text-light" name="primerapellido" onkeypress="return soloLetras(event)" placeholder="Ingrese su Segundo apellido" value="<?php echo $primerapellido ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Correo</label>
                        <input type="email" class="form-control text-light" name="correo" placeholder="Ingrese su correo" value="<?php echo $correo ?>" required>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group input-container" style="margin-top:30px">
                        <label class="form-label">Genero</label>
                        <select class="form-select text-light" style="width:100%; margin-top:0px" name="genero" required>

                            <option value="M" <?php if ($genero === 'M') echo 'selected'; ?>>Masculino</option>
                            <option value="F" <?php if ($genero === 'F') echo 'selected'; ?>>Femenino</option>
                            <option value="O" <?php if ($genero === 'O') echo 'selected'; ?>>Otro</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Altura</label>
                        <input type="number" step="0.01" class="form-control text-light" id="altura" name="altura" placeholder="Ingrese su altura" value="<?php echo $altura ?>" required>
                    </div>
                </div>

            </div>
            <div class="row">

                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Peso</label>
                        <input type="number" step="0.01" class="form-control text-light" id="peso" name="peso" placeholder="Ingrese su peso" value="<?php echo $peso ?>" required>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Contraseña nueva</label>
                        <input type="password" class="form-control text-light" name="pass" placeholder="Ingrese su nueva contraseña" value="">
                    </div>
                </div>
            </div>
            <div class="col-md-6 checkbox text-light">
                <input type="checkbox" name="show_password" id="show_password">
                <label for="show_password">Mostrar contraseña</label>
            </div>
            <br>
            <button type="submit" class="btn btn-light" name="mandar" id="updatebtn">Actualizar</button>
            <button type="submit" class="btn btn-danger" name="cancelar">Cancelar</button>
    </div>
    <div class="mr-5"></div>
    </form>
    </div>
    <script src="js/script_update.js"></script>
</body>

</html>