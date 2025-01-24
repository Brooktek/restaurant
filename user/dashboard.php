<?php
session_start();
@include '../includes/db.php';

if ($_SESSION['user_type'] !== 'user') {
    header("Location: ../login.php");
    exit();
}
@include '../includes/header.php'; 

// Add to cart functionality
if (isset($_POST['add_to_cart'])) {
    $user_id = $_SESSION['user_id'];
    $food_id = $_POST['food_id'];
    $quantity = 1; // Default quantity
    
    $check_cart = mysqli_query($conn, "SELECT * FROM carts WHERE user_id='$user_id' AND food_id='$food_id'");
    if (mysqli_num_rows($check_cart) > 0) {
        echo "<p>This item is already in your cart.</p>";
    } else {
        mysqli_query($conn, "INSERT INTO carts (user_id, food_id, quantity) VALUES ('$user_id', '$food_id', '$quantity')");
        echo "<p>Item added to cart!</p>";
    }
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
    <div class="food-list">
        <?php
        $foods = mysqli_query($conn, "SELECT foods.*, users.name AS restaurant_name FROM foods JOIN users ON foods.restaurant_id = users.id");
        while ($food = mysqli_fetch_assoc($foods)) {
        ?>
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
