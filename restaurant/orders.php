<?php
session_start();
@include '../includes/db.php';

if ($_SESSION['user_type'] !== 'restaurant') {
    header("Location: ../login.php");
    exit();
}

$restaurant_id = $_SESSION['user_id'];

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
        <?php while ($order = mysqli_fetch_assoc($orders)) { ?>
        <div class="order-item">
            <h3><?php echo $order['food_name']; ?></h3>
            <p>Ordered by: <?php echo $order['user_name']; ?></p>
            <p>Quantity: <?php echo $order['quantity']; ?></p>
            <p>Total Price: $<?php echo $order['total_price']; ?></p>
            <p>Order Date: <?php echo $order['order_date']; ?></p>
            <p>Status: <?php echo $order['status']; ?></p>
        </div>
        <?php } ?>
    </div>
</body>
</html>
