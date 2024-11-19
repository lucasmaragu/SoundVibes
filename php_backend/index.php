<?php
require 'config/session.php';

/*if(!hasRole('user')) {
    header('Location: login.php');
    exit();
}*/

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="stylesheet" href="styles/styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <h1> Hola, <?php echo $_SESSION['username']; ?></h1>
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-sm w-full text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Are you sure you want to log out?</h1>
        <form action="logout.php" method="POST">
            <button class="bg-red-500 text-white py-2 px-4 rounded-lg text-lg font-semibold hover:bg-red-600 transition-colors" type="submit">
                Logout
            </button>
           
        </form>
    </div>

</body>
</html>
