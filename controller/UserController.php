<?php
include_once '../config/Database.php';

class UserController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function createUser($name, $email, $password) {
        $query = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
        if ($stmt->execute()) {
            return json_encode(["message" => "User created successfully"]);
        } else {
            return json_encode(["message" => "Error creating user"]);
        }
    }

    public function getUsers() {
        $query = "SELECT id, name, email FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function updateUser($id, $name, $email) {
        $query = "UPDATE users SET name = :name, email = :email WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        if ($stmt->execute()) {
            return json_encode(["message" => "User updated successfully"]);
        } else {
            return json_encode(["message" => "Error updating user"]);
        }
    }

    public function deleteUser($id) {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return json_encode(["message" => "User deleted successfully"]);
        } else {
            return json_encode(["message" => "Error deleting user"]);
        }
    }
}
?>
