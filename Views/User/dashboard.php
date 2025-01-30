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
    <link rel="stylesheet" href="../../public/css/style.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color:rgba(244, 244, 244, 0.29);
            text-align: center;
        }

        h1 {
            background-color: #ff6600;
            color: white;
            padding: 20px;
            margin: 0;
            font-size: 28px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        h2 {
            margin: 20px 0;
            color: #333;
        }

        .food-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }

        .food-item {
            background: white;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 280px;
            transition: transform 0.2s ease-in-out;
        }

        .food-item:hover {
            transform: scale(1.05);
        }

        .food-item img {
            width: 100%;
            border-radius: 8px;
        }

        .food-item h3 {
            margin: 10px 0;
            color: #ff6600;
        }

        .food-item p {
            margin: 5px 0;
            color: #555;
        }

        .add-to-cart {
            background: #ff6600;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .add-to-cart:hover {
            background: #cc5200;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            margin: 20px;
            background: #007bff;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-size: 16px;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background: #0056b3;
        }

        footer {
            background: #333;
            color: white;
            padding: 15px;
            margin-top: 20px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            display: inline;
            margin: 0 10px;
        }

        .footer-links a {
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <h1>Welcome to the Food Ordering Platform</h1>
    <h2>Available Foods</h2>

    <!-- Food List -->
    <div class="food-list">
    <?php
        $foods = mysqli_query($conn, "SELECT foods.*, users.name AS restaurant_name FROM foods JOIN users ON foods.restaurant_id = users.id");
        while ($food = mysqli_fetch_assoc($foods)) {
    ?>       
        <div class="food-item">
            <img src="../public/uploaded_img/<?php echo $food['image']; ?>" alt="<?php echo $food['name']; ?>">
            <h3><?php echo $food['name']; ?></h3>
            <p><?php echo $food['description']; ?></p>
            <p><strong>Price:</strong> $<?php echo $food['price']; ?></p>
            <p><strong>Restaurant:</strong> <?php echo $food['restaurant_name']; ?></p>
            <form action="dashboard.php" method="post">
                <input type="hidden" name="food_id" value="<?php echo $food['id']; ?>">
                <button type="submit" name="add_to_cart" class="add-to-cart">Add to Cart</button>
            </form>
        </div>
    <?php } ?>
    </div>

    <!-- Display Message -->
    <?php if (!empty($message)) { echo "<p style='color: green; font-weight: bold;'>$message</p>"; } ?>

    <!-- View Cart Button -->
    <a href="cart.php" class="btn">View Cart</a>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Food Platform. All rights reserved.</p>
        <ul class="footer-links">
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Terms of Service</a></li>
        </ul>
    </footer>

</body>
</html>
