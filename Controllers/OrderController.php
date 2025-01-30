<?php

// Define a constant for the base directory
define('BASE_PATH', dirname(__DIR__));

// Use absolute paths for includes
include BASE_PATH . '/Models/CartModel.php';
include BASE_PATH . '/Models/OrderModel.php';
require_once BASE_PATH . '/Config/db.php';

class OrderController {
    private $cartModel;
    private $orderModel;

    // Constructor to inject dependencies (Database connection)
    public function __construct($dbConnection) {
        $this->cartModel = new CartModel($dbConnection);
        $this->orderModel = new OrderModel($dbConnection);
    }

    // Get order history for a specific user
    public function getOrderHistory($userId) {
        return $this->orderModel->getOrderHistory($userId);
    }

    // Handle checkout process
    public function checkout() {
        // Redirect if the user is not logged in as 'user'
        if ($_SESSION['user_type'] !== 'user') {
            header("Location: login.php");
            exit();
        }

        // Get user_id and total_price from POST request
        $user_id = $_SESSION['user_id'];
        $total_price = $_POST['total_price']; 

        // Generate a unique order ID
        $order_id = 'ORDER-' . uniqid();

        // Get cart items for the user
        $cart_items = $this->cartModel->getCartItems($user_id);

        // Insert each item in the order into the orders table
        foreach ($cart_items as $item) {
            $this->orderModel->createOrder($order_id, $user_id, $item['food_id'], $item['quantity'], $total_price);
        }

        // Clear the user's cart
        $this->cartModel->clearCart($user_id);

        // Redirect to order confirmation page
        header("Location: order-confirmation.php?order_id=$order_id");
        exit();
    }
}

// If not a POST request, fetch the order history
if (isset($_SESSION['user_id'])) {
    $db = new Database();
    $conn = $db->getConnection();

    $orderController = new OrderController($conn);
    $orders = $orderController->getOrderHistory($_SESSION['user_id']);
}

?>
