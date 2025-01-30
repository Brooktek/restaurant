<?php

class FoodController {
    private $foodModel;

    public function __construct($conn) {
        $this->foodModel = new FoodModel($conn);
    }

    public function editFood($id, $name, $description, $price, $image) {
        if ($this->foodModel->updateFood($id, $name, $description, $price, $image)) {
            return true;
        }
        return false;
    }

    public function deleteFood($id) {
        if ($this->foodModel->deleteFood($id)) {
            return true;
        }
        return false;
    }

    public function getFoodDetails($id) {
        return $this->foodModel->getFoodsByRestaurant($id);
    }
}


