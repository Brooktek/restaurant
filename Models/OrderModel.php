<?php
class OrderModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getOrderHistory($userId) {
        $query = "
            SELECT orders.*, foods.name AS food_name, foods.image 
            FROM orders 
            JOIN foods ON orders.food_id = foods.id 
            WHERE orders.user_id = ?
            ORDER BY orders.order_date DESC
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function createOrder($orderId, $userId, $foodId, $quantity, $totalPrice) {
        $query = "INSERT INTO orders (order_id, user_id, food_id, quantity, total_price, order_date, status)
                  VALUES (?, ?, ?, ?, ?, NOW(), 'Pending')";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("siidi", $orderId, $userId, $foodId, $quantity, $totalPrice);
        return $stmt->execute();
    }

    public function getOrderDetails($orderId, $userId) {
        $query = "
            SELECT orders.*, foods.name AS food_name, foods.price AS food_price, foods.image, orders.quantity 
            FROM orders 
            JOIN foods ON orders.food_id = foods.id 
            WHERE orders.order_id = ? AND orders.user_id = ?
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $orderId, $userId);
        $stmt->execute();
        return $stmt->get_result();
    }
    
     // Fetch orders for a specific restaurant
     public function getOrdersByRestaurant($restaurantId) {
        $query = "
            SELECT orders.*, users.name AS user_name, foods.name AS food_name 
            FROM orders 
            JOIN foods ON orders.food_id = foods.id 
            JOIN users ON orders.user_id = users.id 
            WHERE foods.restaurant_id = ?
            ORDER BY orders.order_date DESC
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $restaurantId);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>