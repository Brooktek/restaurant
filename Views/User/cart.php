<?php
session_start();
define('BASE_PATH', dirname(__DIR__, 2)); 

require_once BASE_PATH . '/Config/db.php';
require_once BASE_PATH . '/Controllers/CartController.php';


if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'user') {
  header("Location: ../login.php");
  exit();
}

$cartController = new CartController($conn);

if (isset($_POST['delete_item'])) {
    $foodId = $_POST['food_id'];
    $userId = $_SESSION['user_id'];
    $cartController->deleteItem($userId, $foodId);
    header("Location: cart.php"); 
}

$cartItems = $cartController->getCartItems($_SESSION['user_id']);

$totalPrice = 0;
while ($item = mysqli_fetch_assoc($cartItems)) {
    $totalPrice += $item['price'] * $item['quantity'];
}
mysqli_data_seek($cartItems, 0); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="../../Public/css/style.css">
</head>
<body>
    <h1>Your Cart</h1>
    <div class="cart-items">
        <?php while ($item = mysqli_fetch_assoc($cartItems)) { ?>
        <div class="cart-item">
            <img src="../../Public/uploaded_img/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" width="100">
            <h3><?php echo $item['name']; ?></h3>
            <p>Price: <?php echo $item['price']; ?> Birr</p>
            <p>Quantity: <?php echo $item['quantity']; ?></p>
            <form action="cart.php" method="post">
                <input type="hidden" name="food_id" value="<?php echo $item['food_id']; ?>">
                <input type="submit" name="delete_item" value="Delete" class="btn delete-btn">
            </form>
        </div>
        <?php } ?>
    </div>

    <h2>Total Price: <?php echo $totalPrice; ?> Birr</h2>

    <form action="checkout.php" method="post">
        <input type="hidden" name="total_price" value="<?php echo $totalPrice; ?>">
        <input type="submit" name="submit_order" value="Proceed to Checkout" class="btn">
    </form>

    <a href="dashboard.php" class="btn">Back to Menu</a>
</body>
</html>