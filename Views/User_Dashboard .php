<?php
session_start();
if ($_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit();
}

require_once 'controllers/CartController.php';
$cartController = new CartController($_SESSION['user_id']);
$message = '';

// Add to cart functionality
if (isset($_POST['add_to_cart'])) {
    $food_id = intval($_POST['food_id']);
    $message = $cartController->addToCart($food_id);
}

$foods = $cartController->getAvailableFoods();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <h1>Welcome to the Food Ordering Platform</h1>
    <h2>Available Foods</h2>

    <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <div class="food-list">
        <?php while ($food = $foods->fetch_assoc()) { ?>
        <div class="food-item">
            <img src="../uploaded_img/<?php echo $food['image']; ?>" alt="<?php echo $food['name']; ?>" width="150">
            <h3><?php echo $food['name']; ?></h3>
            <p><?php echo $food['description']; ?></p>
            <p>Price: $<?php echo $food['price']; ?></p>
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
