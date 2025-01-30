<?php
session_start();

include '../../Models/CartModel.php';
include '../../Controllers/OrderController.php';
include '../../Config/db.php';

// Ensure user is logged in
if ($_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];


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

       // Delete an item from the cart
       public function deleteItem($user_id, $food_id) {
        $this->cartModel->deleteItem($user_id, $food_id);
    }
    
}

$db = new Database();
$conn = $db->getConnection();

// Initialize the controller
$cartController = new CartController($conn);

// Handle Add to Cart functionality
$message = $cartController->handleAddToCart($_POST, $_SESSION['user_id']);

// Get the list of available foods
$foods = $cartController->getFoods();
?>