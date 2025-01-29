<?php
session_start();
require_once '../../Config/db.php';
require_once '../../Controllers/CartController.php';

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
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <h1>Welcome to the Food Ordering Platform</h1>
    <h2>Available Foods</h2>

    <!-- Display message if any -->
    <?php if ($message) { echo "<p>$message</p>"; } ?>

    <div class="food-list">
        <?php while ($food = mysqli_fetch_assoc($foods)) { ?>
        <div class="food-item">
            <img src="../uploaded_img/<?php echo $food['image']; ?>" alt="<?php echo $food['name']; ?>" width="150">
            <h3><?php echo $food['name']; ?></h3>
            <p><?php echo $food['description']; ?></p>
            <p>Price: <?php echo $food['price']; ?></p>
            <p>Restaurant: <?php echo $food['restaurant_name']; ?></p>
            <form action="dashboard.php" method="post">
                <input type="hidden" name="food_id" value="<?php echo $food['id']; ?>">
                <input type="submit" name="add_to_cart" value="Add to Cart">
            </form>
        </div>
        <?php } ?>
    </div>

    <a href="../cart.php" class="btn">View Cart</a>
    <footer>
        <p>&copy; 2025 Food Platform. All rights reserved.</p>
        <ul class="footer-links">
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Terms of Service</a></li>
        </ul>
    </footer>
</body>
</html>
