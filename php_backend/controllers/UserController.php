<?php
class UserController {
    private $filePath = 'data/users.json';

    
    private function readData() {
        if (!file_exists($this->filePath)) {
            return []; 
        }

        $jsonData = file_get_contents($this->filePath);
        $data = json_decode($jsonData, true);
        return $data['users'] ?? [];
    }

   
    private function writeData($users) {
        $data = ['users' => $users];
        file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT));
    }

    
    public function createUser($username, $password) {
        $users = $this->readData();
        $newId = count($users) > 0 ? max(array_column($users, 'id')) + 1 : 1;
        
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $newUser = [
            "id" => $newId,
            "username" => $username,
            "password" => $hashedPassword,  
            "role" => "user"
        ];
        
        $users[] = $newUser;
        $this->writeData($users);
        return $newUser;
    }

    
    public function readUsers() {
        return $this->readData();
    }

    
    public function updateUser($id, $newName, $newPassword) {
        $users = $this->readData();
        $userIndex = array_search($id, array_column($users, 'id'));

        if ($userIndex !== false) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $users[$userIndex]['username'] = $newName;
            $users[$userIndex]['password'] = $hashedPassword; 
            $this->writeData($users);
            return true;
        }
        return false;
    }

    public function deleteUser($id) {
        $users = $this->readData();
        $userIndex = array_search($id, array_column($users, 'id'));

        if ($userIndex !== false) {
            unset($users[$userIndex]);
            $users = array_values($users);
            $this->writeData($users);
            return true;
        }
        return false;
    }
}
