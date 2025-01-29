<?php
require_once 'config/db.php';

class UserModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getUserByEmailAndType($email, $type) {
        $query = "SELECT * FROM users WHERE email = ? AND type = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $email, $type);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function createUser($name, $email, $password, $type) {
        $query = "INSERT INTO users (name, email, password, type) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $name, $email, $password, $type);
        return $stmt->execute();
    }
}
?>