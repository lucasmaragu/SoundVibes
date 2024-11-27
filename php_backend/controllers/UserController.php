<?php
class UserController {
    // Ruta al archivo JSON donde se almacenan los datos de los usuarios
    private $filePath = 'data/users.json';

    // Método principal para manejar solicitudes
    public function handleRequest() {
        // Configura la respuesta como JSON
        header('Content-Type: application/json');

        // Obtiene la acción desde los datos POST
        $action = $_POST['action'] ?? '';

        // Maneja la acción solicitada según su tipo
        switch ($action) {
            case 'create': // Crear un nuevo usuario
                echo json_encode($this->createUser($_POST['username'], $_POST['password'], $_POST['role']));
                break;
            case 'read': // Leer todos los usuarios
                echo json_encode($this->readUsers());
                break;
            case 'update': // Actualizar un usuario existente
                $result = $this->updateUser($_POST['id'], $_POST['username'], $_POST['role'], $_POST['password']);
                // Devuelve el resultado de la operación
                echo json_encode(['success' => $result, 'message' => $result ? 'Usuario actualizado exitosamente' : 'Error al actualizar usuario']);
                break;
            case 'delete': // Eliminar un usuario por su ID
                $result = $this->deleteUser($_POST['id']);
                // Devuelve el resultado de la operación
                echo json_encode(['success' => $result, 'message' => $result ? 'Usuario eliminado exitosamente' : 'Error al eliminar usuario']);
                break;
            default: // Si la acción no es válida
                echo json_encode(['error' => 'Acción inválida']);
        }
    }
    
    // Método privado para leer datos del archivo JSON
    private function readData() {
        // Si el archivo no existe, devuelve un arreglo vacío
        if (!file_exists($this->filePath)) {
            return []; 
        }

        // Lee el contenido del archivo JSON
        $jsonData = file_get_contents($this->filePath);
        // Convierte los datos JSON a un arreglo asociativo
        $data = json_decode($jsonData, true);
        // Devuelve solo la lista de usuarios, o un arreglo vacío si no existe
        return $data['users'] ?? [];
    }

    // Método privado para escribir datos en el archivo JSON
    private function writeData($users) {
        // Crea un arreglo con la clave 'users' y lo guarda como JSON
        $data = ['users' => $users];
        file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT));
    }

    // Crear un nuevo usuario
    public function createUser($username, $password, $role) {
        // Lee los usuarios existentes
        $users = $this->readData();
        // Calcula un nuevo ID basado en el máximo ID existente
        $newId = count($users) > 0 ? max(array_column($users, 'id')) + 1 : 1;

        // Crea un nuevo usuario con los datos proporcionados
        $newUser = [
            "id" => $newId,
            "username" => $username,
            "password" => $password,  // Nota: En un entorno real, no se debería almacenar contraseñas sin encriptar.
            "role" => $role,
        ];

        // Agrega el nuevo usuario a la lista y guarda los datos
        $users[] = $newUser;
        $this->writeData($users);

        // Devuelve el nuevo usuario creado
        return $newUser;
    }

    // Leer todos los usuarios
    public function readUsers() {
        return $this->readData();
    }

    // Actualizar un usuario existente
    public function updateUser($id, $newName, $newRole, $newPassword) {
        // Lee los usuarios existentes
        $users = $this->readData();

        // Encuentra el índice del usuario con el ID proporcionado
        $userIndex = array_search($id, array_column($users, 'id'));

        if ($userIndex !== false) {
            // Actualiza los datos del usuario en la lista
            $users[$userIndex]['username'] = $newName;
            $users[$userIndex]['role'] = $newRole;
            $users[$userIndex]['password'] = $newPassword;
            
            // Guarda los cambios en el archivo JSON
            $this->writeData($users);

            return true; // Indica éxito
        }

        return false; // No se encontró el usuario
    }

    // Eliminar un usuario por su ID
    public function deleteUser($id) {
        // Lee los usuarios existentes
        $users = $this->readData();

        // Encuentra el índice del usuario con el ID proporcionado
        $userIndex = array_search($id, array_column($users, 'id'));

        if ($userIndex !== false) {
            // Elimina al usuario de la lista
            unset($users[$userIndex]);

            // Reindexa el arreglo para evitar inconsistencias
            $users = array_values($users);

            // Guarda los cambios en el archivo JSON
            $this->writeData($users);

            return true; // Indica éxito
        }

        return false; // No se encontró el usuario
    }
}
