<?php
class Database {
    private $conn;

    public function __construct() {
        // Database connection logic
        $this->conn = new mysqli('localhost', 'root', '', 'food_ordering');
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>
