<?php
require_once 'config/db.php';

class CartModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Check if the food item is already in the cart
    public function checkItemInCart($userId, $foodId) {
        $query = "SELECT * FROM cart WHERE user_id = ? AND food_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $userId, $foodId);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Add item to the cart
    public function addItemToCart($userId, $foodId, $quantity) {
        $query = "INSERT INTO cart (user_id, food_id, quantity) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $userId, $foodId, $quantity);
        return $stmt->execute();
    }

     // Get available foods
     public function getFoods() {
      $query = "SELECT foods.*, users.name AS restaurant_name FROM foods JOIN users ON foods.restaurant_id = users.id";
      $result = $this->conn->query($query);
      return $result;
  }
}
?>
