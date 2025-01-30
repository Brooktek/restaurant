<?php
include '/Models/CartModel.php';
include '/Models/OrderModel.php';
include '/Config/db.php';

class OrderController {
    private $cartModel;
    private $orderModel;

    public function __construct($dbConnection) {
        $this->cartModel = new CartModel($dbConnection);
        $this->orderModel = new OrderModel($dbConnection);
    }

    // Get order history for a specific user
    public function getOrderHistory($userId) {
        return $this->orderModel->getOrderHistory($userId);
    }

    // Place an order
    public function placeOrder($userId, $totalPrice) {
        // Generate a unique order ID
        $orderId = 'ORDER-' . uniqid();

        // Get cart items for the user
        $cartItems = $this->cartModel->getCartItems($userId);

        // Insert each cart item into the orders table
        while ($item = $cartItems->fetch_assoc()) {
            $foodId = $item['food_id'];
            $quantity = $item['quantity'];
            $this->orderModel->createOrder($orderId, $userId, $foodId, $quantity, $totalPrice);
        }

        // Clear the user's cart
        $this->cartModel->clearCart($userId);

        // Redirect to order confirmation page
        header("Location: Views/order-confirmation.php?order_id=$orderId");
        exit();
    }
}

// POST request to place an order
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'user') {
        header("Location: Views/user/login.php");
        exit();
    }

    // Initialize database connection
    $db = new Database();
    $conn = $db->getConnection();

    // Retrieve user inputs
    $userId = $_SESSION['user_id'];
    $totalPrice = $_POST['total_price'];

    // Initialize the order controller and place the order
    $orderController = new OrderController($conn);
    $orderController->placeOrder($userId, $totalPrice);
}

// If not a POST request, fetch the order history
if (isset($_SESSION['user_id'])) {
    $db = new Database();
    $conn = $db->getConnection();

    $orderController = new OrderController($conn);
    $orders = $orderController->getOrderHistory($_SESSION['user_id']);
}
?>
