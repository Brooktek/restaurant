<?php
session_start();
@include 'includes/db.php';
@include 'includes/header.php';

if ($_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$total_price = $_POST['total_price'];  // Total price from cart page
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Checkout</h1>

    <h2>Total Price: <?php echo $total_price; ?> Birr</h2>

    <form action="save-order.php" method="post">
        <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
        <input type="submit" name="confirm_payment" value="Confirm Payment" class="btn">
    </form>

    <a href="cart.php" class="btn">Back to Cart</a>
</body>
</html>
