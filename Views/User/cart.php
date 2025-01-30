<?php
class CartView {
    public function displayCart($cart_items, $total_price) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Cart</title>
            <link rel="stylesheet" href="css/style.css">
        </head>
        <body>
            <h1>Your Cart</h1>
            <div class="cart-items">
                <?php while ($item = mysqli_fetch_assoc($cart_items)) { 
                    $total_price += $item['price'] * $item['quantity'];
                ?>
                <div class="cart-item">
                    <img src="uploaded_img/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" width="100">
                    <h3><?php echo $item['name']; ?></h3>
                    <p>Price: $<?php echo $item['price']; ?></p>
                    <p>Quantity: <?php echo $item['quantity']; ?></p>
                    <form action="cart.php" method="post">
                        <input type="hidden" name="food_id" value="<?php echo $item['food_id']; ?>">
                        <input type="submit" name="delete_item" value="Delete" class="btn delete-btn">
                    </form>
                </div>
                <?php } ?>
            </div>
            <h2>Total Price: $<?php echo $total_price; ?></h2>
            <form action="checkout.php" method="post">
                <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
                <input type="submit" name="submit_order" value="Proceed to Checkout" class="btn">
            </form>
            <a href="user/dashboard.php" class="btn">Back to Menu</a>
        </body>
        </html>
        <?php
    }
}
?>
