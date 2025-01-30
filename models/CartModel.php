<?php
class CartModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Add item to the cart
    public function addItemToCart($userId, $foodId, $quantity) {
        $query = "INSERT INTO cart (user_id, food_id, quantity) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $userId, $foodId, $quantity);

        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Error in addItemToCart: " . $stmt->error);
            return false;
        }
    }

    // Check if an item is already in the cart
    public function checkItemInCart($userId, $foodId) {
        $query = "SELECT * FROM cart WHERE user_id = ? AND food_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $userId, $foodId);

        if ($stmt->execute()) {
            return $stmt->get_result();
        } else {
            error_log("Error in checkItemInCart: " . $stmt->error);
            return false;
        }
    }

    // Fetch all cart items for a specific user
    public function getCartItems($userId) {
        $query = "SELECT cart.*, foods.name, foods.price, foods.image 
                  FROM cart 
                  JOIN foods ON cart.food_id = foods.id 
                  WHERE cart.user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            return $stmt->get_result();
        } else {
            error_log("Error in getCartItems: " . $stmt->error);
            return false;
        }
    }

    // Remove an item from the cart
    public function removeItemFromCart($userId, $foodId) {
        $query = "DELETE FROM cart WHERE user_id = ? AND food_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $userId, $foodId);

        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Error in removeItemFromCart: " . $stmt->error);
            return false;
        }
    }

    // Clear all items from the user's cart
    public function clearCart($userId) {
        $query = "DELETE FROM cart WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Error in clearCart: " . $stmt->error);
            return false;
        }
    }

    // Fetch all available foods
    public function getFoods() {
        $query = "SELECT * FROM foods";
        $result = $this->conn->query($query);

        if ($result) {
            return $result;
        } else {
            error_log("Error in getFoods: " . $this->conn->error);
            return false;
        }
    }
}
?>
