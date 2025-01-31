<?php
define('BASE_PATH', dirname(__DIR__));

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

    public function getOrdersByRestaurant($restaurantId) {
        return $this->orderModel->getOrdersByRestaurant($restaurantId);
    }

    public function getOrderHistory($userId) {
        return $this->orderModel->getOrderHistory($userId);
    }

    public function checkout($userId, $totalPrice) { 
        $order_id = 'ORDER-' . uniqid();

        $cartItems  = $this->cartModel->getCartItems($userId);

        foreach ($cartItems  as $item) {
            $this->orderModel->createOrder($order_id, $userId, $item['food_id'], $item['quantity'], $totalPrice);
        }

        //  $this->cartModel->clearCart($userId);

        header("Location: order-confirmation.php?order_id=$order_id");
        exit();
    }

        public function getOrderDetails($orderId, $userId) {
            return $this->orderModel->getOrderDetails($orderId, $userId);
        } 
}
try {
    $db = new Database();
    $conn = $db->getConnection();
    $orderController = new OrderController($conn);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['total_price'])) {
        $userId = $_SESSION['user_id'];
        $totalPrice = filter_var($_POST['total_price'], FILTER_VALIDATE_FLOAT);
        
        if ($totalPrice === false || $totalPrice < 0) {
            die("Invalid total price.");
        }
        $orderController->checkout($userId, $totalPrice);
    }

    if (isset($_SESSION['user_id'])) {
        $orders = $orderController->getOrderHistory($_SESSION['user_id']);
    }

    if (isset($_GET['order_id']) && ctype_alnum($_GET['order_id'])) {
        $orderId = htmlspecialchars($_GET['order_id']);
        $userId = $_SESSION['user_id'];
        $orderDetails = $orderController->getOrderDetails($orderId, $userId);
        include BASE_PATH . '/Views/User/order-confirmation.php';
    }
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    die("An unexpected error occurred.");
}


?>
