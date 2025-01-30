<?php
session_start();
define('BASE_PATH', dirname(__DIR__, 2)); // Go two levels up to the project root
require_once BASE_PATH . '/Config/db.php';
require_once BASE_PATH . '/Controllers/RestaurantController.php';

if ($_SESSION['user_type'] !== 'restaurant') {
    header("Location: ../login.php");
    exit();
}


$foods = $restaurantController->getFoodsByRestaurant($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Dashboard</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>

    <h1>Restaurant Dashboard</h1>
    <form action="dashboard.php" method="post" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Food Name" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="number" name="price" placeholder="Price" required>
        <input type="file" accept="image/png, image/jpeg, image/jpg" name="image" required>
        <input type="submit" name="add_food" value="Add Food">
    </form>
    <a href="orders.php" class="btn">View Orders</a>

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
            <?php while($row = mysqli_fetch_assoc($foods)){ ?>
            <tr>
                <td><img src="../public/uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td>$<?php echo $row['price']; ?>/-</td>
                <td>
                    <a href="admin_update.php?edit=<?php echo $row['id']; ?>" class="btn">Edit</a>
                    <a href="admin_update.php?delete=<?php echo $row['id']; ?>" class="btn">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>