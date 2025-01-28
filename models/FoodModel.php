<?php
class FoodModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllFoods() {
        $query = "SELECT foods.*, users.name AS restaurant_name FROM foods JOIN users ON foods.restaurant_id = users.id";
        return mysqli_query($this->conn, $query);
    }

    public function addFood($restaurant_id, $name, $description, $price, $image) {
        $query = "INSERT INTO foods (restaurant_id, name, description, price, image) 
                  VALUES ('$restaurant_id', '$name', '$description', '$price', '$image')";
        return mysqli_query($this->conn, $query);
    }

    public function getFoodsByRestaurant($restaurant_id) {
        $query = "SELECT * FROM foods WHERE restaurant_id = '$restaurant_id'";
        return mysqli_query($this->conn, $query);
    }
}
?>