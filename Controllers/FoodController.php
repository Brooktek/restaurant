<?php
require_once __DIR__ . '/../Models/FoodModel.php';

class FoodController {
    private $foodModel;

    public function __construct($conn) {
        $this->foodModel = new FoodModel($conn);
    }

    // Handle Add Food functionality
    public function handleAddFood($postData, $filesData, $restaurantId) {
        if (isset($postData['add_food'])) {
            $name = htmlspecialchars($postData['name']);
            $description = htmlspecialchars($postData['description']);
            $price = filter_var($postData['price'], FILTER_VALIDATE_FLOAT);
            $image = $filesData['image']['name'];
            $image_tmp = $filesData['image']['tmp_name'];
            $target = __DIR__ . '/../Public/uploaded_img/' . basename($image);

            if ($price === false || $price <= 0) {
                return "Invalid price.";
            } elseif (move_uploaded_file($image_tmp, $target)) {
                if ($this->foodModel->addFood($restaurantId, $name, $description, $price, $image)) {
                    return "Food item added successfully!";
                } else {
                    return "Failed to add food item.";
                }
            } else {
                return "Failed to upload image.";
            }
        }
        return null;
    }

    // Get foods for the current restaurant
    public function getFoodsByRestaurant($restaurantId) {
        return $this->foodModel->getFoodsByRestaurant($restaurantId);
    }

    // Add a new food item
    public function addFood($restaurantId, $name, $description, $price, $image) {
        return $this->foodModel->addFood($restaurantId, $name, $description, $price, $image);
    }

    // Get details of a specific food item
    public function getFoodDetails($id) {
        return $this->foodModel->getFoodDetails($id);
    }

    // Update a food item
    public function updateFood($id, $name, $description, $price, $image) {
        return $this->foodModel->updateFood($id, $name, $description, $price, $image);
    }

    // Delete a food item
    public function deleteFood($id) {
        return $this->foodModel->deleteFood($id);
    }
}