<?php
require './controllers/UserController.php';
require './logout.php';
require './config/session.php';



function isAdmin() {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
        echo "Sesión no válida. Redirigiendo a login.";
        return false;
    }
    if ($_SESSION['role'] !== 'admin') {
        echo "No eres administrador. Rol actual: " . $_SESSION['role'];
        return false;
    }
    return true;
}

if (!isAdmin()) {
    header('Location: login.php');
    exit();
}

$userController = new UserController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $userController->createUser($_POST['name'], $_POST['email']);
    } elseif (isset($_POST['update'])) {
        $userController->updateUser($_POST['id'], $_POST['new_name'], $_POST['new_email']);
    }
}

if (isset($_GET['delete'])) {
    $userController->deleteUser($_GET['delete']);
}

$users = $userController->readUsers();


?>

<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-full">
    <div class="min-h-full">
        <div class="bg-indigo-600 pb-32">
            <nav class="border-b border-indigo-300 border-opacity-25 bg-indigo-600 lg:border-none">
                <div class="mx-auto max-w-7xl px-2 sm:px-4 lg:px-8">
                    <div class="relative flex h-16 items-center justify-between lg:border-b lg:border-indigo-400 lg:border-opacity-25">
                        <div class="flex items-center px-2 lg:px-0">
                        <form action="logout.php" method="POST">
                            <button   type="submit" name="logout" class="bg-red-800 rounded-lg py-2 px-4 text-sm text-white font-medium ">
                                Logout</button>
                        </form>
                        </div>
                    </div>
                </div>
            </nav>
            <header class="py-10">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold tracking-tight text-white">User Management Dashboard</h1>
                </div>
            </header>
        </div>

        <main class="-mt-32">
            <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
                <div class="rounded-lg bg-white px-5 py-6 shadow sm:px-6">
                    <div id="create" class="mb-12">
                        <h2 class="text-xl font-semibold mb-6">Create New User</h2>
                        <form method="POST" class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            </div>
                            <button type="submit" name="create" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Create User</button>
                        </form>
                    </div>

                    <div id="users">
                        <h2 class="text-xl font-semibold mb-6">User List</h2>
                        <div class="mt-8 flex flex-col">
                            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-300">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">ID</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Name</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                        <span class="sr-only">Actions</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 bg-white">
                                                <?php foreach ($users as $user): ?>
                                                    <tr>
                                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                            <?= isset($user['id']) ? htmlspecialchars($user['id']) : 'N/A' ?>
                                                        </td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                            <?= isset($user['username']) ? htmlspecialchars($user['username']) : 'N/A' ?>
                                                        </td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                            <?= isset($user['role']) ? htmlspecialchars($user['role']) : 'N/A' ?>
                                                        </td>
                                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                            <button type="button" onclick="openUpdateForm('<?= isset($user['id']) ? htmlspecialchars($user['id']) : '' ?>', '<?= isset($user['username']) ? htmlspecialchars($user['username']) : '' ?>', '<?= isset($user['password']) ? htmlspecialchars($user['password']) : '' ?>')" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                                            <a href="?delete=<?= isset($user['id']) ? htmlspecialchars($user['id']) : '' ?>" class="text-red-600 hover:text-red-900 ml-4">Delete</a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    
    <div id="updateModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center">
        <div class="bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full sm:p-6">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Update User</h3>
                <form method="POST">
                    <input type="hidden" name="id" id="updateId">
                    <div class="mb-4">
                        <label for="updateName" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="new_name" id="updateName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    </div>
                    <div class="mb-4">
                        <label for="updateEmail" class="block text-sm font-medium text-gray-700">Role</label>
                        <input type="text" name="new_email" id="updateEmail" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    </div>
                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                        <button type="submit" name="update" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">Update User</button>
                        <button type="button" onclick="closeUpdateForm()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openUpdateForm(id, username, password) {
            document.getElementById('updateId').value = id;
            document.getElementById('updateName').value = username;
            document.getElementById('updateEmail').value = password;
            document.getElementById('updateModal').classList.remove('hidden');
        }

        function closeUpdateForm() {
            document.getElementById('updateModal').classList.add('hidden');
        }
    </script>
</body>

</html>