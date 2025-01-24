<?php
session_start();
@include 'includes/db.php';
@include 'includes/header.php'; 

if ($_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit();
}

$order_id = $_GET['order_id'];  // Get the order ID passed from PayPal
$user_id = $_SESSION['user_id'];

// Store the order in the database (you should create an orders table)
$query = "INSERT INTO orders (user_id, order_id, total_price, status) VALUES ('$user_id', '$order_id', '$_POST[total_price]', 'Completed')";
mysqli_query($conn, $query);

// Display order confirmation details
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Thank you for your order!</h1>
    <h2>Order ID: <?php echo $order_id; ?></h2>
    <p>Your payment was successful. We will process your order shortly.</p>

    <a href="user/dashboard.php" class="btn">Back to Menu</a>
</body>
</html>
