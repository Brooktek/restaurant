<?php
session_start();
require_once __DIR__ . '/../../Config/db.php';
require_once __DIR__ . '/../../Controllers/OrderController.php';

// Redirect if the user is not logged in as a restaurant
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'restaurant') {
    header("Location: ../login.php");
    exit();
}

// Initialize database connection
$db = new Database();
$conn = $db->getConnection();

// Initialize OrderController
$orderController = new OrderController($conn);

// Fetch orders for the current restaurant
$restaurantId = $_SESSION['user_id'];
$orders = $orderController->getOrdersByRestaurant($restaurantId);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>
    <link rel="stylesheet" href="../../Public/css/style.css">
</head>
<body>
    <h1>Orders</h1>
    <div class="order-list">
        <?php if ($orders && $orders->num_rows > 0) { ?>
            <?php while ($order = $orders->fetch_assoc()) { ?>
                <div class="order-item">
                    <h3><?php echo htmlspecialchars($order['food_name']); ?></h3>
                    <p>Ordered by: <?php echo htmlspecialchars($order['user_name']); ?></p>
                    <p>Quantity: <?php echo htmlspecialchars($order['quantity']); ?></p>
                    <p>Total Price: $<?php echo htmlspecialchars($order['total_price']); ?></p>
                    <p>Order Date: <?php echo htmlspecialchars($order['order_date']); ?></p>
                    <p>Status: <?php echo htmlspecialchars($order['status']); ?></p>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>No orders found for your restaurant.</p><br>
        <?php } ?>
    </div>
    <a href="dashboard.php" class="btn">Go Back</a>
</body>
</html>