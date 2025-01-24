<?php
session_start();
$user_name = $_SESSION['user_name'] ?? 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"> 
    <title>Food Ordering Website</title>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="index.php">FoodieApp</a>
            </div>
            <ul class="menu">
                <li><a href="user_dashboard.php">Home</a></li>
                <li><a href="../cart.php">My Cart</a></li>
                <li><a href="order_history.php">Order History</a></li>
                <li><a href="logout.php">Logout (<?php echo htmlspecialchars($user_name); ?>)</a></li>
            </ul>
        </nav>
    </header>
