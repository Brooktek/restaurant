<?php
session_start();
require_once '../includes/db.php';  // Include Database class
require_once '../cart.php';  // Include Cart class
require_once '../Food.php';  // Include Food class

if ($_SESSION['user_type'] !== 'user') {
    header("Location: ../login.php");
    exit();
}

$db = new Database();  // Initialize the Database class
$cartManager = new cart($db, $_SESSION['user_id']);  // Initialize the Cart class with user_id
$foodManager = new Food($db);  // Initialize the Food class

$message = ''; // Initialize message variable

// Add to cart functionality
if (isset($_POST['add_to_cart'])) {
    $user_id = $_SESSION['user_id'];
    $food_id = $_POST['food_id'];

    // Add food to the cart using Cart class
    $message = $cartManager->addToCart($user_id, $food_id);
}
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

    <!-- Display message if exists -->
    <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <div class="food-list">
        <?php
        // Fetch available foods using the Food class
        $foods = $foodManager->getAvailableFoods();
        while ($food = $foods->fetch_assoc()) {
        ?>
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
    
    <a href="../Views/cart.php" class="btn">View Cart</a>

    <footer>
        <p>&copy; 2025 Food Platform. All rights reserved.</p>
        <ul class="footer-links">
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Terms of Service</a></li>
        </ul>
    </footer>

</body>
</html>
