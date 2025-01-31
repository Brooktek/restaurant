<?php
session_start();
define('BASE_PATH', dirname(__DIR__, 2)); // Go two levels up to the project root
include BASE_PATH . '/Config/db.php';
include BASE_PATH . '/Controllers/CartController.php';

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
    <link rel="stylesheet" href="../../Public/css/style.css">
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
        <img src="../../Public/uploaded_img/<?php echo $food['image']; ?>" alt="<?php echo $food['name']; ?>" width="150">
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
    <?php if ($message) { echo "<p>$message</p>"; } ?>

    <a href="cart.php" class="btn">View Cart</a>
    
</body>
</html>