<?php
require_once '../includes/db.php';  // Ensure the DB class is included

<<<<<<< HEAD
class Order {
    private $db;
    private $restaurant_id;

    public function __construct(Database $db, $restaurant_id) {
        $this->db = $db->getConnection();
        $this->restaurant_id = $restaurant_id;
    }

    // Fetch orders for the restaurant
    public function getOrders() {
        $query = "SELECT orders.*, users.name AS user_name, foods.name AS food_name 
                  FROM orders 
                  JOIN foods ON orders.food_id = foods.id 
                  JOIN users ON orders.user_id = users.id 
                  WHERE foods.restaurant_id = ?
                  ORDER BY orders.order_date DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $this->restaurant_id); // Bind the restaurant ID parameter
        $stmt->execute();
        return $stmt->get_result(); // Return the result set
    }

    // Display orders as HTML
    public function displayOrders() {
        $orders = $this->getOrders();

        if ($orders->num_rows > 0) {
            while ($order = $orders->fetch_assoc()) {
                echo "<div class='order-item'>
                        <h3>{$order['food_name']}</h3>
                        <p>Ordered by: {$order['user_name']}</p>
                        <p>Quantity: {$order['quantity']}</p>
                        <p>Total Price: \${$order['total_price']}</p>
                        <p>Order Date: {$order['order_date']}</p>
                        <p>Status: {$order['status']}</p>
                    </div>";
            }
        } else {
            echo "<p>No orders found for your restaurant.</p>";
        }
    }
}
?>
=======
// Check if user is logged in as a restaurant
if ($_SESSION['user_type'] !== 'restaurant') {
    header("Location: ../login.php");
    exit();
}

$restaurant_id = $_SESSION['user_id'];

echo "Restaurant ID: " . $restaurant_id; // Debugging line to check the value

// Debugging: Check if restaurant ID is valid
if (empty($restaurant_id)) {
    echo "Restaurant ID is missing!";
    exit();
}

$orders = mysqli_query($conn, "
    SELECT orders.*, users.name AS user_name, foods.name AS food_name 
    FROM orders 
    JOIN foods ON orders.food_id = foods.id 
    JOIN users ON orders.user_id = users.id 
    WHERE foods.restaurant_id = '$restaurant_id'
    ORDER BY orders.order_date DESC
");

// Check if the query was successful
if (!$orders) {
    echo "Error fetching orders: " . mysqli_error($conn);
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Orders</h1>
    <?php if (mysqli_num_rows($orders) > 0) { ?>
    <div class="order-list">
        <?php while ($order = mysqli_fetch_assoc($orders)) { ?>
        <div class="order-item">
            <h3><?php echo $order['food_name']; ?></h3>
            <p>Ordered by: <?php echo $order['user_name']; ?></p>
            <p>Quantity: <?php echo $order['quantity']; ?></p>
            <p>Total Price: $<?php echo $order['total_price']; ?></p>
            <p>Order Date: <?php echo $order['order_date']; ?></p>
            <p>Status: <?php echo $order['status']; ?></p>
        </div>
        <?php } ?>
    </div>
    <?php } else { ?>
        <p>No orders found for your restaurant.</p>
    <?php } ?>

    <a href="dashboard.php" class="btn">Go Back</a>

</body>
</html>
>>>>>>> parent of b2e7ceb (updated)
