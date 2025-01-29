<?php
require_once 'Models/OrderModel.php';

class OrderController {
    private $orderModel;

    public function __construct($dbConnection) {
        $this->orderModel = new OrderModel($dbConnection);
    }

    // Get order history for a specific user
    public function getOrderHistory($userId) {
        return $this->orderModel->getOrderHistory($userId);
    }
}
?>