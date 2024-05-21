<?php
include ('C:\xampp\htdocs\pf\database\connect.php');
require ('C:\xampp\htdocs\pf\dashboard\fpdf\fpdf.php');

$con->set_charset('utf8');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener información del usuario
    $user_query = "SELECT * FROM user_info WHERE Id_User = $id";
    $user_result = mysqli_query($con, $user_query);
    $user_info = mysqli_fetch_assoc($user_result);

    // Modifica la consulta SQL para obtener todos los días de la semana, las rutinas asociadas y los videos de los ejercicios
    $query = "SELECT d.Id_Day, d.Day, r.Name_Routine, e.Name_Exercise, e.url_video
    FROM days AS d
    LEFT JOIN calendar AS c ON d.Id_Day = c.Id_Day AND c.Id_User = $id
    LEFT JOIN routine AS r ON c.Id_Routine = r.Id_Routine
    LEFT JOIN rut_has_exercise AS rhe ON r.Id_Routine = rhe.Id_Routine
    LEFT JOIN exercise AS e ON rhe.Id_Exercise = e.Id_Exercise
    ORDER BY d.Id_Day";

    $result = mysqli_query($con, $query);

    // Inicializa un array para almacenar las rutinas por día
    $rutinas_por_dia = array();

    // Variable para realizar un seguimiento de la primera página
    $primera_pagina = true;

    // Itera sobre cada fila de resultados
    while ($row = mysqli_fetch_assoc($result)) {
        $day = $row['Day'];
        $rutina = $row['Name_Routine'];
        $ejercicio = $row['Name_Exercise'];
        $url_video = $row['url_video'];

        if ($primera_pagina && $day === "Lunes") {
            // Crear instancia de FPDF
            $pdf = new FPDF();
            $pdf->AddPage();
        
            // Configurar fuente y tamaño
            $pdf->SetFont('Arial','B',16);
        
            // Título del PDF
            $pdf->SetTitle('Rutinas de Ejercicio');
        
            // Título centrado
            $pdf->Cell(0,10,utf8_decode('Lleva tu Rutina a todas partes'),0,1,'C');
            $pdf->Ln(); // Salto de línea
        
            // Imprimir información del usuario centrada en la mitad de la página
            $pdf->SetY($pdf->GetPageHeight()/2 - 10);
            $pdf->Cell(0,10,utf8_decode("Nombre: {$user_info['Name_User']}"),0,1,'C');
            $pdf->Cell(0,10,utf8_decode("Apellido: {$user_info['Last_Name_User']}"),0,1,'C');
            $pdf->Cell(0,10,utf8_decode("Email: {$user_info['Email_User']}"),0,1,'C');
        
            // Cambiar el estado de la variable para evitar que se imprima nuevamente la información del usuario
            $primera_pagina = false;
        }

        // Si la rutina es nula, significa que no hay rutina asignada para este día
        if ($rutina === null) {
            // Verifica si la rutina tiene el ID 0
            if ($row['Id_Day'] === 0) {
                // Si la rutina tiene el ID 0, significa que es un día de descanso
                $rutina = "Descanso";
                $ejercicio = "";
                $url_video = "";
            } else {
                // Si la rutina es nula y no tiene el ID 0, significa que no hay rutina asignada
                $rutina = "No hay rutina asignada";
                $ejercicio = "";
                $url_video = "";
            }
        } elseif ($rutina === "0") {
            // Si la rutina tiene el ID 0, también es un día de descanso
            $rutina = "Descanso";
            $ejercicio = "";
            $url_video = "";
        } elseif ($rutina !== null && $ejercicio === null) {
            // Si la rutina no es nula pero no hay ejercicios asociados
            $ejercicio = "No se han asignado ejercicios";
            $url_video = "";
        }

        // Agrega la rutina y el ejercicio al día correspondiente
        if (!isset($rutinas_por_dia[$day])) {
            $rutinas_por_dia[$day] = array();
        }
        if (!isset($rutinas_por_dia[$day][$rutina])) {
            $rutinas_por_dia[$day][$rutina] = array();
        }
        if (!empty($ejercicio)) {
            $rutinas_por_dia[$day][$rutina][] = array('ejercicio' => $ejercicio, 'url_video' => $url_video);
        }
    }

    // Generar contenido del PDF
    foreach ($rutinas_por_dia as $day => $rutinas) {
        // Si es la primera página y el primer día, la información del usuario ya ha sido impresa
        if (!($primera_pagina && $day === "Lunes")) {
            // Crear una nueva página para cada día
            $pdf->AddPage();
    
            // Imprimir información del día
            $pdf->SetFont('Arial','B',14);
            $pdf->Cell(0,10,utf8_decode("Día: $day"),0,1);
            foreach ($rutinas as $rutina => $ejercicios) {
                $pdf->SetFont('Arial','B',12); // Establecer la fuente en negrita para el nombre de la rutina
                $pdf->Cell(0,10,utf8_decode("Rutina: $rutina"),0,1); // Imprimir nombre de la rutina
                $pdf->SetFont('Arial','',12); // Restaurar la fuente regular para los ejercicios
                if (!empty($ejercicios)) {
                    // Imprimir ejercicios y videos en líneas separadas
                    foreach ($ejercicios as $ejercicio) {
                        $pdf->Cell(0,10,utf8_decode("- {$ejercicio['ejercicio']}"),0,1);
                        if (!empty($ejercicio['url_video'])) {
                            $pdf->SetFont('Arial','I',10); // Establecer la fuente en cursiva para el URL del video
                            $pdf->SetTextColor(0, 0, 255); // Cambiar el color de texto a azul para el hipervínculo
                            $pdf->Cell(0,10,utf8_decode("  Video: {$ejercicio['url_video']}"),0,1, 'L', false, $ejercicio['url_video']);
                            $pdf->SetFont('Arial','',12); // Restaurar la fuente regular para los ejercicios
                            $pdf->SetTextColor(0, 0, 0); // Restaurar el color de texto a negro
                        }
                    }
                } else {
                    // Si no hay ejercicios, imprimir mensaje correspondiente
                    $pdf->Cell(0,10,utf8_decode("- No se han asignado ejercicios"),0,1);
                }
            }
        }
    }

    // Generar PDF
    header('Content-Disposition: attachment; filename="calendario.pdf"');
    $pdf->Output();
} else {
    echo "No se proporcionó un ID de usuario válido.";
}

$con->close();
?>
