<?php
require_once 'db.php';

class Cart {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Get cart items for a user
    public function getCartItems($user_id) {
        $query = "SELECT cart.food_id, food.name, food.price, food.image, cart.quantity
                  FROM cart 
                  JOIN food ON cart.food_id = food.id
                  WHERE cart.user_id = ?";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Delete item from cart
    public function deleteItem($food_id, $user_id) {
        $query = "DELETE FROM cart WHERE food_id = ? AND user_id = ?";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bind_param("ii", $food_id, $user_id);
        $stmt->execute();
    }
}
?>
