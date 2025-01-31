<?php
session_start();
define('BASE_PATH', dirname(__DIR__, 2)); 
require_once BASE_PATH . '/Config/db.php';
require_once BASE_PATH . '/Controllers/FoodController.php';

// Redirect if the user is not a restaurant
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'restaurant') {
    header("Location: ../login.php");
    exit();
}

// Initialize database connection
$db = new Database();
$conn = $db->getConnection();

// Initialize RestaurantController
$restaurantController = new FoodController($conn);

// Handle form submission
$message = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_food'])) {
    $message = $restaurantController->handleAddFood($_POST, $_FILES, $_SESSION['user_id']);
}

// Fetch foods for the current restaurant
$foods = $restaurantController->getFoodsByRestaurant($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Dashboard</title>
    <link rel="stylesheet" href="../../Public/css/style.css">
</head>
<body>
    <h1>Restaurant Dashboard</h1>
    <?php if ($message) { echo "<p>$message</p>"; } ?>
    <form action="dashboard.php" method="post" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Food Name" required><br>
        <textarea name="description" placeholder="Description" required></textarea><br><br>
        <input type="number" name="price" step="0.01" placeholder="Price" required><br><br>
        <input type="file" accept="image/png, image/jpeg, image/jpg" name="image" required><br><br>
        <input type="submit" name="add_food" value="Add Food">
    </form>
    <a href="orders.php" class="btn">View Orders</a><br><br>

    <div class="product-display">
        <table class="product-display-table">
            <thead>
                <tr>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Product Description</th>
                    <th>Product Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($foods)) { ?>
                <tr>
                    <td><img src="../../Public/uploaded_img/<?php echo htmlspecialchars($row['image']); ?>" height="100" alt=""></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td>$<?php echo htmlspecialchars($row['price']); ?>/-</td>
                    <td>
                        <a href="admin_update.php?edit=<?php echo $row['id']; ?>" class="btn">Edit</a>
                        <a href="admin_update.php?delete=<?php echo $row['id']; ?>" class="btn">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>