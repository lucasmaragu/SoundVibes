<?php




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Usuario</title>
</head>
<body>
    <h1>Selecciona tu estado de ánimo</h1>
    <form method="POST" action="dashboard.php">
        <label for="mood">Estado de ánimo:</label>
        <select name="mood" id="mood">
            <option value="feliz">Feliz</option>
            <option value="triste">Triste</option>
            <option value="enérgico">Enérgico</option>
            <option value="relajado">Relajado</option>
        </select>
        <button type="submit">Obtener Recomendaciones</button>
    </form>

    <?php
    // Procesar el formulario y mostrar recomendaciones
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mood"])) {
        $mood = $_POST["mood"];
        echo "<h2>Recomendaciones para el estado de ánimo: " . htmlspecialchars($mood) . "</h2>";
        echo "<ul>";

        // Obtener las recomendaciones basadas en el estado de ánimo
        $recommendations = getMusicRecommendations($mood);
        foreach ($recommendations as $song) {
            echo "<li>" . htmlspecialchars($song) . "</li>";
        }
        echo "</ul>";
    }

    // Función para obtener recomendaciones musicales
    function getMusicRecommendations($mood) {
        $musicLibrary = [
            "feliz" => ["Happy - Pharrell Williams", "Can't Stop the Feeling - Justin Timberlake"],
            "triste" => ["Someone Like You - Adele", "Fix You - Coldplay"],
            "enérgico" => ["Eye of the Tiger - Survivor", "Don't Stop Me Now - Queen"],
            "relajado" => ["Weightless - Marconi Union", "Clair de Lune - Debussy"],
        ];

        return $musicLibrary[$mood] ?? ["Sin recomendaciones disponibles"];
    }
    ?>
</body>
</html>
