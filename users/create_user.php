<?php 
include ('C:\xampp\htdocs\pf\users\files_php\create.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="stylesheet" href="style1.css">
    <title>usuario</title>
</head>
<body>
    <div class=" container my-5" style="width:100%;">
        <form method="post" class="form bg-dark" data-bs-theme="dark">
            <div class="titulo">
                <h1>REGISTRO DE USUARIO</h1>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Id</label>
                        <input type="number" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                            class="form-control text-light" id="id" name="id" placeholder="Ingrese su Numero de documento" required
                            value="<?php if (isset($_POST['id'])) echo $_POST['id']; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Primer nombre</label>
                        <input type="text" class="form-control text-light" id="primernombre" name="primernombre"
                            placeholder="Ingrese su nombre"
                            value="<?php if (isset($_POST['primernombre'])) echo $_POST['primernombre']; ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Segundo nombre</label>
                        <input type="text" class="form-control text-light" id="segundonombre" name="segundonombre"
                            placeholder="Ingrese su Segundo nombre"
                            value="<?php if (isset($_POST['segundonombre'])) echo $_POST['segundonombre']; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Primer apellido</label>
                        <input type="text" class="form-control text-light" id="primerapellido" name="primerapellido"
                            placeholder="Ingrese su apellido"
                            value="<?php if (isset($_POST['primerapellido'])) echo $_POST['primerapellido']; ?>"
                            required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Segundo apellido</label>
                        <input type="text" class="form-control text-light" id="segundoapellido" name="segundoapellido"
                            placeholder="Ingrese su Segundo apellido"
                            value="<?php if (isset($_POST['segundoapellido'])) echo $_POST['segundoapellido']; ?>"
                            required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Correo</label>
                        <input type="email" class="form-control text-light" id="correo" name="correo"
                            placeholder="Ingrese su correo"
                            value="<?php if (isset($_POST['correo'])) echo $_POST['correo']; ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group box-select input-container">
                        <label class="form-label">Genero</label>
                        <select class="form-select text-light" style="width:100%;margin-top:0px" id="genero" name="genero"
                            required>
                            <option value="" disabled selected  >Tipo de Genero</option>
                            <option value="M"
                                <?php if (isset($_POST['genero']) && $_POST['genero'] === 'M') echo 'selected'; ?>>
                                Masculino</option>
                            <option value="F"
                                <?php if (isset($_POST['genero']) && $_POST['genero'] === 'F') echo 'selected'; ?>>
                                Femenino</option>
                            <option value="O"
                                <?php if (isset($_POST['genero']) && $_POST['genero'] === 'O') echo 'selected'; ?>>Otro
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Contraseña</label>
                        <input type="password" class="form-control text-light" id="contraseña" name="contraseña"
                            placeholder="Ingrese su contraseña"
                            value="<?php if (isset($_POST['contraseña'])) echo $_POST['contraseña']; ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Altura</label>
                        <input type="text" step="0.01" class="form-control text-light" id="altura" name="altura"
                            placeholder="Ingrese su altura (#.##)"
                            value="<?php if (isset($_POST['altura'])) echo number_format($_POST['altura'], 2, '.', ''); ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-container">
                        <label class="form-label">Peso</label>
                        <input type="text" step="0.01" class="form-control text-light" id="peso" name="peso"
                            placeholder="Ingrese su peso (##.# o ##.##)"
                            value="<?php if (isset($_POST['peso'])) echo number_format($_POST['peso'], 1, '.', ''); ?>" required>
                    </div>
                </div>
            </div>


            <div class="row">

                <div class="col-md-6 checkbox text-light">
                    <input type="checkbox" name="show_password" id="show_password">
                    <label for="show_password">Mostrar contraseña</label>
                </div>
            </div>


            <div class="py-2">
            </div>
            <button type="submit" class="btn btn-light mr-4" name="enviar">Confirmar</button>
            <a href="crud_users.php"><button type="button" class="btn btn-danger" name="enviar">Cancelar</button></a>
        </form>
    </div>
    <script src="script_create.js"></script>
</body>
</html>