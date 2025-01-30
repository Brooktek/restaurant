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
    public function checkout($userId, $totalPrice) { 
        // Generate a unique order ID
        $order_id = 'ORDER-' . uniqid();

        // Get cart items for the user
        $cartItems  = $this->cartModel->getCartItems($userId);

        // Insert each item in the order into the orders table
        foreach ($cartItems  as $item) {
            $this->orderModel->createOrder($order_id, $userId, $item['food_id'], $item['quantity'], $totalPrice);
        }

        // Clear the user's cart
        $this->cartModel->clearCart($userId);

        // Redirect to order confirmation page
        header("Location: order-confirmation.php?order_id=$order_id");
        exit();
    }

        // Fetch the details of a specific order for the user
        public function getOrderDetails($orderId, $userId) {
            return $this->orderModel->getOrderDetails($orderId, $userId);
        } 
}
    // Initialize database connection
    $db = new Database();
    $conn = $db->getConnection();

    $orderController = new OrderController($conn);


// Handle checkout if POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['total_price'])) {
    $userId = $_SESSION['user_id'];
    $totalPrice = $_POST['total_price'];
    $orderController->checkout($userId, $totalPrice);
}

// Fetch order history if user is logged in
if (isset($_SESSION['user_id'])) {
    $orders = $orderController->getOrderHistory($_SESSION['user_id']);
}

// Handle order confirmation page
if (isset($_GET['order_id'])) {
    $orderId = $_GET['order_id'];
    $userId = $_SESSION['user_id'];
    $orderDetails = $orderController->getOrderDetails($orderId, $userId);
    include BASE_PATH . '/Views/User/order-confirmation.php';
}

?>
