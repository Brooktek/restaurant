<?php
require_once '../includes/db.php';  // Ensure the DB class is included

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
