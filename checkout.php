<?php
session_start();
@include 'includes/db.php';
@include 'includes/header.php'; 

if ($_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$total_price = $_POST['total_price'];  // Get total price from cart page

?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="css/style.css">
    
    <!-- Include PayPal JavaScript SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=AYTZGuxOcoAUestxSu9heNS2bz5gANaJ-U05GW5QjU9xJw4ajJDwDTAbP6FFixyfEbThj3N_EWBRHtxc&currency=USD"></script>

  </head>
<body>
    <h1>Checkout</h1>

    <h2>Total Price: <?php echo $total_price; ?>Birr</h2>

    <!-- PayPal Button for payment -->
    <div id="paypal-button-container"></div>

    <script>
    // Render PayPal button
    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '<?php echo $total_price; ?>'  // Pass the total price from PHP
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                alert('Transaction completed by ' + details.payer.name.given_name);
                
                // Redirect user to order confirmation page after successful payment
                window.location.href = 'order-confirmation.php?order_id=' + details.id;
            });
        },
        onError: function(err) {
            alert('Payment failed. Please try again!');
        }
    }).render('#paypal-button-container');
    </script>

    <a href="cart.php" class="btn">Back to Cart</a>
</body>
</html>
