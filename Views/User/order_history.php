<?php
session_start();
require_once '../../Config/db.php';
require_once '../../Controllers/OrderController.php';

// Redirect if the user is not logged in as 'user'
if ($_SESSION['user_type'] !== 'user') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="../../Public/css/style.css">
</head>
<body>
    <h3>Your Order History</h3>
    <div class="order-list">
        <?php while ($order = mysqli_fetch_assoc($orders)) { ?>
        <div class="order-item">
            <img src="../../Public/uploaded_img/<?php echo $order['image']; ?>" alt="<?php echo $order['food_name']; ?>" width="100">
            <h3><?php echo $order['food_name']; ?></h3>
            <p>Quantity: <?php echo $order['quantity']; ?></p>
            <p>Total Price: <?php echo $order['total_price']; ?> birr</p>
            <p>Order Date: <?php echo $order['order_date']; ?></p>
            <p>Status: <?php echo $order['status']; ?></p>
        </div>
        <?php } ?>
    </div><br>
    <a href="dashboard.php" class="btn">Back to Menu</a>
</body>
</html>