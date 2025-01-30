<?php
class CartModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
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

    // Get available foods for display
    public function getFoods() {
        $query = "SELECT foods.*, users.name AS restaurant_name FROM foods JOIN users ON foods.restaurant_id = users.id";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }

       // Fetch cart items for the user
    public function getCartItems($userId) {
        $query = "SELECT food_id, quantity FROM cart WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result();
    }

        // Clear the user's cart
        public function clearCart($userId) {
            $query = "DELETE FROM cart WHERE user_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $userId);
            return $stmt->execute();
        }

            // Delete an item from the cart
    public function deleteItem($user_id, $food_id) {
        $query = "DELETE FROM cart WHERE user_id = '$user_id' AND food_id = '$food_id'";
        mysqli_query($this->conn, $query);
    }
}
?>