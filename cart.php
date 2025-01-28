<?php
class Cart {
    private $db;
    private $user_id;

    public function __construct($db, $user_id) {
        $this->db = $db;
        $this->user_id = $user_id;
    }

    // Add food to the cart
    public function addToCart($food_id): string {
        // Check if the food item is already in the cart for the user
        $checkQuery = "SELECT * FROM cart WHERE user_id = ? AND food_id = ?";
        $stmt = $this->db->getConnection()->prepare($checkQuery);
        $stmt->bind_param("ii", $this->user_id, $food_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return "Item is already in the cart.";
        }
            $foodD = 12;
        // If not in the cart, add the item
        $query = "INSERT INTO cart (food_id, user_id) VALUES (?, ?)";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bind_param("ii", $this->user_id, $foodD);

        if ($stmt->execute()) {
            return "Item added to cart.";
        } else {
            return "Error adding item to cart.";
        }
    }

    // Get all cart items for a specific user
    public function getCartItems() {
        $query = "SELECT cart.*, foods.name, foods.price, foods.image 
                  FROM cart 
                  JOIN foods ON cart.food_id = foods.id 
                  WHERE cart.user_id = ?";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bind_param("i", $this->user_id);
        $stmt->execute();
        return $stmt->get_result();  // Return the result set
    }

    // Delete an item from the cart
    public function deleteCartItem($food_id) {
        $query = "DELETE FROM cart WHERE user_id = ? AND food_id = ?";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bind_param("ii", $this->user_id, $food_id);

        if ($stmt->execute()) {
            return "Item removed from cart.";
        } else {
            return "Error removing item from cart.";
        }
    }
}

