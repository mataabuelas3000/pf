<?php
include ('C:\xampp\htdocs\pf\database\connect.php');
$con->set_charset('utf8');
// Inicia la sesión si no está iniciada
if (!isset($_SESSION)) {
    session_start();
}

// Verifica si la sesión está activa y tiene la variable $_SESSION['id_personal']
if (isset($_SESSION['id'])) {
    // Obtén el ID personal de la sesión
    $idPersonal = $_SESSION['id'];


    $sqlIMC = "SELECT Imc_User FROM data WHERE Id_User  = $idPersonal";
    $resultIMC = $con->query($sqlIMC);

    if ($resultIMC->num_rows > 0) {
        $rowIMC = $resultIMC->fetch_assoc();
        $IMCUsuario = $rowIMC['Imc_User'];

        // Consulta para obtener la información nutricional según el IMC del usuario
        $sqlNutricion = "SELECT * FROM information WHERE IMC_MIN <= $IMCUsuario AND IMC_MAX >= $IMCUsuario";
        $resultNutricion = $con->query($sqlNutricion);

        if ($resultNutricion->num_rows > 0) {
            // Mostrar la información nutricional en el HTML
            while ($rowNutricion = $resultNutricion->fetch_assoc()) {
                echo "<b><h5>Su IMC es de: </b> " . $IMCUsuario . "<br></h5>";
                echo "<b>Descripción:</b> " . $rowNutricion['Description_Nutritional'] . "<br>";
                echo "<b>Desayuno:</b> ". "<br>" . $rowNutricion['D_P'] . "<br>" . $rowNutricion['D_C'] . "<br>" . $rowNutricion['D_GS'] . "<br>";
                echo "<b>Almuerzo:</b> " . "<br>". $rowNutricion['A_P'] . "<br>" . $rowNutricion['A_C'] . "<br>" . $rowNutricion['A_GS'] . "<br>";
                echo "<b>Cena:</b> " . "<br>". $rowNutricion['C_P'] . "<br>" . $rowNutricion['C_C'] . "<br>". $rowNutricion['C_GS'] . "<br>";
            }
        } else {
            echo "No se encontró información nutricional para este IMC.";
        }
    } else {
        echo "No se encontró el IMC del usuario.";
    }

    $con->close();
} else {
    echo "Error: La sesión no está activa o no se proporcionó el ID personal.";
}
?>