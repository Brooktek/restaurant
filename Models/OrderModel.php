<?php
class OrderModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Fetch order history for a specific user
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
}
?>