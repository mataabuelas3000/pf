<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = strtolower(trim($_POST["message"]));

    // Diccionario de palabras clave y respuestas predefinidas
    $responses = [
        "¡Hola! Bienvenido al gimnasio. Soy el asistente virtual del gimnasio. ¿En qué puedo ayudarte?" => [
            "hola", "saludos", "buenas", "buenos dias", "buenas tardes", "buenas noches", "que tal", "hello", "hi", "saludo", "bienvenido", "hola asistente", "hola gym"
        ],
        "Gym JS ofrece una plataforma integral que fusiona tecnología y conocimiento en fitness para mejorar la experiencia de entrenamiento. Nuestra misión es transformar la forma en que las personas abordan su bienestar físico." => [
            "servicios", "ofertas", "que ofrecen", "que servicios tienen", "actividades", "que actividades tienen", "que tienen", "servicios disponibles", "que clases ofrecen", "servicios del gimnasio", "actividades del gym"
        ],
        "Nuestro aplicativo web, Gym JS, está disponible las 24 horas del día, los 7 días de la semana. Esto te ofrece acceso continuo a nuestra plataforma de entrenamiento y bienestar, permitiéndote disfrutar de nuestros servicios y recursos en cualquier momento que se ajuste a tu horario." => [
            "horarios", "cuando estan abiertos", "hora", "tiempo", "cuando estan abiertos", "que horarios tienen", "apertura", "horas de apertura", "horas de operacion", "horario de apertura", "horario del gimnasio", "horario del gym"
        ],
        "¡En Gym JS, todo es gratis! Accede a entrenamiento personalizado, seguimiento de progreso, asesoramiento y comunidad en línea sin costo alguno. Únete ahora para una vida más activa sin preocupaciones por cargos adicionales." => [
            "precio", "costo", "tarifa", "cuanto cuesta", "precio de membresia", "que precios tienen", "cuanto cuesta", "tarifas de membresia", "costos de membresia", "precios del gimnasio", "precios del gym", "cuanto vale", "costos del gym","prueba", "probar", "dia gratis", "prueba gratuita", "como probar", "visita gratis", "dia de prueba", "dia gratuito", "probar gratis", "visitar gratis", "puedo probar" 
        ],
        "Sí, contamos con entrenadores personales altamente cualificados que pueden ayudarte a alcanzar tus objetivos de fitness de manera efectiva." => [
            "entrenadores", "instructores", "personal", "entrenamiento personal", "coaches", "entrenadores personales", "instructores personales", "entrenador personal", "coach personal", "entrenadores del gimnasio", "entrenadores del gym"
        ],
        "Estamos ubicados en [Calle 18H sur #32-88]." => [
            "direccion", "ubicacion", "donde estan", "como llegar", "direccion del gimnasio", "ubicacion del gimnasio", "direccion del gym", "ubicacion del gym", "donde queda", "donde se encuentra", "direccion exacta", "donde estan ubicados"
        ],
        "Disponemos de una amplia gama de equipos de última generación, incluyendo máquinas cardiovasculares, pesas libres, máquinas de fuerza, y más." => [
            "equipo", "maquinas", "aparatos", "instrumentos", "materiales", "equipo de gimnasio", "maquinas de gimnasio", "aparatos de gimnasio", "equipos disponibles", "equipos del gimnasio", "maquinaria del gimnasio", "equipamiento del gym"
        ],
        "Puedes inscribirte a través de nuestra página web." => [
            "inscripcion", "registrarse", "apuntarse", "como inscribirse", "registro", "inscribirme", "registrarme", "como apuntarse", "inscripcion online", "registro en linea", "inscribirse en la web", "como apuntarse al gimnasio"
        ],
        
        "Ofrecemos rutinas específicas para entrenar en casa, que incluyen ejercicios de peso corporal y el uso de equipamiento básico. Aquí tienes algunas rutinas populares para empezar. Selecciona una para más detalles:" => [
            "ejercicios", "plan de entrenamiento", "asesoramiento de ejercicio", "ayuda para principiantes", "iniciar rutina", "rutinas", "rutina", "plan de ejercicios", "programa de ejercicios", "programa de entrenamiento", "rutinas de inicio", "rutinas para empezar", "ejercicios para principiantes",
            "rutinas en casa", "ejercicios en casa", "entrenar en casa", "plan de entrenamiento en casa", "rutinas de ejercicio para casa", "como entrenar en casa", "programas de ejercicio en casa", "rutinas de fitness en casa"
        ],

        "Para un gimnasio en casa, normalmente necesitas un espacio de al menos 2x2 metros, pero depende del equipo que planeas usar,tambien recomendamos equipos básicos como pesas, bandas de resistencia, una colchoneta de yoga, y una máquina de cardio como una bicicleta estática o una cinta de correr." => [
            "espacio en casa", "cuanto espacio necesito", "gimnasio en casa espacio", "dimensiones para gimnasio en casa", "tamaño de gimnasio en casa", "espacio necesario para gimnasio en casa", "area para gimnasio en casa", "metros para gimnasio en casa",  "equipo para casa", "gimnasio en casa", "equipamiento para casa", "material para gimnasio en casa", "maquinas para casa", "que equipo necesito para un gimnasio en casa", "herramientas de ejercicio para casa", "implementos de gimnasio en casa"
        ],

        "Tener un gimnasio en casa ofrece comodidad y ahorro de tiempo. Puedes entrenar a cualquier hora sin desplazarte. Es importante seguir medidas de seguridad como usar equipo adecuado y mantener el área de entrenamiento limpia y organizada." => [
            "seguridad en casa", "medidas de seguridad en casa", "gimnasio en casa seguro", "como hacer seguro mi gimnasio en casa", "precauciones para gimnasio en casa", "seguridad de gimnasio en casa", "consejos de seguridad para gimnasio en casa", "recomendaciones de seguridad para gimnasio en casa", "beneficios de gimnasio en casa", "ventajas de entrenar en casa", "gimnasio en casa ventajas", "por que tener gimnasio en casa", "beneficios de hacer ejercicio en casa", "razones para gimnasio en casa", "comodidad de gimnasio en casa", "ventajas de gimnasio en casa"
        ],
        "¡Hasta luego! No dudes en contactarnos si tienes más preguntas." => [
            "adios", "hasta luego", "hasta pronto", "nos vemos", "chao", "gracias", "despedida", "bye", "me despido", "gracias por la ayuda", "hablamos luego", "adios gym", "adios gimnasio"
        ],
        // ... más respuestas
    ];
    

    // Buscar la respuesta adecuada
    $response = "Lo siento, no entiendo esa pregunta.";

    foreach ($responses as $reply => $keywords) {
        foreach ($keywords as $keyword) {
            if (strpos($message, $keyword) !== false) {
                $response = $reply;
                break 2; // Rompe ambos bucles
            }
        }
    }

    // Devolver la respuesta
    echo $response;
}
?>
