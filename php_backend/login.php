<?php
ob_start();

function login($user)
{

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    
    setcookie("user_role", $_SESSION['role'],  time() + (86400 * 30), "/");


}





function loadUsers()
{
    $json = file_get_contents('data/users.json');
    return json_decode($json, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        
        $users = loadUsers();
        if (!isset($users['users']) || !is_array($users['users'])) {
            echo "<div class='text-red-500 text-center mt-4'>Error al cargar usuarios.</div>";
            exit();
        }
        $foundUser = null;

        
        foreach ($users['users'] as $user) { 
            if ($user['username'] === $username && $user['password'] === $password) {
                $foundUser = $user;
                break;
            }
        }

        
        if ($foundUser) {
            login($foundUser);
            var_dump($_SESSION);
            if ($foundUser['role'] === 'admin') {
                header('Location: dashboard.php'); 
            } else {
                header('Location: jukebox.php'); 
            }
            exit();
        } else {
            echo "<div class='text-red-500 text-center mt-4'>Error al iniciar sesión. Intenta de nuevo.</div>";
        }
    } else {
        echo "<div class='text-red-500 text-center mt-4'>Por favor, ingresa tu nombre de usuario y contraseña.</div>";
    }
}
ob_end_flush(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles/styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-lg max-w-sm w-full text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Login</h1>

        
        <form method="POST">
            <div class="mb-4">
                <input type="text" name="username" placeholder="Username" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>
            <div class="mb-6">
                <input type="password" name="password" placeholder="Password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>
            <button type="submit" class="w-full py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">Login</button>
        </form>
        
     
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($foundUser)) {
            echo "<div class='text-red-500 mt-4'>Usuario o contraseña incorrectos</div>";
        }
        ?>
    </div>

</body>
</html>
