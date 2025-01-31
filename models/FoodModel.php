<?php
require_once __DIR__ . '/../Config/db.php';

class FoodModel extends Database {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Add a new food item
    public function addFood($restaurantId, $name, $description, $price, $image) {
        $query = "INSERT INTO foods (restaurant_id, name, description, price, image) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("issds", $restaurantId, $name, $description, $price, $image);
        return $stmt->execute();
    }

    // Get all foods for a specific restaurant
    public function getFoodsByRestaurant($restaurantId) {
        $query = "SELECT * FROM foods WHERE restaurant_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $restaurantId);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Get details of a specific food item
    public function getFoodDetails($id) {
        $query = "SELECT * FROM foods WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Update a food item
    public function updateFood($id, $name, $description, $price, $image) {
        $query = "UPDATE foods SET name = ?, description = ?, price = ?, image = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssdsi", $name, $description, $price, $image, $id);
        return $stmt->execute();
    }

    // Delete a food item
    public function deleteFood($id) {
        // Delete related orders first
        $deleteOrders = $this->conn->prepare("DELETE FROM orders WHERE food_id = ?");
        $deleteOrders->bind_param("i", $id);
        $deleteOrders->execute();

        // Then delete the food
        $stmt = $this->conn->prepare("DELETE FROM foods WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}