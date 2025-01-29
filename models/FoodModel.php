<?php
class FoodModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Add a new food item
    public function addFood($restaurantId, $name, $description, $price, $image) {
        $query = "INSERT INTO foods (restaurant_id, name, description, price, image) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("issds", $restaurantId, $name, $description, $price, $image);
        return $stmt->execute();
    }

    // Fetch all foods for a specific restaurant
    public function getFoodsByRestaurant($restaurantId) {
        $query = "SELECT * FROM foods WHERE restaurant_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $restaurantId);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>