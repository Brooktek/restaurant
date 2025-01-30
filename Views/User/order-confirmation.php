<?php
session_start();

require_once __DIR__ . '/../../Controllers/OrderController.php';

// Redirect if the user is not logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit();
}

// Initialize the controller
$db = new Database();
$conn = $db->getConnection();
$orderController = new OrderController($conn);

// Fetch order details if order_id is provided
if (isset($_GET['order_id'])) {
    $orderId = $_GET['order_id'];
    $userId = $_SESSION['user_id'];
    $orderDetails = $orderController->getOrderDetails($orderId, $userId);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
    <h1>Order Confirmation</h1>

    <h2>Order ID: <?php echo htmlspecialchars($orderId); ?></h2>
    <p>Thank you for your order! Here are the details:</p>

    <div class="order-details">
        <?php if ($orderDetails && $orderDetails->num_rows > 0) { ?>
            <?php while ($row = $orderDetails->fetch_assoc()) { ?>
                <div class="order-item">
                    <h3><?php echo htmlspecialchars($row['food_name']); ?></h3>
                    <p>Price: $<?php echo htmlspecialchars($row['food_price']); ?></p>
                    <p>Quantity: <?php echo htmlspecialchars($row['quantity']); ?></p>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>No order details available.</p>
        <?php } ?>
    </div>

    <a href="user/dashboard.php" class="btn">Back to Menu</a>
</body>
</html>