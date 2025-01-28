<?php
session_start();
require_once '../includes/db.php';  // Include the DB class
require_once '../restaurant/Order.php';  // Include the Order class

// Ensure the user is logged in as a restaurant
if ($_SESSION['user_type'] !== 'restaurant') {
    header("Location: ../login.php");
    exit();
}

$restaurant_id = $_SESSION['user_id']; // Get the restaurant's user ID

// Initialize the Database and Order objects
$db = new Database();
$orderManager = new Order($db, $restaurant_id);

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
        <?php $orderManager->displayOrders(); ?> <!-- Display orders using the method from Order class -->
    </div>
    <a href="dashboard.php" class="btn">Go Back</a>
</body>
</html>
