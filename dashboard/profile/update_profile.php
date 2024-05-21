<?php
    include('index.php');
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
            <link rel="stylesheet" href="../interface_style.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-Kpv8THDbkGt7upobz6i8tM8aK5MUKWk1z/zUJQ+xhxC5xR3nTO2EoeGvEY5mCZQ7mKqm40sv5Yq97h4ajc0L2Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />

            <title>actualizar</title>
        </head>

        <body>
            
           
            
            <div class="container my-7" id="cerrar">
            <h1 style="text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.5);">
        Actualiza tus Datos
        </h1>
        <hr class="hr">
                <form method="post" id="actualizarForm">
                    <div class="row ">
                        <div class="col-md-6">
                            <div class="form-group input-container">
                                <label class="form-label">ID</label>
                                <input type="number" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                    class="form-control" name="id" placeholder="Ingrese su id"
                                    value="<?php echo $idviejo ?>" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group input-container">
                                <label class="form-label">Primer nombre</label>
                                <input type="text" class="form-control" name="primernombre" id="inputText" onkeypress="return soloLetras(event)"
                                    placeholder="Ingrese su nombre" value="<?php echo $primernombre ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group input-container">
                                <label class="form-label">Apellidos</label>
                                <input type="text" class="form-control" name="primerapellido"id="inputText" onkeypress="return soloLetras(event)"
                                    placeholder="Ingrese su Segundo apellido" value="<?php echo $primerapellido ?>"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group input-container">
                                <label class="form-label">Correo</label>
                                <input type="email" class="form-control" name="correo" placeholder="Ingrese su correo"
                                    value="<?php echo $correo ?>" required>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group input-container" style="margin-top:30px;box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5);">
                                <label class="form-label">Genero</label>
                                <select class="form-select" style="width:100%; margin-top:0px" name="genero" required>
                                    <option value="M" <?php if ($genero === 'M') echo 'selected'; ?>>Masculino</option>
                                    <option value="F" <?php if ($genero === 'F') echo 'selected'; ?>>Femenino</option>
                                    <option value="O" <?php if ($genero === 'O') echo 'selected'; ?>>Otro</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group input-container">
                                <label class="form-label">Altura</label>
                                <input type="number" step="0.01" class="form-control" id="altura" name="altura"
                                    placeholder="Ingrese su altura" value="<?php echo $altura ?>" required>
                            </div>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group input-container">
                                <label class="form-label">Peso</label>
                                <input type="number" step="0.01" class="form-control" id="peso" name="peso"
                                    placeholder="Ingrese su peso" value="<?php echo $peso ?>" required>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group input-container">
                                <label class="form-label">Confirma tu Contraseña</label>
                                <input type="password" class="form-control " name="passlast"
                                    placeholder="Confirma tu contraseña" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group input-container">
                                <label class="form-label">Nueva contraseña</label>
                                <input type="password" class="form-control " name="passnew"
                                    placeholder="Ingrese su contraseña nueva" value="">
                            </div>
                        </div>
                    <div class="col-md-6 checkbox text-light">
                        <input type="checkbox" name="show_password" id="show_password">
                        <label for="show_password">Mostrar contraseña</label>
                    </div>
                    </div>
                    <br>
                    <div class="d-flex">
                    <button type="submit" class="btn btn-dark mr-4" name="mandar" id="updatebtn">Actualizar</button>
                    <button type="submit" class="btn btn-danger" name="cancelar">Cancelar</button>
                    </div>
            </div>
            <div class="mr-5"></div>
            </form>
            </div>


        <script src="js/script.js"></script>

        </body>

        </html>