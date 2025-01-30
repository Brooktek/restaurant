<?php
session_start();
@include 'includes/db.php';

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
    <title>Checkout</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
    <h1>Checkout</h1>

    <h2>Total Price: <?php echo htmlspecialchars($_POST['total_price']); ?> Birr</h2>

    <form action="order-confirmation.php" method="post">
        <input type="hidden" name="total_price" value="<?php echo htmlspecialchars($_POST['total_price']); ?>">
        <input type="submit" name="confirm_payment" value="Confirm Payment" class="btn">
    </form>

    <a href="cart.php" class="btn">Back to Cart</a>
</body>
</html>
