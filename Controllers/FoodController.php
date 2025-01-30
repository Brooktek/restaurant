<?php
class FoodController {
    private $foodModel;

    public function __construct($conn) {
        $this->foodModel = new FoodModel($conn);
    }

    // Edit food
    public function editFood($id, $name, $description, $price, $image) {
        if ($this->foodModel->updateFood($id, $name, $description, $price, $image)) {
            return true;
        }
        return false;
    }

    // Delete food
    public function deleteFood($id) {
        if ($this->foodModel->deleteFood($id)) {
            return true;
        }
        return false;
    }

    // Fetch food details by ID
    public function getFoodDetails($id) {
        return $this->foodModel->getFoodsByRestaurant($id);
    }
}
