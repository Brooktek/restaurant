<?php
require_once 'Models/CartModel.php';

class CartController {
    private $cartModel;

    public function __construct($dbConnection) {
        $this->cartModel = new CartModel($dbConnection);
    }

    // Handle Add to Cart functionality
    public function handleAddToCart($postData, $userId) {
        if (isset($postData['add_to_cart'])) {
            $foodId = $postData['food_id'];
            $quantity = 1;

            // Check if item is already in cart
            $checkCart = $this->cartModel->checkItemInCart($userId, $foodId);
            if ($checkCart->num_rows > 0) {
                return "This item is already in your cart.";
            } else {
                // Add to cart
                $result = $this->cartModel->addItemToCart($userId, $foodId, $quantity);
                if ($result) {
                    return "Item added to cart!";
                } else {
                    return "Error: Could not add item to cart.";
                }
            }
        }
        return null;
    }

    // Get available foods for display
    public function getFoods() {
        return $this->cartModel->getFoods();
    }
}
?>