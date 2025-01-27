<?php
session_start();
@include 'includes/db.php';

if ($_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit();
}

$order_id = $_GET['order_id'];
$user_id = $_SESSION['user_id'];

// Fetch order details
$query = "
    SELECT orders.*, foods.name AS food_name, foods.price AS food_price 
    FROM orders 
    JOIN foods ON orders.food_id = foods.id 
    WHERE orders.order_id = '$order_id' AND orders.user_id = '$user_id'
";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Order Confirmation</h1>
    <h2>Order ID: <?php echo $order_id; ?></h2>
    <p>Thank you for your order! Here are the details:</p>

    <div class="order-details">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="order-item">
            <h3><?php echo $row['food_name']; ?></h3>
            <p>Price: $<?php echo $row['food_price']; ?></p>
            <p>Quantity: <?php echo $row['quantity']; ?></p>
        </div>
        <?php } ?>
    </div>

    <a href="user/dashboard.php" class="btn">Back to Menu</a>
</body>
</html>
