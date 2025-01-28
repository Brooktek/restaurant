<?php
require_once '../includes/db.php';
require_once '../cart.php';
require_once '../Food.php';

class CartController {
    private $db;
    private $cartManager;
    private $foodManager;

    public function __construct($user_id) {
        $this->db = new Database();
        $this->cartManager = new Cart($this->db, $user_id);
        $this->foodManager = new Food($this->db);
    }

    public function addToCart($food_id) {
        return $this->cartManager->addToCart($food_id);
    }

    public function getCartItems() {
        return $this->cartManager->getCartItems();
    }

    public function deleteItem($food_id) {
        return $this->cartManager->deleteCartItem($food_id);
    }

    public function getAvailableFoods() {
        return $this->foodManager->getAvailableFoods();
    }
}
?>
