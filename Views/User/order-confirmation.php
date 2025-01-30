<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Order Confirmed</h1>
    <p>Your order ID: <?php echo htmlspecialchars($_GET['order_id']); ?></p>
    <a href="../index.php">Return to Home</a>
</body>
</html>
