<?php
require_once __DIR__ . '/../Models/FoodModel.php';

class RestaurantController {

  private $foodModel;

  public function __construct() {
    $this->foodModel = new FoodModel();
  }

    // Handle Add Food functionality
    public function handleAddFood($postData, $filesData, $restaurantId) {
        if (isset($postData['add_food'])) {
            $name = $postData['name'];
            $description = $postData['description'];
            $price = $postData['price'];
            $image = $filesData['image']['name'];
            $image_tmp = $filesData['image']['tmp_name'];
            $target = "/../Public/uploaded_img/" . basename($image);

            if ($target) {
                return $this->foodModel->addFood($restaurantId, $name, $description, $price, $image);
            } else {
                return false;
            }
        }
        return null;
    }

    // Get foods for the current restaurant
    public function getFoodsByRestaurant($restaurantId) {
        return $this->foodModel->getFoodsByRestaurant($restaurantId);
    }
}
?>