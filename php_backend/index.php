<?php
// Apertura de etiqueta PHP vacía: puede ser útil si se requiere añadir lógica PHP inicial
// como inicialización de variables, carga de configuraciones, etc.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Metadatos básicos del documento HTML -->
    <meta charset="UTF-8"> <!-- Establece la codificación de caracteres como UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Hace el diseño responsivo -->
    <title>Dashboard de Usuario</title> <!-- Título que aparece en la pestaña del navegador -->
</head>
<body>
    <!-- Encabezado principal de la página -->
    <h1>Selecciona tu estado de ánimo</h1>
    
    <!-- Formulario para seleccionar el estado de ánimo -->
    <form method="POST" action="dashboard.php">
        <!-- Etiqueta para el selector de estados de ánimo -->
        <label for="mood">Estado de ánimo:</label>
        
        <!-- Menú desplegable con opciones de estados de ánimo -->
        <select name="mood" id="mood">
            <option value="feliz">Feliz</option> <!-- Opción para "feliz" -->
            <option value="triste">Triste</option> <!-- Opción para "triste" -->
            <option value="enérgico">Enérgico</option> <!-- Opción para "enérgico" -->
            <option value="relajado">Relajado</option> <!-- Opción para "relajado" -->
        </select>
        
        <!-- Botón para enviar el formulario -->
        <button type="submit">Obtener Recomendaciones</button>
    </form>

    <?php
    // Verifica si el formulario fue enviado mediante el método POST
    // y si el campo "mood" (estado de ánimo) está configurado
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mood"])) {
        // Obtiene el estado de ánimo seleccionado desde el formulario
        $mood = $_POST["mood"];
        
        // Muestra un encabezado con el estado de ánimo seleccionado
        echo "<h2>Recomendaciones para el estado de ánimo: " . htmlspecialchars($mood) . "</h2>";
        
        // Comienza una lista no ordenada para mostrar las recomendaciones musicales
        echo "<ul>";

        // Llama a la función `getMusicRecommendations` para obtener las canciones
        // basadas en el estado de ánimo seleccionado
        $recommendations = getMusicRecommendations($mood);
        
        // Itera sobre las recomendaciones obtenidas y las muestra como elementos de la lista
        foreach ($recommendations as $song) {
            echo "<li>" . htmlspecialchars($song) . "</li>"; // Sanitiza el texto de las canciones
        }
        
        // Cierra la lista no ordenada
        echo "</ul>";
    }

    // Función para obtener recomendaciones musicales según el estado de ánimo
    function getMusicRecommendations($mood) {
        // Biblioteca musical: un array que relaciona estados de ánimo con listas de canciones
        $musicLibrary = [
            "feliz" => ["Happy - Pharrell Williams", "Can't Stop the Feeling - Justin Timberlake"],
            "triste" => ["Someone Like You - Adele", "Fix You - Coldplay"],
            "enérgico" => ["Eye of the Tiger - Survivor", "Don't Stop Me Now - Queen"],
            "relajado" => ["Weightless - Marconi Union", "Clair de Lune - Debussy"],
        ];

        // Devuelve las canciones asociadas al estado de ánimo o
        // un mensaje por defecto si el estado no está definido en la biblioteca
        return $musicLibrary[$mood] ?? ["Sin recomendaciones disponibles"];
    }
    ?>
</body>
</html>
