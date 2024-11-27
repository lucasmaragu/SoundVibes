<?php 
session_start(); // Inicia la sesión, lo que permite acceder a la variable $_SESSION
ob_start(); // Comienza el almacenamiento en búfer de la salida (para enviar cabeceras después si es necesario)

function login($user) {
    // Función para guardar la información del usuario en la sesión y establecer una cookie para el rol.
    $_SESSION['user_id'] = $user['id']; // Guarda el ID del usuario en la sesión
    $_SESSION['username'] = $user['username']; // Guarda el nombre de usuario en la sesión
    $_SESSION['role'] = $user['role']; // Guarda el rol del usuario en la sesión
    setcookie("user_role", $_SESSION['role'], time() + (86400 * 30), "/"); // Establece una cookie para el rol del usuario (durante 30 días)
}

function loadUsers() {
    // Función que carga los usuarios desde un archivo JSON y lo decodifica en un array
    $json = file_get_contents('data/users.json'); // Obtiene el contenido del archivo users.json
    return json_decode($json, true); // Decodifica el contenido JSON y lo devuelve como un array asociativo
}

// Verifica si la solicitud es un POST, lo cual indica que el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si se han enviado los campos 'username' y 'password' desde el formulario
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Asigna los valores de los campos a variables locales
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Carga todos los usuarios desde el archivo JSON
        $users = loadUsers();
        
        // Verifica si la estructura de usuarios es válida
        if (!isset($users['users']) || !is_array($users['users'])) {
            // Si no es válida, muestra un mensaje de error y termina la ejecución
            echo "<div class='text-red-500 text-center mt-4'>Error al cargar usuarios.</div>";
            exit();
        }

        // Busca al usuario que coincida con el nombre de usuario y contraseña
        $foundUser = null;
        foreach ($users['users'] as $user) { 
            if ($user['username'] === $username && $user['password'] === $password) {
                // Si el usuario es encontrado, asigna el usuario a la variable $foundUser
                $foundUser = $user;
                break;
            }
        }

        // Si se encuentra al usuario
        if ($foundUser) {
            // Llama a la función login para iniciar la sesión
            login($foundUser);

            // Redirige al usuario según su rol
            if ($foundUser['role'] === 'admin') {
                // Si el rol es 'admin', redirige al dashboard de administración
                header('Location: dashboard.php');
                exit(); // Asegura que no se ejecute código después de la redirección
            } else {
                // Si el rol no es 'admin', redirige al jukebox
                header('Location: jukebox.php');
                exit(); // Detiene la ejecución del script para evitar que se siga procesando
            }
        } else {
            // Si no se encuentra al usuario, muestra un mensaje de error
            echo "<div class='text-red-500 text-center mt-4'>Usuario o contraseña incorrectos.</div>";
        }
    } else {
        // Si no se envían el nombre de usuario o la contraseña, muestra un mensaje de error
        echo "<div class='text-red-500 text-center mt-4'>Por favor, ingresa tu nombre de usuario y contraseña.</div>";
    }
}
ob_end_flush(); // Envía el contenido del búfer de salida y desactiva el almacenamiento en búfer
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Define la codificación de caracteres como UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Hace la página responsiva -->
    <title>Login</title> <!-- Título que aparece en la pestaña del navegador -->
    
    <!-- Carga el archivo de estilos CSS personalizado -->
    <link rel="stylesheet" href="styles/styles.css">
    
    <!-- Carga la librería TailwindCSS para utilizar clases de estilo rápidas -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <!-- Clase "bg-gray-100": Fondo gris claro -->
    <!-- Clase "flex justify-center items-center": Centra el contenido en el eje horizontal y vertical -->
    <!-- Clase "min-h-screen": Asegura que el contenedor ocupe al menos toda la altura de la pantalla -->
    
    <!-- Contenedor principal para el formulario de inicio de sesión -->
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-sm w-full text-center">
        <!-- Clase "bg-white": Fondo blanco -->
        <!-- Clase "p-8": Padding de 8 unidades -->
        <!-- Clase "rounded-lg": Bordes redondeados -->
        <!-- Clase "shadow-lg": Sombra alrededor del cuadro -->
        <!-- Clase "max-w-sm": Máximo ancho pequeño -->
        <!-- Clase "w-full": Ancho completo del contenedor -->
        <!-- Clase "text-center": Centra el texto -->

        <!-- Título del formulario -->
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Login</h1>
        <!-- Clase "text-3xl": Tamaño de texto grande -->
        <!-- Clase "font-bold": Texto en negrita -->
        <!-- Clase "text-gray-800": Texto gris oscuro -->
        <!-- Clase "mb-6": Margen inferior de 6 unidades -->

        <!-- Formulario de inicio de sesión -->
        <form method="POST">
            <!-- Campo de entrada para el nombre de usuario -->
            <div class="mb-4">
                <input type="text" name="username" placeholder="Username" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                <!-- Clase "w-full": Ancho completo -->
                <!-- Clase "px-4 py-2": Padding en los ejes horizontal y vertical -->
                <!-- Clase "border": Borde del campo de entrada -->
                <!-- Clase "rounded-lg": Bordes redondeados -->
                <!-- Clase "focus:outline-none": Elimina el borde de enfoque por defecto -->
                <!-- Clase "focus:ring-2": Anima un anillo de enfoque de 2 píxeles -->
                <!-- Clase "focus:ring-blue-400": Color azul para el anillo de enfoque -->
            </div>

            <!-- Campo de entrada para la contraseña -->
            <div class="mb-6">
                <input type="password" name="password" placeholder="Password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <!-- Botón de envío para iniciar sesión -->
            <button type="submit" class="w-full py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">Login</button>
            <!-- Clase "w-full": Ancho completo -->
            <!-- Clase "py-2": Padding en el eje vertical -->
            <!-- Clase "bg-blue-500": Fondo azul -->
            <!-- Clase "text-white": Texto blanco -->
            <!-- Clase "rounded-lg": Bordes redondeados -->
            <!-- Clase "hover:bg-blue-600": Cambia a un azul más oscuro al pasar el ratón -->
            <!-- Clase "transition-colors": Transición suave de colores -->
        </form>

        <?php
        // Si se envió el formulario y no se encontró al usuario, muestra un mensaje de error
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($foundUser)) {
            echo "<div class='text-red-500 mt-4'>Usuario o contraseña incorrectos.</div>";
        }
        ?>
    </div>
</body>
</html>
