<?php

require_once __DIR__ . '/../Models/CartModel.php';

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
                    error_log("Error: Could not add item to cart.");
                    return "Error: Could not add item to cart.";
                }
            }
        }
        return null;
    }

    // Delete an item from the cart
    public function deleteItem($userId, $foodId) {
        $result = $this->cartModel->removeItemFromCart($userId, $foodId);
        if (!$result) {
            error_log("Error: Could not delete item from cart.");
            return false;
        }
        return true;
    }

    // Get cart items for a specific user
    public function getCartItems($userId) {
        return $this->cartModel->getCartItems($userId);
    }

    // Clear the entire cart for a user
    public function clearCart($userId) {
        $result = $this->cartModel->clearCart($userId);
        if (!$result) {
            error_log("Error: Could not clear cart.");
            return false;
        }
        return true;
    }

       // Get all foods for display
    public function getFoods() {
        return $this->cartModel->getFoods();
    }
}

$db = new Database();
$conn = $db->getConnection();

// Initialize the CartController
$cartController = new CartController($conn);

// Example usage (depends on context, such as a form submission or AJAX call):
$message = null;

// Handle adding to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $message = $cartController->handleAddToCart($_POST, $_SESSION['user_id']);
}

// Fetch all foods (for menu display)
$foods = $cartController->getFoods();

// Fetch cart items for the user
if (isset($_SESSION['user_id'])) {
    $cartItems = $cartController->getCartItems($_SESSION['user_id']);
}


?>
