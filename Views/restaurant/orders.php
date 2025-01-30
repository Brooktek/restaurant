<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <h1>Orders</h1>
    <div class="order-list">
        <?php if (!empty($orders)) {  ?>
            <?php foreach ($orders as $order) { ?>
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
            <p>No orders found for your restaurant.</p> 
        <?php } ?>
    </div>
    <a href="../dashboard.php" class="btn">Go Back</a>
</body>
</html>
