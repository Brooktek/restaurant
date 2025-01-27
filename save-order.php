<?php
session_start();
@include 'includes/db.php';

if ($_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$total_price = $_POST['total_price'];

// Generate a unique fake order ID
$order_id = 'ORDER-' . uniqid();

// Get cart items for the user
$cart_items = mysqli_query($conn, "
    SELECT food_id, quantity 
    FROM carts 
    WHERE user_id = '$user_id'
");

// Insert each item in the order into the orders table
while ($item = mysqli_fetch_assoc($cart_items)) {
    $food_id = $item['food_id'];
    $quantity = $item['quantity'];

    $query = "INSERT INTO orders (order_id, user_id, food_id, quantity, total_price, order_date, status)
              VALUES ('$order_id', '$user_id', '$food_id', '$quantity', '$total_price', NOW(), 'Pending')";
    mysqli_query($conn, $query);
}

// Clear the user's cart after saving the order
$delete_cart_query = "DELETE FROM carts WHERE user_id = '$user_id'";
mysqli_query($conn, $delete_cart_query);

// Redirect to order confirmation page
header("Location: order-confirmation.php?order_id=$order_id");
exit();
?>
