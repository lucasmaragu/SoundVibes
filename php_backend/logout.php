<?php
session_start(); // Inicia la sesión para poder acceder a las variables de sesión

// Elimina la cookie "user_role" configurándola para que caduque en el pasado (un segundo atrás)
setcookie("user_role", '', time() - 3600, "/"); 

// Elimina todas las variables de sesión
session_unset(); 

// Destruye la sesión completamente, eliminando los datos de la sesión en el servidor
session_destroy(); 

// Redirige al usuario a la página de inicio de sesión (login.php)
header("Location: login.php"); 
exit(); // Asegura que no se ejecute más código después de la redirección
?>
