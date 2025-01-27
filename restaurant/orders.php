<?php
session_start();
@include '../includes/db.php';

// Ensure the user is logged in as a restaurant
if ($_SESSION['user_type'] !== 'restaurant') {
    header("Location: ../login.php");
    exit();
}

$restaurant_id = $_SESSION['user_id']; // Get the restaurant's user ID

// Query to fetch orders for the specific restaurant
$orders = mysqli_query($conn, "
    SELECT orders.*, users.name AS user_name, foods.name AS food_name 
    FROM orders 
    JOIN foods ON orders.food_id = foods.id 
    JOIN users ON orders.user_id = users.id 
    WHERE foods.restaurant_id = '$restaurant_id'
    ORDER BY orders.order_date DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Orders</h1>
    <div class="order-list">
        <?php 
        if (mysqli_num_rows($orders) > 0) { // Check if there are any orders
            while ($order = mysqli_fetch_assoc($orders)) { ?>
                <div class="order-item">
                    <h3><?php echo $order['food_name']; ?></h3>
                    <p>Ordered by: <?php echo $order['user_name']; ?></p>
                    <p>Quantity: <?php echo $order['quantity']; ?></p>
                    <p>Total Price: $<?php echo $order['total_price']; ?></p>
                    <p>Order Date: <?php echo $order['order_date']; ?></p>
                    <p>Status: <?php echo $order['status']; ?></p>
                </div>
            <?php } 
        } else { ?>
            <p>No orders found for your restaurant.</p> <!-- Message if no orders are found -->
        <?php } ?>
    </div>
    <a href="dashboard.php" class="btn">Go Back</a>
</body>
</html>
