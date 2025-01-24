<?php
session_start();
@include '../includes/db.php';

if ($_SESSION['user_type'] !== 'user') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch orders for the logged-in user
$orders = mysqli_query($conn, "
    SELECT orders.*, foods.name AS food_name, foods.image 
    FROM orders 
    JOIN foods ON orders.food_id = foods.id 
    WHERE orders.user_id = '$user_id'
    ORDER BY orders.order_date DESC
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order History</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Your Order History</h1>
    <div class="order-list">
        <?php while ($order = mysqli_fetch_assoc($orders)) { ?>
        <div class="order-item">
            <img src="../uploaded_img/<?php echo $order['image']; ?>" alt="<?php echo $order['food_name']; ?>" width="100">
            <h3><?php echo $order['food_name']; ?></h3>
            <p>Quantity: <?php echo $order['quantity']; ?></p>
            <p>Total Price: $<?php echo $order['total_price']; ?></p>
            <p>Order Date: <?php echo $order['order_date']; ?></p>
            <p>Status: <?php echo $order['status']; ?></p>
        </div>
        <?php } ?>
    </div>
    <a href="dashboard.php" class="btn">Back to Menu</a>
</body>
</html>
